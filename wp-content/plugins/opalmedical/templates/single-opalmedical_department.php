<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); 
//get custom field taxonomy department
$category_tax = new Opalmedical_Taxonomy_Department();
$image = $category_tax::get_term_image(get_queried_object());
$icon = $category_tax::get_term_icon(get_queried_object());
$args_template = array('image'=>$image,'icon'=>$icon,'department'=>get_queried_object());
?>
<?php do_action( 'mediac_template_main_before' ); ?>
	<section id="main-container" class="site-main container" role="main">
		<main id="primary" class="content content-area">
				<div class="single-opalmedical-department-container">
	            <?php echo Opalmedical_Template_Loader::get_template_part( 'content-single-department',$args_template ); ?>
				</div>
		
				<?php
					/**
					 * opalmedical_after_single_department_summary hook
					 *
					 * @hooked opalmedical_output_service_data_tabs - 10
					 * @hooked opalmedical_upsell_doctor_display - 15
					 */
					do_action( 'opalmedical_after_single_department_summary' );				
				?>
		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>

