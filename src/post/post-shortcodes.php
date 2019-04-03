<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );



function tt_add_hidden_content($content, $containerId) {
  global $tt_protect_client_only;
  
  $retVal = '';
  if ($tt_protect_client_only && !empty($content)) {
    $retVal .= '<div id="'.$containerId.'" class="tt-hidden-content">';
    $retVal .= do_shortcode($content);
    $retVal .= '</div>';
  }

  return $retVal;
}

// Register the shortcode [tallytoo-protect], so that it will eventually be removed
function tallytoo_paywall_func( $atts, $content = "" ){
 
  if (!is_singular() || !is_main_query() || !in_the_loop())
  {
    return do_shortcode($content);
  }

  global $tt_donatewall;
  global $tt_paywall;
  global $tt_protect_client_only;
  global $tt_fade_id;
  
  // Handle paywall or donatewall
  if ($tt_paywall || $tt_donatewall) {

    $paywall_attrs = shortcode_atts( array(
      'cost' => 1
    ), $atts );

    $retVal = "";

    $containerId = null;
    $contentContainerId = null;
    $fadeId = null;

    if ($tt_protect_client_only) {
      $containerId = uniqid();
      $contentContainerId = uniqid(); 
      $fadeId = $tt_fade_id;     
    }

    if ($tt_paywall) {
      $box = tt_get_paywall_html();
      $box = tt_tally_button_element($box, '', $paywall_attrs['cost'], 'pay', $containerId, $contentContainerId, $fadeId);

      $retVal .= $box;
    }
    else if ($tt_donatewall) {
      $box = tt_get_donatewall_html();
      $box = tt_tally_button_element($box, '', $paywall_attrs['cost'], 'donate', $containerId, $contentContainerId, $fadeId);
        
      $retVal .= $box;
    }

    // Add hidden content if client-side only
    $retVal .= tt_add_hidden_content($content, $contentContainerId);

    $content = $retVal;
    
  } else {
    $content = do_shortcode($content);
  }

  return $content;
}
add_shortcode( 'tallytoo-paywall', 'tallytoo_paywall_func' );
add_shortcode( 'tallytoo-donatewall', 'tallytoo_paywall_func' );


function tallytoo_donate_func( $atts, $content = "" ){
 
  if (!is_singular() || !is_main_query() || !in_the_loop())
  {
    return do_shortcode($content);
  }

  global $tt_donatewall;
  global $tt_donate_inline;
  global $tt_paywall;
  global $tt_protect_client_only;
  
  if  ($tt_donate_inline) {

    $paywall_attrs = shortcode_atts( array(
      'cost' => 1
    ), $atts );

    $box = tt_get_donateinline_html();
    $uid = uniqid();
    $box = tt_tally_button_element($box, '', $paywall_attrs['cost'], 'donateinline', $uid);
    $box = str_replace("[tallysection]", $uid, $box);
    
    $content .= $box;
  }

  return do_shortcode($content);
}

add_shortcode( 'tallytoo-donate', 'tallytoo_donate_func' );


function tallytoo_fade_func( $atts, $content = "" ){
 
  if (!is_singular() || !is_main_query() || !in_the_loop())
  {
    return do_shortcode($content);
  }

  global $tt_donatewall;
  global $tt_donate_inline;
  global $tt_paywall;
  global $tt_protect_client_only;
  global $tt_fade_id;
  
  $retVal = "";
  if  (($tt_donatewall || $tt_paywall) && ($tt_fade_id != null)) {  
    $retVal .= '<div style="position: relative;">';
    $retVal .= do_shortcode($content);  
    $retVal .= tt_get_fade($tt_fade_id); 
    $retVal .= '</div>';

  } else {
    $retVal = do_shortcode($content);
  }

  return $retVal;
}

add_shortcode( 'tallytoo-fade', 'tallytoo_fade_func' );

?>