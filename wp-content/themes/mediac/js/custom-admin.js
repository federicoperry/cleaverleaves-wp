(function () {
	jQuery(document).ready(function($) {

		$('body').delegate(".input_datetime", 'hover', function(e){
	            e.preventDefault();
	            $(this).datepicker({
		               defaultDate: "",
		               dateFormat: "yy-mm-dd",
		               numberOfMonths: 1,
		               showButtonPanel: true,
	            });
         });

		var hides = ['mediac_audio_link','mediac_link_link','mediac_link_text','mediac_video_link','mediac_gallery_files'];
		var shows = {
			audio:['mediac_audio_link'],
			video:['mediac_video_link','mediac_video_text'],
			link:['mediac_link_link'],
			gallery:['mediac_gallery_files']
		}
		$( '.post-type-post #post-formats-select input' ).click( function(){
			 $(hides).each( function( i, item ){
			 	$("[name="+item+']').parent().parent().hide();
			 } );
			 var s = $(this).val();
			 if( shows[s] != null ){
			 	$(shows[s]).each( function( i, is ){
			 		$("[name="+is+']').parent().parent().show();
				 } );
			 }
		} );
	});
} )( jQuery );