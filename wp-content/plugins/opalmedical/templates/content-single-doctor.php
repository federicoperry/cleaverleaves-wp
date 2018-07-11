<?php global $doctor, $post;
	$doctor = opalmedical_doctor( get_the_ID() );
?>
<div id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Property" <?php post_class('content-single-doctor'); ?>>
	<div class="row">
		<div class="col-lg-3 col-md-3">
			<?php
				/**
				 * opalmedical_single_doctor_image hook
				 *
				 * @hooked opalmedical_show_images - 10
				 */
				do_action( 'opalmedical_single_doctor_image' );
			?>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6">
			<?php
				/**
				 * opalmedical_single_doctor_image hook
				 *
				 * @hooked opalmedical_show_product_images - 10
				 */
				do_action( 'opalmedical_single_doctor_content' );
			?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-6 sidebar">
			<?php
				/**
				 * opalmedical_single_doctor_image hook
				 *
				 * @hooked opalmedical_show_product_images - 10
				 */
				// do_action( 'opalmedical_single_doctor_contact' );
			?>
				<?php
 
					$times = $doctor->getMetaboxValue("timetable_data");
				?>
				<?php if( $times && isset($times['open']) ): ?>
				<div class="widget widget-timetable-working">
					<h3 class="widget-title"><span><?php _e("working Hours", "opalmedical"); ?></span></h3>
					<div class="element-timetable-working">
						<div class="timetable-working">
						<?php 
							foreach( $times['open'] as $time => $hour ):  
								$openhour  = $hour == 'close' ? __('Closed','opalmedical') : $hour;
								$closehour =  $times['close'][$time]  == 'close' ? __('Closed','opalmedical') : $times['close'][$time];	
						?>
							<div class="timetable-item">
							 	<div class="date-work"><?php echo $time; ?></div>
							 	<?php if(  $times['close'][$time] == 'close' && $times['open'][$time] == 'close' ): ?>
							 	<div class="time-work"><?php _e( 'Closed', 'opalmedical' ); ?></div>
							 	<?php else: ?>
							 	<div class="time-work"><?php echo $openhour; ?> - <?php echo $closehour; ?></div>
							 	<?php endif;?>
							</div>
							<?php endforeach; ?>
						</div>	
					</div>
				</div>	
				<?php endif; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<?php
				/**
				 * opalmedical_single_doctor_image hook
				 *
				 * @hooked opalmedical_show_product_images - 10
				 */
				do_action( 'opalmedical_single_doctor_summary' );
			?>
		</div>
	</div>
	<div class="row">
		<?php
			/**
			* opalmedical_single_doctor_image hook
			*
			* @hooked opalmedical_show_product_images - 10
			*/
			do_action( 'opalmedical_single_after_doctor_summary' );
		?>
	</div>
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
</div><!-- #post-## -->