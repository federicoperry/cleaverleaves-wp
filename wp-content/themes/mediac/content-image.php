<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-image'); ?>>
	<div class="media space-30">
		<div class="media-left">		
			<div class="blog-thumbnail">
				<div class="entry-date">
		            <?php the_time( 'd' ); ?><span><?php the_time( 'M' ); ?></span>
		        </div>
			</div>
		</div>
		<div class="media-body">
			<header class="entry-header">
				<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && mediac_fnc_categorized_blog() ) : ?>


				<div class="entry-meta">

		            <span class="author pull-left"><?php esc_html_e('by', 'mediac'); the_author_posts_link(); ?></span>
		            <div class="entry-category pull-left">
		                <?php esc_html_e('in', 'mediac'); the_category(); ?>
		            </div>
					<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
					<span class="comments-link pull-left"><span class="fa fa-comment-o"></span> <?php comments_popup_link( esc_html__( 'Leave a comment', 'mediac' ), esc_html__( '1 Comment', 'mediac' ), esc_html__( '% Comments', 'mediac' ) ); ?></span>
					<?php endif; ?>

					<?php edit_post_link( esc_html__( 'Edit', 'mediac' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-meta -->

				<?php
					endif;

					if ( is_single() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
					endif;
				?>
			</header><!-- .entry-header -->
		</div>
	</div>
 	
	<div class="post-preview">
		<?php mediac_fnc_post_thumbnail(); ?>
		<span class="post-format">
			<a class="entry-format" href="<?php echo esc_url( get_post_format_link( 'image' ) ); ?>"><i class="fa fa-picture-o"></i></a>
		</span>
	</div>
	<div class="entry-content">
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

	<?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>
</article><!-- #post-## -->
