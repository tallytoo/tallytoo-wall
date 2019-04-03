<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once( plugin_dir_path(__FILE__) . './post-shortcodes.php');
require_once( plugin_dir_path(__FILE__) . './post-shortcodes-editor.php');

use \Firebase\JWT\JWT;

/**
 * Load external libraries
 */
function load_jwt_library() {
  if ( !class_exists( 'Firebase\JWT\JWT' ) ) {
      require_once( plugin_dir_path(__FILE__) . '../../external/php-jwt-master/src/JWT.php' );
      require_once( plugin_dir_path(__FILE__) . '../../external/php-jwt-master/src/BeforeValidException.php' );
      require_once( plugin_dir_path(__FILE__) . '../../external/php-jwt-master/src/ExpiredException.php' );
      require_once( plugin_dir_path(__FILE__) . '../../external/php-jwt-master/src/SignatureInvalidException.php' );
  }
}
add_action( 'plugins_loaded', 'load_jwt_library', 0 );

/**
 * Authorize the query parameters (if necessary)
 */
function add_query_vars($public_query_vars) {
    $use_cookie = tt_get_use_cookie();
    if (!$use_cookie)
    {
        array_push($public_query_vars, 'tt_at', 'tt_skip');
    }
    return $public_query_vars;
}
add_filter('query_vars', 'add_query_vars');

function tt_getPublicKeyUrl() {
  return tt_get_base_url().$GLOBALS["_TALLYTOO_PUB_KEY"];
}

function tt_verify_token($token, $postId) {
  $have_access = false;

  $decoded = null;
  try {
      // Get the public key for validating the JWT 
      // This is a remote call!!
      $publicKey = file_get_contents(tt_getPublicKeyUrl());
      
      // Decode the JWT
      $decoded = JWT::decode($token, $publicKey, array('RS256'));
      $decoded_array = (array) $decoded;

      // Validate the JWT
      if (
          $decoded_array['sub'] == $postId && 
          // $decoded_array['contentId'] == $post->ID && 
          $decoded_array['iss'] == 'tallytoo'
          // aud == origin/domain of website 
      )
      {
          $have_access = true;
          
      }
      else
      {
          throw new Exception("Sub, contentId, or iss were not valid in the token");
      }

      //echo "Decode:\n" . print_r($decoded_array, true) . "\n";
  }
  catch (Exception $e)
  {
      //echo $e->getMessage();
      $have_access = false;
  }

  return $have_access;
}

function tt_tallytoo_protection($post) {

  if (!$post) {
    return "none";
  }

  $content = $post->post_content;

  if (empty($content)) {
    return "none";
  }

  $paywall_pos = strpos($content, "[tallytoo-paywall");
  $donatewall_pos = strpos($content, "[tallytoo-donatewall");
  $donate_pos = strpos($content, "[tallytoo-donate");


  $protection = "none";
  if ($paywall_pos != false && $paywall_pos >= 0) {
    $protection = "pay";
  } else if ($donatewall_pos != false && $donatewall_pos >= 0) {
    $protection = "donate";
  } else if ($donate_pos != false && $donate_pos >= 0) {
    $protection = "donateinline";
  }

  return $protection;
}

/**
 * Function that will read the cookie/query param and validate if authorisation is given.
 * @return true if: authorisation is given for this post. It will return true also if no authorisation is required for this post.
 */
function tt_calculate_access(){

  global $tt_should_load_tallytoo;
  global $tt_donatewall;
  global $tt_donate_inline;
  global $tt_paywall;
  global $tt_protect_client_only;
  global $tt_fade_id;

  // Whether or not to load the tallybutton scripts & styles
  $tt_should_load_tallytoo = false;

  // Protection type
  $tt_donatewall = false;
  $tt_donate_inline = false;
  $tt_paywall = false;
  $tt_protect_client_only = false;
  $tt_fade_id = null;

  // This is not a page and not a post, always give access
  if (!is_page() && !is_single()) {    
    return;
  }

  // Always give full access if tallytoo has not been set-up
  $apikey = tt_get_api_key();
  if (empty($apikey)) {
    return;
  }

  // If this is a page or post, get the post data
  $post = $GLOBALS['post'];

  // Get protection type
  $protection = tt_tallytoo_protection($post);
  
  $tt_protect_client_only = (tt_get_protection_client_side($post->ID) == "client" ? true : false);
  
  // Fade ID
  $content = $post->post_content;
  $fade_pos = strpos($content, "[tallytoo-fade");
  
  if ($fade_pos > -1) {
    $tt_fade_id = uniqid();
  }

  // Give full access if "none" is specified as the protection type
  if ($protection == "none") {
    return;
  }

  // If we arrive here, we know:
  // - it is a page or post
  // - tallytoo set up
  // - protection type is active on this page or post
  

  // Get query parameters

  $token = null;
  $skip = null;

  $use_cookie = tt_get_use_cookie();
  if (!$use_cookie)
  {
      $token = get_query_var("tt_at");
      $skip = get_query_var("tt_skip");
  }
  else
  {
      $token = $_COOKIE['tt_at'];
      $skip =  $_COOKIE['tt_skip'];
  }

  // Handle pay-wall type
  if ($protection == "pay") {

    if ($token && tt_verify_token($token, $post->ID)) {
      // Token exists, and is verified
      return;
    } else {
      // No token, or token not verified, must protect this content
      $tt_paywall = true;
      $tt_should_load_tallytoo = true;
      return;
    }

  }

  // Handle donate-wall type
  else if ($protection == "donate") {

    if ($skip) {
      // User asked to skip this content
      return;
    } else if ($token && tt_verify_token($token, $post->ID)) {
      // Case where article automatically bought because no ads to pay
      return;
    }
    else {
      $tt_donatewall = true;
      $tt_should_load_tallytoo = true;
    }

  }

  // Handle donate-inline type
  else if ($protection == "donateinline") {

    $tt_donate_inline = true;
    $tt_should_load_tallytoo = true;   

  }
}

/**
 * 1. Once per page, check whether authorisation is present
 */
function tt_preprocess_post()
{
  // Calculate the access types
  tt_calculate_access();
}
add_action( 'wp','tt_preprocess_post' );


/** 
 * 2. Include the correct scripts for the tallybutton 
 */
function tt_enqueue_tallytoo_script() {

  global $tt_should_load_tallytoo;
  global $tt_protect_client_only;

  if (!$tt_should_load_tallytoo) {
    return;
  }

  // Get the tallybutton script source
  wp_enqueue_script( 'tallybutton',  getScriptSrc(), false );

  if ($tt_protect_client_only) {
    $unhide_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/tallybutton_callback_show.js');
    wp_add_inline_script('tallybutton', $unhide_script, 'after');
  } else {
    // Configure a generic callback for when authorisation is returned.
    $use_cookie = tt_get_use_cookie();
    if (!$use_cookie)
    {
        // If using a cookie, set it, and redirect to content
        $qp_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/tallybutton_callback_queryparam.js');
        wp_add_inline_script('tallybutton', $qp_script, 'after');
    }
    else
    {
        // If not using a cookie, add the authorisation token to the query
        $cookie_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/tallybutton_callback_cookie.js.js');
        wp_add_inline_script('tallybutton', $cookie_script, 'after');
    }
  }
  
  

  // Configure the script with the API key
  global $tt_donate_inline;
  $handle_respond = false;
  if ($tt_donate_inline) {
    $handle_respond = true;
  }
  
  wp_add_inline_script('tallybutton',  getTallybuttonCreateScript($handle_respond), 'after');  
}
add_action( 'wp_enqueue_scripts', 'tt_enqueue_tallytoo_script');

/**
 * 3. Include the correct styles
 */
function tt_add_paywall_style(){
  
  global $tt_should_load_tallytoo;
  if (!$tt_should_load_tallytoo) {
    return;
  }

  global $tt_donatewall;
  global $tt_donate_inline;
  global $tt_paywall;

  
  $css = '';

  if ($tt_paywall) {
    $css = tt_get_paywall_css();    
  }  
  else if ($tt_donatewall) {
    $css = tt_get_donatewall_css(); 
  }
  else if ($tt_donate_inline) {
    $css = tt_get_donateinline_css(); 
  }

  if (!empty($css)) {
    echo '<style type="text/css">'.$css.'</style>';
  }
  
}
add_action( 'wp_head', 'tt_add_paywall_style' );







/**
 * 4. Process the content of the post. Look for the [tallytoo-protect] short code. Everything after will be removed
 * if no authorisation given, and the paywall will be displayed instead.
 */
/* function tt_process_content($content) {

  if (!is_singular() || !is_main_query() || !in_the_loop())
  {
    return $content;
  }

  global $tt_donatewall;
  global $tt_donate_inline;
  global $tt_paywall;
  global $tt_protect_client_only;
  
  
  // Handle paywall & donatewall
  if ($tt_paywall || $tt_donatewall) {

    $retVal = "";

    // Access is not awareded:
    // 1. Cut the content at the designated point
    // 2. Show the paywall
    
    $protect_pos = strpos($content, "[tallytoo-protect]");
    $start_pos = strpos($content, "[tallytoo-protect-start]");
    $end_pos = strpos($content, "[tallytoo-protect-end]");

    $cut = "";

    // $pos = strpos($content, "[tallytoo-protect]");
    if ($protect_pos === false && $start_pos == false)
    {
      // No marker... do not fade content
      $retVal = "";
      $cut = $content;
    }
    

    $top_pos = $protect_pos;
    if ($top_pos == false) {
      $top_pos = $start_pos;
    }

    $containerId = null;
    $contentContainerId = null;
    $fadeId = null;
    if ($tt_protect_client_only) {
      $containerId = uniqid();
      $contentContainerId = uniqid();      
      $fadeId = uniqid();
    }

    if ($top_pos) {      
      // Marker found, gray out content before 
      $retVal .= '<div style="position: relative;">';
      $retVal .= substr($content, 0, $top_pos);  
      $cut = substr($content, $top_pos);  
      
      $retVal .= tt_get_fade($fadeId); 
      $retVal .= '</div>';
    }
    
    

    if ($tt_paywall) {
      $box = tt_get_paywall_html();
      $box = tt_tally_button_element($box, '', 'pay', $containerId, $contentContainerId, $fadeId);

      $retVal .= $box;
    }
    else if ($tt_donatewall) {
      $box = tt_get_donatewall_html();
      $box = tt_tally_button_element($box, '', 'donate', $containerId, $contentContainerId, $fadeId);
        
      $retVal .= $box;
    }

    // Add text after
    if ($end_pos) {
      
      $end_cut_pos = strpos($cut, "[tallytoo-protect-end]");
      if ($end_cut_pos) {
        $cut = substr($cut, 0, $end_cut_pos);   
      }

      $retVal .= tt_add_hidden_content($cut, $contentContainerId);
      
      $retVal .= substr($content, $end_pos); 
    } else {
      $retVal .= tt_add_hidden_content($cut, $contentContainerId);
    }

    $content = $retVal;
    
  }

  // Handle donate inline
  else if  ($tt_donate_inline) {

    $pos = strpos($content, "[tallytoo-protect]");
    if ($pos === false) {
      $pos = strpos($content, "[tallytoo-donate]");
    }

    if ($pos === false) {          
      // Neither found, add by default at end
      $content .= getInlineDonateBox();
    } else {   
      
      // Replace all instances with the donate box
      while (strpos($content, "[tallytoo-protect]") != false) {
        $content = str_replace_first("[tallytoo-protect]", getInlineDonateBox(), $content);
      }

      while (strpos($content, "[tallytoo-donate]") != false) {
        $content = str_replace_first("[tallytoo-donate]", getInlineDonateBox(), $content);
      }
              
    }

  }

  return $content;

}
*/
// add_filter('the_content', 'tt_process_content');


function tt_tally_button_element($html, $params, $cost, $mode, $containerId = null, $contentContainerId = null, $fadeId = null)
{
    $post = $GLOBALS['post'];
    $id = $GLOBALS['post']->ID;

    if ($id)
    {
        $permalink = get_permalink($post);

        $dataItem = 'data-item=\'{"redirect": "'.$permalink.'" ';

        if ($containerId) {
          $dataItem .= ', "containerId": "'.$containerId.'"';
        }
        if ($contentContainerId) {
          $dataItem .= ', "contentContainerId": "'.$contentContainerId.'"';
        }
        if ($fadeId) {
          $dataItem .= ', "fadeId": "'.$fadeId.'"';
        }

        $dataItem .= ', "mode": "'.$mode.'"';
        $dataItem .= '}\'';

        // Set the inline donate mode to plain old donate (tallybutton doesn't care)
        if ($mode == "donateinline") {
          $mode = "donate";
        }

        $title = esc_html(get_the_title($post));

        $tally_elem = '<tallybutton content-id="'.$id.'" cost="'.$cost.'" '.$dataItem.' mode=\''.$mode.'\' title=\''.$title.'\' '.$params.'></tallybutton>';
        $html = str_replace("[tallybutton]", $tally_elem, $html);


        // Process skip button if present
        $html = tt_tallyskip($html, $permalink, $containerId, $contentContainerId, $fadeId);

        // Replace tallysection if present
        if ($containerId) {
          $html = str_replace("[tallysection]", $containerId, $html);
        } else {
          $html = str_replace("[tallysection]", '', $html);
        }

        return $html;
    }
    else
    {
        return '';
    }
}

function tt_add_footer_scripts() {
  
  global $tt_should_load_tallytoo;
  if (!$tt_should_load_tallytoo)
  {
    // No need, accessible
    return;
  }

  $load_script = getTallybuttonLoadScript();
  echo '<script>'.$load_script.'</script>';
}
add_action( 'wp_print_footer_scripts', 'tt_add_footer_scripts' );




/*
function tt_lock_icon( $title, $id = null ) {

  if (!$id || is_admin()) {
    return $title;
  }

  $should_lock = tt_get_locked_icon_enabled();
  if (!$should_lock) {
    return $title;
  }

  $protected = tt_get_protection_type($id);
  
	if ($protected == "pay")
	{
    $locked_icon = tt_get_locked_icon();
    
    $your_img_src = wp_get_attachment_image_src( $locked_icon, 'full' );
    $you_have_img = is_array( $your_img_src );

    if ( $you_have_img ) {

      $height = tt_get_locked_icon_height();
      $height = str_replace("px", "", $height);
      $title = $title.'&nbsp;<img src="'.$your_img_src[0].'" alt="" style="height: '.$height.'px; display: inline-block; vertical-align: middle; float: none;" />';
    }
    
  }

  return $title;
}
add_filter( 'the_title', 'tt_lock_icon', 10, 2 );
*/

?>