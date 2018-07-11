<?php
/**
 * Template Name: Main Left Sidebar
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */
global $mediac_layouts;

get_header( apply_filters( 'mediac_fnc_get_header_layout', null ) );
$mediac_layouts = apply_filters( 'mediac_fnc_get_page_sidebar_configs', null )

?>
<?php do_action( 'mediac_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('mediac_template_main_container_class','container');?> inner">
	<div class="row">

		<div id="main-content" class="main-content col-xs-12 col-lg-8 col-md-8">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();

							// Include the page content template.
							get_template_part( 'content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
						endwhile;
					?>

				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>

		</div><!-- #main-content -->

		<?php get_sidebar('left'); ?>
<?php wp_reset_query(); ?>
	</div>
</section>
<?php

get_footer();
