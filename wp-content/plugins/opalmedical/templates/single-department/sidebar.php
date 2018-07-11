<div class="inner">

		<?php  
	 		$doctors_query = Opalmedical_Query::get_doctor_by_id_query( get_the_ID() );
	 	?>
	 	<?php if( $doctors_query->have_posts() ): $_id = rand(); ?>
	 	<div class="department-doctors">
	 		<h3><?php _e( 'Doctors' ) ; ?></h3>
			<div class="owl-carousel-play">
				<div class="owl-carousel" data-slide="1" data-navigation="1">	
	 		<?php while( $doctors_query->have_posts() ): $doctors_query->the_post();

	 		 ?>
	 			<div class="doctor-item">
	 				<?php echo Opalmedical_Template_Loader::get_template_part( 'content-doctor-grid' ); ?>
	 			</div>	
	 		<?php endwhile ;?>
		 	</div>
		 		<?php if( $doctors_query->found_posts > 1 ) : ?>
		 		<div class="carousel-controls carousel-controls-v1 carousel-hidden">
					<a href="#carousel-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control">
						<span class="fa fa-angle-left"></span>
					</a>
					<a href="#carousel-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control">
						<span class="fa fa-angle-right"></span>
					</a>
				</div>
				<?php endif; ?>

		 </div>
	 	<div>	
	 
	 	<?php endif ; wp_reset_postdata();  ?>


		<?php
 
			$times =  get_post_meta( get_the_ID(), OPALMEDICAL_DEPARTMENT_PREFIX."timetable_data" , true );
		?>
		<?php if( isset($times['open']) && $times ): ?>
		<div class="widget widget-style widget-timetable-working">
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

		<?php 
		$phone  = get_post_meta( get_the_ID(), OPALMEDICAL_DEPARTMENT_PREFIX."phone" , true );
		$fax 	= get_post_meta( get_the_ID(), OPALMEDICAL_DEPARTMENT_PREFIX."fax" , true );
		$email  = get_post_meta( get_the_ID(), OPALMEDICAL_DEPARTMENT_PREFIX."email" , true );
		if( $email || $fax || $phone ): ?>
		<div class="medical-contact">
			<?php if( $phone ): ?>
			<div class="phone">
				<h4 class="media-heading"><?php _e( 'For emergency cases', 'opalmedical' ); ?></h4>
				<div class="number"><?php echo $phone ;?></div>
			</div>
			<?php endif; ?>
			<ul class="list-group">			
			<?php if( $fax ): ?>		
		    <li class="list-group-item">
		  		<div class="media">
				    <div class="media-left">
				           <i class="fa fa-fax text-primary fa-2" aria-hidden="true"></i>
				    </div>
				    <div class="media-body">
				        <h4 class="media-heading"><?php _e( 'Fax', 'opalmedical' ); ?></h4>
				        <?php echo $fax ;?>
				    </div>
				</div>
		    </li>
		    <?php endif; ?>  
		    <?php if( $email ): ?>	
			<li class="list-group-item">
		  		<div class="media">
				    <div class="media-left">
				           <i class="fa fa-envelope-o text-primary fa-2" aria-hidden="true"></i>
				    </div>
				    <div class="media-body">
				        <h4 class="media-heading"><?php _e( 'Email', 'opalmedical' ); ?></h4>
				        <a href="mailto:<?php echo $email ;?>"><?php echo $email ;?></a>
				    </div>
				</div>
			</li>
			<?php endif; ?>  
			</ul>
		</div>	
		<?php endif; ?>
</div>	

