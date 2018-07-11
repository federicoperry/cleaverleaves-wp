<?php
/**
 * Template Name: Contributor
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */


get_header( apply_filters( 'mediac_fnc_get_header_layout', null ) ); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
					the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );

					// Output the authors list.
					mediac_fnc_list_authors();

					edit_post_link( esc_html__( 'Edit', 'mediac' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' );
				?>
			</article><!-- #post-## -->

			<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->
<?php wp_reset_query(); ?>
<?php
get_sidebar();
get_footer();
