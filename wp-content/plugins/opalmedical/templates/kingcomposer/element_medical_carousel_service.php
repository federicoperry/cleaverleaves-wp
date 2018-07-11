<?php 
$atts  = array_merge( array(
	'title'            	=> '',
	'description'      	=> '',
	'category'			   => '',
	'column'           	=> '',
	'limit'            	=> '',
	'image_size'		 	=> '',
	'other_size'			=> '',
	'max_char'      		=> '',
	'show_description' 	=> 1,
	'show_category'    	=> 1,
	'show_thumbnail'   	=> 1,
	'show_learnmore'   	=> 1,
	'enable_rtl'   	 	=> 1,
	'enable_navigation'  => 1,
	'enable_pagination'  => 1,
	'enable_loop'   		=> 1,
	'enable_mousedrag'   => 1,
	'enable_touchdrag'   => 1,
	'slide_by'           => '',
	'margin_item'        => '',
	'default_items'      => '',
	'mobile_items'       => '',
	'tablet_small_items' => '',
	'tablet_items'       => '',
	'portrait_items'     => '',
	'large_items'        => '',
	'custom_items'       => '',
	'autoplay'   			=> 1,
	'speed'            	=> '',
	), $atts); 
extract( $atts );
if( $limit < $column){
	$limit = $column;
}
// show by shortcode [opalmedical_carousel_service]
echo do_shortcode( '[opalmedical_carousel_service
category="'.$category.'" 
limit="'.$limit.'" 
column="'.$column.'" 
title="'.$title.'" 
image_size="'.$image_size.'"  
other_size="'.$other_size.'"  
max_char="'.$max_char.'"  
description="'.$description.'"  
show_description="'.$show_description.'" 
show_category="'.$show_category.'" 
show_thumbnail="'.$show_thumbnail.'" 
show_learnmore="'.$show_learnmore.'" 
enable_rtl="'.$enable_rtl.'" 
enable_navigation="'.$enable_navigation.'" 
enable_pagination="'.$enable_pagination.'" 
enable_loop="'.$enable_loop.'" 
enable_mousedrag="'.$enable_mousedrag.'" 
enable_touchdrag="'.$enable_touchdrag.'" 
slide_by="'.$slide_by.'" 
margin_item="'.$margin_item.'" 
default_items="'.$default_items.'" 
mobile_items="'.$mobile_items.'" 
tablet_small_items="'.$tablet_small_items.'" 
tablet_items="'.$tablet_items.'" 
portrait_items="'.$portrait_items.'" 
large_items="'.$large_items.'" 
custom_items="'.$custom_items.'" 
autoplay="'.$autoplay.'" 
speed="'.$speed.'" 
]' );
