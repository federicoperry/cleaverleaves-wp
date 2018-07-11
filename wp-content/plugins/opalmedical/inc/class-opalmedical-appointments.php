<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalmedical
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Opalmedical_Appointments {
	/**
	 *
	 */
	protected $post_id; 

	protected $appointment_name;

	protected $appointment_mail; 

	protected $appointment_date; 

	protected $appointment_time;

	protected $appointment_phone; 

	protected $appointment_people;

	public $status;


	/**
	 * Constructor 
	 */
	public function __construct(){
		
	}	
	
	public static function process_acction_form()
	{
		if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "appointment_post") {
			global $appointment_field_args;

			if (self::validate_form_appointment()) {

				$appointment_field_args = array(
					'name' 			=> $_POST['appointment_name'],
					'mail' 			=> $_POST['appointment_mail'],
					'date' 			=> $_POST['appointment_date'],
					'time' 			=> $_POST['appointment_time'],
					'phone' 			=> $_POST['appointment_phone'],
					'message' 		=> $_POST['appointment_message'],
				);
				if(isset($_POST['appointment_topic'])){
					$appointment_field_args = array_merge(array('topic'=> $_POST['appointment_topic']),$appointment_field_args);
				}

				// Add the content of the form to $post as an array
				$appointment_post_args = array(
					'post_title' 		=> 'customer appointments',
			      'post_status'   	=> 'opal-pending',           // Choose: publish, preview, future, draft, etc.
			      'post_type' 		=> 'opal_appointments',  //'post',page' or use a custom post type if you want to
				);
				

				//save the new post
				$post_id = wp_insert_post($appointment_post_args,true);

				  $appointment = array(
				      'ID'           => $post_id,
				      'post_title'   => __('#No.','opalmedical').$post_id,
				  );

				// Update the post into the database
				  wp_update_post( $appointment );

				//save the postmeta
				self::save_postmeta($post_id, $appointment_field_args );

				//do_action( "opalmedical_after_save_appointment" );

				return true;
			}else{
				return false;
			}
			
		}//end if
	}
	/**
	* Function Save Post Meta 
	* @use > process_acction_form()
	*/
	public static function save_postmeta($post_id, array $args)
	{
		foreach ($args as $key => $value) {
			add_post_meta( $post_id, OPALMEDICAL_APPOINTMENTS_PREFIX.$key , $value, true );
		}
		wp_reset_postdata();		
	}
	/**
	* Function Valide Form 
	* @use > process_acction_form()
	*/
	public static function validate_form_appointment(){
		// Do some minor form validation to make sure there is content
		if (!isset ($_POST['appointment_name'])|| !isset ($_POST['appointment_mail']) || !isset ($_POST['appointment_date']) || !isset ($_POST['appointment_time']) || !isset ($_POST['appointment_phone']) ) {
			return false;
		}
		//-----
		return true;
	}

}