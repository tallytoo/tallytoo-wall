
<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


/// -------------- Visual Editor --------------- ///

function tallytoo_enqueue_plugin_scripts($plugin_array)
{
    $plugin_array["tallytoo_plugin"] =  plugin_dir_url(__FILE__) . "../scripts/tinymce.plugin.js";
    return $plugin_array;
}
add_filter("mce_external_plugins", "tallytoo_enqueue_plugin_scripts");

function tallytoo_register_buttons_editor($buttons)
{
    //register buttons with their id.
    array_push($buttons, "tallytoo_paywall");
    array_push($buttons, "tallytoo_donatewall");
    array_push($buttons, "tallytoo_donate");
    array_push($buttons, "tallytoo_fade");
    return $buttons;
}

add_filter("mce_buttons", "tallytoo_register_buttons_editor");

/// -------------- Text Editor --------------- ///

// add more buttons to the html editor
function tallytoo_add_quicktags() {
  if (wp_script_is('quicktags')){
?>
  <script type="text/javascript">
  QTags.addButton( 'tallytoo_paywall', "<?php _e('tallytoo paywall', 'tallytoo-wall') ?>", '[tallytoo-paywall cost=1]', '[/tallytoo-paywall]', null, "<?php _e('tallytoo paywall', 'tallytoo-wall') ?>");
  QTags.addButton( 'tallytoo_donatewall', "<?php _e('tallytoo donate wall', 'tallytoo-wall') ?>", '[tallytoo-donatewall cost=1]', '[/tallytoo-donatewall]', null, "<?php _e('tallytoo donatewall', 'tallytoo-wall') ?>");
  QTags.addButton( 'tallytoo_donate', "<?php _e('tallytoo donate', 'tallytoo-wall') ?>", '[tallytoo-donate cost=1]', '[/tallytoo-donate]', null, "<?php _e('tallytoo donate', 'tallytoo-wall') ?>");
  QTags.addButton( 'tallytoo_fade', "<?php _e('tallytoo fade', 'tallytoo-wall') ?>", '[tallytoo-fade]', '[/tallytoo-fade]', null, "<?php _e('tallytoo fade', 'tallytoo-wall') ?>");
  
  </script>
<?php
  }
}
add_action( 'admin_print_footer_scripts', 'tallytoo_add_quicktags' );

?>