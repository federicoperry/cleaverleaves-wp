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
class Opalmedical_PostType_Department{

	/**
	 * init action and filter data to define department post type
	 */
	public static function init(){ 
		
		add_action( 'init', array( __CLASS__, 'definition' ) );
		//
		define( 'OPALMEDICAL_DEPARTMENT_PREFIX', 'opal_department_' );
		add_action( 'cmb2_admin_init', array( __CLASS__, 'metaboxes' )  );
		require_once OPALMEDICAL_PLUGIN_DIR . 'inc/vendors/cmb2/timetable.php';
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'                  => __( 'Departments', 'opalmedical' ),
			'singular_name'         => __( 'Departments', 'opalmedical' ),
			'add_new'               => __( 'Add Department', 'opalmedical' ),
			'add_new_item'          => __( 'Add New Department', 'opalmedical' ),
			'edit_item'             => __( 'Edit Department', 'opalmedical' ),
			'new_item'              => __( 'New Department', 'opalmedical' ),
			'all_items'             => __( 'Departments', 'opalmedical' ),
			'view_item'             => __( 'View Department', 'opalmedical' ),
			'search_items'          => __( 'Search Department', 'opalmedical' ),
			'not_found'             => __( 'No Department found', 'opalmedical' ),
			'not_found_in_trash'    => __( 'No Department found in Trash', 'opalmedical' ),
			'parent_item_colon'     => '',
			'menu_name'      		=> __( 'Medical Departments', 'opalmedical' ),
		);

		$labels = apply_filters( 'opalmedical_postype_department_labels' , $labels );

		register_post_type( 'opal_department',
			array(
				'labels'            		=> $labels,
				'supports'          		=> array('title', 'editor','excerpt','thumbnail' ),
				'public'            		=> true,
				'has_archive'       		=> true,
				'rewrite'           		=> array( 'slug' => 'department' ),
				'show_in_menu'  			=> 'edit.php?post_type=opalmedical_doctor',
				'menu_position'   			=> 6,
				'categories'      	  		=> array(),
				'menu_icon'      		    => 'dashicons-admin-home',
			)
		);
	}

	
  	/**
	 * 	
	 */
	public static function metaboxes( ) {
		$prefix = OPALMEDICAL_DEPARTMENT_PREFIX;  

		$cmb = new_cmb2_box( array(
			'id'                        => $prefix . 'timetable',
			'title'                     => __( 'Working Time', 'opalestate' ),
			'object_types'              => array( 'opal_department' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
		) );


		$cmb->add_field( array(
			'name'       => __( 'Phone', 'opalmedical' ),
			'desc'       => __( 'field description (optional)', 'opalmedical' ),
			'id'         => $prefix . 'phone',
			'type'       => 'text',
		) );
		$cmb->add_field( array(
			'name'       => __( 'Fax', 'opalmedical' ),
			'desc'       => __( 'field description (optional)', 'opalmedical' ),
			'id'         => $prefix . 'fax',
			'type'       => 'text',
		) );
		$cmb->add_field( array(
			'name'       => __( 'Email', 'opalmedical' ),
			'desc'       => __( 'field description (optional)', 'opalmedical' ),
			'id'         => $prefix . 'email',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'name'       => __( 'Gallery', 'opalmedical' ),
			'desc'       => __( 'field description (optional)', 'opalmedical' ),
			'id'         => $prefix . 'gallery',
			'type'       => 'file_list'	
		) );
		

		$cmb->add_field( array(
			'name'       => __( 'Timetable', 'opalmedical' ),
			'desc'       => __( 'field description (optional)', 'opalmedical' ),
			'id'         => $prefix . 'timetable',
			'type'       => 'timetable',
			'multiple' => true,
		) );


 
		$cmb->add_field(	array(
			'id'          => $prefix . 'treatments_pricing',
			'type'        => 'group',
			'row_classes' => 'opalmedical-subfield',
	
			'options'     => array(
				'add_button'    => esc_html__( 'Add Level', 'opalmedical' ),
				'remove_button' => '<span class="dashicons dashicons-no"></span>',
				'sortable'      => true, // beta
				'group_title'   => __( 'Treatments Pricing {#}', 'opalmedical' ),
			),
			// Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
			'fields'      => apply_filters( 'opalmedical_pricing_table_row', array(
				array(
					'name' => esc_html__( 'ID', 'opalmedical' ),
					'id'   => $prefix . 'id',
					'type' => 'levels_id',
				),
				array(
					'name'              => esc_html__( 'Entry', 'opalmedical' ),
					'id'                => $prefix . 'entry',
					'type'              => 'text_small',
                    'attributes'        => array(
						'class'       => 'cmb-type-text-small opalmedical-money-field',
					),
				),
				array(
					'name'       => esc_html__( 'Price', 'opalmedical' ),
					'id'         => $prefix . 'price',
					'type'       => 'text',
					'attributes' => array(
						'class'       => 'opalmedical-multilevel-text-field',
					),
				)
			) ),
		) );


		$cmb->add_field(	array(
			'id'          => $prefix . 'investigations_pricing',
			'type'        => 'group',
			'row_classes' => 'opalmedical-subfield',
		
			'options'     => array(
				'add_button'    => esc_html__( 'Investigation Level', 'opalmedical' ),
				'remove_button' => '<span class="dashicons dashicons-no"></span>',
				'sortable'      => true, // beta
				'group_title'   => __( 'Investigation Pricing {#}', 'opalmedical' ),
			),
			// Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
			'fields'      => apply_filters( 'opalmedical_investigations_pricing_table_row', array(
				array(
					'name'              => esc_html__( 'Entry', 'opalmedical' ),
					'id'                => $prefix . 'entry',
					'type'              => 'text_small',
                    'attributes'        => array(
						'class'       => 'cmb-type-text-small opalmedical-money-field',
					),
					 
				),
				array(
					'name'       => esc_html__( 'Price', 'opalmedical' ),
					'id'         => $prefix . 'price',
					'type'       => 'text',
					'attributes' => array(
						'class'       => 'opalmedical-multilevel-text-field',
					),
				)
			) ),
		) );

		$cmb->add_field(	array(
			'id'          => $prefix . 'treatments_pricing',
			'type'        => 'group',
			'row_classes' => 'opalmedical-subfield',
			 
			'options'     => array(
				'add_button'    => esc_html__( 'Add Treatment', 'opalmedical' ),
				'remove_button' => '<span class="dashicons dashicons-no"></span>',
				'sortable'      => true, // beta
				'group_title'   => __( 'Treatment Pricing {#}', 'opalmedical' ),
			),
			// Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
			'fields'      => apply_filters( 'opalmedical_investigations_pricing_table_row', array(
			 
				array(
					'name'              => esc_html__( 'Entry', 'opalmedical' ),
					'id'                => $prefix . 'entry',
					'type'              => 'text_small',
                    'attributes'        => array(
						'class'       => 'cmb-type-text-small opalmedical-money-field',
					),
					 
				),
				array(
					'name'       => esc_html__( 'Price', 'opalmedical' ),
					'id'         => $prefix . 'price',
					'type'       => 'text',
					'attributes' => array(
						'class'       => 'opalmedical-multilevel-text-field',
					),
				)
			) ),
		) );
	}// end function
		
	 

}// end class

Opalmedical_PostType_Department::init();
