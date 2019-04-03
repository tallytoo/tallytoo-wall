<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function tt_load_localisation_plugin() {
  $domain = 'tallytoo-wall';
  $mo_file =  plugin_dir_path(__FILE__) . '../../languages/'. $domain . '-' . get_locale() . '.mo';
  load_textdomain( $domain, $mo_file);   
}
add_action( 'init', 'tt_load_localisation_plugin');


?>