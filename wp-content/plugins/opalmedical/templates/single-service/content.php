<?php 
	global $service, $post; 
 	
	$categories = $service->getCategoryTax();
?>
<div class="entry-content">
	<h3 class="box-heading"><?php the_title(); ?></h3>
	<div class="service-categories">
		<?php foreach( $categories as $categorie ) : 
			$namect = $categorie->name.'/';
			if ($categorie === end($categories) || count($categories) == 1){
				$namect = $categorie->name;
			}?>
			<span><?php echo $namect ?></span>
	<?php endforeach; ?>
	</div>
	<div class="service-description">
		<?php the_content(); ?>
	</div>
</div><!-- .entry-content -->