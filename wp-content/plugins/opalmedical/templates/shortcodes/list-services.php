<?php 

if( $limit < $column){
	$limit = $column;
}
global $more;
$categorys = explode(',', $category);
if( class_exists("Opalmedical_Query") ):
	$query = Opalmedical_Query::get_service_by_term_slug( $categorys, $limit );

$args_template = array(
	'show_category'		=>$show_category,
	'show_description'	=>$show_description,
	'show_thumbnail'		=>$show_thumbnail,
	'show_learnmore'		=>$show_learnmore,
	'max_char'				=>$max_char,
	'image_size'			=>$image_size,
	'query'					=>$query,
	);

$colclass = floor(12/$column);  
?>
<div class="widget widget-medical-service">
	<?php if(!empty($title)){ ?>
		<h4 class="widget-title text-center">
			<span><?php echo trim($title); ?></span>
			<?php if(trim($description)!=''){ ?>
				<br><span class="widget-desc">
				<?php echo trim($description); ?>
			</span>
			<?php } ?>
		</h4>
		<?php } ?>

	<div class="widget-content">
		<div class="opalmedical-recent-service opalmedical-rows">
			<?php if( $query->have_posts() ): ?> 
				<div class="row">
					<?php if ( $layout == 'tabs' ){
						echo Opalmedical_Template_Loader::get_template_part( 'content-service-tabs',$args_template ); 
					}else{ ?>
						<?php $cnt=0; while ( $query->have_posts() ) : $query->the_post(); 
						$cls = '';
						if( $cnt++%$column==0 ){
							$cls .= ' first-child';
						}?>
						<?php if ( $layout == 'grid' ){ ?>
							<div class="col-md-<?php echo esc_attr($colclass); ?> col-sm-6 <?php echo esc_attr($cls); ?> <?php echo esc_attr($layout); ?>">
								<?php echo Opalmedical_Template_Loader::get_template_part( 'content-service-grid',$args_template ); ?>	
							</div>
						<?php } ?>
					<?php endwhile; ?>
					<?php } //end check layout tabs ?>
				</div>
			<?php endif; ?>
		</div>
	</div>	
</div>	
<?php endif; ?>
<?php wp_reset_postdata(); ?>