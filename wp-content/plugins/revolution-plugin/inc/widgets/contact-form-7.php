<?php
// Contact Form 7 Widget
class widget_thb_contactform extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_thb_contactform',
			'description' => esc_html__('Display Contact Form 7','revolution')
		);

		parent::__construct(
			'thb_thb_contactform_widget',
			esc_html__( 'Fuel Themes - Contact Form 7' , 'revolution' ),
			$widget_ops
		);

		$this->defaults = array( 'title' => 'Subscribe', 'cf7' => '', 'description' => '' );
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title']);
		$cf7 = $instance['cf7'];
		$description = $instance['description'];
		echo $before_widget;
		echo ($title ? $before_title . $title . $after_title : '');
		if ($description) {
			echo wpautop($description);
		}
		echo do_shortcode('[contact-form-7 id="'.esc_attr($cf7).'"]');
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['cf7'] = strip_tags( $new_instance['cf7'] );
		$instance['description'] = $new_instance['description'];
		return $instance;
	}
	function form($instance) {
		$defaults = $this->defaults;
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Widget Title:', 'revolution' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php esc_html_e('Short Description:', 'revolution' ); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id( 'description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>" class="widefat" rows="3"><?php echo esc_textarea($instance['description']); ?></textarea>
		</p>
		<?php
	    $cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
	    if ( $cf7 ) {
	      ?>
	      <p>
	      <?php foreach ( $cf7 as $cform ) { ?>
    			<label for="<?php echo esc_attr($this->get_field_id($cform->ID)); ?>">
    			<input id="<?php echo esc_attr($this->get_field_id($cform->ID)); ?>" name="<?php echo esc_attr($this->get_field_name('cf7')); ?>" type="radio" value="<?php echo esc_html($cform->ID); ?>" <?php checked( $instance['cf7'], $cform->ID) ?> /> <?php echo esc_html($cform->post_title); ?></label><br>
    		<?php
	      }
	      ?>
	      </p>
	    <?php } else { ?>
	      <p><?php esc_html_e( 'No contact forms found', 'revolution' ); ?>
	  <?php } ?>
	<?php
	}
}