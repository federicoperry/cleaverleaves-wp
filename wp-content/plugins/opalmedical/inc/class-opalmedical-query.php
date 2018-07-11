<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalmedical
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Opalmedical_Query {


	public static function get_doctor_by_id_query( $ids ){

		$args = array(
			'post_type'         => 'opalmedical_doctor'
		);

		$args['meta_query'] = array('relation' => 'AND');
 

		$metaquery = array();
		 
		$fieldquery = array(
			'key'     => OPALMEDICAL_DOCTOR_PREFIX.'department',
        	'value'   => 0,
        	'compare' => '>',
        	'type' => 'NUMERIC'
		);

		$metaquery[] = $fieldquery;
 		$args['meta_query'] = array_merge( $args['meta_query'], $metaquery );
 
		return Opalmedical_Query::get_doctor_query( $args );

	}
	public static function get_doctor_query( $args=array() ){
		$default = array(
			'post_type'         => 'opalmedical_doctor',
			'posts_per_page'	=> 10 ,

		);

		$args = array_merge( $default, $args );
		return new WP_Query( $args );
	}

	public static function getServiceQuery( $args=array() ){
		$default = array(
			'post_type'         => 'opalmedical_service',
		);

		$args = array_merge( $default, $args );
		return new WP_Query( $args );
	}

	/**
	* @param $term_id is term_id in taxonomy
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_doctor_by_term_id($term_id,$per_page = 10){
		wp_reset_query();
		$args = array();
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		if($term_id == 0 || empty($term_id)){
			$args = array(
				'posts_per_page' 	=> $per_page,
				'paged' 				=> $paged,
				'post_type' 		=> "opalmedical_doctor",
			);
		}else{
			$args = array(
				'posts_per_page' 	=> $per_page,
				'paged'			 	=> $paged,
				'post_type' 		=> "opalmedical_doctor",
				'tax_query' 		=> array(
					array(
						'taxonomy' 	=> "opal_doctor_cat",
						'field' 		=> 'term_id',
						'terms' 		=> $term_id,
						'operator' 	=> 'IN'
						)
					)
				);
		}
		return new WP_Query( $args );
	}

	/**
	* @param $term_slug is slug in taxonomy
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_doctor_by_term_slug($term_slug,$per_page = 10){
		wp_reset_query();
		$args = array();
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		if($term_slug == 0 || empty($term_slug)){
			$args = array(
				'posts_per_page' 	=> $per_page,
				'paged' 				=> $paged,
				'post_type' 		=> "opalmedical_doctor",
			);
		}else{
			$args = array(
				'posts_per_page' 	=> $per_page,
				'paged'			 	=> $paged,
				'post_type' 		=> "opalmedical_doctor",
				'tax_query' 		=> array(
					array(
						'taxonomy' 	=> "opal_doctor_cat",
						'field' 		=> 'slug',
						'terms' 		=> $term_slug,
						'operator' 	=> 'IN'
						)
					)
				);
		}
		return new WP_Query( $args );
	}

	/**
	* @param $term_id is term_id in taxonomy
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_service_by_term_id($term_id,$per_page = -1){
		wp_reset_query();
		$args = array();
		if($term_id == 0 || empty($term_id)){
			$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalmedical_service",
			);
		}else{
			$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalmedical_service",
				'tax_query' => array(
					array(
						'taxonomy' => "opalmedical_category_service",
						'field' => 'term_id',
						'terms' => $term_id,
						'operator' => 'IN'
						)
					)
				);
		}
		return new WP_Query( $args );
	}

	public static function get_departments_query( $per_page = -1 ){
		$args = array();
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$args = array(
			'posts_per_page' 	=> $per_page,
			'paged'			 	=> $paged,
			'post_type' 		=> "opal_department",
		);
		return new WP_Query( $args );
	}

	/**
	* @param $term_id is term_id in taxonomy
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_service_by_term_slug($term_slug,$per_page = -1){
		wp_reset_query();
		$args = array();
		if($term_slug == 0 || empty($term_slug)){
			$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalmedical_service",
			);
		}else{
			$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalmedical_service",
				'tax_query' => array(
					array(
						'taxonomy' => "opalmedical_category_service",
						'field' => 'slug',
						'terms' => $term_slug,
						'operator' => 'IN'
						)
					)
				);
		}
		return new WP_Query( $args );
	}

	/**
	* 
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_the_term_filter_name($post,$taxonomy_name){
		$terms = wp_get_post_terms( $post->ID, $taxonomy_name ,array("fields" => "names") );
		return $terms; 
	}
	/**
	* Get All Categories 
	* @param $args
	*/
	public static function get_categories($per_page = 0){
		$args = array(
				  'hide_empty' => false,
				  'orderby' => 'name',
				  'order' => 'ASC',
				  'number' => $per_page,
				);
		$terms = get_terms('opal_doctor_cat',$args);
		return $terms;
	}
	/**
	* Get All Categories 
	* @param $args
	*/
	public static function getCategoryServices($per_page = 0){
		$args = array(
				  'hide_empty' => false,
				  'orderby' => 'name',
				  'order' => 'ASC',
				  'number' => $per_page,
				);
		$terms = get_terms('opalmedical_category_service',$args);
		return $terms;
	}


}