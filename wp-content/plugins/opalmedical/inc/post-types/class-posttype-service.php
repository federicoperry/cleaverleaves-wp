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
class Opalmedical_PostType_Service{

	/**
	 * init action and filter data to define service post type
	 */
	public static function init(){ 
		
		add_action( 'init', array( __CLASS__, 'definition' ) );
		//-- custom add column to list post
		add_filter( 'manage_opalmedical_service_posts_columns',array(__CLASS__,'init_service_columns'),10);
		add_action("manage_opalmedical_service_posts_custom_column", array(__CLASS__, "show_service_columns"), 10, 2);
		// /End
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
		//
		define( 'OPALMEDICAL_SERVICE_PREFIX', 'opal_service_' );

	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'                  => __( 'Services', 'opalmedical' ),
			'singular_name'         => __( 'Services', 'opalmedical' ),
			'add_new'               => __( 'Add Service', 'opalmedical' ),
			'add_new_item'          => __( 'Add New Service', 'opalmedical' ),
			'edit_item'             => __( 'Edit Service', 'opalmedical' ),
			'new_item'              => __( 'New Service', 'opalmedical' ),
			'all_items'             => __( 'Services', 'opalmedical' ),
			'view_item'             => __( 'View Service', 'opalmedical' ),
			'search_items'          => __( 'Search Service', 'opalmedical' ),
			'not_found'             => __( 'No Service found', 'opalmedical' ),
			'not_found_in_trash'    => __( 'No Service found in Trash', 'opalmedical' ),
			'parent_item_colon'     => '',
			'menu_name'      		=> __( 'Medical Services', 'opalmedical' ),
		);

		$labels = apply_filters( 'opalmedical_postype_service_labels' , $labels );
		$slug_field = opalmedical_get_option( 'slug_service' );
		$slug = isset($slug_field) ? $slug_field : "service";
		register_post_type( 'opalmedical_service',
			array(
				'labels'            		=> $labels,
				'supports'          		=> array('title', 'editor','excerpt','thumbnail' ),
				'public'            		=> true,
				'has_archive'       		=> true,
				'rewrite'           		=> array( 'slug' => $slug ),
				//'show_in_menu'  			=> 'edit.php?post_type=opalmedical_doctor',
				'menu_position'   => 6,
				'categories'        		=> array(),
				'menu_icon'       => 'dashicons-admin-home',
			)
		);
	}

		/**
	 * Add custom taxonomy columns
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public static function init_service_columns($columns) {
		$columns = array_slice($columns, 0, 1, true) + array(OPALMEDICAL_SERVICE_PREFIX .'thumb' => __("Image", 'opalmedical_service')) + array_slice($columns, 1, count($columns) - 1, true);		
		return $columns;
	}

	/**
	 * Add content to custom column
	 *
	 * @param $column
	 */
	public static function show_service_columns($column, $post_ID) {

		global $post;
		switch ($column) {
			case OPALMEDICAL_SERVICE_PREFIX .'thumb':
				echo '<a href="' . get_edit_post_link($post->ID) . '">' . get_the_post_thumbnail($post_ID,array( 100, 100)) . '</a>';
				break;
		}
	}

	/**
   *
   */
  public static function metaboxes( array $metaboxes ) {
    $prefix = OPALMEDICAL_SERVICE_PREFIX;     
    $metaboxes[ $prefix . 'managements' ] = array(
      'id'                        => $prefix . 'standard-service',
      'title'                     => __( 'Working Hours', "opalmedical" ),
      'object_types'              => array( 'opalmedical_service' ),
      'context'                   => 'normal',
      'priority'                  => 'high',
      'show_names'                => true,
      'fields'                    => self::metaboxes_management_fields()
    );

    $metaboxes[ $prefix . 'price_lists' ] = array(
			'id'                        => $prefix . 'price_lists',
			'title'                     => __( 'Price List', 'opalestate' ),
			'object_types'              => array( 'opalmedical_service' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_price_lists_fields()
		);

    return $metaboxes;
  }// end function

  /**
   *
   */ 
  public static function metaboxes_management_fields (){
    $prefix = OPALMEDICAL_SERVICE_PREFIX;
    $fields = array(
 		array(
			'name'       => __( 'Timetable', 'opalmedical' ),
			'desc'       => __( 'field description (optional)', 'opalmedical' ),
			'id'         => $prefix . 'timetable',
			'type'       => 'timetable',
			'multiple' => true,
		)
    );

   return apply_filters( 'opalmedical_postype_service_metaboxes_fields_managements' , $fields );
  }

  /**
	 *
	 */
	public static function metaboxes_price_lists_fields() {
		$prefix = OPALMEDICAL_SERVICE_PREFIX;
		$fields = array(
		   	array(
				'id'                => $prefix . 'price_lists_group',
				'type'              => 'group',
				'fields'            => array(
					array(
						'id'                => $prefix . 'price_lists_key',
						'name'              => __( 'Label', 'opalmedical' ),
						'type'              => 'text',
					),
					array(
						'id'                => $prefix . 'price_lists_value',
						'name'              => __( 'Content', 'opalmedical' ),
						'type'              => 'text',
					)
				),
				'options'     => array(
			        'group_title'   => __( 'Price {#}', 'opalmedical' ), // since version 1.1.4, {#} gets replaced by row 76
			        'add_button'    => __( 'Add Another Entry', 'opalmedical' ),
			        'remove_button' => __( 'Remove Entry', 'opalmedical' ),
			        'sortable'      => true, // beta
			        'closed'     	=> false, // true to have the groups closed by default
			    ),
			)
		);

		return apply_filters( 'opalmedical_postype_service_metaboxes_fields_price_lists' , $fields );
	}


}// end class

Opalmedical_PostType_Service::init();
