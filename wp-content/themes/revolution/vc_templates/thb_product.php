<?php function thb_product( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_product', $atts );
  extract( $atts );

  if (!thb_wc_supported()) {
  	return;
  }

	$args = array();

	if ($product_sort == "latest-products") {
		$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'posts_per_page' => $item_count
			);
	} elseif ($product_sort == "featured-products") {
		$args = array(
		    'post_type' => 'product',
		    'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
		    'tax_query'      => array(
		    		array(
		    			'taxonomy' => 'product_visibility',
		    			'field'    => 'name',
		    			'terms'    => 'featured',
		    			'operator' => 'IN',
		    		)
				 ),
		    'posts_per_page' => $item_count
			);
	} elseif ($product_sort == "top-rated") {
		$ordering_args = WC()->query->get_catalog_ordering_args( 'rating', 'asc' );

		$args = array(
		    'post_type' => 'product',
		    'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
		    'posts_per_page' => $item_count,
		    'meta_key' 				=> $ordering_args['meta_key'],
		    'orderby' 				=> $ordering_args['orderby'],
				'order' 				=> $ordering_args['order'],
		);


	} elseif ($product_sort == "sale-products") {
		$args = array(
			    'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'posts_per_page' => $item_count,
				'meta_query'     => array(
	        'relation' => 'OR',
	        array( // Simple products type
	            'key'           => '_sale_price',
	            'value'         => 0,
	            'compare'       => '>',
	            'type'          => 'numeric'
	        ),
	        array( // Variable products type
	            'key'           => '_min_variation_sale_price',
	            'value'         => 0,
	            'compare'       => '>',
	            'type'          => 'numeric'
	        )
	    	)
			);
	} elseif ($product_sort == "by-category"){
		$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'product_cat' => $cat,
				'posts_per_page' => $item_count
			);
	} elseif ($product_sort == "by-id"){
		$product_id_array = explode(',', $product_ids);
		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'   => 1,
			'post__in'		=> $product_id_array
		);
	} else {
		$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'posts_per_page' => $item_count,
				'meta_key' 		=> 'total_sales',
				'orderby' 		=> 'meta_value'
			);
	}
 	$args['meta_query'] = WC()->query->get_meta_query();
 	ob_start();
 	$products = new WP_Query( $args );
 	switch($columns) {
 		case 2:
 			$col = 'medium-6';
 			break;
 		case 3:
 			$col = 'medium-4';
 			break;
 		case 4:
 			$col = 'medium-3';
 			break;
		case 6:
 			$col = 'medium-2';
 			break;
 	}

	if ( $products->have_posts() ) {

	set_query_var( 'thb_animation', $animation );
	?>

		<?php if ($thb_carousel === 'true') { ?>

		<div class="thb-carousel overflow-visible products row" data-columns="<?php echo esc_attr($columns); ?>" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-autoplay-speed="<?php echo esc_attr($autoplay_speed); ?>" data-pagination="true">

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<div>
					<?php $product = wc_get_product( $products->post->ID ); ?>
					<?php set_query_var( 'thb_columns', 'medium-12' ); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				</div>
			<?php endwhile; // end of the loop. ?>

		</div>

		<?php } else {  ?>

		<ul class="products shortcode row">

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<?php set_query_var( 'thb_columns', $col ); ?>
				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		</ul>

		<?php } ?>

	<?php }

   $out = ob_get_clean();

   wp_reset_query();
   wp_reset_postdata();

  return $out;
}
thb_add_short( 'thb_product', 'thb_product');
