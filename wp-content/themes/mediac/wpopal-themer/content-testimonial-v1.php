<?php
    $link = get_post_meta( get_the_ID(), 'testimonials_link', true );
    $job = get_post_meta( get_the_ID(), 'testimonials_job', true );
?>
<div class="testimonials testimonial-v1">
<div class="testimonials-body">
    <div class="testimonials-quote"><?php the_content() ?></div>
    <div class="testimonials-profile">
        <div class="testimonials-avatar radius-x">
              <?php the_post_thumbnail('widget', '', 'class="radius-x"');?>
        </div>
        <div class="job">
            <h4 class="name"><?php the_title(); ?></h4>
        	<a class="info" href="<?php echo empty($link) ? '#' : esc_url( $link ); ?>">
        	<?php echo empty($job) ? '' : trim( $job ); ?>
        	</a>
        </div>
    </div>
</div>
</div>