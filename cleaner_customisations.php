<?php
/**
* Plugin Name: cleaner.earth Customisations NEW
*Description: A few customisations and fixes for cleaner.earth
*Version: 0.0.1
*Author: Robin Kehr
*Author URI: robinkehr.de
 */


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


require_once 'inc/cleaner_gamipress.php';
require_once 'inc/cleaner_gamipress_point_update.php';
require_once 'inc/cleaner_gamipress_point_display.php';
require_once 'inc/cleaner_admin.php';



/*----------------------------------------------------------------------
----------ENQUEUE GLOBAL STYLESHEETS & SCRIPTS
----------------------------------------------------------------------*/
function cl_ear_enqueue_styles(){
  wp_enqueue_style('cl_ear_style', plugin_dir_url( __FILE__ ) . 'css/cleaner_style.css');

}
add_action('wp_print_styles', 'cl_ear_enqueue_styles');

function cl_ear_enqueue_scripts(){
  $points_types = gamipress_get_points_types_slugs();
  $points_values = cl_ear_get_point_values();
  wp_register_script('cl_ear_script', plugin_dir_url( __FILE__ ) . 'js/cleaner_js.js', '', '', true);
  wp_localize_script(
    'cl_ear_script',
    'cl_ear_globals',
    [
      'ajax_url'  => admin_url('admin-ajax.php'),
      'nonce'     => wp_create_nonce('cleaner-earth-nonce'),
      'points_types' => $points_types,
      'points_values' => $points_values,
    ]);
  wp_enqueue_script('cl_ear_script');
  wp_register_script('CountUpJs', plugin_dir_url( __FILE__ ) . 'js/countup.js', '', '', true);
  wp_enqueue_script('CountUpJs');
}
add_action('wp_print_scripts', 'cl_ear_enqueue_scripts',-10);

function cl_load_dashicons(){
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'cl_load_dashicons');

function wpdocs_dequeue_script() {
    wp_dequeue_script( 'gdpr-framework-cookie_popupconsent-js');
}
add_action( 'wp_print_scripts', 'wpdocs_dequeue_script', 100 );
