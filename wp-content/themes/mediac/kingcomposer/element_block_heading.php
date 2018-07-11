<?php  extract( $atts ); ?>

<div class="element-block-heading">
	<div class="inner">	
		<?php if( isset($subheading) && $subheading ): ?>
		<h4 class="sub-heading"><?php echo trim( $subheading ); ?></h4>
		<?php endif; ?>

		<?php if( isset($heading) && $heading ): ?>
		<h2 class="heading"><?php echo trim( $heading ); ?></h2>
		<?php endif; ?>
		
		<?php if( isset($description) && $description ): ?>
		<p class="description"><?php echo trim( $description ); ?></p>
		<?php endif; ?>
	</div>
</div>		