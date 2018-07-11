<?php
function mediac_get_plugin_file( $file, $slug ){
	if( is_file(WP_PLUGIN_DIR.'/'.$file) ){
		return $file;
	} 
	return;
}

add_filter( 'pue_get_plugin_file', 'mediac_get_plugin_file' , 2, 2 );
/**
 * Remove javascript and css files not use
 */
if( is_admin() ){
	function mediac_setup_admin_setting(){

		global $pagenow;
		if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
			/**
			 *
			 */
			$pts = array( 'brands', 'footer', 'megamenu', 'testimonials');

			$options = array();

			foreach( $pts as $key ){
				$options['enable_'.$key] = 'on';
			}

			update_option( 'wpopal_themer_posttype', $options );

			do_action( 'mediac_setup_theme_actived' );
		}
	}
	add_action( 'init', 'mediac_setup_admin_setting'  );
}


/**
 * Hoo to top bar layout
 */
function mediac_fnc_topbar_layout(){
	$layout = mediac_fnc_get_header_layout();
	get_template_part( 'page-templates/parts/topbar', $layout );
	get_template_part( 'page-templates/parts/topbar', 'mobile' );
}

add_action( 'mediac_template_header_before', 'mediac_fnc_topbar_layout' );

/**
 * Hook to select header layout for archive layout
 */
function mediac_fnc_get_header_layout( $layout='' ){
	global $post;

	$layout = $post && get_post_meta( $post->ID, 'mediac_header_layout', 1 ) ? get_post_meta( $post->ID, 'mediac_header_layout', 1 ) : mediac_fnc_theme_options( 'headerlayout' );

 	if( $layout == 'default' ){
 		return '';
 	}elseif( $layout){
 		return trim( $layout );
 	}elseif ( $layout = mediac_fnc_theme_options('header_skin','') ){
 		return trim( $layout );
 	}

	return $layout;
}

add_filter( 'mediac_fnc_get_header_layout', 'mediac_fnc_get_header_layout' );

/**
 * Hook to select header layout for archive layout
 */
function mediac_fnc_get_footer_profile( $profile='default' ){

	global $post;

	$profile =  $post? get_post_meta( $post->ID, 'mediac_footer_profile', 1 ):null ;

	$options = get_option( 'wpopal_themer_posttype' ); 
 	if( !isset($options['enable_footer']) || $options['enable_footer'] !='on' ){
 		return ;
 	}
 	if ( $profile && $profile != 'global' ) {
 		return trim( $profile );
 	} elseif ( $profile = mediac_fnc_theme_options('footer-style', $profile ) ) {
 		return trim( $profile );
 	}

	return $profile;
}

add_filter( 'mediac_fnc_get_footer_profile', 'mediac_fnc_get_footer_profile' );


/**
 * Hook to show breadscrumbs
 */
function mediac_fnc_render_breadcrumbs(){

	global $post;

	if( is_object($post) ){
		$disable = get_post_meta( $post->ID, 'mediac_disable_breadscrumb', 1 );
		if(  $disable || is_front_page() ){
			return true;
		}
		$bgimage = get_post_meta( $post->ID, 'mediac_image_breadscrumb', 1 );
		$color 	 = get_post_meta( $post->ID, 'mediac_color_breadscrumb', 1 );
		$bgcolor = get_post_meta( $post->ID, 'mediac_bgcolor_breadscrumb', 1 );
		$style = array();

		if( $bgcolor  ){
			$style[] = 'background-color:'.$bgcolor;
		}

		if( $bgimage  ){
			$style[] = 'background-image:url(\''.wp_get_attachment_url($bgimage).'\')';
		}else{
			$bgimage = mediac_fnc_theme_options( 'breadcrumb-bg' );
			$style[] =  $bgimage  ? 'background-image:url(\''.$bgimage.'\')' : "";
		}

		if( $color  ){
			$style[] = 'color:'.$color;
		}

		$estyle = !empty($style)? 'style="'.implode(";", $style).'"':"";
	} else {

		$bgimage = mediac_fnc_theme_options( 'breadcrumb-bg' );
		if( !empty($bgimage)  ){
			$style[] = 'background-image:url(\''.$bgimage.'\')';
		}
		$estyle = !empty($style)? 'style="'.implode(";", $style).'"':"";
	}

	echo '<section id="opal-breadscrumb" class="opal-breadscrumb" '.$estyle.'><div class="container">';
			mediac_fnc_breadcrumbs();
	echo '</div></section>';

}

add_action( 'mediac_template_main_before', 'mediac_fnc_render_breadcrumbs' );


/**
 * Main Container
 */

function mediac_template_main_container_class( $class ){
	global $post;
	global $mediac_wpopconfig;

	$layoutcls = get_post_meta( $post->ID, 'mediac_enable_fullwidth_layout', 1 );

	if( $layoutcls ) {
		$mediac_wpopconfig['layout'] = 'fullwidth';
		return 'container-fluid';
	}
	return $class;
}
add_filter( 'mediac_template_main_container_class', 'mediac_template_main_container_class', 1 , 1  );
add_filter( 'mediac_template_main_content_class', 'mediac_template_main_container_class', 1 , 1  );



/**
 * Get Configuration for Page Layout
 *
 */
function mediac_fnc_get_page_sidebar_configs( $configs='' ){

	global $post;

	$left  =  get_post_meta( $post->ID, 'mediac_leftsidebar', 1 );
	$right =  get_post_meta( $post->ID, 'mediac_rightsidebar', 1 );

	return mediac_fnc_get_layout_configs( $left, $right );
}

add_filter( 'mediac_fnc_get_page_sidebar_configs', 'mediac_fnc_get_page_sidebar_configs', 1, 1 );


function mediac_fnc_get_single_sidebar_configs( $configs='' ){

	global $post;

	$left  =  get_post_meta( $post->ID, 'mediac_leftsidebar', 1 );
	$right =  get_post_meta( $post->ID, 'mediac_rightsidebar', 1 );

	if ( empty( $left ) ) {
		$left  =  mediac_fnc_theme_options( 'blog-single-left-sidebar' );
	}

	if ( empty( $right ) ) {
		$right =  mediac_fnc_theme_options( 'blog-single-right-sidebar' );
	}

	return mediac_fnc_get_layout_configs( $left, $right );
}

add_filter( 'mediac_fnc_get_single_sidebar_configs', 'mediac_fnc_get_single_sidebar_configs', 1, 1 );

function mediac_fnc_get_archive_sidebar_configs( $configs='' ){

	global $post;


	$left  =  mediac_fnc_theme_options( 'blog-archive-left-sidebar' );
	$right =  mediac_fnc_theme_options( 'blog-archive-right-sidebar' );

	return mediac_fnc_get_layout_configs( $left, $right );
}

add_filter( 'mediac_fnc_get_archive_sidebar_configs', 'mediac_fnc_get_archive_sidebar_configs', 1, 1 );
add_filter( 'mediac_fnc_get_category_sidebar_configs', 'mediac_fnc_get_archive_sidebar_configs', 1, 1 );

/**
 *
 */
function mediac_fnc_get_layout_configs( $left, $right ){
	$configs = array();
	$configs['main'] = array( 'class' => 'col-lg-9 col-md-9' );

	$configs['sidebars'] = array(
		'left'  => array( 'sidebar' => $left, 'active' => is_active_sidebar( $left ), 'class' => 'col-lg-3 col-md-3 col-xs-12'  ),
		'right' => array( 'sidebar' => $right, 'active' => is_active_sidebar( $right ), 'class' => 'col-lg-3 col-md-3 col-xs-12' )
	);

	if( $left && $right ){
		$configs['main'] = array( 'class' => 'col-lg-6 col-md-6' );
	} elseif( empty($left) && empty($right) ){
		$configs['main'] = array( 'class' => 'col-lg-12 col-md-12' );
	}
	return $configs;
}


function mediac_fnc_sidebars_others_configs(){

	global $mediac_page_layouts;

	return $mediac_page_layouts;
}

add_filter("mediac_fnc_sidebars_others_configs", "mediac_fnc_sidebars_others_configs");