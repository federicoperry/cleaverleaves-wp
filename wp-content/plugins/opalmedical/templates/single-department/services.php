<?php
$mediac_page_layouts = apply_filters( 'mediac_fnc_get_single_chef_sidebar_configs', null );
$limitservice = $mediac_page_layouts['limitservice'];
$limitservice = isset($limitservice) ? $limitservice : 10;

$columnservice = $mediac_page_layouts['columnservice'];
$columnservice = isset($columnservice) ? $columnservice : 2;

$colclass = floor(12/$columnservice);

$department = get_queried_object();
$query = Opalmedical_Query::getServiceQuery();
?>

<div class="medical-our-service">
	<div class="our-service-title">
		<h2><?php esc_html_e("Medical Services","opalmedical"); ?></h2>
	</div>

	<div class="service-content">
	<?php if( $query->have_posts() ): ?>
		<div class="opalmedical-recent-service opalmedical-rows">
			<div class="row">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-<?php echo esc_attr($colclass); ?>">
						<div class="service-list">
							<div class="service-left ">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="service-box-image">
										<a href="<?php the_permalink(); ?>" class="service-box-image-inner ">
											<?php the_post_thumbnail( "thumbnail" ); ?>
										</a>
									</div>
								<?php endif; ?>
							</div> <!--/.col-lg-4 left-->
							<div class="service-right ">
								<div class="entry-content">
									<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
									<div class="service-description">
										<?php echo opalmedical_fnc_description(21,'...'); ?>
									</div>
								</div><!-- .entry-content -->
							</div> <!--/.col-lg-10 right-->
						</div> <!--/.row service-list-->
					</div>
				<?php endwhile; ?>
			</div>
		</div>
		<?php endif; ?>
	</div><!--/.service-content-->
</div> <!--/.medical-our-service-->