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
class Opalmedical_Taxonomy_Category{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ), 4 );
	}

	/**
	 *
	 */
	public static function definition(){
		$slug_field = opalmedical_get_option( 'slug_category_doctor' );
		$slug = isset($slug_field) ? $slug_field : "category-doctor";
		register_taxonomy('opal_doctor_cat', 'opalmedical_doctor', array(
            'labels' => array(
                'name'              => __('Doctor Category','opalmedical'),
                'all_items'         => __( 'Doctor Category', 'opalmedical' ),
                'add_new_item'      => __('Add New  Category','opalmedical'),
                'new_item_name'     => __('New Category','opalmedical')
            ),
            'hierarchical'  	  => true,
         	'query_var'         => true,
            'rewrite'       	  => array('slug' => $slug,'with_front' => true),
            'public'            => true,
            'show_ui'           => true,
        ));
	}
}

Opalmedical_Taxonomy_Category::init();