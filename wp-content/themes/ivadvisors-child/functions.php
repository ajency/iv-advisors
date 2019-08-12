<?php

function enqueue_theme_styles() {
    wp_enqueue_style('theme-styles', get_template_directory_uri() . '/style.css', array(), '', false);
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );


function iva_register_custom_post_types() {
	$args = array(
	'labels' => array(
	'name' => __('Press Media'),
	'singular_name' => __('Press Media'),
	),
	'public' => true,
	'has_archive' => false,
	'rewrite' => array( 'slug' => 'press_media' ),
	'supports' => array( 'title', 'thumbnail' ),
	);

	register_post_type( 'press_media', $args );
}
add_action( 'init', 'iva_register_custom_post_types' );


function if_change_recipient_comment_notification( $emails, $comment_id ){
 	$recipient_email = 'sunildias@iv-advisors.com';
 
 	return array( $recipient_email );
}
add_filter( 'comment_notification_recipients', 'if_change_recipient_comment_notification', 10, 2 ); 