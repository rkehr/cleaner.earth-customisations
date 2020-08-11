<?php

add_action('wp_ajax_cl_ear_fetch_coin_values', 'cl_ear_fetch_coin_values');
add_action('wp_ajax_nopriv_cl_ear_fetch_coin_values', 'cl_ear_fetch_coin_values');

function cl_ear_fetch_coin_values(){
  check_ajax_referer( 'cleaner-earth-nonce' );

//  $response = array();
  $coin_types = array(
    'helfende_haende',
    'retter_rubel',
    'lingunan_token'
  );
  // foreach($coin_types as $coin_type){
  //   $response[$coin_type] = intval(do_shortcode('[gamipress_points type="'. $cointype .'"      thumbnail="no"  label="no"  current_user="yes"  inline="yes"]'));
  // }
  $response['data'] = 'test';
//  $response[ 'success' ] = true;

  //$response = json_encode($response);
  echo $response;
  die();
}
