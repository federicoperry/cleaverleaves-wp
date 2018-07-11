<?php

function mediac_fnc_import_remote_demos() {
	return array(
		'mediac' => array(
			'name' 		=> 'mediac',
		 	'source'	=> 'http://wpsampledemo.com/mediac/mediac.zip',
		 	'preview'   => 'http://wpsampledemo.com/mediac/screenshot.png'
		),
	);
}

add_filter( 'wpopal_themer_import_remote_demos', 'mediac_fnc_import_remote_demos' );



function mediac_fnc_import_theme() {
	return 'mediac';
}
add_filter( 'wpopal_themer_import_theme', 'mediac_fnc_import_theme' );

function mediac_fnc_import_demos() {
	$folderes = glob( get_template_directory() .'/inc/import/*', GLOB_ONLYDIR );

	$output = array();

	foreach( $folderes as $folder ){
		$output[basename( $folder )] = basename( $folder );
	}

 	return $output;
}
add_filter( 'wpopal_themer_import_demos', 'mediac_fnc_import_demos' );

function mediac_fnc_import_types() {
	return array(
			'all' => 'All',
			'content' => 'Content',
			'widgets' => 'Widgets',
			'page_options' => 'Theme + Page Options',
			'menus' => 'Menus',
			'rev_slider' => 'Revolution Slider',
			'vc_templates' => 'VC Templates'
		);
}
add_filter( 'wpopal_themer_import_types', 'mediac_fnc_import_types' );

/**
 * Matching and resizing images with url.
 *
 *  $ouput = array(
 *        'allowed' => 1, // allow resize images via using GD Lib php to generate image
 *        'height'  => 900,
 *        'width'   => 800,
 *        'file_name' => 'blog_demo.jpg'
 *   );
 */
function mediac_import_attachment_image_size( $url ){

   $name = basename( $url );

   $ouput = array(
         'allowed' => 0
   );

   if( preg_match("#product#", $name) ) {
      $ouput = array(
         'allowed' => 1,
         'height'  => 500,
         'width'   => 500,
         'file_name' => 'product_demo.jpg'
      );
   }
   elseif( preg_match("#blog#", $name) || preg_match("#news-#", $name) || preg_match("#612YntpjodL#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 600,
         'width'   => 1000,
         'file_name' => 'blog_demo.jpg'
      );
   }
   elseif( preg_match("#service#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 372,
         'width'   => 672,
         'file_name' => 'service_demo.jpg'
      ); 
   }
   elseif( preg_match("#doctor#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 480,
         'width'   => 370,
         'file_name' => 'doctor_demo.jpg'
      ); 
   }

   return $ouput;
}

add_filter( 'pbrthemer_import_attachment_image_size', 'mediac_import_attachment_image_size' , 1 , 999 );
