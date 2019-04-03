<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$_TT_SETTINGS_SECTION_REGISTRATION = "tallytoo-plugin-settings-registration";
$_TT_SETTINGS_SECTION_PAYWALL = "tallytoo-plugin-settings-paywall";
$_TT_SETTINGS_SECTION_DONATEWALL = "tallytoo-plugin-settings-donatewall";
$_TT_SETTINGS_SECTION_DONATEINLINE = "tallytoo-plugin-settings-donateinline";
$_TT_SETTINGS_SECTION_DISPLAY = "tallytoo-plugin-settings-display";
$_TT_SETTINGS_SECTION_ADVANCED = "tallytoo-plugin-settings-advanced";

$_TT_SETTINGS_LIST = array();

function tt_register_settings() {
  // Api Key
  tt_register_api_key();

  // Use the cookie or not
  tt_register_use_cookie();

  // Allow free access or not
  tt_register_allow_free();
  
  // Z-index of popover
  tt_register_fun_z_index();
  tt_register_fun_always_popup();
  
  // Paywall CSS and HTML
  tt_register_paywall_html();
  tt_register_paywall_css();

  // Donatewall CSS and HTML
  tt_register_donatewall_html();
  tt_register_donatewall_css();

  // Donateinline CSS and HTML
  tt_register_donateinline_html();
  tt_register_donateinline_css();

  // Tallybutton display
  // tt_register_tallybutton_display();
  tt_register_display_background_color();
  tt_register_display_background_hover_color();
  tt_register_display_background_active_color();
  tt_register_display_title_color();
  tt_register_display_subtitle_color();  
  tt_register_display_social_background_color();
  tt_register_display_social_color();
  tt_register_display_social_border_color();
  tt_register_display_link_color();
  tt_register_display_border_enabled();
  tt_register_display_border_radius();
  tt_register_display_border_width();
  tt_register_display_border_color();

  // Locked icon
  /* 
  tt_register_locked_icon();
  tt_register_locked_icon_height();
  tt_register_locked_icon_enabled();
  */

  // Advanced
  tt_register_plugin_url();
  tt_register_base_url();

  // Excerpt settings
  // register_setting('tallytoo-plugin-settings', 'tallytoo_excerpt_show');
  // register_setting('tallytoo-plugin-settings', 'tallytoo_excerpt_html');
}
add_action('admin_init', 'tt_register_settings');

function tt_factory_reset() {
  foreach ($GLOBALS['_TT_SETTINGS_LIST'] as $setting){
    delete_option($setting);
  }
}


// -------------------------- ADVANCED PLUGIN URL -------------------------- //

// Base URL
function tt_plugin_url_var() {
  return 'tallytoo_plugin_url';
}

function tt_register_plugin_url() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_ADVANCED'], tt_plugin_url_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_plugin_url_var());
}

function tt_get_plugin_url() {
  $value = get_option(tt_plugin_url_var());
  return $value;
}

// JS-Name
function tt_base_url_var() {
  return 'tallytoo_base_url';
}

function tt_register_base_url() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_ADVANCED'], tt_base_url_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_base_url_var());
}

function tt_get_base_url() {
  $value = get_option(tt_base_url_var());
  if (empty($value)) {
    $value = $GLOBALS["_TALLYTOO_BASE_URL"];
  }
  return $value;
}





// -------------------------- API KEY -------------------------- //

function tt_api_key_var() {
  return 'tallytoo_api_key';
}

function tt_register_api_key() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_REGISTRATION'], tt_api_key_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_api_key_var());
}

function tt_get_api_key() {
  $value = get_option(tt_api_key_var());
  return $value;
}

// -------------------------- COOKIE -------------------------- //

function tt_use_cookie_var() {
  return 'tallytoo_use_cookie';
}

function tt_register_use_cookie() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_REGISTRATION'], tt_use_cookie_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_use_cookie_var());
}

function tt_get_use_cookie() {
  $value = get_option(tt_use_cookie_var(), false);      // Default == false
  return $value;
}


// -------------------------- ALLOW FREE -------------------------- //

function tt_allow_free_var() {
  return 'tallytoo_allow_free_access';
}

function tt_register_allow_free() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_REGISTRATION'], tt_allow_free_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_allow_free_var());
}

function tt_get_allow_free() {
  $value = get_option(tt_allow_free_var(), true);      // Default == false
  return $value;
}

// -------------------------- FUN Z-INDEX -------------------------- //

function tt_fun_z_index_var() {
  return 'tallytoo_fun_z_index';
}

function tt_register_fun_z_index() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_REGISTRATION'], tt_fun_z_index_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_fun_z_index_var());
}

function tt_get_fun_z_index() {
  $value = get_option(tt_fun_z_index_var(), 10000);
  if (!$value) {
    $value = 10000;
  }
  return $value;
}

// -------------------------- FUN POPUP -------------------------- //

function tt_fun_always_popup_var() {
  return 'tallytoo_fun_always_popup';
}

function tt_register_fun_always_popup() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_REGISTRATION'], tt_fun_always_popup_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_fun_always_popup_var());
}

function tt_get_fun_always_popup() {
  $value = get_option(tt_fun_always_popup_var(), false);      // Default == false
  return $value;
}

// -------------------------- PAYWALL -------------------------- //

function tt_paywall_html_var() {
  return 'tallytoo_paywall_html';
}

function tt_register_paywall_html() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_PAYWALL'], tt_paywall_html_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_paywall_html_var());
}

function tt_get_paywall_html() {
  $html = get_option(tt_paywall_html_var());
  if (empty($html)) {
      $html = file_get_contents(plugin_dir_path(__FILE__) .'../templates/paywall/paywall.html');
  }
  return $html;
}

function tt_paywall_css_var() {
  return 'tallytoo_paywall_css';
}

function tt_register_paywall_css() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_PAYWALL'], tt_paywall_css_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_paywall_css_var());
}

function tt_get_paywall_css() {
  $css = get_option(tt_paywall_css_var());
  if (empty($css)) {
      $css = file_get_contents(plugin_dir_path(__FILE__) .'../templates/paywall/paywall.css');
  }
  return $css;
}


// -------------------------- DONATE-WALL -------------------------- //

function tt_donatewall_html_var() {
  return 'tallytoo_donatewall_html';
}

function tt_register_donatewall_html() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DONATEWALL'], tt_donatewall_html_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_donatewall_html_var());
}

function tt_get_donatewall_html() {
  $html = get_option(tt_donatewall_html_var());
  if (empty($html)) {
      $html = file_get_contents(plugin_dir_path(__FILE__) .'../templates/donatewall/donatewall.html');
  }
  return $html;
}

function tt_donatewall_css_var() {
  return 'tallytoo_donatewall_css';
}

function tt_register_donatewall_css() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DONATEWALL'], tt_donatewall_css_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_donatewall_css_var());
}

function tt_get_donatewall_css() {
  $css = get_option(tt_donatewall_css_var());
  if (empty($css)) {
      $css = file_get_contents(plugin_dir_path(__FILE__) .'../templates/donatewall/donatewall.css');
  }
  return $css;
}

// -------------------------- DONATE-INLINE -------------------------- //

function tt_donateinline_html_var() {
  return 'tallytoo_donateinline_html';
}

function tt_register_donateinline_html() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DONATEINLINE'], tt_donateinline_html_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_donateinline_html_var());
}

function tt_get_donateinline_html() {
  $html = get_option(tt_donateinline_html_var());
  if (empty($html)) {
      $html = file_get_contents(plugin_dir_path(__FILE__) .'../templates/donateinline/donateinline.html');
  }
  return $html;
}

function tt_donateinline_css_var() {
  return 'tallytoo_donateinline_css';
}

function tt_register_donateinline_css() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DONATEINLINE'], tt_donateinline_css_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_donateinline_css_var());
}

function tt_get_donateinline_css() {
  $css = get_option(tt_donateinline_css_var());
  if (empty($css)) {
      $css = file_get_contents(plugin_dir_path(__FILE__) .'../templates/donateinline/donateinline.css');
  }
  return $css;
}

// -------------------------- LOCKED ICON -------------------------- //
/*
function tt_locked_icon_var() {
  return 'tallytoo_locked_icon';
}

function tt_register_locked_icon() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_PAYWALL'], tt_locked_icon_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_locked_icon_var());
}

function tt_get_locked_icon() {
  $icon = get_option(tt_locked_icon_var());
  return $icon;
}




function tt_locked_icon_height_var() {
  return 'tallytoo_locked_icon_height';
}

function tt_register_locked_icon_height() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_PAYWALL'], tt_locked_icon_height_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_locked_icon_height_var());
}

function tt_get_locked_icon_height() {
  $height = get_option(tt_locked_icon_height_var());
  if (empty($height)) {
    $height = 15;
  }
  return $height;
}


function tt_locked_icon_enabled_var() {
  return 'tallytoo_locked_icon_enabled';
}

function tt_register_locked_icon_enabled() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_PAYWALL'], tt_locked_icon_enabled_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_locked_icon_enabled_var());
}

function tt_get_locked_icon_enabled() {
  $enabled = get_option(tt_locked_icon_enabled_var());  
  return $enabled;
}
*/

// -------------------------- DISPLAY -------------------------- //


function tt_add_comma($str) {
  if (!empty($str)) {
    $str .= ",";
  }
  return $str;
}

function tt_get_param($str, $name, $val) {
  if (!empty($val)) {
    $str = tt_add_comma($str);
    $str .= '"'.$name.'": "'.$val.'"';
  } 
  return $str;
}

function tt_get_tallybutton_display() {
  
  $display = "";
  $display = tt_get_param($display, "backgroundColor",        tt_get_tallybutton_display_background_color());
  $display = tt_get_param($display, "backgroundHoverColor",   tt_get_tallybutton_display_background_hover_color());
  $display = tt_get_param($display, "backgroundActiveColor",  tt_get_tallybutton_display_background_active_color());

  $display = tt_get_param($display, "titleColor",       tt_get_tallybutton_display_title_color());
  $display = tt_get_param($display, "subtitleColor",    tt_get_tallybutton_display_subtitle_color());

  $display = tt_get_param($display, "socialBackgroundColor",       tt_get_tallybutton_display_social_background_color());
  $display = tt_get_param($display, "socialColor",                 tt_get_tallybutton_display_social_color());
  $display = tt_get_param($display, "socialBorderColor",           tt_get_tallybutton_display_social_border_color());

  $display = tt_get_param($display, "linkColor",           tt_get_tallybutton_display_link_color());

  $display = tt_get_param($display, "border",             tt_get_tallybutton_display_border_enabled());
  $display = tt_get_param($display, "borderRadius",        tt_get_tallybutton_display_border_radius());
  $display = tt_get_param($display, "borderWidth",         tt_get_tallybutton_display_border_width());
  $display = tt_get_param($display, "borderColor",         tt_get_tallybutton_display_border_color());


  
  $display = '{'.$display.'}';  
  return $display;
}


// Background color

function tt_tallybutton_display_background_color_var() {
  return 'tallytoo_tallybutton_display_background_color';
}

function tt_register_display_background_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_background_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_background_color_var());
}

function tt_get_tallybutton_display_background_color() {
  $display = get_option(tt_tallybutton_display_background_color_var());  
  return $display;
}

// Background hover color

function tt_tallybutton_display_background_hover_color_var() {
  return 'tallytoo_tallybutton_display_background_hover_color';
}

function tt_register_display_background_hover_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_background_hover_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_background_hover_color_var());
}

function tt_get_tallybutton_display_background_hover_color() {
  $display = get_option(tt_tallybutton_display_background_hover_color_var());  
  return $display;
}

// Background active color

function tt_tallybutton_display_background_active_color_var() {
  return 'tallytoo_tallybutton_display_background_active_color';
}

function tt_register_display_background_active_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_background_active_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_background_active_color_var());
}

function tt_get_tallybutton_display_background_active_color() {
  $display = get_option(tt_tallybutton_display_background_active_color_var());  
  return $display;
}

// Title color

function tt_tallybutton_display_title_color_var() {
  return 'tallytoo_tallybutton_display_title_color';
}

function tt_register_display_title_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_title_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_title_color_var());
}

function tt_get_tallybutton_display_title_color() {
  $display = get_option(tt_tallybutton_display_title_color_var());  
  return $display;
}

// Sub-title color

function tt_tallybutton_display_subtitle_color_var() {
  return 'tallytoo_tallybutton_display_subtitle_color';
}

function tt_register_display_subtitle_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_subtitle_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_subtitle_color_var());
}

function tt_get_tallybutton_display_subtitle_color() {
  $display = get_option(tt_tallybutton_display_subtitle_color_var());  
  return $display;
}


// Social background

function tt_tallybutton_display_social_background_color_var() {
  return 'tallytoo_tallybutton_display_social_background_color';
}

function tt_register_display_social_background_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_social_background_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_social_background_color_var());
}

function tt_get_tallybutton_display_social_background_color() {
  $display = get_option(tt_tallybutton_display_social_background_color_var());  
  return $display;
}

// Social color

function tt_tallybutton_display_social_color_var() {
  return 'tallytoo_tallybutton_display_social_color';
}

function tt_register_display_social_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_social_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_social_color_var());
}

function tt_get_tallybutton_display_social_color() {
  $display = get_option(tt_tallybutton_display_social_color_var());  
  return $display;
}

// Social border color

function tt_tallybutton_display_social_border_color_var() {
  return 'tallytoo_tallybutton_display_social_border_color';
}

function tt_register_display_social_border_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_social_border_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_social_border_color_var());
}

function tt_get_tallybutton_display_social_border_color() {
  $display = get_option(tt_tallybutton_display_social_border_color_var());  
  return $display;
}

// Link color

function tt_tallybutton_display_link_color_var() {
  return 'tallytoo_tallybutton_display_link_color';
}

function tt_register_display_link_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_link_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_link_color_var());
}

function tt_get_tallybutton_display_link_color() {
  $display = get_option(tt_tallybutton_display_link_color_var());  
  return $display;
}


// Border enabled

function tt_tallybutton_display_border_enabled_var() {
  return 'tallytoo_tallybutton_display_border_enabled';
}

function tt_register_display_border_enabled() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_border_enabled_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_border_enabled_var());
}

function tt_get_tallybutton_display_border_enabled() {
  $display = get_option(tt_tallybutton_display_border_enabled_var());  
  return $display;
}

// Border radius

function tt_tallybutton_display_border_radius_var() {
  return 'tallytoo_tallybutton_display_border_radius';
}

function tt_register_display_border_radius() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_border_radius_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_border_radius_var());
}

function tt_get_tallybutton_display_border_radius() {
  $display = get_option(tt_tallybutton_display_border_radius_var());  
  return $display;
}

// Border width

function tt_tallybutton_display_border_width_var() {
  return 'tallytoo_tallybutton_display_border_width';
}

function tt_register_display_border_width() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_border_width_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_border_width_var());
}

function tt_get_tallybutton_display_border_width() {
  $display = get_option(tt_tallybutton_display_border_width_var());  
  return $display;
}

// Border color

function tt_tallybutton_display_border_color_var() {
  return 'tallytoo_tallybutton_display_border_color';
}

function tt_register_display_border_color() {
  register_setting($GLOBALS['_TT_SETTINGS_SECTION_DISPLAY'], tt_tallybutton_display_border_color_var());
  array_push($GLOBALS['_TT_SETTINGS_LIST'], tt_tallybutton_display_border_color_var());
}

function tt_get_tallybutton_display_border_color() {
  $display = get_option(tt_tallybutton_display_border_color_var());  
  return $display;
}



?>