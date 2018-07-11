<?php
    $link = get_post_meta( get_the_ID(), 'testimonials_link', true );
    $job = get_post_meta( get_the_ID(), 'testimonials_job', true );
?>
<div class="testimonials-left">
<div class="testimonials-body row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="testimonials-quote"><?php the_content() ?></div>
    </div>
    <div class="testimonials-profile col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="testimonials-avatar radius-x">
              <?php the_post_thumbnail('widget', '', 'class="radius-x"');?>
        </div>
        <h4 class="name"><?php the_title(); ?></h4>
        <div class="job info">
        	<a href="<?php echo empty($link) ? '#' : esc_url( $link ); ?>">
        	<?php echo empty($job) ? '' : trim( $job ); ?>
        	</a>
        </div>
    </div>
</div>
</div>