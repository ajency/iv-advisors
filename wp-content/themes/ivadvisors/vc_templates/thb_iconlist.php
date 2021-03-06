<?php function thb_iconlist( $atts, $content = null ) {
  $atts = vc_map_get_attributes( 'thb_iconlist', $atts );
  extract( $atts );
    
 	
 	$element_id = uniqid('thb-pricing-column-');
 	$list_content_array = explode(',', $list_content);
 	$el_class[] = 'thb-iconlist';
 	$el_class[] = $extra_class;
 	
 	$out ='';
	ob_start();
	?>
    <div class="<?php echo esc_attr(implode(' ', $el_class)); ?>" id="<?php echo esc_attr($element_id); ?>">
    	<ul>
    		<?php foreach ($list_content_array as $list) { ?>
    		  <li class="thb-iconlist-li <?php echo esc_attr($animation); ?>">
    		  	<i class="<?php echo esc_attr($icon);?>"></i>
    		  	<?php echo wp_kses_post($list); ?>
    		  </li>
	      <?php } ?>
    	</ul>
    	<style>
    		<?php if ($thb_icon_color) { ?>
    		#<?php echo esc_attr($element_id); ?>.thb-iconlist .fa {
    			color: <?php echo esc_attr($thb_icon_color); ?>;
    		}
    		<?php } ?>
    		<?php if ($thb_text_color) { ?>
    		#<?php echo esc_attr($element_id); ?>.thb-iconlist {
    			color: <?php echo esc_attr($thb_text_color); ?>;
    		}
    		<?php } ?>
    	</style>
    </div>
  <?php
	$out = ob_get_clean();
	return $out;
}
thb_add_short( 'thb_iconlist', 'thb_iconlist');