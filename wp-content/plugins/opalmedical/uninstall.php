<?php
/**
 * Uninstall Opal Medical
 *
 * @package     Opal Medical
 * @subpackage  Uninstall
 * @copyright   Copyright (c) 2016, Wopal
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

function opalmedical_uninstall() {

	$delete_data = opalmedical_get_option( 'delete_data' );

	/* Make sure that the user wants to remove all the data. */
	if ( 'yes' === $delete_data ) {
		delete_option( 'opalmedical_setup' );

		$opalmedical_list_departments = opalmedical_get_option( 'opalmedical_list_departments' );
		/* Delete the plugin pages.	 */
		wp_delete_post( intval( $opalmedical_list_departments ), true );

		/* Remove all plugin options. */
		delete_option( 'opalmedical_settings' );


		/* Delete all tag terms. */
		$terms = get_terms( 'opalmedical_category_service', array( 'fields' => 'ids', 'hide_empty' => false ) );
  	foreach ( $terms as $value ) {
       	wp_delete_term( $value, 'opalmedical_category_service' );
  	}
  	$terms = get_terms( 'opal_department', array( 'fields' => 'ids', 'hide_empty' => false ) );
  	foreach ( $terms as $value ) {
       	wp_delete_term( $value, 'opal_department' );
  	}
	}
}