<?php
$imgresizes = "";
if($image_size == 'other'){
	$imgtemp = explode('x', $other_size);
	$imgresizes = array($imgtemp[0],$imgtemp[1],true);
}else{
	$imgresizes = $image_size;
}

?>
<div class="col-lg-6 col-md-6">
	<?php $i=0; while ( $query->have_posts() ) : $query->the_post(); ?>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="service-box-image-tab" id="<?php echo get_the_ID();?>tab">
			<a href="<?php the_permalink(); ?>" class="service-box-image-inner">
				<?php the_post_thumbnail( $imgresizes); ?>
			</a>
		</div>
	<?php endif; ?>
	<?php $i++; endwhile; ?>
</div> <!-- END COL IMAGE -->	
<div class="col-lg-6  col-md-6">
	<ul class="nav nav-tabs" id="tabService">
		<?php $i = 0; while ( $query->have_posts() ) : $query->the_post(); ?>
		<li class="<?php if ( $i == 0 ){ echo "active"; } ?>"><a data-target="#<?php echo get_the_ID();?>" data-toggle="tab"> <?php the_title();?> </a></li>
		<?php $i++; endwhile; ?>
	</ul>

	<div class="tab-content">
		<?php $i = 0; while ( $query->have_posts() ) : $query->the_post(); ?>
		<div class="tab-pane <?php if ( $i == 0 ){ echo "active"; } ?>" id="<?php echo get_the_ID();?>">
			<?php the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<?php if($show_description == "yes"): ?>
			<div class="service-description">
				<?php echo opalmedical_fnc_description(80,'...'); ?>
			</div>
			<?php endif; ?>
			<?php if($show_learnmore == "yes"): ?>
			<div class="service-learnmore">
				<a href="<?php echo esc_url( get_permalink() );?>"> <button class="btn">Learn More</button>  </a>
			</div>
			<?php endif; ?>
		</div>
		<?php $i++; endwhile; ?>
	</div>
</div><!-- END COL Content -->
<script type="text/javascript">
	jQuery(function () {
		jQuery('#tabService a:first').tab('show');
		jQuery('.service-box-image-tab a:first').addClass("active");

		jQuery('#tabService a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			var target = jQuery(e.target).attr("data-target"); // newly activated tab
			jQuery(target+'tab a').addClass("active"); //show main image by tab
		});
		jQuery('#tabService a[data-toggle="tab"]').on('hide.bs.tab', function (e) {
			var target = jQuery(e.target).attr("data-target"); // newly hiden tab
			jQuery(target+'tab a').removeClass("active"); //hide main image by tab
		});
	});
</script>