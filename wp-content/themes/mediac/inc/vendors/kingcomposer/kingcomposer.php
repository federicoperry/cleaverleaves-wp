<?php
	add_action('init', 'mediac_element_kingcomposer_map', 99 );

	function mediac_element_kingcomposer_map(){
		global $kc;

		$maps = array();
		// Give-Report
 		$maps['element_give_report'] =  array(
				"name"        => esc_html__("Give Report", 'mediac'),
				"class"       => "",
				"description" => 'Show The Money Goes',
				"category"    => esc_html__('Elements', 'mediac'),
				"icon"        => 'cpicon sl-paper-plane',
				"params"      => array(
				// start param
				array(
					'type'			=> 'group',
					'label'			=> esc_html__('Options', 'mediac'),
					'name'			=> 'options',
					'description'	=> esc_html__( 'Repeat this fields with each item created, Each item corresponding Pie element.', 'mediac' ),
					'options'		=> array('add_text' => esc_html__('Add new Pie and doughnut charts', 'mediac')),
					'value' => '',
					'params' => array(
						array(
							'type' => 'number_slider',
							'label' => esc_html__( 'Value', 'mediac' ),
							'name' => 'value',
							'description' => esc_html__( 'Enter targeted value of the bar (From 1 to 100).', 'mediac' ),
							'admin_label' => true,
							'options' 		=> array(
								'min'		=> 1,
								'max'		=> 100,
							),
							'value' => '80'
						),
						array(
							'type' => 'color_picker',
							'label' => esc_html__( 'Value Color', 'mediac' ),
							'name' => 'value_color',
							'description' => esc_html__( 'Color of targeted value text.', 'mediac' ),
						),
						array(
							'type' => 'text',
							'label' => esc_html__( 'Label', 'mediac' ),
							'name' => 'label',
							'description' => esc_html__( 'Enter text used as title of the bar.', 'mediac' ),
							'admin_label' => true,
						),
					),
				),
				// end param
				array(
					"type"        => "textfield",
					"label"       => esc_html__("Wrapper class", 'mediac'),
					"name"        => "wrap_class",
					"value"       => '',
					"admin_label" => true
				),
			  )
		);
		// Degree-360
 		$maps['element_block_heading'] =  array(

				"name"        => esc_html__("Block Heading", 'mediac'),
				"class"       => "",
				"description" => esc_html__( 'Display Block Heading', 'mediac' ),
				"category"    => esc_html__('Elements', 'mediac'),
				"icon"        => 'kc-icon-title',
				"params"      => array(

		

		    	array(
					"type"        => "textfield",
					"label"       => esc_html__("Heading", 'mediac'),
					"name"        => "heading",
					"value"       => '',
					"admin_label" => true
				),
				array(
					"type"        => "textfield",
					"label"       => esc_html__("Sub Heading", 'mediac'),
					"name"        => "subheading",
					"value"       => '',
					"admin_label" => true
				),
				array(
					"type"        => "textarea",
					"label"       => esc_html__("Description", 'mediac'),
					"name"        => "description",
					'description' => esc_html__( 'Display Description In heading.', 'mediac' ),
					'admin_label' => true
				),
			  )
		);

 		$maps['opalmembership_packages'] =  array(

				"name"        => esc_html__("Membership Package Plan", 'mediac'),
				"class"       => "",
				"description" => esc_html__( 'Display package plan from opal membership', 'mediac' ),
				"category"    => esc_html__('Elements', 'mediac'),
				"icon"        => 'kc-icon-title',
				"params"      => array(

		

		    	array(
					"type"        => "textfield",
					"label"       => esc_html__("Heading", 'mediac'),
					"name"        => "heading",
					"value"       => '',
					"admin_label" => true
				),
			  )
		);

		$maps = apply_filters( 'mediac_element_kingcomposer_map', $maps );
	    $kc->add_map( $maps );
	} // end class
?>