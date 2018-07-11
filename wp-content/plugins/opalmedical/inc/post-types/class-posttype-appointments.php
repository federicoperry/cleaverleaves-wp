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
class Opalmedical_PostType_Appointments{

	/**
	 * init action and filter data to define appointments post type
	 */
	public static function init(){ 
		
		add_action( 'init', array( __CLASS__, 'definition' ) );

		// add opal insert save
		add_filter( 'wp_insert_post_data', array( __CLASS__, 'pre_post_insert' ), 10, 2 );
		add_action( 'save_post', array( __CLASS__, 'save_post_insert' ), 10, 2 );
		//--- sent mail when change status
		add_action( 'transition_post_status',  array( __CLASS__, 'send_email_status' ), 10, 3 );
		
		// custom edit page
		add_action( 'admin_menu', array( __CLASS__, 'remove_meta_box') );
		add_action( 'add_meta_boxes', array( __CLASS__, 'taxonomy_add_meta_box') );

		//-- custom add column to list post
		add_filter( 'manage_opal_appointments_posts_columns',array(__CLASS__,'init_appointments_columns'),10,1);
		add_action("manage_opal_appointments_posts_custom_column", array(__CLASS__, "show_appointments_columns"), 10, 2);
		// /End
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
	}


	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'                  => __( 'Appointments', 'opalmedical' ),
			'singular_name'         => __( 'Appointments', 'opalmedical' ),
			'add_new'               => __( 'Add New Appointment', 'opalmedical' ),
			'add_new_item'          => __( 'Add New Appointment', 'opalmedical' ),
			'edit_item'             => __( 'Edit Appointment', 'opalmedical' ),
			'new_item'              => __( 'New Appointment', 'opalmedical' ),
			'all_items'             => __( 'Appointments', 'opalmedical' ),
			'view_item'             => __( 'View Appointment', 'opalmedical' ),
			'search_items'          => __( 'Search Appointment', 'opalmedical' ),
			'not_found'             => __( 'No Appointment found', 'opalmedical' ),
			'not_found_in_trash'    => __( 'No Appointment found in Trash', 'opalmedical' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Appointments', 'opalmedical' ),
		);

		$labels = apply_filters( 'opalmedical_posttype_appointments_labels' , $labels );

		register_post_type( 'opal_appointments',
			array(
				'labels'            	=> $labels,
				'supports'          	=> array('title'),
				'public'            	=> true,
				'has_archive'       	=> false,
				'rewrite'           	=> array( 'slug' => 'apointment' ),
				'show_in_menu'  		=> 'edit.php?post_type=opalmedical_doctor',
				'categories'        	=> array(),
				'menu_icon'     		=> 'dashicons-calendar',
				'capability_type'    => 'post',
				'capabilities' 		=> array(
				    'create_posts' 	=> 'do_not_allow', // false < WP 4.5, credit @Ewout
				),
				'map_meta_cap' => true,
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
	public static function init_appointments_columns($columns) {
		$columns = array_slice($columns, 0, 4, true) + array(OPALMEDICAL_APPOINTMENTS_PREFIX .'name' => __("Name", 'opal_appointments')) + array_slice($columns, 4, count($columns) - 1, true);
		$columns = array_slice($columns, 0, 5, true) + array(OPALMEDICAL_APPOINTMENTS_PREFIX.'mail' => __("Email", 'opal_appointments')) + array_slice($columns, 5, count($columns) - 1, true);
		$columns = array_slice($columns, 0, 6, true) + array(OPALMEDICAL_APPOINTMENTS_PREFIX.'phone' => __("Phone", 'opal_appointments')) + array_slice($columns, 6, count($columns) - 1, true);
		$columns = array_slice($columns, 0, 7, true) + array('opal-status' => __("Status", 'opal_appointments')) + array_slice($columns, 7, count($columns) - 1, true);
		return $columns;
	}

	/**
	 * Add content to custom column
	 *
	 * @param $column
	 */
	public static function show_appointments_columns($column, $post_ID) {
		
		global $post;
		remove_post_type_support( 'opal_appointments', 'date' );

		switch ($column) {
			//case 
			case OPALMEDICAL_APPOINTMENTS_PREFIX .'name':
				if (!empty($post->opal_appointments_name)) {
					echo $post->opal_appointments_name;
				} else {
					echo '_';
				}
				break;
			case OPALMEDICAL_APPOINTMENTS_PREFIX .'mail':
				if (!empty($post->opal_appointments_mail)) {
					echo $post->opal_appointments_mail;
				} else {
					echo '_';
				}
				break;
			case OPALMEDICAL_APPOINTMENTS_PREFIX .'phone':
				if (!empty($post->opal_appointments_phone)) {
					echo $post->opal_appointments_phone;
				} else {
					echo '_';
				}
				break;
			case 'opal-status':
					opalmedical_display_status( $post->ID );
				break;
		}
	}

	/**
	 *
	 */
	public static function metaboxes( array $metaboxes ) {
		$prefix = OPALMEDICAL_APPOINTMENTS_PREFIX; 		
		//$metaboxes = array();
		$metaboxes[ $prefix . 'managements' ] = array(
			'id'                        => $prefix . 'managements',
			'title'                     => __( 'Appointments Management', 'opalmedical' ),
			'object_types'              => array( 'opal_appointments' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_management_fields()
		);
		return $metaboxes;
	}

	/**
	 *
	 */	
	public static function metaboxes_management_fields(){
		$prefix = OPALMEDICAL_APPOINTMENTS_PREFIX;
		$fields = array(
			
			array(
				'name'            => __( 'Topic', 'opalmedical' ),
				'id'              => $prefix . 'topic',
				'type'            => 'text'
			),
			array(
				'name'            => __( 'Name', 'opalmedical' ),
				'id'              => $prefix . 'name',
				'type'            => 'text'
			),
			array(
				'name'            => __( 'Email', 'opalmedical' ),
				'id'              => $prefix . 'mail',
				'type'            => 'text',
				'description' 		=> __('Please Enter Your Email','opalmedical')
			),
			array(
				'name'            => __( 'Date', 'opalmedical' ),
				'id'              => $prefix . 'date',
				'type'            => 'text_date',
			),
			array(
				'name'            => __( 'Time', 'opalmedical' ),
				'id'              => $prefix . 'time',
				'type'            => 'text_time',
			),
			array(
				'name'            => __( 'Phone', 'opalmedical' ),
				'id'              => $prefix . 'phone',
				'type'            => 'text_medium',
			),
			array(
				'name'            => __( 'Message', 'opalmedical' ),
				'id'              => $prefix . 'message',
				'type'            => 'textarea',
			),
		);

		return apply_filters( 'opalmedical_postype_appointments_metaboxes_fields_managements' , $fields );
	}
	/**
	*
	*/

	public static function remove_meta_box() {
	   remove_meta_box('submitdiv', 'opal_appointments', 'normal');
	   remove_meta_box('opal_statusdiv', 'opal_appointments', 'normal');
	}
	
	public static  function taxonomy_add_meta_box() {
	    add_meta_box( 'opalmedical_submit', __( 'Details', 'opalmedical' ), array( __CLASS__, 'submit_section' ), 'opal_appointments' , 'side', 'core');
	}

	public static function submit_section( $post ) {
		require_once( OPALMEDICAL_PLUGIN_DIR . 'inc/admin/metaboxes/details.php' );
	}

	/**
	 * update status ( insert/update )
	 */
	public static function pre_post_insert( $data, $postarr ) {
		//die("jasdjashdj");
		if(isset($_REQUEST[ 'action' ]) && $_REQUEST[ 'action' ] == "trash"){
			return $data;
		}
		if ( $data['post_type'] == 'opal_appointments' ) {
			$statuses = opalmedical_register_status();
			if ( !in_array( $data['post_status'], $statuses ) ) {
				$data['post_status'] = isset($_REQUEST[ 'post_status_override' ]) ? $_REQUEST[ 'post_status_override' ] : 'opal-pending';
			}
		}
		return $data;
	}
	/**
	 * add opal status for post ( insert/update )
	 */
	public static function save_post_insert( $data, $postarr ) {
		if(isset($_REQUEST[ 'action' ]) && $_REQUEST[ 'action' ] == "trash"){
			return $data;
		}
		if ( $postarr->post_type == 'opal_appointments' ) {
			if($_REQUEST[ 'action' ] != "editpost" && $postarr->post_status == "opal-pending"){
				// Send mail when insert booking
				$args = array('appointment_id'=>$postarr->ID);
				
				Opalmedical_Appointment_Email::sendNewAppointmentEmail( $args );
			}		
		}
		return $data;
	}


	/**
	 * add opal status for post ( update status )
	 */
	public static function send_email_status( $new_status, $old_status, $post ) {
		if ( $post->post_type == 'opal_appointments' ) {
			$args = array('appointment_id'=>$post->ID);

			if ( $old_status != $new_status && $new_status != "opal-pending") {
				Opalmedical_Appointment_Email::sendChangeStatusEmail( $new_status, $args );
			}
		} 
		return $post;
	}

	/**
	 * 
	 */

	public static function generator_people(){
		$number = array();
		for ($i=1; $i <= 100; $i++) { 
			$number[$i] = $i;
		}
		return $number;
	}
}

Opalmedical_PostType_Appointments::init();
