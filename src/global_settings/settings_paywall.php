<?php
  defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
  
  $_TT_SETTINGS_PAYWALL_SLUG = "tallytoo-settings-paywall";

  function tt_register_settings_paywall() {

    $section_slug = 'tallytoo_settings_pawyall';
    // $locked_slug = 'tallytoo_settings_pawyall_locked';

    add_settings_section(
      $section_slug,       // Slug-name to identify the section
      null,                      // Formatted title of the section
      'tt_paywall_section_html',          // Callback
      $GLOBALS['_TT_SETTINGS_PAYWALL_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );

    /* 
    add_settings_section(
      $locked_slug,       // Slug-name to identify the section
      "Lock-icon in titles",                      // Formatted title of the section
      'tt_paywall_locked_section_html',          // Callback
      $GLOBALS['_TT_SETTINGS_PAYWALL_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );
    */

    add_settings_field(
      'tallytoo_paywallhtml',             // Slug-name to identify the field
      __('Paywall html', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_paywall_html_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_PAYWALL_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_paywallcss',             // Slug-name to identify the field
      __('Paywall css', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_paywall_css_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_PAYWALL_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

    /* add_settings_field(
      'tallytoo_lockediconenabled',             // Slug-name to identify the field
      'Show locked icon',                       // Formatted title of the field
      'tallytoo_locked_icon_enabled_cb',        // Callback
      $GLOBALS['_TT_SETTINGS_PAYWALL_SLUG'],                // Slug name of the settings page on which to show the section
      $locked_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_lockedicon',             // Slug-name to identify the field
      'Locked icon',                     // Formatted title of the field
      'tallytoo_locked_icon_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_PAYWALL_SLUG'],                // Slug name of the settings page on which to show the section
      $locked_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_lockediconheight',             // Slug-name to identify the field
      'Locked icon height',                     // Formatted title of the field
      'tallytoo_locked_icon_height_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_PAYWALL_SLUG'],                // Slug name of the settings page on which to show the section
      $locked_slug                       // Slug-name of the section 
    ); */
  }
  add_action('admin_init', 'tt_register_settings_paywall');


  function tt_register_settings_paywall_page($parent_slug) {
    global $tt_settings_paywall_page;
    $tt_settings_paywall_page = add_submenu_page(
      $parent_slug,               // Parent slug
      __("Paywall", 'tallytoo-wall'),                  // Title
      __("Paywall", 'tallytoo-wall'),                  // Menu title
      "manage_options",           // Capability
      $GLOBALS['_TT_SETTINGS_PAYWALL_SLUG'],     // Menu slug
      "tt_paywall_html"      // Callback
    );

    add_action( 'admin_head-'. $tt_settings_paywall_page, 'tt_paywall_admin_head' );
    add_action( 'admin_footer-'. $tt_settings_paywall_page, 'tt_paywall_admin_footer' );
  }


  function tt_paywall_admin_head() {
    $css = tt_get_paywall_css(); 
    echo '<style type="text/css">'.$css.'</style>';
  }

  function tt_paywall_admin_footer() {
    $load_script = getTallybuttonLoadScript();
    echo '<script>'.$load_script.'</script>';

    // $my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

    $image_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/image-selector.js');
    $image_script = str_replace("__UPLOAD_LINK__", "#tt_upload_link", $image_script);        
    $image_script = str_replace("__DELETE_LINK__", "#tt_delete_link", $image_script);        
    $image_script = str_replace("__IMG_CONTAINER__", "#tt_img_container", $image_script);        
    $image_script = str_replace("__IMP_INP__", "#tt_img_inp", $image_script);        
    $image_script = str_replace("__TITLE__", "Select the lock image", $image_script);        


    echo '<script>'.$image_script.'</script>';
    // $image_script = str_replace("__POST_ID__", $image_script, $setting);        

  }

  function tt_paywall_html() {
    // Check permissions
    if (!current_user_can('manage_options')) {
      return;
    }

    ?>
      <div class="wrap">
          <h1><?= esc_html(get_admin_page_title()); ?></h1>

          <form action="options.php" method="post">
          <?php
              // output security fields for the registered setting "wporg_options"
              settings_fields($GLOBALS['_TT_SETTINGS_SECTION_PAYWALL']);

              // output setting sections and their fields
              // (sections are registered for "wporg", each field is registered to a specific section)
              do_settings_sections($GLOBALS['_TT_SETTINGS_PAYWALL_SLUG']);

              // output save settings button
              submit_button(__('Save Settings', 'tallytoo-wall'));
          ?>   
          </form>

      </div>

    <?php
  }

  /*
  function tt_paywall_locked_section_html() {
    ?>
      <p>The lock icon is a small icon that will appear next to the titles of your articles that are locked by a paywall. This is a common technique to inform your users of premium content. It is not obligatory.</p>
    <?php
  }
  */


  function tt_paywall_section_html() {

    $setting = tt_get_paywall_html();

    

    ?>
      <p><?php _e('Use the tallytoo-paywall shortcode to protect content in your post or page: <strong>[tallytoo-paywall cost=1] ... content to protect ... [/tallytoo-paywall]</strong>', 'tallytoo-wall') ?></p>
      <p><?php _e('The following gives a rough preview of how the paywall will look, although your template styles will make it look different on your site', 'tallytoo-wall') ?></p>
      <p><?php _e('We recommend that you create a private test post, and experiment with the layout of your paywall.', 'tallytoo-wall') ?></p>


      <div style="width: 100%; max-width: 768px; margin: 0 auto; position: relative;">
          <div style="display: block;padding: 25px;margin: 0;">
              <div style="display: block;margin: 0;padding: 0;">
                  <div style="overflow: hidden;">
                      <div style="position: relative;">
                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                          <?php 
                              echo tt_get_fade();
                          ?>
                      </div>
                      <?php 
                          $tally_elem = '<tallybutton content-id="admin" cost="1" test="true" mode="pay"></tallybutton>';
                          $html = str_replace("[tallybutton]", $tally_elem, $setting);        
                          echo $html 
                      ?>
                  </div>
              </div>

          </div>
      </div>

    <?php

    
  }

  function tallytoo_paywall_html_cb()
  {
      $setting = tt_get_paywall_html();
      ?>

      <fieldset>
          
          <label for="<?php echo tt_paywall_html_var() ?>">
            <p><?php _e('Insert the html for your paywall here. The <strong>[tallybutton]</strong> short-code will be replaced by the real tallytoo button.', 'tallytoo-wall') ?> </p>
            <p><?php _e('Do not forget to add the <strong>[tallysection]</strong> short-code as an ID to your paywall root element. This allows this plugin to remove the paywall if necessary.', 'tallytoo-wall') ?> </p>
            <p><?php _e('The button will adapt to the size of the container you give to it. We recommend however, a minimum size of 240x54 pixels. Smaller versions will work (the button is fully responsive), but the indicators that incite your users to earn and spend points on your site may be less visible.', 'tallytoo-wall') ?></p>            
          </label>
          <textarea id="tallytoo_paywall_html_editor" rows="5" name="<?php echo tt_paywall_html_var() ?>" class="widefat textarea"><?php echo wp_unslash( $setting ); ?></textarea>   
      </fieldset>

      <?php
  }


  function tallytoo_paywall_css_cb()
  {
      $setting = tt_get_paywall_css();
      ?>

      <fieldset>
          <label for="<?php echo tt_paywall_css_var() ?>">
            <p><?php _e('The following css will be used to style the above html.', 'tallytoo-wall') ?> </p>
            <p><?php _e('The class <strong>.tt-fadeover</strong> is a special class for providing the fadeout effect over any text that you envelope with the <strong>[tallytoo-fade]</strong> shortcode. You may customize its color as you wish.', 'tallytoo-wall') ?> </p>
            <p><?php _e('Note that the tallytoo button styling cannot be done by css, but rather in the <strong>Appearance</strong> option menu of this plugin.', 'tallytoo-wall') ?></p>
          </label>
          <textarea id="tallytoo_paywall_css_editor" rows="5" name="<?php echo tt_paywall_css_var() ?>" class="widefat textarea"><?php echo wp_unslash( $setting ); ?></textarea>   
      </fieldset>

      <?php
  }


  function tt_add_settings_paywall_scripts( $hook ) {   

    global $tt_settings_paywall_page;
	  if( $hook != $tt_settings_paywall_page ) 
		  return;

    wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
    
    wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '../scripts/code-editor-empty.js', array( 'jquery' ), '', true );    

    $create_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/code-editor.js');
    $create_script = str_replace('__ELEMENT_ID__', 'tallytoo_paywall_html_editor' , $create_script);
    $create_script = str_replace('__EDIT_MODE__', 'text/html' , $create_script);
    wp_add_inline_script('js-code-editor',  $create_script, 'after');

    $create_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/code-editor.js');
    $create_script = str_replace('__ELEMENT_ID__', 'tallytoo_paywall_css_editor' , $create_script);
    $create_script = str_replace('__EDIT_MODE__', 'text/css' , $create_script);
    wp_add_inline_script('js-code-editor',  $create_script, 'after');

    //wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '/code-editor.js', array( 'jquery' ), '', true );    

    wp_enqueue_script( 'tallybutton',  getScriptSrc(), false );
    wp_add_inline_script('tallybutton',  getTallybuttonCreateScript(), 'after');

  }
  add_action('admin_enqueue_scripts', 'tt_add_settings_paywall_scripts' );

  /*
  function tallytoo_locked_icon_cb() {

    wp_enqueue_media();

    // Get WordPress' media upload URL
    $upload_link = esc_url( get_upload_iframe_src( 'image' ) );

    // See if there's a media id already saved as post meta
    $your_img_id = tt_get_locked_icon();    

    // Get the image src
    $your_img_src = wp_get_attachment_image_src( $your_img_id, 'full' );

    // For convenience, see if the array is valid
    $you_have_img = is_array( $your_img_src );
    ?>

    <!-- Your image container, which can be manipulated with js -->
    <div id="tt_img_container" class="custom-img-container">
        <?php if ( $you_have_img ) : ?>
            <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:100%;" />
        <?php endif; ?>
    </div>

    <!-- Your add & remove image links -->
    <p class="hide-if-no-js">
        <a id="tt_upload_link" class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
          href="<?php echo $upload_link ?>">
            <?php _e('Set custom image') ?>
        </a>
        <a id="tt_delete_link" class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
          href="#">
            <?php _e('Remove this image') ?>
        </a>
    </p>

    <!-- A hidden input to set and post the chosen image id -->
    <input id="tt_img_inp" class="custom-img-id" name="<?php echo tt_locked_icon_var() ?>" type="hidden" value="<?php echo esc_attr( $your_img_id ); ?>" />

    <?php
  }

  function tallytoo_locked_icon_height_cb()
  {
      $setting = tt_get_locked_icon_height();
      ?>
      <input type="number" name="<?php echo tt_locked_icon_height_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
      <label for="<?php echo tt_locked_icon_height_var() ?>">The height (in pixels) of your locked icon, which will be attached to the end of each title.</label>
      <?php
  }

  function tallytoo_locked_icon_enabled_cb()
  {
      $setting = tt_get_locked_icon_enabled();
      
      ?>
      <input type="checkbox" name="<?php echo tt_locked_icon_enabled_var() ?>" value="1"  <?php checked("1", $setting);?>><br>	
      <label for="<?php echo tt_locked_icon_enabled_var() ?>">Check this box in order to display a locked image next to your article titles.</label>
      <?php
  }*/

?>