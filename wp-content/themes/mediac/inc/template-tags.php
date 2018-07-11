<?php
/**
 * Custom template tags for Mediac
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */

if ( ! function_exists( 'mediac_fnc_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Mediac 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function mediac_fnc_paging_nav() {
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => esc_html__( '&larr; Previous', 'mediac' ),
		'next_text' => esc_html__( 'Next &rarr;', 'mediac' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'mediac' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo trim($links); ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'mediac_fnc_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since Mediac 1.0
 */
function mediac_fnc_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<h3 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'mediac' ); ?></h3>
		<div class="nav-links clearfix">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', '<div class="col-lg-6"><span class="meta-nav">'.esc_html__( 'Published In', 'mediac').'</span>%title</div>' );
			else :
				previous_post_link( '%link', '<div class="pull-left"><span class="meta-nav">'.esc_html__( 'Previous Post', 'mediac' ).'</span>%title</div>' );
				next_post_link( '%link', '<div class="pull-right"><span class="meta-nav">'.esc_html__( 'Next Post', 'mediac' ).'</span><span>%title</span></div>' );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'mediac_fnc_posted_on' ) ) :
/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since Mediac 1.0
 */
function mediac_fnc_posted_on() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="featured-post"><span class="fa fa-thumb-tack"></span> ' . esc_html__( 'Sticky', 'mediac' ) . '</span>';
	}

	// Set up and print post meta information.
	printf( '<time class="entry-date" datetime="%2$s">%3$s</time>',
		esc_url( get_permalink() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date('d')).'<span>'.esc_html(get_the_date('M')).'</span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author()
	);
}
endif;

/**
 * Find out if blog has more than one category.
 *
 * @since Mediac 1.0
 *
 * @return boolean true if blog has more than 1 category
 */
function mediac_fnc_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'mediac_fnc_category_count' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'mediac_fnc_category_count', $all_the_cool_cats );
	}

	if ( 1 !== (int) $all_the_cool_cats ) {
		// This blog has more than 1 category so mediac_fnc_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so mediac_fnc_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in mediac_fnc_categorized_blog.
 *
 * @since Mediac 1.0
 */
function mediac_fnc_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'mediac_fnc_category_count' );
}
add_action( 'edit_category', 'mediac_fnc_category_transient_flusher' );
add_action( 'save_post',     'mediac_fnc_category_transient_flusher' );

if ( ! function_exists( 'mediac_fnc_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @since Mediac 1.0
 * @since Mediac 1.4 Was made 'pluggable', or overridable.
 */
function mediac_fnc_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->
	

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
		?>
	</a>

	<?php endif; // End is_singular()

}
endif;

if ( ! function_exists( 'mediac_fnc_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ...
 * and a Continue reading link.
 *
 * @since Mediac 1.3
 *
 * @param string $more Default Read More excerpt link.
 * @return string Filtered Read More excerpt link.
 */
function mediac_fnc_excerpt_more( $more ) {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( esc_html__( 'Continue reading %s', 'mediac' ).' <span class="meta-nav">&rarr;</span>', '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'mediac_fnc_excerpt_more' );
endif;

/**
 * show related post by category and id
 */
if(!function_exists('mediac_fnc_related_post')){
    function mediac_fnc_related_post( $relate_count = 4, $posttype = 'post', $taxonomy = 'category' ){

        $terms = get_the_terms( get_the_ID(), $taxonomy );
        $termids =array();

        if($terms){
            foreach($terms as $term){
                $termids[] = $term->term_id;
            }
        }

        $args = array(
            'post_type' => $posttype,
            'posts_per_page' => $relate_count,
            'post__not_in' => array( get_the_ID() ),
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $termids,
                    'operator' => 'IN'
                )
            )
        );
        $template_name = 'related_'.$posttype.'.php';

        $relates = new WP_Query( $args );

	    if( $relates->have_posts() ):
	        $_id = mediac_fnc_makeid();
	        $columns  = mediac_fnc_theme_options('blog-items-show', 3);
	    ?>
		    <div class="widget widget-style">
		        <h4 class="related-post-title widget-title">
		            <span><?php esc_html_e( 'Related post', 'mediac' ); ?></span>
		        </h4>

		        <div class="related-posts-content blog-post widget-content  owl-carousel-play" id="postcarousel-<?php echo esc_attr($_id); ?>" data-ride="carousel">

		            <?php   if( $relates->post_count > $columns ) { ?>
		            <div class="carousel-controls carousel-controls-v1 carousel-hidden">
		                <a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control carousel-xs">
		                    <span class="fa fa-angle-left"></span>
		                </a>
		                <a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control carousel-xs">
		                    <span class="fa fa-angle-right"></span>
		                </a>
		            </div>
		            <?php } ?>
		            <div class="owl-carousel" data-slide="<?php echo esc_attr($columns); ?>"  data-singleItem="true" data-navigation="true" data-pagination="true">
		            <?php
		                $class_column = 12/$relate_count;
		                while ( $relates->have_posts() ) : $relates->the_post();
		                    ?>
		                    <div class="carouse-item">
		                          <?php   get_template_part( 'content', 'blog' );  ?>
		                    </div>
		                    <?php
		                endwhile; ?>
		            </div>
		        </div>
		    </div>
		<?php
		    endif;

	        wp_reset_postdata();
	    }
}