<?php
/*
* Template Name: Media
*
*/
	get_header(); 

global $wp_query;
?>

	<?php the_content(); ?>

	<?php 
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		// the query
		$wpb_all_query = new WP_Query(array('post_type'=>'press_media', 'post_status'=>'publish', 'posts_per_page'=> 8, 'paged' => $paged)); ?>

		<?php if ( $wpb_all_query->have_posts() ) : ?>

		<!-- the loop -->
		<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
		<div class="container row">
			<ol class="media-list-view">
				<li class="single-list-item" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<span class="item-date"><?php the_date(''); ?></span> 
					<div class="item-meta">
						<?php if( get_field('press_media_file') ): ?>
							<a class="item-action action-more" href="<?php the_field('press_media_file'); ?>" target="_blank" >
								<span class="meta-title"><?php the_title(''); ?></span>
							</a>
						<?php endif; ?>
						<p class="meta-description"><?php the_field('press_media_publication_name'); ?></p>
					</div>
					<div class="item-actions text-right">
						<?php if( get_field('press_media_file') ): ?>
							<a class="item-action action-more" href="<?php the_field('press_media_file'); ?>" target="_blank" >View Article</a>
						<?php endif; ?>
					</div>

				</li>
			</ol>
		</div>

	<?php endwhile; ?>

	<div class="container pagination_nav">
		<?php

			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wpb_all_query->max_num_pages
			) );
		?>
	</div>


	<?php wp_reset_postdata(); ?>


	<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
	<?php endif; ?>

<?php 
	get_footer(); 
?>

