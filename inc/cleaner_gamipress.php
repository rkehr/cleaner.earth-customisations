<?php

if( !defined('ABSPATH') ) exit;

function cleaner_activity_triggers( $triggers ){
  $triggers[__('Cleaner Earth', 'cleaner_customisations')] = array(
    'support_proj1' => __('Projekt 1 unterstützen', 'cleaner_customisations'),
  );
  return $triggers;
}
add_filter( 'gamipress_activity_triggers', 'cleaner_activity_triggers' );
