<?php 
$atts  = array_merge( array(
), $atts); 
extract( $atts );
if( $limit < $column){
	$limit = $column;
}
// show by shortcode [opalmedical_list_services]
echo do_shortcode( '[opalmedical_list_services category="'.$category.'" layout="'.$layout.'" limit="'.$limit.'" column="'.$column.'" title="'.$title.'" description="'.$description.'" max_char="'.$max_char.'" show_category="'.$show_category.'" show_learnmore="'.$show_learnmore.'" show_description="'.$show_description.'" show_thumbnail="'.$show_thumbnail.'" image_size="'.$image_size.'" other_size="'.$other_size.'"]' );

