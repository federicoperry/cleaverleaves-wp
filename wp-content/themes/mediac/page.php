<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */

$mediac_page_layouts = apply_filters( 'mediac_fnc_get_page_sidebar_configs', null );

get_header( apply_filters( 'mediac_fnc_get_header_layout', null ) );
?>
<?php do_action( 'mediac_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('mediac_template_main_container_class','container');?> inner">
	<div class="row">
		<?php if( isset($mediac_page_layouts['sidebars']) && !empty($mediac_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($mediac_page_layouts['main']['class']); ?>">
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

	</div>
</section>
<?php
get_footer();