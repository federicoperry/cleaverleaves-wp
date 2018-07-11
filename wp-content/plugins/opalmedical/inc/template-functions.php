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

/**
 *
 */
function opalmedical_template_init(){
	if( isset($_GET['display']) && ($_GET['display']=='list' || $_GET['display']=='grid') ){  
		setcookie( 'opalmedical_displaymode', trim($_GET['display']) , time()+3600*24*100,'/' );
		$_COOKIE['opalmedical_displaymode'] = trim($_GET['display']);
	}
}

add_action( 'init', 'opalmedical_template_init' );

function opalmedical_get_current_url(){

	global $wp;
	$current_url = home_url(add_query_arg(array(),$wp->request));
 	
 	return $current_url;
}

/**
* |----------------------------------------
* | Single Service
* |----------------------------------------
*/ 

/**
 * single content
 */
function opalmedical_service_content(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-service/content' );
}
/**
 * single price list
 */
function opalmedical_service_price_list(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-service/price_list' );
}
/**
 * single working hours
 */
function opalmedical_service_working_hours(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-service/working_hours' );
}
/**
 * single contact
 */
function opalmedical_service_contact(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-service/contacts' );
}

//--
add_action( 'opalmedical_single_service_left', 'opalmedical_service_content', 10 );
//--
//add_action( 'opalmedical_single_service_right', 'opalmedical_service_price_list', 10 );
//add_action( 'opalmedical_single_service_right', 'opalmedical_service_working_hours', 15 );
//add_action( 'opalmedical_single_service_right', 'opalmedical_service_contact', 20 );
//--
//add_action( 'opalmedical_after_single_service_summary', 'opalmedical_service_tags', 35 );



/**
* |----------------------------------------
* | Single Doctor
* |----------------------------------------
*/ 

/**
 * Single doctor image 
 */
function opalmedical_doctor_image(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-doctor/image' );
}

/**
 *
 */
function opalmedical_doctor_content(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-doctor/content' );
}

/**
 *
 */
function opalmedical_doctor_contact(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-doctor/contacts' );
}

/**
 *
 */
function opalmedical_doctor_information(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-doctor/information' );
}


//--
add_action( 'opalmedical_single_doctor_image', 'opalmedical_doctor_image', 10 );
//--
add_action( 'opalmedical_single_doctor_content', 'opalmedical_doctor_content', 10 );
//--
add_action( 'opalmedical_single_doctor_contact', 'opalmedical_doctor_contact', 10 );
//--
add_action( 'opalmedical_single_doctor_summary', 'opalmedical_doctor_information', 10 );
//--
//add_action( 'opalmedical_after_single_doctor_summary', 'opalmedical_doctor_menus', 15 );


/**
* |----------------------------------------
* | Single Doctor
* |----------------------------------------
*/ 

/**
 * Single Our doctor
 */
function opalmedical_department_our_doctor(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-department/our_doctor' );
}

/**
 * Single doctor image 
 */
function opalmedical_department_service(){
	echo Opalmedical_Template_Loader::get_template_part( 'single-department/services' );
}


add_action( 'opalmedical_single_department_summary', 'opalmedical_department_service', 10 );
//--
add_action( 'opalmedical_single_department_summary', 'opalmedical_department_our_doctor', 15 );



