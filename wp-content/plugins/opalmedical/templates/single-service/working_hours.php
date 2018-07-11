<?php
	global $service, $post;
	$times = $service->getMetaboxValue("timetable_data");
?>
<?php if( $times && isset($times['open']) ): ?>
<div class="widget widget-style widget-timetable-working">
	<h3 class="widget-title"><span><?php _e("working Hours", "opalmedical"); ?></span></h3>
	<div class="element-timetable-working">
		<div class="timetable-working">
		<?php 
			foreach( $times['open'] as $time => $hour ):  
				$openhour  = $hour == 'close' ? __('Closed','opalmedical') : $hour;
				$closehour =  $times['close'][$time]  == 'close' ? __('Closed','opalmedical') : $times['close'][$time];	
		?>
			<div class="timetable-item">
			 	<div class="date-work"><?php echo $time; ?></div>
			 	<?php if(  $times['close'][$time] == 'close' && $times['open'][$time] == 'close' ): ?>
			 	<div class="time-work"><?php _e( 'Closed', 'opalmedical' ); ?></div>
			 	<?php else: ?>
			 	<div class="time-work"><?php echo $openhour; ?> - <?php echo $closehour; ?></div>
			 	<?php endif;?>
			</div>
			<?php endforeach; ?>
		</div>	
	</div>
</div>	
<?php endif; ?>