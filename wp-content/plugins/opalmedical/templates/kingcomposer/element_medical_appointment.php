<?php 
$atts  = array_merge( array(
		'title'            		=> '',
		'description'      		=> '',
	), $atts); 
extract( $atts );
// show by shortcode [opalmedical_appointment]
echo do_shortcode( '[opalmedical_appointment  title="'.$title.'"  description="'.$description.'"]' );

