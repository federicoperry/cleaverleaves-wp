<?php
global $doctor, $post;
$doctor = new Opalmedical_Doctor( get_the_ID() );
 
?>
<div class="doctor-box-meta">
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<div class="doctor-label">
		<?php echo $doctor->getMetaboxValue('label'); ?>
	</div>
	<div class="doctor-department">
		<a href="<?php echo esc_url( get_permalink( $doctor->getMetaboxValue('department') ));?>"><?php echo get_the_title($doctor->getMetaboxValue('department')); ?> </a>
	</div>
	<hr>
	<div class="doctor-info pull-left">
 		<span class="doctor-phone"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $doctor->getMetaboxValue('phone'); ?></span>	
		<span class="doctor-email"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $doctor->getMetaboxValue('email'); ?></span>
	</div>
	<div class="doctor-social pull-right">
		<a href="<?php echo $doctor->getMetaboxValue('google');?>" title="google"><i class="fa fa-google" aria-hidden="true"></i></a>
		<a href="<?php echo $doctor->getMetaboxValue('facebook');?>" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
		<a href="<?php echo $doctor->getMetaboxValue('youtube');?>" title="youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
		<a href="<?php echo $doctor->getMetaboxValue('twitter');?>" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
		<a href="<?php echo $doctor->getMetaboxValue('printest');?>" title="printrest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
	</div>
	<div class="clearfix"></div>
	<div class="doctor-description">
		<?php the_excerpt(); ?>
	</div>
</div>