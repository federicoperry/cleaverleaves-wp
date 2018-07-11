<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version       3.3.1
 */
if( !(mediac_fnc_theme_options('wc_show_upsells', false)) ){
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $product, $woocommerce_loop;

	$upsells = $product->get_upsell_ids();
	$posts_per_page = mediac_fnc_theme_options('woo-number-product-single',6);
	if ( sizeof( $upsells ) == 0 ) return;

	$meta_query = WC()->query->get_meta_query();

	$args = array(
		'post_type'           => 'product',
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => 1,
		'posts_per_page'      => $posts_per_page,
		'orderby'             => $orderby,
		'post__in'            => $upsells,
		'post__not_in'        => array( $product->get_id() ),
		'meta_query'          => $meta_query
	);
	$_count =1;
	$products = new WP_Query( $args );

	$columns_count = mediac_fnc_theme_options('product-number-columns',3);
	$class_column = 'col-sm-' . floor( 12/$columns_count );
	$woocommerce_loop['columns'] = $columns;
	$_id = rand();

	if ( $products->have_posts() ) : ?>

			<div class="widget products-collection owl-carousel-play woocommerce" id="postcarousel-<?php echo esc_attr($_id); ?>" data-ride="carousel">

					<div class="mask"></div>
					<h3 class="widget-title">
				        <span><?php esc_html_e( 'You may also like&hellip;', 'mediac' ); ?></span>
					</h3>
					<div class="woocommerce">
						<div class="widget-content <?php echo isset($style) ? esc_attr( $style ): ''; ?>">
						    <?php   if( $products->post_count > $columns_count ) { ?>
							<div class="carousel-controls carousel-controls-v1 carousel-hidden">
								<a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control">
									<span class="fa fa-angle-left"></span>
								</a>
								<a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control">
									<span class="fa fa-angle-right"></span>
								</a>
							</div>
							<?php } ?>

						    <div class="owl-carousel " data-slide="<?php echo esc_attr($columns_count); ?>"  data-singleItem="true" data-navigation="false" data-pagination="false">
								<?php while ( $products->have_posts() ) : $products->the_post();  ?>
										<div class="product-carousel-item">	<?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
								<?php endwhile; ?>
							</div>

						</div>
					</div>

			</div>

		<?php endif;

	wp_reset_postdata();
}