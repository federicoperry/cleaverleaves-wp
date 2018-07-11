<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalestate
 * @author     Opal  Team <info@wpopal.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Opalmedicial_Field_Timetable {

	/**
	 * Current version number
	 */
	const VERSION = '1.0.0';

	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	public static function init() {
		add_filter( 'cmb2_render_timetable', array( __CLASS__, 'render_timetable' ), 10, 5 );

		add_filter( 'cmb2_sanitize_timetable', array( __CLASS__, 'sanitize_timetable' ), 10, 4 );
	}

	/**
	 * Render field
	 */
	public static function render_timetable( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
		$week = array(
			'monday'    => __( 'Monday', 'opalmedical' ),
			'tuesday'   => __( 'Tuesday', 'opalmedical' ),
			'wednesday' => __( 'Wednesday', 'opalmedical' ),
			'thursday'  => __( 'Thursday', 'opalmedical' ),
			'friday' 	=> __( 'Friday', 'opalmedical' ),
			'saturday'  => __( 'Saturday', 'opalmedical' ),
			'sunday'    => __( 'Sunday', 'opalmedical' )
		); 
		 
			$name = $field->args( '_name' );

			$value = $field->value;

	 	
			$data = get_post_meta( $field_object_id,  $field->args( '_name' )  . '_data' , true );
			


	?>
		<table class="wp-list-table widefat fixed striped pages">
			<thead>
				<tr>
					<td><?php echo __("Day", 'opalmedical'); ?></td>
					<td><?php echo __("Open", 'opalmedical'); ?></td>
					<td><?php echo __("Close",'opalmedical'); ?></td>
				</tr>
				<?php foreach( $week as $day => $day_label ):
					$openslt = isset($data['open'][$day]) ? ($data['open'][$day]):'close';
					$closeslt = isset($data['close'][$day]) ? ($data['close'][$day]):'close';

				 ?>
				<tr>
					<td><?php echo $day_label; ?></td>
					<td>
						<select name="<?php echo $name?>[open][<?php echo $day; ?>]">
							<option value="close" <?php if(  $openslt == 'close' ) :?>selected="selected"<?php endif; ?>><?php echo __('Close','opalmedical'); ?></option>
							<?php 
							for( $i=0; $i<=24; $i++ ): 
								$key = $i>9 ? $i.'.00': '0'.$i.'.00';
							?>
							<option value="<?php echo $key; ?>" <?php if(  $openslt == $key ) :?>selected="selected"<?php endif; ?>><?php echo $key; ?></option>
							<?php endfor; ?>
						</select>
					</td>
					<td>
						<select name="<?php echo $name?>[close][<?php echo $day; ?>]">
							<option value="close" <?php if(  $closeslt == 'close' ) :?>selected="selected"<?php endif; ?>><?php echo __('Close','opalmedical'); ?></option>
							<?php 
							for( $i=0; $i <= 24; $i++ ): 
								$key = $i>9 ? $i.'.00': '0'.$i.'.00';
							?>
							<option value="<?php echo $key; ?>" <?php if( $closeslt == $key ) :?> selected="selected"<?php endif; ?>><?php echo $key; ?></option>
							<?php endfor; ?>
						</select>
					</td>
				</tr>	
				<?php endforeach; ?>
			</thead>		
		</table>
	<?php 	
	}

	/**
	 * Optionally save the latitude/longitude values into two custom fields
	 */
	public static function sanitize_timetable( $override_value, $value, $object_id, $field_args ) {
 		
 		if( $value ){
 			update_post_meta( $object_id, $field_args['id'] . '_data', $value );
 		}
 		$value = 0;

		return $value;
	}	 
}

Opalmedicial_Field_Timetable::init();
