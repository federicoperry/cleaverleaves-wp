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
class Opalmedical_Register_PostType_Status{

	/**
	 * init action and filter data to define ticket post type
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'register_post_type_statuses') );
	}

	public static function register_post_type_statuses() {
		$statuses = opalmedical_register_status();
		if ( !empty($statuses) && is_array($statuses) ) {
			foreach ($statuses as $key => $status) {
				register_post_status( $key, $status );
			}
		}
	}

}

Opalmedical_Register_PostType_Status::init();