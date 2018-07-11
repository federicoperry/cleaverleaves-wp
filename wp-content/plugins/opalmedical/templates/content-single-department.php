
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $service, $post;
$service = new Opalmedical_Service( get_the_ID() );
?>
<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Property" <?php post_class(); ?>>
	<div class="row">
		<div class="col-lg-9">
		
				<header class="entry-header">

					<?php
						the_title( '<h1 class="entry-title">', '</h1>' );
						
					?>
				</header><!-- .entry-header -->

		
		 
				<div class="department-content">
					<?php
						/* translators: %s: Name of current post */
						if(is_single()){
							the_content( sprintf(
								esc_html__( 'Continue reading %s', 'mediac').'<span class="meta-nav">&rarr;</span>',
								the_title( '<span class="screen-reader-text">', '</span>', false )
							) );
						}else{
							the_excerpt();
						}

						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'mediac' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
					?>
				</div><!-- .entry-content -->
			 	

				<?php 
					$galleries = get_post_meta( get_the_ID(), OPALMEDICAL_DEPARTMENT_PREFIX."gallery" , true );

					if( $galleries ): 
				?>
				<div class="medical-gallery">
					<h4><?php _e('Gallery'); ?><h4>
					<div class="row">
					<?php foreach( $galleries as $gallery ): ?>
						<div class="col-lg-3">
							<img src="<?php echo $gallery; ?>">
						</div>
					<?php endforeach; ?>	
					</div>	
				</div>	
				
				<?php endif; ?>

		</div>
		<div class="col-lg-3 sidebar">
		 	<?php echo Opalmedical_Template_Loader::get_template_part( 'single-department/sidebar' ); ?>
		</div>
	</div> <!-- //.row -->
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
</article><!-- #post-## -->

