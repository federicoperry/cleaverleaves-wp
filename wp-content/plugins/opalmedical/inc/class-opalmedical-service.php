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

class Opalmedical_Service {
	/**
	 *
	 */
	protected $post_id; 

	/**
	 * Constructor 
	 */
	public function __construct( $post_id ){
		
		$this->post_id 	= $post_id;   
	}

	/**
	 * Gets status
	 *
	 * @access public
	 * @return array
	 */
	public function getCategoryTax(){
		$terms = wp_get_post_terms( $this->post_id, 'opalmedical_category_service' );
		return $terms; 
	}

	/**
	 * Gets meta box value
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function getMetaboxValue( $key, $single = true ) {
		return get_post_meta( $this->post_id, OPALMEDICAL_SERVICE_PREFIX.$key, $single ); 
	}	

}