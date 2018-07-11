<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

$column = opalmedical_get_option('column_doctor') ? opalmedical_get_option('column_doctor') : 4;
$colclass = floor(12/$column);
$limit = opalmedical_get_option('limit_category') ? opalmedical_get_option('limit_category') : 10;
$showmode = opalmedical_get_option('doctor_view') ? opalmedical_get_option('doctor_view') : "grid";
//get custom field taxonomy category
$departments = Opalmedical_Query::get_departments_query($limit);

?>
<?php do_action( 'mediac_template_main_before' ); ?>
<section id="main-container" class="site-main container" role="main">
	<header>
		<div class="opal-doctor-page">
			<div class="title">
				<h1>
					<?php echo  esc_html__('Our Doctors', 'opalmedical'); ?>
				</h1>
			</div>
			<div class="description">
				<?php echo  esc_html__('Provice Comprehensive Quality Care', 'opalmedical'); ?>
			</div>
		</div>
	</header><!-- /header -->
	<main id="primary" class="content content-area">
		<div class="archive-departments">					
					<ul class="nav nav-tabs departments-filter">
						<li class="active"><a data-target="departments-all" data-toggle="tab"> <?php echo _e("All");?> </a></li>
						<?php if( $departments->have_posts() ):  ?> 
						<?php while( $departments->have_posts() ): $departments->the_post(); ?>
						<li class=""><a data-target="departments-<?php the_ID();?>" data-toggle="tab"> <?php  the_title();?> </a></li>
						<?php endwhile; ?>
						<?php endif; wp_reset_postdata(); ?> 
					</ul>
					<?php if ( have_posts() ) : ?>

						<div class="archive-opalmedical-container widget-medical-service <?php if ($showmode == "grid"): ?> service-grid<?php else: ?> service-list<?php endif; ?>">
							<div class="row">
							<?php $cnt=0; while ( have_posts() ) : the_post();
									$cls = ' departments-all';
									$department = get_post_meta( get_the_ID(), OPALMEDICAL_DOCTOR_PREFIX.'department', true ); 
									if( !empty($department) && is_numeric($department) ){
										$cls .= ' departments-'.$department.' ';
									} 
								 
									if ($showmode == "grid") : ?>
									<div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-<?php echo esc_attr($colclass); ?> <?php echo esc_attr($cls); ?>">
										<?php echo Opalmedical_Template_Loader::get_template_part( 'content-doctor-grid' ); ?>
									</div>
									<?php else: ?>
										<div class="col-md-12 item">
									   <?php echo Opalmedical_Template_Loader::get_template_part( 'content-doctor-list' ); ?>
									   </div>
									<?php endif; ?>
								<?php endwhile; ?>
							</div>
						</div>
					<?php global $wp_query; if( $wp_query->max_num_pages ): ?> 
					<?php opalmedical_pagination( $wp_query->max_num_pages ); ?>
					<?php endif ; ?>
					<?php else : ?>
						<?php echo Opalmedical_Template_Loader::get_template_part( 'content-data-none' ); ?>
					<?php endif; ?>	
 
		</div>
	</main><!-- .site-main -->
</section><!-- .content-area -->

<?php get_footer(); ?>
