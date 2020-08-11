<?php

add_shortcode('cleaner_inline_gamipress_points', 'cleaner_inline_gamipress_points');

function cleaner_inline_gamipress_points( $atts ){
  $a = shortcode_atts(array(
    'type' => '',
    'current_user' => 'no',
    'label' => 'no',
    'period' => '',
    'period_start' => '',
    'period_end' => '',
  ), $atts);
  if($a['current_user'] == 'yes'){
    $output = '<span class="cleaner-inline-gamipress-user-points gamipress-user-points-' . $a['type'] . '">';
  }else{
    $output = '<span class="cleaner-inline-gamipress-global-points gamipress-user-points-' . $a['type'] . '">';
  }
  $output .= do_shortcode("[gamipress_points type=\"$a[type]\" current_user=\"$a[current_user]\" thumbnail=\"no\" inline=\"yes\" label=\"$a[label]\" period=\"$a[period]\" period_start=\"$a[period_start]\" period_end=\"$a[period_end]\"]");
  $output .= '</span>';
  return $output;
}

add_shortcode('cleaner_coin_sidebar', 'cleaner_coin_sidebar');

function cleaner_coin_sidebar(){
  $output = '';
  $output .= '<div id="coin-sidebar">' .
    do_shortcode(
      '[gamipress_points
      type="bonuspunkte,aktionspunkte"
      thumbnail="yes"
      label="no"
      current_user="yes"]') .
  '</div>';

  $output .= '';
  return $output;
}

function cleaner_output_coin_sidebar(){
  echo do_shortcode('[cleaner_coin_sidebar]');
}
add_action('wp_footer', 'cleaner_output_coin_sidebar');


add_shortcode('cleaner_php_info', 'cleaner_php_info');

function cleaner_php_info( $atts ){
  if(current_user_can('administrator')){

    echo phpinfo();
  }
  return "Yaaaay";
}
