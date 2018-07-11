<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $service, $post;
$service = new Opalmedical_Service( get_the_ID() );
$categories = $service->getCategoryTax();
$imgresizes = "";
if($image_size == 'other'){
	$imgtemp = explode('x', $other_size);
	$imgresizes = array($imgtemp[0],$imgtemp[1],true);
}else{
	$imgresizes = $image_size;
}


?>
<div itemscope itemtype="http://schema.org/Doctor" <?php post_class(); ?>>
	<?php do_action( 'opalmedical_before_service_loop_item' ); ?>
	<div class="service-list row">
		<div class="service-left col-lg-6 col-md-6">
			<?php if($show_thumbnail) : ?>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="service-box-image">
						<a href="<?php the_permalink(); ?>" class="service-box-image-inner ">
							<?php the_post_thumbnail( $imgresizes ); ?>
						</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>

		</div> <!--/.col-lg-4 left-->
		<div class="service-right col-lg-6 col-md-6">
			<div class="entry-content">
				<h5 class="service-title-top kc_title heading-style-v2"><?php esc_html_e('WHAT WE DO','opalmedical'); ?></h5>
				<?php if(!empty($title)){ ?>
				<h2 class="service-title kc_title ">
					<span><?php esc_html_e($title,'opalmedical'); ?></span>
				</h2>
				<?php } ?>
				<?php if(trim($description)!=''){ ?>
			   <div class="service-desc-top kc_text_block headingFont text-big-1">
			      <p><em><?php echo trim($description); ?></em></p>
			   </div>
			   <?php } ?>
				<hr>
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
				<?php if($show_category): ?>
			     <div class="service-categories">
			     <?php foreach( $categories as $categorie ) :
			     			$namect = $categorie->name.'/';
				     		if ($categorie === end($categories) || count($categories) == 1){
				     			$namect = $categorie->name;
				     		}?>
				     	<span><?php echo $namect ?></span>
					<?php endforeach; ?>
			     </div>
				<?php endif; ?>
			<?php if($show_description): ?>
				<div class="service-description">
					<?php echo opalmedical_fnc_description($max_char,'...'); ?>
				</div>
			<?php endif?>

			<?php if($show_learnmore): ?>
			<div class="service-learnmore">
				<a href="<?php echo esc_url( get_permalink() );?>"> <button class="btn">Learn More</button>  </a>
			</div>
			<?php endif?>
			</div><!-- .entry-content -->
		</div> <!--/.col-lg-8 right-->
	</div> <!--/.row chef-list-->
<?php do_action( 'opalmedical_after_service_loop_item' ); ?>
<meta itemprop="url" content="<?php the_permalink(); ?>" />
</div><!-- #post-## -->
