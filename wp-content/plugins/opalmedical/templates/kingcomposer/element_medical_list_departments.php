<?php 
$atts  = array_merge( array(
		'title'            => '',
		'description'      => '',
		'column'           => '',
		'limit'            => '',
		'max_char'      	 => '',
		'show_description' => 1,
	), $atts); 
extract( $atts );
if( $limit < $column){
	$limit = $column;
}
// show by shortcode [opalmedical_list_categories]
echo do_shortcode( '[opalmedical_list_departments limit="'.$limit.'" column="'.$column.'"  max_char="'.$max_char.'" show_description="'.$show_description.'"]' );

