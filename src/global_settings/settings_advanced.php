<?php
  defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
  
  $_TT_SETTINGS_ADVANCED_SLUG = "tallytoo-settings-advanced";

  function tt_register_settings_advanced() {

    $section_slug = 'tallytoo_settings_advanced';

    add_settings_section(
      $section_slug,       // Slug-name to identify the section
      null,                      // Formatted title of the section
      'tt_advanced_section_html',          // Callback
      $GLOBALS['_TT_SETTINGS_ADVANCED_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );

    add_settings_field(
      'tallytoo_pluginurl',                  // Slug-name to identify the field
      __('Override tallybutton javascript source', 'tallytoo-wall'),               // Formatted title of the field
      'tallytoo_plugin_url_cb',               // Callback
      $GLOBALS['_TT_SETTINGS_ADVANCED_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_baseurl',                  // Slug-name to identify the field
      __('Override tallytoo service base url', 'tallytoo-wall'),                // Formatted title of the field
      'tallytoo_base_url_cb',               // Callback
      $GLOBALS['_TT_SETTINGS_ADVANCED_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

  }
  add_action('admin_init', 'tt_register_settings_advanced');


  function tt_register_settings_advanced_page($parent_slug) {
    add_submenu_page(
      $parent_slug,               // Parent slug
      __("Advanced", 'tallytoo-wall'),             // Title
      __("Advanced", 'tallytoo-wall'),  // Menu title
      "manage_options",           // Capability
      $GLOBALS['_TT_SETTINGS_ADVANCED_SLUG'],     // Menu slug
      "tt_advanced_html"      // Callback
    );

  }

  function tt_advanced_html() {
    // Check permissions
    if (!current_user_can('manage_options')) {
      return;
    }

    if (isset($_POST['reset_button']) && check_admin_referer('reset_button_clicked')) {
      // the button has been pressed AND we've passed the security check
      tt_reset_plugin();
    }

    ?>
      <div class="wrap">
          <h1><?= esc_html(get_admin_page_title()); ?></h1>

          <form action="options.php" method="post">
          <?php
              // output security fields for the registered setting "wporg_options"
              settings_fields($GLOBALS['_TT_SETTINGS_SECTION_ADVANCED']);

              // output setting sections and their fields
              // (sections are registered for "wporg", each field is registered to a specific section)
              do_settings_sections($GLOBALS['_TT_SETTINGS_ADVANCED_SLUG']);

              // output save settings button
              submit_button(__('Save Settings', 'tallytoo-wall'));
          ?>   
          </form>

          <h1><?php _e('Factory reset', 'tallytoo-wall') ?></h1>
          <p><?php _e('Do so at your own risk! This button will erase all settings, returning them to their original defaults. This includes all paywall html and css.', 'tallytoo-wall') ?></p>
          <p><?php _e('Make sure that you are certain about this factory reset, as there is no undo option!', 'tallytoo-wall') ?></p>
          <form action="admin.php?page=<?php echo $GLOBALS['_TT_SETTINGS_ADVANCED_SLUG'] ?>" method="post">
            <?php
              wp_nonce_field('reset_button_clicked');
              echo '<input type="hidden" value="true" name="reset_button" />';
              submit_button(__('Reset plugin to factory settings', 'tallytoo-wall'));
            ?>
          </form>
      </div>

      

    <?php
  }

  function tt_reset_plugin() {
    tt_factory_reset();
  }


  function tt_advanced_section_html() {
    ?>
    <?php
  }

  
  function tallytoo_plugin_url_cb() {

    $setting = tt_get_plugin_url();
    ?>
    
    <input type="text" name="<?php  echo tt_plugin_url_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_plugin_url_var() ?>"><?php _e('(Advanced) Paste the fully qualified URL of the tallybutton to use.', 'tallytoo-wall') ?></label>
    <?php
  }

  function tallytoo_base_url_cb() {

    $setting = tt_get_base_url();
    ?>
    
    <input type="text" name="<?php  echo tt_base_url_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_base_url_var() ?>"><?php _e('(Advanced) The URL of the base tallytoo service.', 'tallytoo-wall') ?></label>
    <?php
  }


?>