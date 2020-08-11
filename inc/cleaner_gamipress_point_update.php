<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action('wp_ajax_cl_ear_fetch_point_values', 'cl_ear_fetch_point_values');
add_action('wp_ajax_nopriv_cl_ear_fetch_point_values', 'cl_ear_fetch_point_values');

function cl_ear_fetch_point_values(){
  check_ajax_referer( 'cleaner-earth-nonce' );

  $response = cl_ear_get_point_values();

  $response[ 'success' ] = true;

  $response = json_encode($response);
  echo $response;
  die();
}
function cl_ear_get_point_values(){
  $point_types = gamipress_get_points_types_slugs();

  $result = array();

  foreach($point_types as $point_type){
    $result[$point_type]["currentUser"] = gamipress_get_user_points( 0, $point_type);
    $result[$point_type]["global"] = gamipress_get_site_points( $point_type);
  }

  return $result;
}
