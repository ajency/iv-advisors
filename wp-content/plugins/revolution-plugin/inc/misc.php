<?php

// Remove Type Attribute.
function thb_clean_type_tag( $input ) {
  $input = str_replace( "type='text/javascript' ", '', $input );
  $input = str_replace( "type='text/css' ", '', $input );
  return $input;
}
add_filter( 'script_loader_tag', 'thb_clean_type_tag' );
add_filter( 'style_loader_tag', 'thb_clean_type_tag' );