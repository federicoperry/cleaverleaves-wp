<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $doctor, $post; 
$doctor = new Opalmedical_Doctor( get_the_ID() );
$department_id = $doctor->getMetaboxValue('department');
$imgresizes = "";
if($image_size == 'other'){
	$imgtemp = explode('x', $other_size);
	$imgresizes = array($imgtemp[0],$imgtemp[1],true);
}else{
	$imgresizes = $image_size;
}
?> 
<div itemscope itemtype="http://schema.org/Doctor" <?php post_class(); ?>>
	<div class="doctor-v2">
		<?php do_action( 'opalmedical_before_doctor_loop_item' ); ?>
		<div class="doctor-social">
			<a href="<?php echo $doctor->getMetaboxValue('google');?>" title="google"><i class="fa fa-google" aria-hidden="true"></i></a>
			<a href="<?php echo $doctor->getMetaboxValue('facebook');?>" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			<a href="<?php echo $doctor->getMetaboxValue('youtube');?>" title="youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
			<a href="<?php echo $doctor->getMetaboxValue('twitter');?>" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<a href="<?php echo $doctor->getMetaboxValue('printest');?>" title="printrest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
		</div>

		<header>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="doctor-box-image">
					<a href="<?php the_permalink(); ?>" class="doctor-box-image-inner ">
						<?php the_post_thumbnail( $imgresizes ); ?>
					</a>
				</div>
			<?php endif; ?>
		</header>

	<div class="opal-booking-btn">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-light"><?php _e( 'Book an Appointment', 'opalmedical' ); ?></a>
	</div>

	<div class="doctor-content">
		<?php the_title( '<h4 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
		<?php if($department_id): ?>
			<div class="doctor-department info">
				<a href="<?php echo esc_url( get_permalink($department_id) );?>" class="department-link"><span><?php echo get_the_title($department_id);  ?></span></a>
			</div>
		<?php endif; ?>
 
	</div><!-- .doctor-content -->


<?php do_action( 'opalmedical_after_doctor_loop_item' ); ?>

<meta itemprop="url" content="<?php the_permalink(); ?>" />
</div>
</div><!-- #post-## -->
