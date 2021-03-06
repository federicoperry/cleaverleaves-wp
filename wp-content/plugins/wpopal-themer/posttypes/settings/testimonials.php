<?php 
function wpopal_themer_enable_testimonials_setting_fields( ) { 
    add_settings_field(
            'enable_testimonials', // ID
            'Enable Testimonials', // Title ,
             'wpopal_themer_enable_testimonials_callback', // Callback
            'wpopalframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'wpopal_themer_add_setting_field', 'wpopal_themer_enable_testimonials_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function wpopal_themer_enable_testimonials_callback()
{
	$options = get_option( 'wpopal_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_testimonials" name="wpopal_themer_posttype[enable_testimonials]"  %s />',
        isset( $options['enable_testimonials'] ) && $options['enable_testimonials'] ?  'checked="checked"'  : ''
    );
}

