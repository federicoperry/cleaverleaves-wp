<?php 

	add_action('init', 'opalmedical_element_kingcomposer_map', 99 );
 
	function opalmedical_element_kingcomposer_map(){
		global $kc;

		$maps = array();

	 
		//=======================================================================

		$maps['element_medical_carousel_doctor'] =  array(
		    'name' => esc_html__('Medical Carousel Doctor', 'opalmedical'),
		    'icon' => 'kc-icon-pcarousel',
		    'description' => 'Show list carousel doctor Info',
		    'category' => esc_html__('Elements', 'opalmedical'),
		    'params' => array(
		    	array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'opalmedical'),
					'name'        => 'title',
					'description' => __( 'The title of the Doctor List.', 'opalmedical' ),
					'value'	     => __( 'List Doctor', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type' 		  => 'number_slider',  // USAGE RADIO TYPE
					'label'       => __( 'Column', 'opalmedical' ),
					'name'        => 'column',
					'description' => __( 'Number column of the page', 'opalmedical' ),
					'admin_label' => true,
				   'options' => array(    // REQUIRED
				        'min' => 1,
				        'max' => 6,
				        'unit' => '',
				        'show_input' => false
				    ),
					//'options'     => array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6)
				),

				array(
					'type'        => 'number_slider',
					'label'       => esc_html__('Limit', 'opalmedical'),
					'name'        => 'limit',
					'description' => __( 'Number Limit of the page.', 'opalmedical' ),
					'value'	     => __( '4', 'opalmedical' ),
					'admin_label' => true,
					'options' => array(    // REQUIRED
				        'min' => 1,
				        'max' => 20,
				        'unit' => '',
				        'show_input' => false
				    ),
				),

				array(
					'type'        => 'dropdown',
					'label'       => __( 'Image Size', 'opalmedical' ),
					'name'        => 'image_size',
					'description' => __( 'Thumbnail (default 150px x 150px max)<br>Medium resolution (default 300px x 300px max)<br>Large resolution (default 640px x 640px max)<br>Full resolution (original size uploaded)<br>Other resolutions', 'opalmedical' ),
					'admin_label' => true,
					'options'     => array(
						'thumbnail'      	=> 'Thumbnail',
						'medium'          => 'Medium',
						'large'          	=> 'Large',
						'full'          	=> 'Full',
						'other'          	=> 'Other size',
					)
				),

				array(
					'type'        => 'text',
					'label'       => esc_html__('Other Image Size', 'opalmedical'),
					'name'        => 'other_size',
					'description' => __( 'the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opalmedical' ),
					'value'	     => __( '150x150', 'opalmedical' ),
					'admin_label' => true,
					'relation'	=> array(
						'parent'	=> 'image_size',
						'show_when'	=> 'other'
					),
				),
 
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Right To Left', 'opalmedical' ),
					'name'        => 'enable_rtl',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Button Navigation', 'opalmedical' ),
					'name'        => 'enable_navigation',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Button Pagination', 'opalmedical' ),
					'name'        => 'enable_pagination',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Loop Carousel', 'opalmedical' ),
					'name'        => 'enable_loop',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Mouse Drag', 'opalmedical' ),
					'name'        => 'enable_mousedrag',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Touch Drag', 'opalmedical' ),
					'name'        => 'enable_touchdrag',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Slide By', 'opalmedical'),
					'name'        => 'slide_by',
					'description' => __( 'Number Items will slide on a time. Default: 1', 'opalmedical' ),
					'value'	     => __( '1', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Margin Each Items', 'opalmedical'),
					'name'        => 'margin_item',
					'description' => __( 'Default 0', 'opalmedical' ),
					'value'	     => __( '0', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Default)', 'opalmedical'),
					'name'        => 'default_items',
					'description' => __( 'Show number items when screen size between 1199px and 980px', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Phones)', 'opalmedical'),
					'name'        => 'mobile_items',
					'description' => __( 'Show number items when screen size bellow 480px', 'opalmedical' ),
					'value'	     => __( '1', 'opalmedical' ),
					'admin_label' => true
				),array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Phones to Small tablets)', 'opalmedical'),
					'name'        => 'tablet_small_items',
					'description' => __( 'Show number items when screen size between 641px and 480px', 'opalmedical' ),
					'value'	     => __( '2', 'opalmedical' ),
					'admin_label' => true
				),array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Phones to tablets)', 'opalmedical'),
					'name'        => 'tablet_items',
					'description' => __( 'Show number items when screen size between 768px and 641px', 'opalmedical' ),
					'value'	     => __( '2', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Portrait tablets)', 'opalmedical'),
					'name'        => 'portrait_items',
					'description' => __( 'Show number items when screen size between 979px and 769px', 'opalmedical' ),
					'value'	     => __( '3', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Large display)', 'opalmedical'),
					'name'        => 'large_items',
					'description' => __( 'Show number items when screen size 1200px and up', 'opalmedical' ),
					'value'	     => __( '5', 'opalmedical' ),
					'admin_label' => true
				),array(
					'type'        => 'text',
					'label'       => esc_html__('Custom Number Items with screen size', 'opalmedical'),
					'name'        => 'custom_items',
					'description' => __( 'For example: [320, 1], [360, 1], [480, 1], [568, 2], [600, 2], [640, 2], [768, 2], [900, 3], [960, 3], [1024, 3] empty to disable', 'opalmedical' ),
					'admin_label' => true
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Auto Play', 'opalmedical' ),
					'name'        => 'autoplay',
					'description' => __( 'Show the Pagination of the page.', 'opalmedical' ),
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Speed', 'opalmedical'),
					'name'        => 'speed',
					'description' => __( 'Determines the duration of the transition in milliseconds.If less than 10, the number is interpreted as a speed (pixels/millisecond).This is probably desirable when scrolling items with variable sizes', 'opalmedical' ),
					'admin_label' => true,
					'value'	     => __( '3000', 'opalmedical' ),
				),


		   )
		);

		//=======================================================================



		//=======================================================================

		$maps['element_medical_list_departments'] =  array(
		    'name' => esc_html__('Medical List Departments', 'opalmedical'),
		    'icon' => 'kc-icon-post',
		    'description' => 'Show Listing Departments Info',
		    'category' => esc_html__('Elements', 'opalmedical'),
		    'params' => array(
				array(
					'type'        => 'dropdown',
					'label'       => __( 'Column', 'opalmedical' ),
					'name'        => 'column',
					'description' => __( 'Number column of the page', 'opalmedical' ),
					'admin_label' => true,
					'options'     => array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6)
				),

				array(
					'type'        => 'text',
					'label'       => esc_html__('Limit', 'opalmedical'),
					'name'        => 'limit',
					'description' => __( 'Number Limit of the page.', 'opalmedical' ),
					'value'	      => __( '4', 'opalmedical' ),
					'admin_label' => true
				),

				array(
					'type'        => 'text',
					'label'       => esc_html__('Description Max Chars', 'opalmedical'),
					'name'        => 'max_char',
					'description' => __( 'the set number max character for description department', 'opalmedical' ),
					'value'	     => __( '15', 'opalmedical' ),
					'admin_label' => true
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Description', 'opalmedical' ),
					'name'        => 'show_description',
					'description' => __( 'Show the Description of the page.', 'opalmedical' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opalmedical'),
					)
				),
		   )
		);
 

		//=======================================================================

		$maps['element_medical_appointment'] =  array(
		    'name' => esc_html__('Medical Appointment', 'opalmedical'),
		    'icon' => 'kc-icon-post',
		    'description' => 'Show Appointment Table Info',
		    'category' => esc_html__('Elements', 'opalmedical'),
		    'params' => array(
		    	array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'opalmedical'),
					'name'        => 'title',
					'description' => __( 'The title of the appointment.', 'opalmedical' ),
					'value'	      => __( 'Appointment a Table', 'opalmedical' ),
					'admin_label' => true
				),

				array(
					'type'			=> 'textarea',
					'label'			=> __( 'Description', 'opalmedical' ),
					'name'			=> 'description',
					'description'	=> __( 'The text description for your page.', 'opalmedical' ),
					'value'		    => esc_html__('The Description'),
				),
		   )
		);


		//=======================================================================
		$maps['element_medical_list_service'] =  array(
		    'name' => esc_html__('Medical List Service', 'opalmedical'),
		    'icon' => 'kc-icon-post',
		    'description' => 'Show Listing Service Info',
		    'category' => esc_html__('Elements', 'opalmedical'),
		    'params' => array(
		    	array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'opalmedical'),
					'name'        => 'title',
					'description' => __( 'The title of the Service List.', 'opalmedical' ),
					'value'	     => __( 'List Service', 'opalmedical' ),
					'admin_label' => true
				),

				array(
					'type'			=> 'textarea',
					'label'			=> __( 'Description', 'opalmedical' ),
					'name'			=> 'description',
					'description'	=> __( 'The text description for your page.', 'opalmedical' ),
					'value'		   => esc_html__('The Description'),
				),

				array(
					'type'        => 'multiple',
					'label'       => __( 'By Categories', 'opalmedical' ),
					'name'        => 'category',
					'description' => __( 'Layout of the page', 'opalmedical' ),
					'admin_label' => true,
					'options'     => CategoryService_OptionArray(),
				),

				array(
					'type'        => 'dropdown',
					'label'       => __( 'Column', 'opalmedical' ),
					'name'        => 'column',
					'description' => __( 'Number column of the page', 'opalmedical' ),
					'admin_label' => true,
					'options'     => array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6)
				),

				array(
					'type'        => 'dropdown',
					'label'       => __( 'Layouts', 'opalmedical' ),
					'name'        => 'layout',
					'description' => __( 'Layout of the page', 'opalmedical' ),
					'admin_label' => true,
					'options'     => array(
						'tabs'       	 => 'Tabs Home',
						'grid'          => 'Grid',
					)
				),

				array(
					'type'        => 'text',
					'label'       => esc_html__('Limit', 'opalmedical'),
					'name'        => 'limit',
					'description' => __( 'Number Limit of the page.', 'opalmedical' ),
					'value'	     => __( '4', 'opalmedical' ),
					'admin_label' => true
				),

				

				array(
					'type'        => 'dropdown',
					'label'       => __( 'Image Size', 'opalmedical' ),
					'name'        => 'image_size',
					'description' => __( 'Thumbnail (default 150px x 150px max)<br>Medium resolution (default 300px x 300px max)<br>Large resolution (default 640px x 640px max)<br>Full resolution (original size uploaded)<br>Other resolutions', 'opalmedical' ),
					'admin_label' => true,
					'options'     => array(
						'thumbnail'      	=> 'Thumbnail',
						'medium'          => 'Medium',
						'large'          	=> 'Large',
						'full'          	=> 'Full',
						'other'          	=> 'Other size',
					)
				),

				array(
					'type'        => 'text',
					'label'       => esc_html__('Other Image Size', 'opalmedical'),
					'name'        => 'other_size',
					'description' => __( 'the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opalmedical' ),
					'value'	     => __( '150x150', 'opalmedical' ),
					'admin_label' => true,
					'relation'	=> array(
						'parent'	=> 'image_size',
						'show_when'	=> 'other'
					),
				),
				
				array(
					'type'        => 'text',
					'label'       => esc_html__('Description Max Chars', 'opalmedical'),
					'name'        => 'max_char',
					'description' => __( 'the set number max character for description service', 'opalmedical' ),
					'value'	     => __( '10', 'opalmedical' ),
					'admin_label' => true
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Category', 'opalmedical' ),
					'name'        => 'show_category',
					'description' => __( 'Show the Category of the page.', 'opalmedical' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opalmedical'),
					)
				), 

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Button Learn More', 'opalmedical' ),
					'name'        => 'show_learnmore',
					'description' => __( 'Show button Learn More of the page.', 'opalmedical' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opalmedical'),
					)
				), 

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Description', 'opalmedical' ),
					'name'        => 'show_description',
					'description' => __( 'Show the Description of the page.', 'opalmedical' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opalmedical'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Thumbnail', 'opalmedical' ),
					'name'        => 'show_thumbnail',
					'description' => __( 'Show the Thumbnail of the page.', 'opalmedical' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opalmedical'),
					)
				),
				

		   )
		);

		//=======================================================================

		$maps['element_medical_carousel_service'] =  array(
		    'name' => esc_html__('Medical Carousel Service', 'opalmedical'),
		    'icon' => 'kc-icon-pcarousel',
		    'description' => 'Show list carousel service Info',
		    'category' => esc_html__('Elements', 'opalmedical'),
		    'params' => array(
		    	array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'opalmedical'),
					'name'        => 'title',
					'description' => __( 'The title of the Service List.', 'opalmedical' ),
					'value'	     => __( 'List Service', 'opalmedical' ),
					'admin_label' => true
				),

				array(
					'type'			=> 'textarea',
					'label'			=> __( 'Description', 'opalmedical' ),
					'name'			=> 'description',
					'description'	=> __( 'The text description for your page.', 'opalmedical' ),
					'value'		   => esc_html__('The Description'),
				),

				array(
					'type'        => 'multiple',
					'label'       => __( 'By Categories', 'opalmedical' ),
					'name'        => 'category',
					'description' => __( 'Layout of the page', 'opalmedical' ),
					'admin_label' => true,
					'options'     => CategoryService_OptionArray(),
				),

				array(
					'type' 		  => 'number_slider',  // USAGE RADIO TYPE
					'label'       => __( 'Column', 'opalmedical' ),
					'name'        => 'column',
					'description' => __( 'Number column of the page', 'opalmedical' ),
					'admin_label' => true,
				   'options' => array(    // REQUIRED
				        'min' => 1,
				        'max' => 6,
				        'unit' => '',
				        'show_input' => false
				    ),
					//'options'     => array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6)
				),

				array(
					'type'        => 'number_slider',
					'label'       => esc_html__('Limit', 'opalmedical'),
					'name'        => 'limit',
					'description' => __( 'Number Limit of the page.', 'opalmedical' ),
					'value'	     => __( '4', 'opalmedical' ),
					'admin_label' => true,
					'options' => array(    // REQUIRED
				        'min' => 1,
				        'max' => 20,
				        'unit' => '',
				        'show_input' => false
				    ),
				),

				array(
					'type'        => 'dropdown',
					'label'       => __( 'Image Size', 'opalmedical' ),
					'name'        => 'image_size',
					'description' => __( 'Thumbnail (default 150px x 150px max)<br>Medium resolution (default 300px x 300px max)<br>Large resolution (default 640px x 640px max)<br>Full resolution (original size uploaded)<br>Other resolutions', 'opalmedical' ),
					'admin_label' => true,
					'options'     => array(
						'thumbnail'      	=> 'Thumbnail',
						'medium'          => 'Medium',
						'large'          	=> 'Large',
						'full'          	=> 'Full',
						'other'          	=> 'Other size',
					)
				),

				array(
					'type'        => 'text',
					'label'       => esc_html__('Other Image Size', 'opalmedical'),
					'name'        => 'other_size',
					'description' => __( 'the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opalmedical' ),
					'value'	     => __( '150x150', 'opalmedical' ),
					'admin_label' => true,
					'relation'	=> array(
						'parent'	=> 'image_size',
						'show_when'	=> 'other'
					),
				),

				array(
					'type'        => 'text',
					'label'       => esc_html__('Description Max Chars', 'opalmedical'),
					'name'        => 'max_char',
					'description' => __( 'the set number max character for description service', 'opalmedical' ),
					'value'	     => __( '10', 'opalmedical' ),
					'admin_label' => true
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Category', 'opalmedical' ),
					'name'        => 'show_category',
					'description' => __( 'Show the Category of the page.', 'opalmedical' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opalmedical'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Button Learn More', 'opalmedical' ),
					'name'        => 'show_learnmore',
					'description' => __( 'Show button Learn More of the page.', 'opalmedical' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opalmedical'),
					)
				), 
					
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Description', 'opalmedical' ),
					'name'        => 'show_description',
					'description' => __( 'Show the Description of the page.', 'opalmedical' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opalmedical'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Thumbnail', 'opalmedical' ),
					'name'        => 'show_thumbnail',
					'description' => __( 'Show the Thumbnail of the page.', 'opalmedical' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opalmedical'),
					)
				),
				// Owl Carousel Setting

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Right To Left', 'opalmedical' ),
					'name'        => 'enable_rtl',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Button Navigation', 'opalmedical' ),
					'name'        => 'enable_navigation',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Button Pagination', 'opalmedical' ),
					'name'        => 'enable_pagination',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Loop Carousel', 'opalmedical' ),
					'name'        => 'enable_loop',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Mouse Drag', 'opalmedical' ),
					'name'        => 'enable_mousedrag',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Touch Drag', 'opalmedical' ),
					'name'        => 'enable_touchdrag',
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Slide By', 'opalmedical'),
					'name'        => 'slide_by',
					'description' => __( 'Number Items will slide on a time. Default: 1', 'opalmedical' ),
					'value'	     => __( '1', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Margin Each Items', 'opalmedical'),
					'name'        => 'margin_item',
					'description' => __( 'Default 0', 'opalmedical' ),
					'value'	     => __( '0', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Default)', 'opalmedical'),
					'name'        => 'default_items',
					'description' => __( 'Show number items when screen size between 1199px and 980px', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Phones)', 'opalmedical'),
					'name'        => 'mobile_items',
					'description' => __( 'Show number items when screen size bellow 480px', 'opalmedical' ),
					'value'	     => __( '1', 'opalmedical' ),
					'admin_label' => true
				),array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Phones to Small tablets)', 'opalmedical'),
					'name'        => 'tablet_small_items',
					'description' => __( 'Show number items when screen size between 641px and 480px', 'opalmedical' ),
					'value'	     => __( '2', 'opalmedical' ),
					'admin_label' => true
				),array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Phones to tablets)', 'opalmedical'),
					'name'        => 'tablet_items',
					'description' => __( 'Show number items when screen size between 768px and 641px', 'opalmedical' ),
					'value'	     => __( '2', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Portrait tablets)', 'opalmedical'),
					'name'        => 'portrait_items',
					'description' => __( 'Show number items when screen size between 979px and 769px', 'opalmedical' ),
					'value'	     => __( '3', 'opalmedical' ),
					'admin_label' => true
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Number Columns On Page (Large display)', 'opalmedical'),
					'name'        => 'large_items',
					'description' => __( 'Show number items when screen size 1200px and up', 'opalmedical' ),
					'value'	     => __( '5', 'opalmedical' ),
					'admin_label' => true
				),array(
					'type'        => 'text',
					'label'       => esc_html__('Custom Number Items with screen size', 'opalmedical'),
					'name'        => 'custom_items',
					'description' => __( 'For example: [320, 1], [360, 1], [480, 1], [568, 2], [600, 2], [640, 2], [768, 2], [900, 3], [960, 3], [1024, 3] empty to disable', 'opalmedical' ),
					'admin_label' => true
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Auto Play', 'opalmedical' ),
					'name'        => 'autoplay',
					'description' => __( 'Show the Pagination of the page.', 'opalmedical' ),
					'options'     => array(
						'1' => __('Yes, Please!', 'opalmedical'),
					)
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Speed', 'opalmedical'),
					'name'        => 'speed',
					'description' => __( 'Determines the duration of the transition in milliseconds.If less than 10, the number is interpreted as a speed (pixels/millisecond).This is probably desirable when scrolling items with variable sizes', 'opalmedical' ),
					'admin_label' => true,
					'value'	     => __( '3000', 'opalmedical' ),
				),

		   )
		);

		//=======================================================================


		$maps = apply_filters( 'opalmedical_element_kingcomposer_map', $maps ); 
	    $kc->add_map( $maps );
	}
	/**
	* Get Array taxonomy Department
	*/
	function CategoriesDoctor_OptionArray()
	{
		$optionArray = array();
		$categories = Opalmedical_Query::get_categories();
		foreach ($categories as $category) {
			$optionArray[$category->slug] = $category->name;
		}
		return $optionArray;
	}

	/**
	* Get Array taxonomy category service
	*/
	function CategoryService_OptionArray()
	{
		$optionArray = array();
		$services = Opalmedical_Query::getCategoryServices();
		foreach ($services as $service) {
			$optionArray[$service->slug] = $service->name;
		}
		return $optionArray;
	}



?>
