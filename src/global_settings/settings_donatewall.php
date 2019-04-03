<?php
  defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

  
  $_TT_SETTINGS_DONATEWALL_SLUG = "tallytoo-settings-donatewall";

  function tt_register_settings_donatewall() {

    $section_slug = 'tallytoo_settings_donatewall';

    add_settings_section(
      $section_slug,       // Slug-name to identify the section
      null,                      // Formatted title of the section
      'tt_donatewall_section_html',          // Callback
      $GLOBALS['_TT_SETTINGS_DONATEWALL_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );

    add_settings_field(
      'tallytoo_donatewallhtml',             // Slug-name to identify the field
      __('Donate-wall html', 'tallytoo-wall'),                    // Formatted title of the field
      'tallytoo_donatewall_html_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DONATEWALL_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_donatewallcss',             // Slug-name to identify the field
      __('Donate-wall css', 'tallytoo-wall'),                    // Formatted title of the field
      'tallytoo_donatewall_css_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DONATEWALL_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );
  }
  add_action('admin_init', 'tt_register_settings_donatewall');


  function tt_register_settings_donatewall_page($parent_slug) {
    global $tt_settings_donatewall_page;
    $tt_settings_donatewall_page = add_submenu_page(
      $parent_slug,               // Parent slug
      __("Donate-wall", 'tallytoo-wall'),                 // Title
      __("Donate-wall", 'tallytoo-wall'),                  // Menu title
      "manage_options",           // Capability
      $GLOBALS['_TT_SETTINGS_DONATEWALL_SLUG'],     // Menu slug
      "tt_donatewall_html"      // Callback
    );

    add_action( 'admin_head-'. $tt_settings_donatewall_page, 'tt_donatewall_admin_head' );
    add_action( 'admin_footer-'. $tt_settings_donatewall_page, 'tt_donatewall_admin_footer' );
  }


  function tt_donatewall_admin_head() {
    $css = tt_get_donatewall_css(); 
    echo '<style type="text/css">'.$css.'</style>';
  }

  function tt_donatewall_admin_footer() {
    $load_script = getTallybuttonLoadScript();
    echo '<script>'.$load_script.'</script>';
  }

  function tt_donatewall_html() {
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
              settings_fields($GLOBALS['_TT_SETTINGS_SECTION_DONATEWALL']);

              // output setting sections and their fields
              // (sections are registered for "wporg", each field is registered to a specific section)
              do_settings_sections($GLOBALS['_TT_SETTINGS_DONATEWALL_SLUG']);

              // output save settings button
              submit_button(__('Save Settings', 'tallytoo-wall'));
          ?>   
          </form>

      </div>

    <?php
  }

  function tt_tallyskip($html, $permalink, $containerId = null, $contentContainerId = null, $fadeId = null) {
    $html = str_replace("[tallyskip]", 'window.tallytoo.tally_skip_cb(\''.$permalink.'\',  \''.$containerId.'\', \''.$contentContainerId.'\', \''.$fadeId.'\')', $html);
    return $html;
  }

  function tt_donatewall_section_html() {

    $setting = tt_get_donatewall_html();

    ?>
      <p><?php _e('A donate-wall is like a pay-wall, but a less drastic way of monetising your content. It requests a donation, without restricting access to the content.', 'tallytoo-wall') ?></p>
      <p><?php _e('Surrounding your content with a donate-wall shortcode will prevent that content from being displayed to your user: <strong>[tallytoo-donatewall cost=1] ... content to protect ... [/tallytoo-donatewall]</strong>', 'tallytoo-wall') ?></p>
      <p><?php _e('The following gives a rough preview of how the donate wall will look, although your template styles will make it look different on your site.', 'tallytoo-wall') ?></p>
      <p><?php _e('Please note the difference to the pay-wall: this wall allows the option to by-pass the payment, and access the content.', 'tallytoo-wall') ?></p>
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
                          $tally_elem = '<tallybutton content-id="admin" cost="1" test="true" mode="donate"></tallybutton>';
                          $html = str_replace("[tallybutton]", $tally_elem, $setting);  
                          $html = tt_tallyskip($html, '');   
                          echo $html 
                      ?>
                  </div>
              </div>

          </div>
      </div>

    <?php

    
  }

  function tallytoo_donatewall_html_cb()
  {
      $setting = tt_get_donatewall_html();
      ?>

      <fieldset>
          <label for="<?php echo tt_donatewall_html_var() ?>">
            <p><?php _e('Insert the html for your paywall here. The <strong>[tallybutton]</strong> short-code will be replaced by the real tallytoo button.', 'tallytoo-wall') ?> </p>
            <p><?php _e('Do not forget to add the <strong>[tallysection]</strong> short-code as an ID to your donatewall root element. This allows this plugin to remove the donatewall if necessary.', 'tallytoo-wall') ?> </p>
            <p><?php _e('The <strong>[tallyskip]</strong> short-code is essential for the link or button allowing to bypass the content. It will negotiate free access for your reader (note: you do not get paid by tallytoo in this case).', 'tallytoo-wall') ?> </p>
            <p><?php _e('The button will adapt to the size of the container you give to it. We recommend however, a minimum size of 240x54 pixels. Smaller versions will work (the button is fully responsive), but the indicators that incite your users to earn and spend points on your site may be less visible.', 'tallytoo-wall') ?> </p>            
          </label>
          <textarea id="tallytoo_donatewall_html_editor" rows="5" name="<?php echo tt_donatewall_html_var() ?>" class="widefat textarea"><?php echo wp_unslash( $setting ); ?></textarea>   
      </fieldset>

      <?php
  }


  function tallytoo_donatewall_css_cb()
  {
      $setting = tt_get_donatewall_css();
      ?>

      <fieldset>
          <label for="<?php echo tt_donatewall_css_var() ?>">
            <p><?php _e('The following css will be used to style the above html.', 'tallytoo-wall') ?> </p>
            <p><?php _e('The class <strong>.tt-fadeover</strong> is a special class for providing the fadeout effect over any text that you envelope with the <strong>[tallytoo-fade]</strong> shortcode. You may customize its color as you wish.', 'tallytoo-wall') ?> </p>
            <p><?php _e('Note that the tallytoo button styling cannot be done by css, but rather in the <strong>Appearance</strong> option menu of this plugin.', 'tallytoo-wall') ?></p>
          </label>
          <textarea id="tallytoo_donatewall_css_editor" rows="5" name="<?php echo tt_donatewall_css_var() ?>" class="widefat textarea"><?php echo wp_unslash( $setting ); ?></textarea>   
      </fieldset>

      <?php
  }


  function tt_add_settings_donatewall_scripts( $hook ) {   

    global $tt_settings_donatewall_page;
	  if( $hook != $tt_settings_donatewall_page ) 
		  return;

    wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
    
    wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '../scripts/code-editor-empty.js', array( 'jquery' ), '', true );    

    $create_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/code-editor.js');
    $create_script = str_replace('__ELEMENT_ID__', 'tallytoo_donatewall_html_editor' , $create_script);
    $create_script = str_replace('__EDIT_MODE__', 'text/html' , $create_script);
    wp_add_inline_script('js-code-editor',  $create_script, 'after');

    $create_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/code-editor.js');
    $create_script = str_replace('__ELEMENT_ID__', 'tallytoo_donatewall_css_editor' , $create_script);
    $create_script = str_replace('__EDIT_MODE__', 'text/css' , $create_script);
    wp_add_inline_script('js-code-editor',  $create_script, 'after');

    //wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '/code-editor.js', array( 'jquery' ), '', true );    

    wp_enqueue_script( 'tallybutton',  getScriptSrc(), false );
    wp_add_inline_script('tallybutton',  getTallybuttonCreateScript(), 'after');

  }
  add_action('admin_enqueue_scripts', 'tt_add_settings_donatewall_scripts' );

?>