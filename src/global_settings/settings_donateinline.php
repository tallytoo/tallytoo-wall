<?php 
  defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

  
  $_TT_SETTINGS_DONATEINLINE_SLUG = "tallytoo-settings-donateinline";

  function tt_register_settings_donateinline() {

    $section_slug = 'tallytoo_settings_donateinline';

    add_settings_section(
      $section_slug,       // Slug-name to identify the section
      null,                      // Formatted title of the section
      'tt_donateinline_section_html',          // Callback
      $GLOBALS['_TT_SETTINGS_DONATEINLINE_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );

    add_settings_field(
      'tallytoo_donateinlinehtml',             // Slug-name to identify the field
      __('Donate-section html', 'tallytoo-wall'),                    // Formatted title of the field
      'tallytoo_donateinline_html_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DONATEINLINE_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_donateinlinecss',             // Slug-name to identify the field
      __('Donate-section css', 'tallytoo-wall'),                      // Formatted title of the field
      'tallytoo_donateinline_css_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DONATEINLINE_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );
  }
  add_action('admin_init', 'tt_register_settings_donateinline');


  function tt_register_settings_donateinline_page($parent_slug) {
    global $tt_settings_donateinline_page;
    $tt_settings_donateinline_page = add_submenu_page(
      $parent_slug,               // Parent slug
      __("Inline donation request", 'tallytoo-wall'),                 // Title
      __("Donate-inline", 'tallytoo-wall'),                   // Menu title
      "manage_options",           // Capability
      $GLOBALS['_TT_SETTINGS_DONATEINLINE_SLUG'],     // Menu slug
      "tt_donateinline_html"      // Callback
    );

    add_action( 'admin_head-'. $tt_settings_donateinline_page, 'tt_donateinline_admin_head' );
    add_action( 'admin_footer-'. $tt_settings_donateinline_page, 'tt_donateinline_admin_footer' );
  }


  function tt_donateinline_admin_head() {
    $css = tt_get_donateinline_css(); 
    echo '<style type="text/css">'.$css.'</style>';
  }

  function tt_donateinline_admin_footer() {
    $load_script = getTallybuttonLoadScript();
    echo '<script>'.$load_script.'</script>';
  }

  function tt_donateinline_html() {
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
              settings_fields($GLOBALS['_TT_SETTINGS_SECTION_DONATEINLINE']);

              // output setting sections and their fields
              // (sections are registered for "wporg", each field is registered to a specific section)
              do_settings_sections($GLOBALS['_TT_SETTINGS_DONATEINLINE_SLUG']);

              // output save settings button
              submit_button(__('Save Settings','tallytoo-wall'));
          ?>   
          </form>

      </div>

    <?php
  }


  function tt_donateinline_section_html() {

    $setting = tt_get_donateinline_html();

    ?>
      <p><?php _e('This is the least intrusive monetisation method. It will add a donation request at the end of your article (or wherever you add the <strong>[tallytoo-donate cost=1]</strong> shortcode). However the entire post will be shown.', 'tallytoo-wall') ?></p>
      <p><?php _e('The following gives a rough preview of how the donation request will look, although your template styles will make it look different on your site.', 'tallytoo-wall') ?></p>
      <p><?php _e('We recommend that you create a private test post, and experiment with the layout of your content.', 'tallytoo-wall') ?></p>

      <div style="width: 100%; max-width: 768px; margin: 0 auto; position: relative;">
          <div style="display: block;padding: 25px;margin: 0;">
              <div style="display: block;margin: 0;padding: 0;">
                  <div style="overflow: hidden;">
                      <div style="position: relative;">
                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                      </div>
                      <?php 
                          $tally_elem = '<tallybutton content-id="admin" cost="1" test="true" mode="donate"></tallybutton>';
                          $html = str_replace("[tallybutton]", $tally_elem, $setting);  
                          $html = tt_tallyskip($html, '');   
                          echo $html 
                      ?>
                      <div style="position: relative;">
                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                      </div>

                  </div>
              </div>

          </div>
      </div>

    <?php

    
  }

  function tallytoo_donateinline_html_cb()
  {
      $setting = tt_get_donateinline_html();
      ?>

      <fieldset>
          <label for="<?php echo tt_donateinline_html_var() ?>">
            <p><?php _e('Insert the html for your donation request here. The <strong>[tallybutton]</strong> short-code will be replaced by the real tallytoo button.', 'tallytoo-wall') ?> </p>
            <p><?php _e('The <strong>[tallysection]</strong> short-code is essential, and will be replaced by a unique ID for identifying each donation request block (you can have multiple per page). In the case where the user has already donated for this content, or there are no monetisation options, the donation request block(s) will be hidden.', 'tallytoo-wall') ?></p>
            <p><?php _e('The tallytoo button will adapt to the size of the container you give to it. We recommend however, a minimum size of 240x54 pixels. Smaller versions will work (the button is fully responsive), but the indicators that incite your users to earn and spend points on your site may be less visible.', 'tallytoo-wall') ?></p>            
          </label>
          <textarea id="tallytoo_donateinline_html_editor" rows="5" name="<?php echo tt_donateinline_html_var() ?>" class="widefat textarea"><?php echo wp_unslash( $setting ); ?></textarea>   
      </fieldset>

      <?php
  }


  function tallytoo_donateinline_css_cb()
  {
      $setting = tt_get_donateinline_css();
      ?>

      <fieldset>
          <label for="<?php echo tt_donateinline_css_var() ?>">
            <p><?php _e('The following css will be used to style the above html.', 'tallytoo-wall') ?></p>
            <p><?php _e('Note that the tallytoo button styling cannot be done by css, but rather in the <strong>Appearance</strong> option menu of this plugin.', 'tallytoo-wall') ?></p>
          </label>
          <textarea id="tallytoo_donateinline_css_editor" rows="5" name="<?php echo tt_donateinline_css_var() ?>" class="widefat textarea"><?php echo wp_unslash( $setting ); ?></textarea>   
      </fieldset>

      <?php
  }


  function tt_add_settings_donateinline_scripts( $hook ) {   

    global $tt_settings_donateinline_page;
	  if( $hook != $tt_settings_donateinline_page ) 
		  return;

    wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
    
    wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '../scripts/code-editor-empty.js', array( 'jquery' ), '', true );    

    $create_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/code-editor.js');
    $create_script = str_replace('__ELEMENT_ID__', 'tallytoo_donateinline_html_editor' , $create_script);
    $create_script = str_replace('__EDIT_MODE__', 'text/html' , $create_script);
    wp_add_inline_script('js-code-editor',  $create_script, 'after');

    $create_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/code-editor.js');
    $create_script = str_replace('__ELEMENT_ID__', 'tallytoo_donateinline_css_editor' , $create_script);
    $create_script = str_replace('__EDIT_MODE__', 'text/css' , $create_script);
    wp_add_inline_script('js-code-editor',  $create_script, 'after');

    //wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '/code-editor.js', array( 'jquery' ), '', true );    

    wp_enqueue_script( 'tallybutton',  getScriptSrc(), false );
    wp_add_inline_script('tallybutton',  getTallybuttonCreateScript(), 'after');

  }
  add_action('admin_enqueue_scripts', 'tt_add_settings_donateinline_scripts' );

?>