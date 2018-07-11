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
	<div class="blog-thumbnail">
	<?php
		mediac_fnc_post_thumbnail();

		if ( 'post' == get_post_type() )
			mediac_fnc_posted_on();
	?>
	</div>
	<div class="blog-content">
		<div>
			<header class="entry-header">
				<div class="entry-meta">
					<?php

						if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
					?>
					<span class="comments-link"><span class="fa fa-comment-o"></span> <?php comments_popup_link( esc_html__( 'Leave a comment', 'mediac' ), esc_html__( '1 Comment', 'mediac' ), esc_html__( '% Comments', 'mediac' ) ); ?></span>
					<?php
						endif;

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
					echo mediac_fnc_excerpt( 24, '...' );
				?>
			</div>
			<a class="more" href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Read More', 'mediac' ); ?>"><?php esc_html_e( 'Read More', 'mediac' ); ?></a>
		</div>
	</div><!-- .entry-content -->


</article><!-- #post-## -->
