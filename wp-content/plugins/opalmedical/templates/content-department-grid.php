<div class="opal-doctor-department"><div class="inner">
	<div class="department-preview">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="image-inner ">
				<?php the_post_thumbnail( ); ?>
			</a>
		<?php endif; ?>
	</div>
	<div class="department-content">
		<h4 class="department-title">
			<a href="<?php echo the_permalink();?>">  <?php the_title(); 	?> </a>
		</h4>
		<p class="department-description">
		 	<?php echo opalmedical_fnc_excerpt(10); ?>
		</p>
	</div>
	<div class="department-detail">
		<a href="<?php echo the_permalink();?>" class="btn btn-primary"><?php _e('View Detail', 'opalmedical'); ?></a>
	</div>
</div></div>