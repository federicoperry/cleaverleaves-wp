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

if (!function_exists('opalmedical_process_appointment')) {
	function opalmedical_process_appointment() {
		$status = Opalmedical_Appointments::process_acction_form();
		if($out = get_transient( get_current_user_id().'opal_mail_errors' ) ) {
        delete_transient( get_current_user_id().'opal_mail_errors' );
    	}
		if(!$out){
			$return = array( 'status' => 'danger', 'msg' => __( 'Send Mail is Failed! Please check email address in setting backend is wrong!' , 'opalmedical' ) );
		}
		if ( $status ) {
			$thank_message = opalmedical_get_option('mail_message_success') ? opalmedical_get_option('mail_message_success') : "Thanks, your appointment request is waiting to be confirmed. Updates will be sent to the email address you provided.";
			$return = array( 'status' => 'success', 'msg' => __( $thank_message, 'opalmedical' ) );
		} else {
			$return = array( 'status' => 'danger', 'msg' => __( 'Please enter content for some the field bellow!', 'opalmedical' ) );
		}

		echo json_encode($return); die();
	}
}
// add acction ajax
add_action( 'wp_ajax_appointment_post', 'opalmedical_process_appointment' );
add_action( 'wp_ajax_nopriv_appointment_post', 'opalmedical_process_appointment' );

//===========================
/**
* Function Show Form Appointment Ajax
* @var field
*/
if (!function_exists('opalmedical_show_form_appointment')) {
	function opalmedical_show_form_appointment() {
		echo Opalmedical_Template_Loader::get_template_part( 'content-appointment-form-v2',array('title_form'=>""));
		die();
	}
}
// add acction ajax
add_action( 'wp_ajax_appointment_form', 'opalmedical_show_form_appointment' );
add_action( 'wp_ajax_nopriv_appointment_form', 'opalmedical_show_form_appointment' );