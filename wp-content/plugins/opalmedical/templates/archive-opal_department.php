<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); 

$column = opalmedical_get_option('column_department', 3) ;
$colclass = floor(12/$column); 
 
?>
<?php do_action( 'mediac_template_main_before' ); ?>
<section id="main-container" class="site-main container" role="main">
	<main id="primary" class="content content-area">
		<?php if ( have_posts() ) : ?>

			<div class="archive-opalmedical-container">
				<div class="row">
				<?php $cnt=0; while ( have_posts() ) : the_post();
						$cls = '';
						if( $cnt++%$column==0 ){
							$cls .= ' first-child';
						}
						 ?>
						<div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-<?php echo esc_attr($colclass); ?> <?php echo esc_attr($cls); ?>">
							<?php echo Opalmedical_Template_Loader::get_template_part( 'content-department-grid' ); ?>
						</div>
						 
					<?php endwhile; ?>
				</div>
			</div>
			
				<?php global $wp_query; if( $wp_query->max_num_pages ): ?> 
				<?php opalmedical_pagination( $wp_query->max_num_pages ); ?>
				<?php endif ; ?>
			<?php else : ?>
				<?php echo Opalmedical_Template_Loader::get_template_part( 'content-data-none' ); ?>
			<?php endif; ?>

	</main><!-- .site-main -->
</section><!-- .content-area -->

<?php get_footer(); ?>
