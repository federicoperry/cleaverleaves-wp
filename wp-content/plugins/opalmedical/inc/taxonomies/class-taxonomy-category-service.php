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
class Opalmedical_Taxonomy_Category_Service{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
        'name'              => __( 'Service Categories', "opalmedical" ),
        'singular_name'     => __( 'Service Category', "opalmedical" ),
        'search_items'      => __( 'Search Category Service', "opalmedical" ),
        'all_items'         => __( 'Service Categories', "opalmedical" ),
        'parent_item'       => __( 'Parent Service Category', "opalmedical" ),
        'parent_item_colon' => __( 'Parent Service Category:', "opalmedical" ),
        'edit_item'         => __( 'Edit Service Category', "opalmedical" ),
        'update_item'       => __( 'Update Service Category', "opalmedical" ),
        'add_new_item'      => __( 'Add New ServiceCategory', "opalmedical" ),
        'new_item_name'     => __( 'New ServiceCategory Name', "opalmedical" ),
        'menu_name'         => __( 'Service Categories', "opalmedical" ),
        );
		

		register_taxonomy( 'opalmedical_category_service', 'opalmedical_service', array(
			'labels' => array(
            'name'              => __('Categories','opalmedical'),
            'all_items'         => __( 'Service Categories', 'opalmedical' ),
            'add_new_item'      => __('Add New Service Category','opalmedical'),
            'new_item_name'     => __('New Service Category','opalmedical')
         ),
         'hierarchical'  		=> true,
         'query_var'          => 'opal-category-service',
         'rewrite'       		=> array('slug' => 'category-service'),
		) );
	}



}

Opalmedical_Taxonomy_Category_Service::init();