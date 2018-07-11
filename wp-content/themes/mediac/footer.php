<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */
$footer_profile =  apply_filters( 'mediac_fnc_get_footer_profile', 'default' );
$fullwidth = $footer_data = '';
if( $footer_profile && $footer_profile != 'default' ) {
	$footer_data = mediac_fnc_get_footer_profile_postdata( $footer_profile );
	if( is_object($footer_data) ){
		$fullwidth = get_post_meta( $footer_data->ID, 'mediac_footerfullwidth', 'fullwidth' );
	}
}

?>
		</section><!-- #main -->
		<?php do_action( 'mediac_template_main_after' ); ?>
		<?php do_action( 'mediac_template_footer_before' ); ?>
		<footer id="opal-footer" class="opal-footer <?php echo esc_attr( $fullwidth ); ?>" role="contentinfo">
			<div class="container">
			<div class="inner">
				<?php if( $footer_data ) : ?>
					<div class="opal-footer-profile clearfix">
						<?php mediac_fnc_render_post_content( $footer_data ); ?>
					</div>
				<?php else: ?>
					<?php get_sidebar( 'footer' ); ?>
				<?php endif; ?>


				<?php get_sidebar( 'mass-footer-body' );  ?>

			</div>
			</div>

			<section class="opal-copyright clearfix">
				<div class="container">
					<a href="#" class="scrollup"><span class="fa fa-angle-up"></span></a>
					<?php do_action( 'mediac_fnc_credits' ); ?>
					<?php
						$copyright_text =  mediac_fnc_theme_options('copyright_text', '');
						if(!empty($copyright_text)){
							echo do_shortcode($copyright_text);
						}else{
							$devby = '<a target="_blank" href="'.esc_url('http://wpopal.com').'">WpOpal Team</a>';
							printf( esc_html__( 'Proudly powered by %s. Developed by %s', 'mediac' ), 'WordPress', $devby );
						}
					?>
				</div>
			</section>
		</footer><!-- #colophon -->


		<?php do_action( 'mediac_template_footer_after' ); ?>
		<?php get_sidebar( 'offcanvas' );  ?>
	</div>
</div>
	<!-- #page -->

<?php wp_footer(); ?>
</body>
</html>