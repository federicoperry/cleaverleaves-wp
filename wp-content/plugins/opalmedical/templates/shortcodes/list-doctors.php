<?php 

if( $limit < $column){
	$limit = $column;
}
global $more;
$categorys = explode(',', $category);
if( class_exists("Opalmedical_Query") ):
$query = Opalmedical_Query::get_doctor_by_term_slug( $categorys, $limit );
$args_template = array(
	'show_category'		=>$show_category,
	'show_social'			=>$show_social,
	'show_description'	=>$show_description,
	'show_thumbnail'		=>$show_thumbnail,
	'max_char'				=>$max_char,
	'image_size'			=>$image_size,
);
$colclass = floor(12/$column);  
?>
<div class="widget widget-medical-doctor">
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
		<div class="opalmedical-recent-doctor opalmedical-rows">
			<?php if( $query->have_posts() ): ?> 
				<div class="row">
				   <?php $i = 0;
				    $end = $query->post_count;
				    ?> 
					<?php $cnt=0; while ( $query->have_posts() ) : $query->the_post(); 

						$cls = '';
						if( $cnt++%$column==0 ){
							$cls .= ' first-child';
						}
					?>
                	<?php if ( $layout == 'list' ){ ?>
                			<div class="col-md-12">
	                			<?php echo Opalmedical_Template_Loader::get_template_part( 'content-doctor-list',$args_template ); ?>	
	                		</div>
	               <?php }else if($layout == 'list_v2'){ ?>
	               		<div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-<?php echo esc_attr($colclass); ?> <?php echo esc_attr($cls); ?>">
	                			<?php echo Opalmedical_Template_Loader::get_template_part( 'content-doctor-list-v2',$args_template ); ?>	
	                		</div>
                	<?php }else if($layout == 'grid'){ ?>
                		<div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-<?php echo esc_attr($colclass); ?> <?php echo esc_attr($cls); ?>">
	                		<?php echo Opalmedical_Template_Loader::get_template_part( 'content-doctor-grid',$args_template ); ?>
	                	</div>

	                <?php } // end check layout ?>
	             
					<?php $i++; endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>	
</div>	
<?php endif; ?>
<?php wp_reset_postdata(); ?>