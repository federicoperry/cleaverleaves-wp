<?php 
add_action('opal_account_dropdown_content', 'opalmedical_management_user_menu');
add_action( 'customize_register',  'medical_register_stories_customizer', 9 );
function medical_register_stories_customizer( $wp_customize ){
$wp_customize->add_panel( 'panel_opalmedical', array(
    'priority' => 70,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => esc_html__( 'Opal Medical', 'mediac' ),
    'description' =>esc_html__( 'Make default setting for page, general', 'mediac' ),
) );


//============================================================================
        // Sidebar for Single Lesson 
//============================================================================

/**
 * Archive Page Setting
 */
$wp_customize->add_section( 'service_single_settings', array(
    'priority' => 2,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => esc_html__( 'Single Service Page Setting', 'mediac' ),
    'description' => 'Configure categories, search, shop page setting',
    'panel' => 'panel_opalmedical',
) );



//sidebar single left
$wp_customize->add_setting( 'wpopal_theme_options[service-page-left-sidebar]', array(
    'capability' => 'edit_theme_options',
    'type'       => 'option',
    'default'   => '',
    'checked' => 1,
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize,  'wpopal_theme_options[service-page-left-sidebar]', array(
    'settings'  => 'wpopal_theme_options[service-page-left-sidebar]',
    'label'     => esc_html__('Left Sidebar', 'mediac'),
    'section'   => 'service_single_settings' ,
     'priority' => 3
) ) );

  //sidebar single right
$wp_customize->add_setting( 'wpopal_theme_options[service-page-right-sidebar]', array(
    'capability' => 'edit_theme_options',
    'type'       => 'option',
    'default'   => '',
    'checked' => 1,
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize,  'wpopal_theme_options[service-page-right-sidebar]', array(
    'settings'  => 'wpopal_theme_options[service-page-right-sidebar]',
    'label'     => esc_html__('Right Sidebar', 'mediac'),
    'section'   => 'service_single_settings',
     'priority' => 4 
) ) );

}

/**
* Get Configuration for Page Layout
*
*/
function medical_fnc_get_page_service_sidebar_configs( $configs='' ){

global $post; 

$left  =  mediac_fnc_theme_options( 'service-page-left-sidebar' ); 
$right =  mediac_fnc_theme_options( 'service-page-right-sidebar' ); 


return mediac_fnc_get_layout_configs( $left, $right);
}
add_filter( 'medical_fnc_get_single_service_sidebar_configs', 'medical_fnc_get_page_service_sidebar_configs', 1, 1 );



