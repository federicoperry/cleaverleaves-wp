<?php
$orderby = isset($order_by) ? $order_by : 'ID';
$order = isset($order_list) ? $order_list : 'ASC';

$tax_term = $show_date = $order = $main_color = $class = $blog_style = $custom_class = '';
$columns = 4;
$items =  12;
$atts['post_type'] = 'post';
$atts['taxonomy'] = 'category';

$posts = get_posts( $atts );
$blog_style  = '';

extract( $atts );

$css_class   = array( 'kc-post-layout-1');

array_push( $css_class, $custom_class );

if( isset( $class ) )
	array_push( $css_class, $class );


ob_start();

$col = floor(12/$columns);
 if($blog_style == 'blog-list'){
 	$col =12;
 	$columns = 1;
 }
 
$args = array(
	'paged' => 1,
	'posts_per_page' =>  $items,
	'post_status' => 'publish',
	'orderby'        	=> $orderby,
	'order' 			=> $order,
);
$loop = new WP_Query($args);
$_count = 0;
?>
<div class="blog-post">
	
	<div class="<?php echo esc_attr($blog_style); ?>-layout <?php echo esc_attr( implode( ' ', $css_class ) ) ;?>" >

	 	<?php if ( $loop->have_posts() ) : ?>
	 	<?php
				// Start the Loop.
				while ( $loop->have_posts()  ) : $loop->the_post();
					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					?>
					<?php if($_count%$columns==0): ?>
						<div class="row">
					<?php endif; ?>

						<div class="blog-item col-lg-<?php echo esc_attr($col); ?> col-md-<?php echo esc_attr($col); ?> col-sm-<?php echo esc_attr($col); ?> col-xs-12">
							<?php wpopal_themer_get_template_part( 'content', $blog_style  ); ?>
						</div>

					<?php if($_count%$columns==$columns-1 || $_count == $loop->post_count -1): ?>
						</div>
					<?php endif; ?>

					<?php
						$_count++;

				endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>
	</div>
</div>
<?php
$output = ob_get_clean();

echo trim( $output );

wp_reset_postdata();