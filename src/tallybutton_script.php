<?php

function getScriptSrc()
{
  $plugin_url = tt_get_plugin_url();
  if (empty($plugin_url)) {
    $plugin_url = $GLOBALS["_TALLYTOO_PLUGIN_URL"];
  }

  return $plugin_url;
}

function getTallybuttonCreateScript($respond_bought = false) {
  $apikey = tt_get_api_key();
  $zindex = tt_get_fun_z_index();
  $allowFree = tt_get_allow_free();
  $alwaysPopup = tt_get_fun_always_popup();

  $create_script = file_get_contents(plugin_dir_path(__FILE__) .'./scripts/create_tallybutton.js');
  $create_script = str_replace('__APIKEY__', $apikey , $create_script);
  $create_script = str_replace('__POPOVERZ__', $zindex , $create_script);
  $create_script = str_replace('__ALLOW_FREE__', ($allowFree ? 'true': 'false'), $create_script);
  $create_script = str_replace('__ALWAYS_POPUP__', ($alwaysPopup ? 'true': 'false'), $create_script);
  
  $create_script = str_replace('__HANDLE_BOUGHT__', ($respond_bought ? 'true': 'false'), $create_script);

  

  $display = tt_get_tallybutton_display();
  $display = str_replace("\t", '', $display);
  $display = str_replace("\n", '', $display);
  $display = str_replace("\r", '', $display);
  $display = str_replace("\'", '"', $display);

  $create_script = str_replace('__DISPLAY__', $display, $create_script);

  return $create_script;
}

function getTallybuttonLoadScript()
{
  $load_script = file_get_contents(plugin_dir_path(__FILE__) .'./scripts/load_tallybutton.js');
  return $load_script;
}


?>