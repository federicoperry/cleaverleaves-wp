<?php
	global $doctor;
	$doctor = new Opalmedical_Doctor( get_the_ID() );
?>
<div class="doctor-information">
 	<?php
	/* translators: %s: Name of current post */
	the_content( sprintf(
		__( 'Continue reading %s ', 'opalmedical' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	) );
	?>
</div> <!-- /.doctor-information -->
