<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*----------------------------------------------------------------------
----------SETUP ADMINPAGE IN WP BACKEND
----------------------------------------------------------------------*/
function cl_ear_setup_admin_page() {

  //Register Admin Page
  add_menu_page('Cleaner.Earth Customisation Options', 'Cleaner.Earth', 'manage_options', 'cleaner_earth_customisations', 'cl_ear_create_admin_page', '
dashicons-admin-site' , 4);

  //Register Subpages
  add_submenu_page('cleaner_earth_customisations', 'General', 'General', 'manage_options', 'cleaner_earth_customisations', 'cl_ear_create_admin_page');
  add_submenu_page('cleaner_earth_customisations', 'Pop Up Settings', 'Popups', 'manage_options', 'cleaner_earth_customisations_popups', 'cl_ear_create_popup_admin_page');

  //Register Custom Settings
  add_action('admin_init', 'cl_ear_custom_settings');
}
add_action('admin_menu', 'cl_ear_setup_admin_page');

function cl_ear_create_admin_page(){
  echo "<h1>Cleaner.Earth Customisation Options</h1>";
}

function cl_ear_create_popup_admin_page(){
  require_once(__DIR__ . '/templates/clear-popup-admin.php');
}

function cl_ear_custom_settings(){
  register_setting('cle_ear_popup_settings', '');
}
