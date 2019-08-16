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


 /* Custom login page logo
================================================== */
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url('wp-content/uploads/2019/06/iv-advisor-logo-v1.png');
            height:65px;
            width:320px;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'iv-advisors';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
