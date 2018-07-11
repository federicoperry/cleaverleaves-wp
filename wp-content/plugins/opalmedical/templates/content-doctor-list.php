<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$doctor = new Opalmedical_Doctor( get_the_ID() );
$departments = $doctor->get_categories_tax();
//
$show_thumbnail_option = opalmedical_get_option('doctor_show_thumbnail');
$show_thumbnail_option = ($show_thumbnail_option == true) ? $show_thumbnail_option : 1;
$show_thumbnail = isset($show_thumbnail) ? $show_thumbnail : $show_thumbnail_option;// check exists kingc

$show_category_option = opalmedical_get_option('doctor_show_category');
$show_category_option = ($show_category_option == true) ? $show_category_option : 1;
$show_category = isset($show_category) ? $show_category : $show_category_option;// check exists kingc

$show_description_option = opalmedical_get_option('doctor_show_description');
$show_description_option = ($show_description_option == true) ? $show_description_option : 1;
$show_description = isset($show_description) ? $show_description : $show_description_option; // check exists kingc

$show_social_option = opalmedical_get_option('doctor_show_social');
$show_social_option = ($show_social_option == true) ? $show_social_option : 1;
$show_social = isset($show_social) ? $show_social : $show_social_option; // check exists kingc

$show_booking_btn_option = opalmedical_get_option('doctor_show_booking_btn');
$show_booking_btn_option = ($show_booking_btn_option == true) ? $show_booking_btn_option : 0;
$show_booking_btn = isset($show_booking_btn) ? $show_booking_btn : $show_booking_btn_option; // check exists kingc

$max_char_option = opalmedical_get_option('doctor_max_char');
$max_char_option = ($max_char_option == true) ? $max_char_option : 20;
$max_char = isset($max_char) ? $max_char : $max_char_option;// check exists kingc

//---
$image_size_option = opalmedical_get_option('doctor_image_size');
$image_size_option = ($image_size_option == true) ? $image_size_option :'large';
$image_size = isset($image_size) ? $image_size : $image_size_option;// check exists kingc

$other_size_option = opalmedical_get_option('service_other_size');
$other_size_option = ($other_size_option == true) ? $other_size_option :'279x230';
$other_size = isset($other_size) ? $other_size : $other_size_option;// check exists kingc

$imgresizes = "";
if($image_size == 'other'){
	$imgtemp = explode('x', $other_size);
	$imgresizes = array($imgtemp[0],$imgtemp[1],true);
}else{
	$imgresizes = $image_size;
}

?> 
<article itemscope itemtype="http://schema.org/Doctor" <?php post_class(); ?>>
<?php do_action( 'opalmedical_before_doctor_loop_item' ); ?>
	<div class="doctor-list row">
		<div class="doctor-left col-lg-4">
		<?php if($show_thumbnail) : ?>	
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="doctor-box-image">
					<a href="<?php the_permalink(); ?>" class="doctor-box-image-inner ">
						<?php the_post_thumbnail( $imgresizes ); ?>
					</a>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if($show_social) : ?>
		<div class="doctor-social">
			<a href="<?php echo $doctor->getMetaboxValue('google');?>" title="google"><i class="fa fa-google" aria-hidden="true"></i>
			</a>		<a href="<?php echo $doctor->getMetaboxValue('google');?>" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i>
			</a>		<a href="<?php echo $doctor->getMetaboxValue('twitter');?>" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i>
			</a>		<a href="<?php echo $doctor->getMetaboxValue('printest');?>" title="printrest"><i class="fa fa-pinterest" aria-hidden="true"></i>
			</a>
		</div>
		<?php endif; // check social?>

		</div> <!--/.col-lg-6 left-->
		<div class="doctor-right col-lg-8">
			<div class="entry-content">
				<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
				<?php if($show_category): ?>
				<div class="doctor-department">
						<?php foreach( $departments as $department ) : 
						$namect = $department->name.'/';
						if ($department === end($departments) || count($departments) == 1){
							$namect = $department->name;
						}?>
						<a href="<?php echo get_term_link($department->term_id, 'opal_department');?>" class="department-link"><span><?php echo $namect  ?></span></a>
					<?php endforeach; ?>
				</div>	
				<?php endif; ?>
				<?php if($show_description): ?>
					<div class="doctor-description">
						<?php echo opalmedical_fnc_description($max_char,'...'); ?>
					</div>
				<?php endif?>
				<hr>
				<div class="doctor-email">
					<?php _e("Email: "); echo $doctor->getMetaboxValue('email'); ?>
				</div>
				<div class="doctor-phone">
					<?php _e("Phone: "); echo $doctor->getMetaboxValue('phone'); ?>
				</div>
				
				<?php if($show_booking_btn) : ?>
				<div class="opal-booking-btn">
					<button class="btn ">Book an Appointment</button>
				</div>
				<?php endif; // check button booking?>
			</div><!-- .entry-content -->
		</div> <!--/.col-lg-6 right-->
	</div> <!--/.row chef-list-->
<?php do_action( 'opalmedical_after_doctor_loop_item' ); ?>
<meta itemprop="url" content="<?php the_permalink(); ?>" />
</article><!-- #post-## -->
