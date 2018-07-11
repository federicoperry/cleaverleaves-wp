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
/*
*Template Name: 404 Page
*/

get_header( apply_filters( 'mediac_fnc_get_header_layout', null ) ); ?>

<section id="main-container" class="<?php echo apply_filters('mediac_template_main_container_class','container');?> inner clearfix notfound-page">
	<div class="row">
		<div id="main-content" class="main-content">
			<div id="primary" class="content-area">
				 <div id="content" class="site-content text-center" role="main">
				 	<div class="left-notfound">
						<div class="title">
							<span><?php esc_html_e( '404', 'mediac' ); ?></span>
						</div>
					</div>
					<div>
						<span class="sub"><?php esc_html_e( 'Page Not Found', 'mediac' ); ?></span>
						<div class="error-description">
							<p><?php esc_html_e( 'We are sorry, but something went wrong', 'mediac' ); ?></p>
						</div><!-- .page-content -->

						<div class="page-action">
							<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Return to homepage', 'mediac'); ?></a>
						</div>
					</div>
				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
		</div><!-- #main-content -->


		<?php get_sidebar(); ?>

	</div>
</section>
<?php

get_footer();

