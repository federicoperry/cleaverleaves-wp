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
class Opalmedical_Shortcodes{
	
	/**
	 *
	 */
	static $shortcodes; 

	/**
	 *
	 */
	public static function init(){
	 	
	 	self::$shortcodes = array(
	 		//'list_doctors' => array( 'code' => 'list_doctors', 'label' => __('List Doctors') ),
	 		'list_departments' => array( 'code' => 'list_departments', 'label' => __('List Dipartments') ),
	 		'carousel_doctor' => array( 'code' => 'carousel_doctor', 'label' => __('Carousel Doctor') ),
	 		'carousel_service' => array( 'code' => 'carousel_service', 'label' => __('Carousel Service') ),
	 		'appointment' => array( 'code' => 'appointment', 'label' => __('Appointment Table') ),
	 		//'appointment_page' => array( 'code' => 'appointment_page', 'label' => __('Appointment Page') ),
	 		'list_services' => array( 'code' => 'list_services', 'label' => __('List Service') ),
	 		//'home_page' => array( 'code' => 'home_page', 'label' => __('Medical HomePage') ),
	 	);

	 	foreach( self::$shortcodes as $shortcode ){
	 		add_shortcode( 'opalmedical_'.$shortcode['code'] , array( __CLASS__, $shortcode['code'] ) );
	 	}

	}

	/**
	* the Carousel Doctor
	*/
	public static function carousel_doctor($args, $content){
		return Opalmedical_Template_Loader::get_template_part( 'shortcodes/carousel-doctor',$args);
	}
   
   /**
	* the listing doctor
	*/
	public static function list_doctors($args, $content){
		return Opalmedical_Template_Loader::get_template_part( 'shortcodes/list-doctors',$args);
	}

   /**
	* the listing dipartments
	*/
	public static function list_departments($args, $content){
		return Opalmedical_Template_Loader::get_template_part( 'shortcodes/list-departments',$args);
	}

   /**
	* the listing doctor by dipartments
	*/
	public static function carousel_dipartments_doctor($args, $content){
		return Opalmedical_Template_Loader::get_template_part( 'shortcodes/carousel-dipartments-doctor',$args);
	}

   /**
	* the appointment table
	*/
	public static function appointment($args, $content){
		$default = array(
			'title' 		=> '',
			'description'	=> ''
		);
		$args = array_merge( $default , $args );

		return Opalmedical_Template_Loader::get_template_part( 'shortcodes/appointment',$args);
	}

   /**
	* the appointment table
	*/
	public static function appointment_page($args, $content){
		return Opalmedical_Template_Loader::get_template_part( 'shortcodes/appointment-page',$args);
	}

   

	/**
	* the listing service
	*/
	public static function list_services($args, $content){
		return Opalmedical_Template_Loader::get_template_part( 'shortcodes/list-services',$args);
	}

	/**
	* the carousel service
	*/
	public static function carousel_service($args, $content){
		return Opalmedical_Template_Loader::get_template_part( 'shortcodes/carousel-service',$args);
	}
 

}

Opalmedical_Shortcodes::init();

		


