<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function tt_add_meta_box($type) {
  add_meta_box(
    'tt_post_settings',         // Unique ID
    __('tallytoo', 'tallytoo-wall'),    // Box title
    'tt_custom_box_html',       // Content callback, must be of type callable
    $type                       // Post type
);
}

function tallytoo_add_settings_box_to_post ()
{
  tt_add_meta_box('post');
}
add_action('add_meta_boxes_post', 'tallytoo_add_settings_box_to_post');

function tallytoo_add_settings_box_to_page ()
{
  tt_add_meta_box('page');
}
add_action('add_meta_boxes_page', 'tallytoo_add_settings_box_to_page');

function tt_get_protection_client_side($id) {
  $protection = get_post_meta($id, '_tallytoo_meta_client_side', true);  
  return $protection;
}

function tt_custom_box_html($post)
{ 
  $client_side = tt_get_protection_client_side($post->ID);    
  ?>
  <p>
    <fieldset>
      <input type="checkbox" id="tt-post-client-side" name="tt_tally_client_side" value="client" class="post-format" <?php checked('client',$client_side); ?> /><label for="tt-post-client-side" ><?php _e('Client-side protection only. Enable this option to unlock protected content directly in the browser without reloading the web-page.', 'tallytoo-wall') ?></label><br>
    </fieldset>      
  </p>
  <?php
}

function tallytoo_save_postdata($post_id)
{
  if (array_key_exists('tt_tally_client_side', $_POST)) {
    update_post_meta(
      $post_id,
      '_tallytoo_meta_client_side',
      $_POST['tt_tally_client_side']
    );
  }
}
add_action('save_post', 'tallytoo_save_postdata');

?>