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
class Opalmedical_Appointment_Email {

	public static $headers;

	public  function __construct(){
		$from_name 		=  opalmedical_get_option('from_name');
		$from_email 	= opalmedical_get_option('from_email');
		self::$headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $from_name, $from_email );
	}
	/**
	 *
	 */
	public static function init() {

	}
	/**
	 *
	 */
	public static function sendNewAppointmentEmail( $args ){
		//global $opal_mail_errors;
		try{
			$from_name 		=  opalmedical_get_option('from_name');
			$from_email 	= opalmedical_get_option('from_email');
			$headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $from_name, $from_email );
			extract( $args );

			$datas = self::newrequest( $args );
			extract( $datas );
			if(opalmedical_get_option('admin_email_enable') == 'yes' ){
				wp_mail( @$from_email, @$admin_subject, @$admin_message, $headers );
			}
			$opal_mail_errors = wp_mail( @$email, @$subject, @$message, $headers );
			set_transient( get_current_user_id().'opal_mail_errors', $opal_mail_errors );
			return $opal_mail_errors;
		} catch ( phpmailerException $e ) {
		  	$opal_mail_errors = new WP_Error( $e->getCode(), $e->getMessage() );
		  	set_transient( get_current_user_id().'opal_mail_errors', $opal_mail_errors );
  			return apply_filters( 'wp_mail_send_failed', false, $opal_mail_errors );
		}
	}

	/**
	 *
	 */
	public static function sendChangeStatusEmail( $status, $args ){
		try{
			$subject = '';
			$body 	= '';
			switch ( $status ) {
				
				case 'opal-pending':
					break;
				case 'opal-confirmed':
					$subject = html_entity_decode( opalmedical_get_option('confirmed_email_subject') );
					$body = html_entity_decode( opalmedical_get_option('confirmed_email_body') );
					break;
				case 'opal-closed':
					$subject = html_entity_decode( opalmedical_get_option('rejected_email_subject') );
					$body = html_entity_decode( opalmedical_get_option('rejected_email_subject') );
					break;
			}
			extract( $args );
			$appointment_field_args = array(
					'name' 			=> get_post_meta( $appointment_id, OPALMEDICAL_APPOINTMENTS_PREFIX .'name', true ),
					'mail' 			=> get_post_meta( $appointment_id, OPALMEDICAL_APPOINTMENTS_PREFIX .'mail', true ),
					'date' 			=> get_post_meta( $appointment_id, OPALMEDICAL_APPOINTMENTS_PREFIX .'date', true ),
					'phone' 			=> get_post_meta( $appointment_id, OPALMEDICAL_APPOINTMENTS_PREFIX .'phone', true ),
					'message'		=> get_post_meta( $appointment_id, OPALMEDICAL_APPOINTMENTS_PREFIX .'message', true ),
				);
			$from_name 		=  opalmedical_get_option('from_name');
			$from_email 	= opalmedical_get_option('from_email');
			$headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $from_name, $from_email );
			$message = self::processShortTags($appointment_field_args,$body);
			$email = get_post_meta( $appointment_id, OPALMEDICAL_APPOINTMENTS_PREFIX .'mail', true );
	
			$opal_mail_errors =  wp_mail( @$email, @$subject, @$message, $headers );
			set_transient( get_current_user_id().'opal_mail_errors', $opal_mail_errors );
			return $opal_mail_errors;
		} catch ( phpmailerException $e ) {
		  	$opal_mail_errors = new WP_Error( $e->getCode(), $e->getMessage() );
		  	set_transient( get_current_user_id().'opal_mail_errors', $opal_mail_errors );
  			return apply_filters( 'wp_mail_send_failed', false, $opal_mail_errors );
		}
	}

	/**
	 * get data of newrequest email
	 *
	 * @var $args  array: appointment_id , $body 
	 * @return text: message
	 */
	public static function processShortTags ( $appointment_field, $body ) {
		$appointment_fields = $appointment_field ? $appointment_field : array(
					'name' 			=> "",
					'mail' 			=> "",
					'date' 			=> "",
					'phone' 			=> "",
					'status' 		=> "",
					'message'		=> "",
				);
		extract($appointment_fields);

		$tags 	= array("{user_mail}","{user_name}","{message}","{date}","{phone}","{site_name}","{site_link}","{current_time}");
		$values 	= array( $mail, $name ,$message,$date,$phone,get_bloginfo( 'name' ) ,get_home_url(), date("F j, Y, g:i a"));
		$message = str_replace($tags, $values, $body);
		return $message;
	}

	/**
	 * get data of newrequest email
	 *
	 * @var $args  array: user_id, appointment_id
	 * @return array: email, subject, message, admin_subject, admin_message
	 */
	public static function newrequest( $args ) {
		global $appointment_field_args;
		if ($appointment_field_args) {
			
			$appointment_field =  $appointment_field_args ? $appointment_field_args : array();
			extract( $args );
			extract( $appointment_field );
			// subject
			$subject = html_entity_decode( opalmedical_get_option('newrequest_email_subject') );
			$admin_subject = html_entity_decode( opalmedical_get_option('admin_email_subject') );
			// body
			$body = html_entity_decode( opalmedical_get_option('newrequest_email_body') );
			$admin_body = html_entity_decode( opalmedical_get_option('admin_email_body') );
			$message = self::processShortTags($appointment_field,$body);

			$admin_message = self::processShortTags($appointment_field,$admin_body);
			return apply_filters( 'opalmedical_send_email_newrequest', array( 'email' => $mail, 'subject' => $subject, 'message' => $message, 'admin_subject'=>$admin_subject,'admin_message'=>$admin_message), $args );
		}// check save post
		return array();
	}
	
	
}

Opalmedical_Appointment_Email::init();
