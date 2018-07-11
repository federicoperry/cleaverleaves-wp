<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); 

$column = opalmedical_get_option('column_service') ? opalmedical_get_option('column_service') : 4;
$colclass = floor(12/$column); 
$showmode = opalmedical_get_option('service_view') ? opalmedical_get_option('service_view') : "grid"; 
?>
<?php do_action( 'mediac_template_main_before' ); ?>
<section id="main-container" class="site-main container" role="main">
	<main id="primary" class="content content-area">
		<?php if ( have_posts() ) : ?>

			<div class="archive-opalmedical-container widget-medical-service <?php if ($showmode == "grid"): ?> service-grid<?php else: ?> service-list<?php endif; ?>">
				<div class="row">
				<?php $cnt=0; while ( have_posts() ) : the_post();
						$cls = '';
						if( $cnt++%$column==0 ){
							$cls .= ' first-child';
						}
						if ($showmode == "grid") : ?>
						<div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-<?php echo esc_attr($colclass); ?> <?php echo esc_attr($cls); ?>">
							<?php echo Opalmedical_Template_Loader::get_template_part( 'content-service-grid' ); ?>
						</div>
						<?php else: ?>
							<div class="col-md-12 item">
						   <?php echo Opalmedical_Template_Loader::get_template_part( 'content-service-list' ); ?>
						   </div>
						<?php endif; ?>
					<?php endwhile; ?>
				</div>
			</div>
		<?php the_posts_pagination( array(
		'prev_text'          => esc_html__( 'Previous page', 'opalmedical' ),
		'next_text'          => esc_html__( 'Next page', 'opalmedical' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'opalmedical' ) . ' </span>',
		) ); ?>
		<?php else : ?>
			<?php echo Opalmedical_Template_Loader::get_template_part( 'content-data-none' ); ?>
		<?php endif; ?>

	</main><!-- .site-main -->
</section><!-- .content-area -->

<?php get_footer(); ?>
