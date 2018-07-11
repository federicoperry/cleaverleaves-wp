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

class Opalmedical_Doctor {
	/**
	 *
	 */
	protected $post_id; 

	protected $metabox_category;

	protected $featured;

	/**
	 * Constructor 
	 */
	public function __construct( $post_id ){
		
		$this->post_id 	= $post_id; 
		//$this->featured  	= $this->getMetaboxValue( 'featured' );   
	}


	public function isFeatured(){
		return $this->featured;
	}
	/**
	 * Gets status
	 *
	 * @access public
	 * @return array
	 */
	public function get_categories_tax(){
		$terms = wp_get_post_terms( $this->post_id, 'opal_doctor_cat' );
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
		return get_post_meta( $this->post_id, OPALMEDICAL_DOCTOR_PREFIX.$key, $single ); 
	}	

}