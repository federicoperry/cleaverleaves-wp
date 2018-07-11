<?php
/**
 * The template for displaying Category pages
 *
 * @link http://www.wpopal.com/theme/mediac/
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */

$mediac_page_layouts = apply_filters( 'mediac_fnc_get_archive_sidebar_configs', null );

get_header( apply_filters( 'mediac_fnc_get_header_layout', null ) ); ?>
<?php do_action( 'mediac_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('mediac_template_main_container_class','container');?> inner <?php echo mediac_fnc_theme_options('blog-archive-layout') ; ?>">
	<div class="row">

		<?php if( isset($mediac_page_layouts['sidebars']) && !empty($mediac_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>

		<div id="main-content" class="main-content  col-sm-12 col-xs-12 <?php echo esc_attr($mediac_page_layouts['main']['class']); ?>">
			<div id="primary" class="content-area">
			 <div id="content" class="site-content" role="main">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<?php
								the_archive_title( '<h1 class="page-title">', '</h1>' );
								the_archive_description( '<div class="archive-description">', '</div>' );
							?>
						</header><!-- .page-header -->

						<?php
								// Start the Loop.
								while ( have_posts() ) : the_post();

									/*
									 * Include the post format-specific template for the content. If you want to
									 * use this in a child theme, then include a file called called content-___.php
									 * (where ___ is the post format) and that will be used instead.
									 */
									get_template_part( 'content', get_post_format() );

								endwhile;
								// Previous/next page navigation.
								mediac_fnc_paging_nav();

							else :
								// If no content, include the "No posts found" template.
								get_template_part( 'content', 'none' );

							endif;
						?>
					</div><!-- #content -->


			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
		</div><!-- #main-content -->

<?php wp_reset_query(); ?>

	</div>
</section>
<?php
get_footer();

