<?php 
	//$column = 3;
	$query = Opalmedical_Query::get_departments_query($limit);
	$colclass = floor(12/$column);  
?>
<?php if( $query->have_posts() ): ?>
<div class="medical-departments">
	<div class="row">
		<?php while( $query->have_posts() ): $query->the_post(); ?>
		<div class="col-md-<?php echo esc_attr($colclass); ?> col-sm-6 col-xs-12">
			<?php echo Opalmedical_Template_Loader::get_template_part( 'content-department-grid'  ); ?>	
		</div>
		<?php endwhile;?>
	</div>
</div>
<?php endif; wp_reset_postdata(); ?>