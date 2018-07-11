<?php 
$atts  = array_merge( array(
		'title'            => '',
		'description'      => '',
		'category'      	 => '',
		'column'           => '',
		'limit'            => '',
		'layout'           => '',
		'image_size'		 => '',
		'other_size'		 => '',
		'max_char'      	 => '',
		'show_description' => 1,
		'show_category'    => 1,
		'show_social'    	 => 1,
		'show_job'    	 	 => 1,
		'show_thumbnail'   => 1,
	), $atts); 
extract( $atts );
if( $limit < $column){
	$limit = $column;
}
// show by shortcode [opalmedical_list_doctors]
echo do_shortcode( '[opalmedical_list_doctors category="'.$category.'" layout="'.$layout.'" limit="'.$limit.'" column="'.$column.'" title="'.$title.'" description="'.$description.'" max_char="'.$max_char.'" show_category="'.$show_category.'" show_description="'.$show_description.'" show_thumbnail="'.$show_thumbnail.'" show_social="'.$show_social.'" show_job="'.$show_job.'" image_size="'.$image_size.'" other_size="'.$other_size.'" ]' );

