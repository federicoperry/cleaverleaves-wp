<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( has_post_thumbnail() ): ?>
	<div class="blog-thumbnail">
	<?php
		mediac_fnc_post_thumbnail();

		if ( 'post' == get_post_type() )
			mediac_fnc_posted_on();
	?>
	</div>
	<?php endif; ?>
	<div class="blog-content">
		<div>
			<header class="entry-header">
				<div class="entry-meta">
					<span class="author"><?php esc_html_e('by', 'mediac'); the_author_posts_link(); ?></span>
		            <div class="entry-category">
		                <?php esc_html_e('in', 'mediac'); the_category(); ?>
		            </div>
					<?php
						edit_post_link( esc_html__( 'Edit', 'mediac' ), '<span class="edit-link">', '</span>' );
					?>
				</div><!-- .entry-meta -->
				<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && mediac_fnc_categorized_blog() ) : ?>

				<?php
					endif;

						the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );

				?>

			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php
					/* translators: %s: Name of current post */
					echo mediac_fnc_excerpt( 22, '...' );
				?>
			</div>
			<a class="more" href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Read More', 'mediac' ); ?>"><?php esc_html_e( 'Read More', 'mediac' ); ?></a>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
