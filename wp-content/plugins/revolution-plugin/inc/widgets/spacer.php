<?php
// Spacer Widget
class widget_thb_spacer extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_thb_spacer',
			'description' => esc_html__('Adds a spacer','revolution')
		);

		parent::__construct(
			'thb_thb_spacer_widget',
			esc_html__( 'Fuel Themes - Spacer' , 'revolution' ),
			$widget_ops
		);

		$this->defaults = array( 'value' => '' );
	}

	function widget($args, $instance) {
		extract( $args );
		$value = $instance['value'];

		$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
		$regexr = preg_match( $pattern, $value, $matches );
		$value = isset( $matches[1] ) ? (float) $matches[1] : (float) $value;
		$unit = isset( $matches[2] ) ? $matches[2] : 'px';
		$height = $value . $unit;

		?>
		<div class="vc_empty_space" style="height: <?php echo esc_attr($height); ?>;"></div>
		<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['value'] = strip_tags( $new_instance['value'] );
		return $instance;
	}
	function form($instance) {
		$defaults = $this->defaults;
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p><?php esc_html_e('You can enter any height value, for example: 400px, 10vh, 20%', 'revolution' ); ?></p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'value' )); ?>"><?php esc_html_e('Height:', 'revolution' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'value' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'value' )); ?>" value="<?php echo esc_attr($instance['value']); ?>" class="widefat" />
		</p>
	<?php
	}
}