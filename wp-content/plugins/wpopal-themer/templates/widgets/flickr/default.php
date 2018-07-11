<?php 
// Display the widget title
if ( $title ) {
    echo ($before_title)  . $title . $after_title;
}
?>
<div class="flickr-gallery widget-content">
	<script type="text/javascript">
	function jsonFlickrApi(rsp) {
		if (rsp.stat != "ok"){
			// If this executes, something broke!
			return;
		}

		//variable "s" is going to contain
		//all the markup that is generated by the loop below
		var s = "";

		//this loop runs through every item and creates HTML
		for (var i=0; i < rsp.photos.photo.length; i++) {
			photo = rsp.photos.photo[ i ];
			//notice that "t.jpg" is where you change the
			//size of the image
			t_url = "http://farm2.static.flickr.com/" + photo.server + "/" +
			photo.id + "_" + photo.secret + "_" + "s.jpg";

			p_url = "http://www.flickr.com/photos/" +
			photo.owner + "/" + photo.id;

			s +=  '<div class="flickr_badge_image"><a href="' + p_url + '">' + '<img alt="'+
			photo.title + '"src="' + t_url + '"/>' + '</a></div>';
		}

		document.write(s);
	}
	</script>
	<script type="text/javascript" src="https://api.flickr.com/services/rest/?format=json&amp;method=flickr.photos.search&amp;user_id=<?php echo esc_js( $screen_name ); ?>&amp;api_key=<?php echo esc_js( $api ); ?>&amp;media=photos&amp;per_page=<?php echo esc_js( $number ); ?>&amp;privacy_filter=1"></script>
</div>