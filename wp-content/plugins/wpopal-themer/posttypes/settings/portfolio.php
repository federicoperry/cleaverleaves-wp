<?php 
function wpopal_themer_enable_portfolio_setting_fields( ) { 
    add_settings_field(
            'enable_portfolio', // ID
            'Enable Portfolio', // Title ,
             'wpopal_themer_enable_portfolio_callback', // Callback
            'wpopalframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'wpopal_themer_add_setting_field', 'wpopal_themer_enable_portfolio_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function wpopal_themer_enable_portfolio_callback()
{
	$options = get_option( 'wpopal_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_portfolio" name="wpopal_themer_posttype[enable_portfolio]"  %s />',
        isset( $options['enable_portfolio'] ) && $options['enable_portfolio'] ?  'checked="checked"'  : ''
    );
}

