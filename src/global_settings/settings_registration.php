<?php
  defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
  
  $_TT_SETTINGS_REGISTRATION_SLUG = "tallytoo-settings-registration";

  function tt_register_settings_registration() {

    $section_slug = 'tallytoo_settings_registration';

    add_settings_section(
      $section_slug,       // Slug-name to identify the section
      null,                      // Formatted title of the section
      'tt_registration_section_html',          // Callback
      $GLOBALS['_TT_SETTINGS_REGISTRATION_SLUG']        // Slug name of the settings page on which to show the sections (use add_options_page)
    );

    add_settings_field(
      'tallytoo_apikey',                  // Slug-name to identify the field
      __('Publisher API key', 'tallytoo-wall'),                // Formatted title of the field
      'tallytoo_apikey_cb',               // Callback
      $GLOBALS['_TT_SETTINGS_REGISTRATION_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_use_cookie',               // Slug-name to identify the field
      __('Use cookie', 'tallytoo-wall'),                       // Formatted title of the field
      'tallytoo_use_cookie_cb',            // Callback
      $GLOBALS['_TT_SETTINGS_REGISTRATION_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_allow_free',               // Slug-name to identify the field
      __('Allow free access', 'tallytoo-wall'),                 // Formatted title of the field
      'tallytoo_allow_free_cb',            // Callback
      $GLOBALS['_TT_SETTINGS_REGISTRATION_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_fun_z_index',               // Slug-name to identify the field
      __('Popover z-index', 'tallytoo-wall'),                  // Formatted title of the field
      'tallytoo_fun_z_index_cb',            // Callback
      $GLOBALS['_TT_SETTINGS_REGISTRATION_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );

    add_settings_field(
      'tallytoo_fun_always_popup',               // Slug-name to identify the field
      __('Always show ads in popup', 'tallytoo-wall'),                 // Formatted title of the field
      'tallytoo_fun_always_popup_cb',            // Callback
      $GLOBALS['_TT_SETTINGS_REGISTRATION_SLUG'],                // Slug name of the settings page on which to show the section
      $section_slug                       // Slug-name of the section 
    );


    


  }
  add_action('admin_init', 'tt_register_settings_registration');


  function tt_register_settings_registration_page($parent_slug) {
    add_submenu_page(
      $parent_slug,               // Parent slug
      __("Registration", "tallytoo-wall"),             // Title
      __("Registration", "tallytoo-wall"),            // Menu title
      "manage_options",           // Capability
      $GLOBALS['_TT_SETTINGS_REGISTRATION_SLUG'],     // Menu slug
      "tt_registration_html"      // Callback
    );

  }

  function tt_registration_html() {
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
              settings_fields($GLOBALS['_TT_SETTINGS_SECTION_REGISTRATION']);

              // output setting sections and their fields
              // (sections are registered for "wporg", each field is registered to a specific section)
              do_settings_sections($GLOBALS['_TT_SETTINGS_REGISTRATION_SLUG']);

              // output save settings button
              submit_button(__('Save Settings', 'tallytoo-wall'));
          ?>   
          </form>

      </div>

    <?php
  }


  function tt_registration_section_html() {
    ?>
    <?php
  }

  function tallytoo_apikey_cb() {

    $setting = tt_get_api_key();
    
    $signup_link = tt_getPublisherSignup();
    $portal_link = tt_getPublisherPortal();

    printf( 
      __(
        '<p>In order to use the tallytoo button on your website, you need to <a href=%1$s target="_blank">create an account with tallytoo</a> (or <a href="%2$s" target="_blank">log-in</a>).</p>
        <p>If you have just created an account, you need to wait for your account to be validated by tallytoo.</p>
        <p>Once your account has been validated: </p>
        <ol>
          <li>Navigate to <strong>Integration</strong></li>
          <li>Add the <strong>domain</strong> for this website to the list of allowed domains (be sure to include https://...)</li>
          <li>Create an <strong>api-key</strong></li>
        </ol>
        <p>Once you have created the api key, copy the value of that key here.</p>',
        "tallytoo-wall"
      ),
      $signup_link,
      $portal_link 
    )
    ?>

    <input type="text" name="<?php  echo tt_api_key_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <label for="<?php echo tt_api_key_var() ?>"><?php _e('Copy the API key that you generated for this website.', "tallytoo-wall") ?></label>
    <?php
  }


  function tallytoo_use_cookie_cb()
  {
      // get the value of the setting we've registered with register_setting()
      $setting = tt_get_use_cookie();
      
      ?>
      <input type="checkbox" name="<?php echo tt_use_cookie_var() ?>" value="1"  <?php checked("1", $setting);?>><br>	
      <label for="<?php echo tt_use_cookie_var() ?>"><?php _e('If unchecked, the authorisation token will be sent via query paramaters in the URI', "tallytoo-wall") ?></label>
      <?php
  }

  function tallytoo_allow_free_cb()
  {
      // get the value of the setting we've registered with register_setting()
      $setting = tt_get_allow_free();
      
      ?>
      <input type="checkbox" name="<?php echo tt_allow_free_var() ?>" value="1"  <?php checked("1", $setting);?>><br>	
      <label for="<?php echo tt_allow_free_var() ?>"><?php _e('If checked, the website will automatically unlock the content if no payment alternative was found by tallytoo.', "tallytoo-wall") ?></label>
      <?php
  }

  function tallytoo_fun_z_index_cb()
  {
      $setting = tt_get_fun_z_index();
      ?>
      <input type="number" name="<?php echo tt_fun_z_index_var() ?>" style="width: 100%;" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
      <label for="<?php echo tt_fun_z_index_var() ?>"><?php _e('The z-index of the tallytoo popover. Should be greater than any other element for the best experience.', "tallytoo-wall") ?></label>
      <?php
  }

  function tallytoo_fun_always_popup_cb()
  {
      // get the value of the setting we've registered with register_setting()
      $setting = tt_get_fun_always_popup();
      
      ?>
      <input type="checkbox" name="<?php echo tt_fun_always_popup_var() ?>" value="1"  <?php checked("1", $setting);?>><br>	
      <label for="<?php echo tt_fun_always_popup_var() ?>"><?php _e('If checked, the tallytoo ads will appear as a popup rather than an overlay. This has the advantage of getting around layout issues if your site-template does strange things to the body and html tags. We would recommend (if possible) leaving this setting off for a smoother user-experience.', "tallytoo-wall") ?></label>
      <?php
  }


?>