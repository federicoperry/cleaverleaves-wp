
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $service, $post;
$service = new Opalmedical_Service( get_the_ID() );
?>
<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Property" <?php post_class(); ?>>
	<div class="row">
		<div class="col-lg-12">
			<?php
				/**
				 * opalmedical_single_service_preview hook by template-functions.php
				 * @hooked opalmedical_show_product_images - 10
				 * @hooked opalmedical_show_product_images - 15
				 * @hooked opalmedical_show_content - 20
				 */
				do_action( 'opalmedical_single_service_left' );
			?>
		</div>
	</div> <!-- //.row -->
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
</article><!-- #post-## -->

