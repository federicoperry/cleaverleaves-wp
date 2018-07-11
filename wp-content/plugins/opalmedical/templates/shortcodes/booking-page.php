<div class="booking-page">
<header style="background-image:url('<?php echo $top_link_img_bg; ?>')">
	<?php if(!empty($top_title)){ ?>
		<h4 class="top-title text-center">
			<span><?php echo trim($top_title); ?></span>
			<?php if(trim($top_subtitle)!=''){ ?>
	            <br><span class="top-subtitle"><?php echo trim($top_subtitle); ?></span>
	        <?php } ?>
		</h4>
	<?php } ?>
		<div class="top-description">
			<?php if(trim($top_description)!=''){ ?>
	         <br><span class="top-desc"><?php echo trim($top_description); ?></span>
	      <?php } ?>
		</div>

</header>

<div class="widget widget-medical-booking-table">
	<?php if(!empty($title)){ ?>
		<h4 class="widget-title text-center">
			<span><?php echo trim($title); ?></span>
			<?php if(trim($subtitle)!=''){ ?>
	            <br><span class="widget-desc"><?php echo trim($subtitle); ?></span>
	        <?php } ?>
		</h4>
	<?php } ?>
	
	<div class="widget-content">
		<div class="booking-description">
			<?php if(trim($description)!=''){ ?>
	         <br><span class="widget-desc"><?php echo trim($description); ?></span>
	      <?php } ?>
		</div>
		<div class="opalmedical-recent-booking rows">
			<div class="row">
				<div class="col-lg-6"> 
					<img src="<?php echo $booking_images; ?>" alt="image booking">
				</div>
				<div class="col-lg-6"><?php echo Opalmedical_Template_Loader::get_template_part( 'content-booking-form',array('title_form'=>$title_form)); ?></div>
			</div>	
		</div>
	</div>	
</div>	
</div> <!-- //.booking-page
