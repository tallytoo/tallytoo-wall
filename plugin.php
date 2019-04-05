<?php
/**
 * Plugin Name:  tallytoo wall (beta)
 * Plugin URI: https://tallytoo.com/publishers/integration/wordpress-plugin-tallytoo-wall/
 * Description: Plugin that provides a paywall, donate-wall or donate implementation, based on the tallytoo button.
 * Author: tallytoo
 * Version: v.0.2-beta
 * Text Domain: tallytoo-wall
 */

/// Update the readme : https://generatewp.com/plugin-readme/
/// Header requirements : https://developer.wordpress.org/plugins/plugin-basics/header-requirements/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$_TALLYTOO_PLUGIN_URL = "https://code.app.tallytoo.com/tallybutton-latest.min.js";

// CONSTANTS
$_TALLYTOO_BASE_URL = "https://app.tallytoo.com";
$_TALLYTOO_PUB_KEY = "/api/v1/tallybutton/public_key";
$_TALLYTOO_PUBLISHER_PORTAL = "/publisher";
$_TALLYTOO_PUBLISHER_PORTAL_SIGNUP = "/account/signup/publisher";

// Localisation
require_once( plugin_dir_path(__FILE__) . 'src/localisation/localisation.php');

// All the global settings and their accessors
require_once( plugin_dir_path(__FILE__) . 'src/global_settings/settings.php');


// TODO: ORGANISE THIS BETTER
function tt_get_fade($uniqueId = null) {

  $id = '';
  if ($uniqueId) {
    $id=' id="'.$uniqueId.'" ';
  }
  return '<div '.$id.' class="tt-fadeover"></div>';
}

function tt_getPublisherPortal() {
  return tt_get_base_url().$GLOBALS["_TALLYTOO_PUBLISHER_PORTAL"];
}

function tt_getPublisherSignup() {
  return tt_get_base_url().$GLOBALS["_TALLYTOO_PUBLISHER_PORTAL_SIGNUP"];
}

function str_replace_first($search, $replace, $subject) {
  $pos = strpos($subject, $search);
  if ($pos !== false) {
      return substr_replace($subject, $replace, $pos, strlen($search));
  }
  return $subject;
}


// Helper functions for the tallybutton
require_once( plugin_dir_path(__FILE__) . 'src/tallybutton_script.php');

// Admin page
require_once( plugin_dir_path(__FILE__) . 'src/global_settings/settings_page.php');

// Content meta-boxes
require_once( plugin_dir_path(__FILE__) . 'src/post_settings/post_settings.php');

// Post and page treatment
require_once( plugin_dir_path(__FILE__) . 'src/post/post.php');


?>