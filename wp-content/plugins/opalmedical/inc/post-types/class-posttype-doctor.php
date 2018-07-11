<?php
 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author      Doctor <opalwordpress@gmail.com >
  * @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.wpopal.com
  * @support  http://www.wpopal.com/questions/
  */
 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
class Opalmedical_PostType_Doctor{


  /**
   * init action and filter data to define menu post type
   */
  public static function init(){ 

      add_action( 'init', array( __CLASS__, 'opalmedical_create_type_doctor' ) );
      //-- custom add column to list post
      add_filter( 'manage_opalmedical_doctor_posts_columns',array(__CLASS__,'init_menu_columns'),10);
      add_action("manage_opalmedical_doctor_posts_custom_column", array(__CLASS__, "show_menu_columns"), 10, 2);

      add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );

      define( 'OPALMEDICAL_DOCTOR_PREFIX', 'opalmedical_doctor_' );
  }
  
  public static function opalmedical_create_type_doctor(){
      $labels = array(
        'name'          => __( 'Medical', "opalmedical" ),
        'singular_name' => __( 'Doctors', "opalmedical" ),
        'add_new'       => __( 'Add New Doctor', "opalmedical" ),
        'add_new_item'  => __( 'Add New Doctor', "opalmedical" ),
        'edit_item'     => __( 'Edit Doctor', "opalmedical" ),
        'new_item'      => __( 'New Doctor', "opalmedical" ),
        'view_item'     => __( 'View Doctor', "opalmedical" ),
        'search_items'  => __( 'Search Doctors', "opalmedical" ),
        'not_found'     => __( 'No Doctors found', "opalmedical" ),
        'not_found_in_trash' => __( 'No Doctors found in Trash', "opalmedical" ),
        'parent_item_colon'  => __( 'Parent Doctor:', "opalmedical" ),
        'all_items'          => __( 'Doctors', "opalmedical" ),
        'menu_name'          => __( 'Medicals', "opalmedical" ),
        );
      $slug_field = opalmedical_get_option( 'slug_doctor' );
      $slug = isset($slug_field) ? $slug_field : "doctor";
      $args = array(
        'labels'        => $labels,
        'hierarchical'  => false,
        'description'   => 'List Of Doctors',
        'supports'      => array( 'title', 'editor', 'thumbnail','excerpt'),
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_position' => 5,
        'show_in_nav_menus'   => false,
        'publicly_queryable'  => true,
        'exclude_from_search' => true,
        'rewrite'             => array( 'slug' => $slug ),
        'has_archive'         => true,
        'query_var'           => true,
        'can_export'          => true,
        'capability_type'     => 'post',
        'menu_icon'           => 'dashicons-admin-home',

        );
      register_post_type( 'opalmedical_doctor', $args );

    }


   /**
   * Add custom taxonomy columns
   *
   * @param $columns
   *
   * @return array
   */
  public static function init_menu_columns($columns) {
      $columns = array_slice($columns, 0, 1, true) + array(OPALMEDICAL_DOCTOR_PREFIX .'thumb' => __("Image", 'opalmedical_doctor')) + array_slice($columns, 1, count($columns) - 1, true);
      $columns = array_slice($columns, 0, 3, true) + array(OPALMEDICAL_DOCTOR_PREFIX .'email' => __("Email", 'opalmedical_doctor')) + array_slice($columns, 2, count($columns) - 1, true);
      $columns = array_slice($columns, 0, 4, true) + array(OPALMEDICAL_DOCTOR_PREFIX .'phone' => __("Phone", 'opalmedical_doctor')) + array_slice($columns, 2, count($columns) - 1, true);
      return $columns;
  }

  /**
   * Add content to custom column
   *
   * @param $column
   */
  public static function show_menu_columns($column, $post_ID) {
    global $post;
    switch ($column) {
      case OPALMEDICAL_DOCTOR_PREFIX .'thumb':
        echo '<a href="' . get_edit_post_link($post->ID) . '">' . get_the_post_thumbnail($post_ID,array( 100, 100)) . '</a>';
        break;
      case OPALMEDICAL_DOCTOR_PREFIX .'email':
        if (!empty($post->opalmedical_doctor_email)) {
          echo $post->opalmedical_doctor_email;
        } else {
          echo '—';
        }
        break;
      case OPALMEDICAL_DOCTOR_PREFIX .'phone':
        if (!empty($post->opalmedical_doctor_phone)) {
          echo $post->opalmedical_doctor_phone;
        } else {
          echo '—';
        }
        break;
    }
  }

  /**
   *
   */
  public static function metaboxes( array $metaboxes ) {
    $prefix = OPALMEDICAL_DOCTOR_PREFIX;     
    $metaboxes[ $prefix . 'managements' ] = array(
      'id'                        => $prefix . 'standard-doctor',
      'title'                     => __( 'Doctor Setting', "opalmedical" ),
      'object_types'              => array( 'opalmedical_doctor' ),
      'context'                   => 'normal',
      'priority'                  => 'high',
      'show_names'                => true,
      'fields'                    => self::metaboxes_management_fields()
    );


    $metaboxes[ $prefix . 'socials' ] = array(
      'id'                        => $prefix . 'socials-doctor',
      'title'                     => __( 'Social info', "opalmedical" ),
      'object_types'              => array( 'opalmedical_doctor' ),
      'context'                   => 'normal',
      'priority'                  => 'high',
      'show_names'                => true,
      'fields'                    => self::metaboxes_socials_fields()
    );

    return $metaboxes;
  }// end function

  /**
   *
   */ 
  public static function metaboxes_management_fields (){
    $prefix = OPALMEDICAL_DOCTOR_PREFIX;
    $fields = array(
      array(
          'name'    => __( 'Department', 'opalmedical' ),
          'desc'    => __( 'Select one or multiple department', 'opalmedical' ),
          'id'      => $prefix.'department',
          'type'    => 'select',
          'options' => opalmedical_get_departments(),
      ),  

       array(
        'name'            => __( 'Job/Position', 'opalmedical' ),
        'id'              => $prefix . 'email',
        'type'            => 'label',
        'description'     => __('Please Enter Job/Position','opalmedical')
      ),

      array(
        'name'            => __( 'Email', 'opalmedical' ),
        'id'              => $prefix . 'email',
        'type'            => 'text_email',
        'description'     => __('Please Enter Email','opalmedical')
      ),
      array(
        'name'            => __( 'Phone', 'opalmedical' ),
        'id'              => $prefix . 'phone',
        'type'            => 'text_medium',
        'description'     => __('Please Enter Phone','opalmedical')
      ),
      array(
        'name'       => __( 'Timetable', 'opalmedical' ),
        'desc'       => __( 'field description (optional)', 'opalmedical' ),
        'id'         => $prefix . 'timetable',
        'type'       => 'timetable',
        'multiple' => true,
      )
    );

    return apply_filters( 'opalmedical_postype_doctor_metaboxes_fields_managements' , $fields );
  }

 

  /**
   *
   */ 
  public static function metaboxes_socials_fields (){
    $prefix = OPALMEDICAL_DOCTOR_PREFIX;
    $fields = array(
       // COLOR
      array(
        'name' => __( 'Google Plus Link', "opalmedical" ),
        'id'   => "{$prefix}google",
        'type' => 'text',
        'description' => __('Enter google', "opalmedical")
        ), 

      array(
        'name' => __( 'Facebook Link', "opalmedical" ),
        'id'   => "{$prefix}facebook",
        'type' => 'text',
        'description' => __('Enter facebook', "opalmedical")
        ), 

      array(
        'name' => __( 'Twitter', "opalmedical" ),
        'id'   => "{$prefix}twitter",
        'type' => 'text',
        'description' => __('Enter Twitter', "opalmedical")
        ),

      array(
        'name' => __( 'Youtube', "opalmedical" ),
        'id'   => "{$prefix}youtube",
        'type' => 'text',
        'description' => __('Enter Youtube', "opalmedical")
        ), 
 

      array(
        'name' => __( 'Printest', "opalmedical" ),
        'id'   => "{$prefix}pinterest",
        'type' => 'text',
        'description' => __('Enter pinterest', "opalmedical")
        ), 
    );

    return apply_filters( 'opalmedical_postype_doctor_metaboxes_fields_socials' , $fields );
  }


  public static function listday(){

    $args = array(
       'monday'     => 'Monday',           
       'Tuesday'    => 'Tuesday',           
       'wednesday'  => 'Wednesday',           
       'thursday'   => 'Thursday',           
       'friday'     => 'Friday',           
       'aaturday'   => 'Saturday',          
       'aunday'     => 'Sunday',                        
    );   
    return $args;  
  }  

  public static function opalmedical_fnc_doctor_query(){

    $args = array(
       'post_type' => 'opalmedical_doctor'           
    );   
        return new WP_Query( $args );  
  }    
}// end Classs

Opalmedical_PostType_Doctor::init();


