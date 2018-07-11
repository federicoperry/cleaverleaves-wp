<?php

/**
 * Load woocommerce styles follow theme skin actived
 *
 * @static
 * @access public
 * @since Wpopal_Themer 1.0
 */
function mediac_fnc_woocommerce_load_media() {

    if(isset($_GET['opal-skin']) && $_GET['opal-skin']) {
		$current = $_GET['opal-skin'];
	}else{
		$current = str_replace( '.css','', mediac_fnc_theme_options('skin','default') );
	}

    if($current == 'default'){
        $path =  get_template_directory_uri() .'/css/woocommerce.css';
    }else{
        $path =  get_template_directory_uri() .'/css/skins/'.$current.'/woocommerce.css';
    }
    wp_enqueue_style( 'mediac-woocommerce', $path , 'mediac-woocommerce-front' , MEDIAC_THEME_VERSION, 'all' );
}
add_action( 'wp_enqueue_scripts','mediac_fnc_woocommerce_load_media', 15 );

/**
 * Auto config product images after the theme actived.
 */
function mediac_fnc_woocommerce_setup(){
	$catalog = array(
		'width' 	=> '465',	// px
		'height'	=> '528',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '550',	// px
		'height'	=> '625',	// px
		'crop'		=> 1 		// true
	);

	$thumbnail = array(
		'width' 	=> '90',	// px
		'height'	=> '102',	// px
		'crop'		=> 1 		// true
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog );		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

add_action( 'mediac_setup_theme_actived', 'mediac_fnc_woocommerce_setup');

/**
 */
add_filter('woocommerce_add_to_cart_fragments',				'mediac_fnc_woocommerce_header_add_to_cart_fragment' );

function mediac_fnc_woocommerce_header_add_to_cart_fragment( $fragments ){
	global $woocommerce;

	$fragments['#cart .mini-cart-items'] =  sprintf(_n(' <span class="mini-cart-items"> %d item</span> ', ' <span class="mini-cart-items"> %d item </span> ', $woocommerce->cart->cart_contents_count, 'mediac'), $woocommerce->cart->cart_contents_count);
 	$fragments['#cart .total .amount'] = trim( $woocommerce->cart->get_cart_total() );

    return $fragments;
}
add_filter( 'yith_wcwl_button_label',          'mediac_fnc_wpo_woocomerce_icon_wishlist'  );
add_filter( 'yith-wcwl-browse-wishlist-label', 'mediac_fnc_wpo_woocomerce_icon_wishlist_add' );

function mediac_fnc_wpo_woocomerce_icon_wishlist( $value='' ){
	return '<i class="fa fa-heart-o"></i><span>'.esc_html__('Wishlist','mediac').'</span>';
}

function mediac_fnc_wpo_woocomerce_icon_wishlist_add(){
	return '<i class="fa fa-heart-o"></i><span>'.esc_html__('Wishlist','mediac').'</span>';
}
/**
 * Mini Basket
 */
if(!function_exists('mediac_fnc_minibasket')){
    function mediac_fnc_minibasket( $style='' ){
        $template =  apply_filters( 'mediac_fnc_minibasket_template', mediac_fnc_get_header_layout( '' )  );

      //  if( $template == 'v4' ){
        //	$template = 'v3';
     //   }

        return get_template_part( 'woocommerce/cart/mini-cart-button', $template );
    }
}
if(mediac_fnc_theme_options("woo-show-minicart",true)){
	add_action( 'mediac_template_header_right', 'mediac_fnc_minibasket', 30, 0 );
}
/******************************************************
 * 												   	  *
 * Hook functions applying in archive, category page  *
 *												      *
 ******************************************************/
function mediac_template_woocommerce_main_container_class( $class ){
	if( is_product() ){
		$class .= ' '.  mediac_fnc_theme_options('woocommerce-single-layout') ;
	}else if( is_product_category() || is_archive()  ){
		$class .= ' '.  mediac_fnc_theme_options('woocommerce-archive-layout') ;
	}
	return $class;
}

add_filter( 'mediac_template_woocommerce_main_container_class', 'mediac_template_woocommerce_main_container_class' );
function mediac_fnc_get_woocommerce_sidebar_configs( $configs='' ){

	global $post;
	$right = null; $left = null;

	if( is_product() ){

		$left  =  mediac_fnc_theme_options( 'woocommerce-single-left-sidebar' );
		$right =  mediac_fnc_theme_options( 'woocommerce-single-right-sidebar' );

	}else if( is_product_category() || is_archive() ){
		$left  =  mediac_fnc_theme_options( 'woocommerce-archive-left-sidebar' );
		$right =  mediac_fnc_theme_options( 'woocommerce-archive-right-sidebar' );
	}


	return mediac_fnc_get_layout_configs( $left, $right );
}

add_filter( 'mediac_fnc_get_woocommerce_sidebar_configs', 'mediac_fnc_get_woocommerce_sidebar_configs', 1, 1 );


function mediac_woocommerce_breadcrumb_defaults( $args ){
	$args['wrap_before'] = '<div class="opal-breadscrumb"><div class="container"><ol class="opal-woocommerce-breadcrumb breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>';
	$args['wrap_after'] = '</ol></div></div>';

	return $args;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'mediac_woocommerce_breadcrumb_defaults' );

add_action( 'mediac_woo_template_main_before', 'woocommerce_breadcrumb', 30, 0 );
/**
 * Remove show page results which display on top left of listing products block.
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 10 );


function mediac_fnc_woocommerce_after_shop_loop_start(){
	echo '<div class="products-bottom-wrap clearfix">';
}

add_action( 'woocommerce_after_shop_loop', 'mediac_fnc_woocommerce_after_shop_loop_start', 1 );

function mediac_fnc_woocommerce_after_shop_loop_after(){
	echo '</div>';
}

add_action( 'woocommerce_after_shop_loop', 'mediac_fnc_woocommerce_after_shop_loop_after', 10000 );


/**
 * Wrapping all elements are wrapped inside Div Container which rendered in woocommerce_before_shop_loop hook
 */
function mediac_fnc_woocommerce_before_shop_loop_start(){
	echo '<div class="products-top-wrap clearfix">';
}

function mediac_fnc_woocommerce_before_shop_loop_end(){
	echo '</div>';
}


add_action( 'woocommerce_before_shop_loop', 'mediac_fnc_woocommerce_before_shop_loop_start' , 0 );
add_action( 'woocommerce_before_shop_loop', 'mediac_fnc_woocommerce_before_shop_loop_end' , 1000 );


function mediac_fnc_woocommerce_display_modes(){
	$woo_display = mediac_fnc_theme_options( 'wc_listgrid', 'grid' );

    if (isset($_GET['display'])){
        $woo_display = $_GET['display'];
    }
    echo '<form class="display-mode" method="get">';
        echo '<button title="'.esc_html__('Grid','mediac').'" class="btn '.($woo_display == 'grid' ? 'active' : '').'" value="grid" name="display" type="submit"><i class="fa fa-th"></i></button>';   
        echo '<button title="'.esc_html__( 'List', 'mediac' ).'" class="btn '.($woo_display == 'list' ? 'active' : '').'" value="list" name="display" type="submit"><i class="fa fa-th-list"></i></button>';   
        // Keep query string vars intact
        foreach ( $_GET as $key => $val ) {
            if ( 'display' === $key || 'submit' === $key ) {
                continue;
            }
            if ( is_array( $val ) ) {
                foreach( $val as $innerVal ) {
                    echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
                }

            } else {
                echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
            }
        }
    echo '</form>';   

}

add_action( 'woocommerce_before_shop_loop', 'mediac_fnc_woocommerce_display_modes' , 10 );


/**
 * Processing hook layout content
 */
function mediac_fnc_layout_main_class( $class ){
	$sidebar = mediac_fnc_theme_options( 'woo-sidebar-show', 1 ) ;
	if( is_single() ){
		$sidebar = mediac_fnc_theme_options('woo-single-sidebar-show'); ;
	}
	else {
		$sidebar = mediac_fnc_theme_options('woo-sidebar-show');
	}

	if( $sidebar ){
		return $class;
	}

	return 'col-lg-12 col-md-12 col-xs-12';
}
add_filter( 'mediac_woo_layout_main_class', 'mediac_fnc_layout_main_class', 4 );


/**
 *
 */
function mediac_fnc_woocommerce_archive_image(){
	if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
		$thumb =  get_woocommerce_term_meta( get_queried_object()->term_id, 'thumbnail_id', true ) ;

		if( $thumb ){
			$img = wp_get_attachment_image_src( $thumb, 'full' );

			echo '<p class="category-banner"><img src="'.$img[0].'""></p>';
		}
	}
}
add_action( 'woocommerce_archive_description', 'mediac_fnc_woocommerce_archive_image', 9 );

/**
 * Show/Hide related, upsells products
 */
function mediac_woocommerce_related_upsells_products($located, $template_name) {
	$options      = get_option('wpopal_theme_options');
	$content_none = get_template_directory() . '/woocommerce/content-none.php';

	if ( 'single-product/related.php' == $template_name ) {
		if ( isset( $options['wc_show_related'] ) &&
			( 1 == $options['wc_show_related'] ) ) {
			$located = $content_none;
		}
	} elseif ( 'single-product/up-sells.php' == $template_name ) {
		if ( isset( $options['wc_show_upsells'] ) &&
			( 1 == $options['wc_show_upsells'] ) ) {
			$located = $content_none;
		}
	}

	return apply_filters( 'mediac_woocommerce_related_upsells_products', $located, $template_name );
}

add_filter( 'wc_get_template', 'mediac_woocommerce_related_upsells_products', 10, 2 );

/**
 * Number of products per page
 */
function mediac_woocommerce_shop_per_page($number) {
	$value = mediac_fnc_theme_options('woo-number-page', get_option('posts_per_page'));
	if ( is_numeric( $value ) && $value ) {
		$number = absint( $value );
	}
	return $number;
}

add_filter( 'loop_shop_per_page', 'mediac_woocommerce_shop_per_page' );

/**
 * Number of products per row
 */
function mediac_woocommerce_shop_columns($number) {
	$value = mediac_fnc_theme_options('wc_itemsrow', 4);
	if ( in_array( $value, array(2, 3, 4, 6) ) ) {
		$number = $value;
	}
	return $number;
}

add_filter( 'loop_shop_columns', 'mediac_woocommerce_shop_columns' );

/**
 *
 */
function mediac_fnc_woocommerce_share_box() {
	if ( mediac_fnc_theme_options('wc_show_share_social', 1) ) {
		get_template_part( 'page-templates/parts/sharebox' );
	}
}
add_action( 'mediac_woocommerce_after_single_product_summary', 'mediac_fnc_woocommerce_share_box', 25 );

/**
 *
 */
function mediac_fnc_woo_product_nav(){
    echo '<div class="product-nav pull-right">';

        previous_post_link('<p>%link</p>', '<i class="fa fa-angle-left"></i>', FALSE);
        next_post_link('<p>%link</p>', '<i class="fa fa-angle-right"></i>', FALSE);

    echo '</div>';
}

add_action( 'mediac_woocommerce_after_single_product_title', 'mediac_fnc_woo_product_nav', 1 );


// rating star
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'mediac_woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating');


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 1 );
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );


//remove_action( 'mediac_woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
//add_action( 'mediac_woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25 );

function mediac_woocommerce_show_product_thumbnails( $layout ){
	return $layout;
}

add_filter( 'wpopal_themer_woocommerce_show_product_thumbnails', 'mediac_woocommerce_show_product_thumbnails'  );

function mediac_woocommerce_show_product_images( $layout ){
	return $layout;
}

add_filter( 'wpopal_themer_woocommerce_show_product_images', 'mediac_woocommerce_show_product_images'  );