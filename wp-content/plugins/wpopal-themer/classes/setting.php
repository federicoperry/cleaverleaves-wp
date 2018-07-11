<?php   
class Wpopal_ThemerSetting
{
    private $tmp_posttype;
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    { 
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Wpopal Themer', 
            'manage_options', 
            'wpopalframework-setting-admin', 
            array( $this, 'create_admin_page' )
        );

        
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    { 
        // Set class property
        $this->options = get_option( 'wpopal_themer_posttype' );
        ?>
        <div class="wrap">
        
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'wpopal_postype_group' );   
                do_settings_sections( 'wpopalframework-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {        

        $this->options = get_option( 'wpopal_themer_posttype' );  
        register_setting(
            'wpopal_postype_group', // Option group
            'wpopal_themer_posttype', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            __('Post Types Settings', 'wpopal-themer'), // Title
            array( $this, 'print_section_info' ), // Callback
            'wpopalframework-setting-admin' // Page
        );  
             
        $filepath = WPOPAL_THEMER_PLUGIN_THEMER_DIR.'posttypes/settings/*.php';

        $files  = glob( $filepath );
        $output = array(); 

        foreach( $files as $file ){

            $output[str_replace(".php","",basename($file))] = $file;
        }

        $output = apply_filters( 'wpopal_themer_load_posttype_files', $output );

        foreach( $output as $posttype => $file ){
            include( $file ); 
        }
      
   
        do_action( 'wpopal_themer_add_setting_field' ); 
    }   

   

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        
        foreach( $input as $key => $value ){
            $new_input[$key] = sanitize_text_field( $value );
        }
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

}

if( is_admin() )
    $my_settings_page = new Wpopal_ThemerSetting();