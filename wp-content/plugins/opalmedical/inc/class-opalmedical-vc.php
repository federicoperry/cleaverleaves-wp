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


if( class_exists("WPBakeryVisualComposerAbstract") ){
    function opalmedical_vc_get_term_object( $term ) {
		$vc_taxonomies_types = vc_taxonomies_types();

		return array(
			'label' => $term->name,
			'value' => $term->slug,
			'group_id' => $term->taxonomy,
			'group' => isset( $vc_taxonomies_types[ $term->taxonomy ], $vc_taxonomies_types[ $term->taxonomy ]->labels, $vc_taxonomies_types[ $term->taxonomy ]->labels->name ) ? $vc_taxonomies_types[ $term->taxonomy ]->labels->name : esc_html__( 'Taxonomies', 'mode' ),
		);
	}

	
	function opalmedical_category_render($query) {  
		$category = get_term_by('slug', $query['value'], 'menu_category');
		if ( ! empty( $query ) && !empty($category)) {
			$data = array();
			$data['value'] = $category->slug;
			$data['label'] = $category->name;
			return ! empty( $data ) ? $data : false;
		}
		return false;
	}
	vc_map( array(
          "name" => __("Medical Carousel Menu", "opalmedical"),
          "base" => "opal_medical_carousel_menu",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalMedical', "opalmedical"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalmedical"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opalmedical"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalmedical"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),

	         array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opalmedical"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit menu showing', 'opalmedical')
	        ),

	        array(
				"type" => "dropdown",
				"heading" => esc_html__("Enable Thumbnail", 'opalmedical'),
				"param_name" => "enable_thumbnail",
				'value' 	=> array(
					esc_html__('Disable', 'opalmedical') => 0, 
					esc_html__('Enable', 'opalmedical') => 1, 
					
				),
				'std' => 0
			),
          )
      ));
	//----------------------------------------------------------------------
		vc_map( array(
          "name" => __("Medical Carousel Categories Menu", "opalmedical"),
          "base" => "opal_medical_carousel_categories_menu",
          "class" => "",
          "description" => 'the show list menu by category follow slider',
          "category" => __('OpalMedical', "opalmedical"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalmedical"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opalmedical"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalmedical"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),

	         array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opalmedical"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit Categories showing', 'opalmedical')
	        ),
	         array(
	            "type" => "textfield",
	            "heading" => __("Limit Menu", "opalmedical"),
	            "param_name" => "limit_menu",
	            "value" => 6,
	            'description' =>  __('Limit Menu showing', 'opalmedical')
	        ),
	        array(
				"type" => "dropdown",
				"heading" => esc_html__("Enable Thumbnail", 'opalmedical'),
				"param_name" => "enable_thumbnail",
				'value' 	=> array(
					esc_html__('Disable', 'opalmedical') => 0, 
					esc_html__('Enable', 'opalmedical') => 1, 
					
				),
				'std' => 0
			),
          )
      ));
      vc_map( array(
          "name" => __("Medical List Menu", "opalmedical"),
          "base" => "opal_medical_list_menu",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalMedical', "opalmedical"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalmedical"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Description", "opalmedical"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	         array(
				"type" => "dropdown",
				"heading" => __("View Mode", "opalmedical"),
				"param_name" => "showmode",
				'value' 	=> array(
					esc_html__("Grid","opalmedical")=> "grid",
					esc_html__("List","opalmedical")=> "list",
				),
				'std' => "grid"
				),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalmedical"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),

	         array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opalmedical"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit list menu showing', 'opalmedical')
	        ),
	         array(
	            "type" => "checkbox",
	            "heading" => __("Don't show Description", "opalmedical"),
	            "param_name" => "description"
	        ),
          )
      ));
      vc_map( array(
          "name" => __("Medical List Categories", "opalmedical"),
          "base" => "opal_medical_list_categories",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalMedical', "opalmedical"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalmedical"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opalmedical"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	         array(
				"type" => "dropdown",
				"heading" => __("View Mode", "opalmedical"),
				"param_name" => "showmode",
				'value' 	=> array(
					esc_html__("Grid","opalmedical")=> "grid",
					esc_html__("List","opalmedical")=> "list",
				),
				'std' => "grid"
				),
	        
				array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalmedical"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Limit per page", "opalmedical"),
	            "param_name" => "limit",
	            "value" => 10,
	            'description' =>  __('Limit list categories showing', 'opalmedical')
	        ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Don't show Description", "opalmedical"),
	            "param_name" => "check_description"
	        ),
	      )
      ));


      
      //class WPBakeryShortCode_opal_medical_featured_menu  extends WPBakeryShortCode {}
      class WPBakeryShortCode_opal_medical_carousel_categories_menu  extends WPBakeryShortCode {}
      class WPBakeryShortCode_opal_medical_list_menu  extends WPBakeryShortCode {}
      class WPBakeryShortCode_opal_medical_carousel_menu  extends WPBakeryShortCode {}
      class WPBakeryShortCode_opal_medical_list_categories  extends WPBakeryShortCode {}
  }