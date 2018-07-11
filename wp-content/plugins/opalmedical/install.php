<?php 
/**
 * Install Opal Medical
 *
 * @package     Opal Medical
 * @subpackage  Uninstall
 * @copyright   Copyright (c) 2016, Wopal
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

function opalmedical_install(){


	global $opalmedical_options;
 

	// Clear the permalinks
	flush_rewrite_rules( false );

	// Add Upgraded From Option
	$current_version = get_option( 'opalmedical_version' );
	if ( $current_version ) {
		update_option( 'opalmedical_version_upgraded_from', $current_version );
	}

	// Setup some default options
	$options = array();
	
	$opalmedical_list_departments = opalmedical_get_option( 'opalmedical_list_departments' );
	if ( empty( $opalmedical_list_departments ) ||  $opalmedical_list_departments <= 0 ) {
	// Create a page to list all feature
		$department_page = wp_insert_post(
			array(
				'post_content'   => '[opalmedical_list_departments]',
				'post_title'     => wp_strip_all_tags( __( 'Departments', 'opalmedical' ) ),
				'post_name'      => sanitize_title( __( 'Departments', 'opalmedical' ) ),
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'ping_status'    => 'closed',
				'comment_status' => 'closed',
			)
		);
		$options['opalmedical_list_departments'] = $department_page;
	}
	// -- end create home page 
	//Fresh Install? Setup Test Mode, Base Country (US), Test Gateway, Currency
	if ( empty( $current_version ) ) {
	
		$options['test_mode']          = 1;
		$options['currency']           = 'USD';
		$options['currency_position']  = 'before';
		
	}

	// Populate some default values
	update_option( 'opalmedical_settings', array_merge( $opalmedical_options, $options ) );
	update_option( 'opalmedical_version', OPALMEDICAL_VERSION );

	 
	// Create Give roles
	$roles = new Opalmedical_Roles();
	$roles->add_roles();
	$roles->add_caps();
 
	// Add a temporary option to note that Give pages have been created
	set_transient( '_opalmedical_installed', $options, 30 );

 
	// Bail if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}
	// Add the transient to redirect
	set_transient( '_opalmedical_activation_redirect', true, 30 );

}
	

/**
 * Install user roles on sub-sites of a network
 *
 * Roles do not get created when Give is network activation so we need to create them during admin_init
 *
 * @since 1.0
 * @return void
 */
function opalmedical_install_roles_on_network() {

	global $wp_roles;

	if ( ! is_object( $wp_roles ) ) {
		return;
	}
 
	if ( ! array_key_exists( 'opalmedical_manager', $wp_roles->roles ) ) {
		$roles = new Opalmedical_Roles;
		$roles->add_roles();
		$roles->add_caps();

	}else {  
		remove_role( 'opalmedical_manager' );
	   remove_role( 'opalmedical_manager' );
		$roles = new Opalmedical_Roles;
		$roles->remove_caps();
	}
}

add_action( 'admin_init', 'opalmedical_install_roles_on_network' );	
?>