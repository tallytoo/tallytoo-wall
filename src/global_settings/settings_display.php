<?php
  defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
  
  $_TT_SETTINGS_DISPLAY_SLUG = "tallytoo-settings-display";

  function tt_register_settings_display() {

    $buttonslug = 'tallytoo_settings_button';
    $titleslug = 'tallytoo_settings_title';
    $social_slug = 'tallytoo_settings_social';
    $link_slug = 'tallytoo_settings_link';
    $corners_slug = 'tallytoo_settings_corners';
    $borders_slug = 'tallytoo_settings_borders';

    add_settings_section(
      $buttonslug,       // Slug-name to identify the section
      __('Primary colors and behaviour', 'tallytoo-wall'),                     // Formatted title of the section
      'tt_display_section_html',          // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );

    add_settings_section(
      $titleslug,       // Slug-name to identify the section
      __('Main text colors', 'tallytoo-wall'),                      // Formatted title of the section
      null,          // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );


    add_settings_section(
      $social_slug,       // Slug-name to identify the section
      __('Social band colors', 'tallytoo-wall'),                      // Formatted title of the section
      'tt_social_explain_cb',          // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );


    add_settings_section(
      $link_slug,       // Slug-name to identify the section
      __('Link colors', 'tallytoo-wall'),                      // Formatted title of the section
      null,          // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );

    add_settings_section(
      $corners_slug,       // Slug-name to identify the section
      __('Corners', 'tallytoo-wall'),                      // Formatted title of the section
      null,          // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );

    add_settings_section(
      $borders_slug,       // Slug-name to identify the section
      __('Borders', 'tallytoo-wall'),                      // Formatted title of the section
      null,          // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );


    add_settings_field(
      'tallytoo_displaybackgroundcolor',             // Slug-name to identify the field
      __('Background color', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_background_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $buttonslug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_displaybackgroundhovercolor',             // Slug-name to identify the field
      __('Hover color', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_background_hover_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $buttonslug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_displaybackgroundactivecolor',             // Slug-name to identify the field
      __('Active color', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_background_active_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $buttonslug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_displaytitlecolor',             // Slug-name to identify the field
      __('Title text color', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_title_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $titleslug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_displaysubtitlecolor',             // Slug-name to identify the field
      __('Subtitle text color', 'tallytoo-wall'),                    // Formatted title of the field
      'tallytoo_subtitle_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $titleslug                       // Slug-name of the section 
    );
    
    add_settings_field(
      'tallytoo_displaysocialbackgroundcolor',             // Slug-name to identify the field
      __('Social band background color', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_social_background_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $social_slug                       // Slug-name of the section 
    );
    add_settings_field(
      'tallytoo_displaysocialcolor',             // Slug-name to identify the field
      __('Social band text color', 'tallytoo-wall'),                    // Formatted title of the field
      'tallytoo_social_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $social_slug                       // Slug-name of the section 
    );
    add_settings_field(
      'tallytoo_displaysocialbordercolor',             // Slug-name to identify the field
      __('Social band border color', 'tallytoo-wall'),                    // Formatted title of the field
      'tallytoo_social_border_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $social_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_displaylinkcolor',             // Slug-name to identify the field
      __('Links text color', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_link_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $link_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_displayborderenabled',             // Slug-name to identify the field
      __('Border enabled', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_border_enabled_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $borders_slug                       // Slug-name of the section 
    );
    add_settings_field(
      'tallytoo_displayborderradius',             // Slug-name to identify the field
      __('Corner radius', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_border_radius_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $corners_slug                       // Slug-name of the section 
    );
    add_settings_field(
      'tallytoo_displayborderwidth',             // Slug-name to identify the field
      __('Border width', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_border_width_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $borders_slug                       // Slug-name of the section 
    );
    add_settings_field(
      'tallytoo_displaybordercolor',             // Slug-name to identify the field
      __('Border color', 'tallytoo-wall'),                     // Formatted title of the field
      'tallytoo_border_color_cb',         // Callback
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],                // Slug name of the settings page on which to show the section
      $borders_slug                       // Slug-name of the section 
    );

  }
  add_action('admin_init', 'tt_register_settings_display');


  function tt_register_settings_display_page($parent_slug) {
    global $tt_settings_display_page;
    $tt_settings_display_page = add_submenu_page(
      $parent_slug,               // Parent slug
      __("Tallytoo button appearance", 'tallytoo-wall'),                  // Title
      __("Appearance", 'tallytoo-wall'),                  // Menu title
      "manage_options",           // Capability
      $GLOBALS['_TT_SETTINGS_DISPLAY_SLUG'],     // Menu slug
      "tt_display_html"      // Callback
    );

    add_action( 'admin_head-'. $tt_settings_display_page, 'tt_paywall_display_admin_head' );
    add_action( 'admin_footer-'. $tt_settings_display_page, 'tt_display_admin_footer' );
  }


  function tt_paywall_display_admin_head() {
    $css = tt_get_donatewall_css(); 
    echo '<style type="text/css">'.$css.'</style>';
  }

  function tt_display_admin_footer() {
    $load_script = getTallybuttonLoadScript();
    echo '<script>'.$load_script.'</script>';

    $color_script = "jQuery(document).ready(function($){";
    $color_script .= "$('#".tt_tallybutton_display_background_color_var()."').wpColorPicker();";
    $color_script .= "$('#".tt_tallybutton_display_background_hover_color_var()."').wpColorPicker();";
    $color_script .= "$('#".tt_tallybutton_display_background_active_color_var()."').wpColorPicker();";
    $color_script .= "$('#".tt_tallybutton_display_title_color_var()."').wpColorPicker();";
    $color_script .= "$('#".tt_tallybutton_display_subtitle_color_var()."').wpColorPicker();";
    $color_script .= "$('#".tt_tallybutton_display_social_background_color_var()."').wpColorPicker();";
    $color_script .= "$('#".tt_tallybutton_display_social_color_var()."').wpColorPicker();";
    $color_script .= "$('#".tt_tallybutton_display_social_border_color_var()."').wpColorPicker();";
    $color_script .= "$('#".tt_tallybutton_display_link_color_var()."').wpColorPicker();";
    $color_script .= "$('#".tt_tallybutton_display_border_color_var()."').wpColorPicker();";
    $color_script .= "});";

    echo '<script>'.$color_script.'</script>';
  }

  function tt_display_html() {
    // Check permissions
    if (!current_user_can('manage_options')) {
      return;
    }

    ?>
      <div class="wrap">
          <h1><?= esc_html(get_admin_page_title()); ?></h1>

          <?php tt_appearance_preview(); ?>

          <form action="options.php" method="post">
          <?php
              // output security fields for the registered setting "wporg_options"
              settings_fields($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY']);

              // output setting sections and their fields
              // (sections are registered for "wporg", each field is registered to a specific section)
              do_settings_sections($GLOBALS['_TT_SETTINGS_DISPLAY_SLUG']);

              // output save settings button
              submit_button(__('Save Settings', 'tallytoo-wall'));
          ?>   
          </form>

      </div>

    <?php
  }

  function tt_appearance_preview() {
    $setting = tt_get_paywall_html();

    ?>
      <p><?php _e('The tallytoo button can be fully customised to best fit in with the color schemes of your website. Everything can be modified except the font-styles and the tallytoo logo.', 'tallytoo-wall') ?></p>
      <p><?php _e('The following gives a rough idea of how the tallytoo button will appear in a pay-wall. Customise and save using the options below. On each save, the tallytoo button will be reloaded with your new configuration.', 'tallytoo-wall') ?></p>
      
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
                          $html = tt_tallyskip($html, '');   
                          echo $html 
                      ?>
                  </div>
              </div>

          </div>
      </div>

    <?php
  }

  
  function tt_display_section_html() {
    
    
  }

  function tallytoo_background_color_cb() {
    $setting = tt_get_tallybutton_display_background_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_background_color_var() ?>" name="<?php  echo tt_tallybutton_display_background_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_background_color_var() ?>"><?php _e('Tallytoo button background color', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_background_hover_color_cb() {
    $setting = tt_get_tallybutton_display_background_hover_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_background_hover_color_var() ?>" name="<?php  echo tt_tallybutton_display_background_hover_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_background_hover_color_var() ?>"><?php _e('Tallytoo button hover color', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_background_active_color_cb() {
    $setting = tt_get_tallybutton_display_background_active_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_background_active_color_var() ?>" name="<?php  echo tt_tallybutton_display_background_active_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_background_active_color_var() ?>"><?php _e('Tallytoo button active color', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_title_color_cb() {
    $setting = tt_get_tallybutton_display_title_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_title_color_var() ?>" name="<?php  echo tt_tallybutton_display_title_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_title_color_var() ?>"><?php _e('Tallytoo button title text color', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_subtitle_color_cb() {
    $setting = tt_get_tallybutton_display_subtitle_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_subtitle_color_var() ?>" name="<?php  echo tt_tallybutton_display_subtitle_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_subtitle_color_var() ?>"><?php _e('Tallytoo button subtitle text color', 'tallytoo-wall') ?></label>
    <?php
  }

  function tt_social_explain_cb() {
    _e("The small bar just under the main button is what we call the <strong>social band</strong>. Its objective is to encourage your readers to join the community in supporting your article. It is an important aspect of encouraging users to use the tallytoo service.", 'tallytoo-wall');
  }

  function tallytoo_social_background_color_cb() {
    $setting = tt_get_tallybutton_display_social_background_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_social_background_color_var() ?>" name="<?php  echo tt_tallybutton_display_social_background_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_social_background_color_var() ?>"><?php _e('Tallytoo button social-band background color', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_social_color_cb() {
    $setting = tt_get_tallybutton_display_social_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_social_color_var() ?>" name="<?php  echo tt_tallybutton_display_social_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_social_color_var() ?>"><?php _e('Tallytoo button social-band text color', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_social_border_color_cb() {
    $setting = tt_get_tallybutton_display_social_border_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_social_border_color_var() ?>" name="<?php  echo tt_tallybutton_display_social_border_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_social_border_color_var() ?>"><?php _e('Tallytoo button social-band border color', 'tallytoo-wall') ?></label>
    <?php
  }
  
  function tallytoo_link_color_cb() {
    $setting = tt_get_tallybutton_display_link_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_link_color_var() ?>" name="<?php  echo tt_tallybutton_display_link_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_link_color_var() ?>"><?php _e('Tallytoo button links text color', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_border_enabled_cb() {
    $setting = tt_get_tallybutton_display_border_enabled();
      
    ?>
    <input type="checkbox" name="<?php echo tt_tallybutton_display_border_enabled_var() ?>" value="1"  <?php checked("1", $setting);?>><br>	
    <label for="<?php echo tt_tallybutton_display_border_enabled_var() ?>"><?php _e('Add a border to the tallytoo button', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_border_radius_cb() {
    $setting = tt_get_tallybutton_display_border_radius();
    ?>
    
    <input type="number" name="<?php  echo tt_tallybutton_display_border_radius_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_border_radius_var() ?>"><?php _e('The radius of the tallytoo button corners (0 or empty for sharp corners)', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_border_width_cb() {
    $setting = tt_get_tallybutton_display_border_width();
    ?>
    
    <input type="number" name="<?php  echo tt_tallybutton_display_border_width_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_border_width_var() ?>"><?php _e('The width (in pixels) of the tallytoo button border, if enabled', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_border_color_cb() {
    $setting = tt_get_tallybutton_display_border_color();
    ?>
    
    <input type="text" id="<?php  echo tt_tallybutton_display_border_color_var() ?>" name="<?php  echo tt_tallybutton_display_border_color_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_tallybutton_display_border_color_var() ?>"><?php _e('The color of the tallytoo button border, if enabled', 'tallytoo-wall') ?></label>
    <?php
  }

  /*function tallytoo_donatewall_html_cb()
  {
      $setting = tt_get_donatewall_html();
      ?>

      <fieldset>
          <label for="<?php echo tt_donatewall_html_var() ?>">Insert the html that represents your donate-wall here.</label>
          <textarea id="tallytoo_donatewall_html_editor" rows="5" name="<?php echo tt_donatewall_html_var() ?>" class="widefat textarea"><?php echo wp_unslash( $setting ); ?></textarea>   
      </fieldset>

      <?php
  }


  function tallytoo_donatewall_css_cb()
  {
      $setting = tt_get_donatewall_css();
      ?>

      <fieldset>
          <label for="<?php echo tt_donatewall_css_var() ?>">Insert the css corresponding to your donate-wall.</label>
          <textarea id="tallytoo_donatewall_css_editor" rows="5" name="<?php echo tt_donatewall_css_var() ?>" class="widefat textarea"><?php echo wp_unslash( $setting ); ?></textarea>   
      </fieldset>

      <?php
  }
  */

  function tt_add_settings_display_scripts( $hook ) {   

    global $tt_settings_display_page;
	  if( $hook != $tt_settings_display_page ) 
		  return;


    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'tt-color-picker', plugin_dir_url( __FILE__ ) . '../scripts/color-picker.js', array( 'wp-color-picker' ), false, true );


    

    //wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
    
    /*
    wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '../scripts/code-editor-empty.js', array( 'jquery' ), '', true );    

    $create_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/code-editor.js');
    $create_script = str_replace('__ELEMENT_ID__', 'tallytoo_donatewall_html_editor' , $create_script);
    $create_script = str_replace('__EDIT_MODE__', 'text/html' , $create_script);
    wp_add_inline_script('js-code-editor',  $create_script, 'after');

    $create_script = file_get_contents(plugin_dir_path(__FILE__) .'../scripts/code-editor.js');
    $create_script = str_replace('__ELEMENT_ID__', 'tallytoo_donatewall_css_editor' , $create_script);
    $create_script = str_replace('__EDIT_MODE__', 'text/css' , $create_script);
    wp_add_inline_script('js-code-editor',  $create_script, 'after');
    */
    //wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '/code-editor.js', array( 'jquery' ), '', true );    

    wp_enqueue_script( 'tallybutton',  getScriptSrc(), false );
    wp_add_inline_script('tallybutton',  getTallybuttonCreateScript(), 'after');

  }
  add_action('admin_enqueue_scripts', 'tt_add_settings_display_scripts' );
  
?>