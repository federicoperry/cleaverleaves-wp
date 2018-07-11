<?php 
if( $limit < $column){
	$limit = $column;
}
$enable_rtl 			= convert_boolean($enable_rtl);
$enable_navigation	= convert_boolean($enable_navigation);
$enable_pagination	= convert_boolean($enable_pagination);
$enable_loop 			= convert_boolean($enable_loop);
$enable_mousedrag 	= convert_boolean($enable_mousedrag);
$enable_touchdrag 	= convert_boolean($enable_touchdrag);
// conert_integer is function in mixes-function.php
$slide_by 				= convert_integer($slide_by,1); 
$margin_item 			= convert_integer($margin_item,0); 
$default_items			= convert_integer($default_items,4);
$mobile_items 			= convert_integer($mobile_items,1);
$tablet_small_items 	= convert_integer($tablet_small_items,2);
$tablet_items 			= convert_integer($tablet_items,2);
$portrait_items 		= convert_integer($portrait_items,3);
$large_items 			= convert_integer($large_items,5);
//$custom_items 			= convert_integer($custom_items,1);
$autoplay 				= convert_boolean($autoplay);
$speed 					= convert_integer($speed,3000);


$categories = 0;
if ($category && !empty($category)) {
	$categories = explode(',', $category);
}
if( class_exists("Opalmedical_Query") ):
$query = Opalmedical_Query::get_service_by_term_slug( $categories, $limit );

$args_template = array(
	'show_category'		=> $show_category,
	'show_thumbnail'		=> $show_thumbnail,
	'show_description'	=> $show_description,
	'max_char'				=> $max_char,
	'image_size'			=> $image_size,
	'show_learnmore'	 	=> $show_learnmore,
	'title'					=> $title,
	'description'			=> $description,
);

$id = rand();
$colclass = floor(12/$column);  
?>
<div class="widget widget-medical-service">
	<div class="widget-content">
		<div class="opalmedical-recent-service opalmedical-rows">
			<?php if( $query->have_posts() ): ?> 
			<div class="owl-carousel-play">
				<div class="owl-carousel" data-slide="<?php echo esc_attr($column); ?>" 
				  data-rtl="<?php echo esc_attr($enable_rtl); ?>" data-navigation="<?php echo esc_attr($enable_navigation); ?>" 
				  data-pagination="<?php echo esc_attr($enable_pagination); ?>"
				  data-loop="<?php echo esc_attr($enable_loop); ?>" data-mousedrag="<?php echo esc_attr($enable_mousedrag); ?>" 
				  data-touchdrag="<?php echo esc_attr($enable_touchdrag); ?>" data-slideby="<?php echo esc_attr($slide_by); ?>" 
				  data-margin="<?php echo esc_attr($margin_item); ?>" data-desktop="<?php echo esc_attr($default_items); ?>"
				  data-mobile="<?php echo esc_attr($mobile_items); ?>" data-tabletsmall="<?php echo esc_attr($tablet_small_items); ?>" 
				  data-tablet="<?php echo esc_attr($tablet_items); ?>" data-desktopsmall="<?php echo esc_attr($portrait_items); ?>" 
				  data-large="<?php echo esc_attr($large_items); ?>" data-customitem="<?php echo esc_attr($custom_items); ?>" 
				  data-autoplay="<?php echo esc_attr($autoplay); ?>" data-speed="<?php echo esc_attr($speed); ?>" >

					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<div class="item">
	                	<?php echo Opalmedical_Template_Loader::get_template_part( 'content-service-carousel', $args_template ); ?>
	            	</div>
					<?php endwhile; ?>
				</div>
			</div>	
			<?php else: ?>
				<?php echo Opalmedical_Template_Loader::get_template_part( 'content-data-none' ); ?>
			<?php endif; ?>	
		</div>
	</div>	
</div>	
<?php endif; ?>
<?php wp_reset_postdata(); ?>