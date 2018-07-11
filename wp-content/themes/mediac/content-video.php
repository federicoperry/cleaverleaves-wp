<?php
/**
 * The template for displaying posts in the Video post format
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */
$videolink =  get_post_meta( get_the_ID(),'wpopal_themer_video_link', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-preview">
		<?php if( $videolink ) : ?>
			<div class="video-thumb video-responsive"><?php echo wp_oembed_get( $videolink ); ?></div>
		<?php else : ?>
			<?php mediac_fnc_post_thumbnail(); ?>
		<?php endif; ?>

		<span class="post-format">
			<a class="entry-format" href="<?php echo esc_url( get_post_format_link( 'image' ) ); ?>"><i class="fa fa-film"></i></a>
		</span>
	</div>

	<header class="entry-header">
		<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && mediac_fnc_categorized_blog() ) : ?>
		<div class="entry-meta">
			<span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'mediac' ) ); ?></span>
		</div><!-- .entry-meta -->
		<?php
			endif;

			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			endif;
		?>

		<div class="entry-meta">

			<div class="entry-date pull-left">
                <span><?php the_time( 'd' ); ?></span>&nbsp;<?php the_time( 'M' ); ?>
            </div>
            <span class="author pull-left"><?php esc_html_e('by', 'mediac'); the_author_posts_link(); ?></span>
            <div class="entry-category pull-left">
                <?php esc_html_e('in', 'mediac'); the_category(); ?>
            </div>
			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
			<span class="comments-link pull-left"><span class="fa fa-comment-o"></span> <?php comments_popup_link( esc_html__( 'Leave a comment', 'mediac' ), esc_html__( '1 Comment', 'mediac' ), esc_html__( '% Comments', 'mediac' ) ); ?></span>
			<?php endif; ?>

			<?php edit_post_link( esc_html__( 'Edit', 'mediac' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

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
