<?php
/**
* @package opalmedical
* @category Plugins
* @author WPOPAL
* |--------------------------------------------------------------------------
* | Plugin Opal Medical 
* |--------------------------------------------------------------------------
* Plugin Name: Opal Medical
* Plugin URI: http://www.wpopal.com/opalmedical/
* Description: Create and maintain modern online menus for almost any kind of medical.
* Version: 1.0.0
* Author: WPOPAL
* Author URI: http://www.wpopal.com
* License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}


if (!class_exists("OpalMedical")):
/**
 * Main OpalMedical Class
 * @since 1.0
 */
final class OpalMedical 
{
	/**
	 * @var Opalmedical The one true Opalmedical
	 * @since 1.0
	 */
	private static $instance;

	 /**
     * Plugin path
     *
     * @var string
     */
	 protected $_plugin_path = null;

	/**
	 * contructor
	 */
	public function __construct() {

	}

	/**
	* Main Opalmedical Instance
	*
	* Insures that only one instance of Opalmedical exists in memory at any one
	* time. Also prevents needing to define globals all over the place.
	*
	* @since     1.0
	* @static
	* @staticvar array $instance
	* @uses      Opalmedical::setup_constants() Setup the constants needed
	* @uses      Opalmedical::includes() Include the required files
	* @uses      Opalmedical::load_textdomain() load the language files
	* @see       Opalmedical()
	* @return    Opalmedical
	*/
	public static function getInstance() {
		
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof OpalMedical ) ) {
			self::$instance = new OpalMedical;
			self::$instance->setup_constants();

			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain'));
			self::$instance->includes();
			//self::$instance->roles  = new Opalmedical_Roles();
		}
		//add_action('opalmedical_before_appointment_form',array( self::$instance, 'add_field_topics'));
		return self::$instance;
	}

	/**
	* Function Defien
	*/
	public function setup_constants()
	{
		define("OPALMEDICAL_VERSION", "1.0.0");
		define("OPALMEDICAL_MINIMUM_WP_VERSION", "4.0");
		define("OPALMEDICAL_PLUGIN_URL", plugin_dir_url( __FILE__ ));
		define("OPALMEDICAL_PLUGIN_DIR", plugin_dir_path( __FILE__ ));
		define('OPALMEDICAL_MEDIA_URL', plugins_url(plugin_basename(__DIR__) . '/assets/'));
		define('OPALMEDICAL_LANGUAGE_DIR', plugin_dir_path( __FILE__ ) . '/languages/');
		define('OPALMEDICAL_THEMER_TEMPLATES_DIR', get_template_directory().'/' );
		define('OPALMEDICAL_THEMER_TEMPLATES_URL', get_bloginfo('template_url').'/' );
		define('OPALMEDICAL_APPOINTMENTS_PREFIX', 'opal_appointments_' );

	}

	/**
	* Throw error on object clone
	*
	* The whole idea of the singleton design pattern is that there is a single
	* object, therefore we don't want the object to be cloned.
	*
	* @since  1.0
	* @access protected
	* @return void
	*/
	public function __clone() {
			// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'opalmedical' ), '1.0' );
	}

	/**
     * Include a file
     *
     * @param string
     * @param bool
     * @param array
     */
	function _include( $file, $root = true, $args = array(), $unique = true ){
		if( $root ){
			$file = $this->plugin_path( $file );
		}
		if( is_array( $args ) ){
			extract( $args );
		}

		if( file_exists( $file ) )
		{
			if ( $unique ) {
				require_once $file;
			}
			else {
				require $file;
			}
		}
	}
    /**
    * Get the path of the plugin with sub path
    *
    * @param string $sub
    * @return string
    */
    function plugin_path( $sub = '' ){
    	if( ! $this->_plugin_path ) {
    		$this->_plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
    	}
    	return $this->_plugin_path . '/' . $sub;
    }
    public function setup_cmb2_url() {
    	return OPALMEDICAL_PLUGIN_URL . 'inc/vendors/cmb2/libraries';
    }

    public function includes(){
    	global $opalmedical_options;
		/**
		 * Get the CMB2 bootstrap!
		 *
		 * @description: Checks to see if CMB2 plugin is installed first the uses included CMB2; we can still use it even it it's not active. This prevents fatal error conflicts with other themes and users of the CMB2 WP.org plugin
		 *
		 */
		if ( file_exists( WP_PLUGIN_DIR . '/cmb2/init.php' ) ) {
			require_once WP_PLUGIN_DIR . '/cmb2/init.php';
		} elseif ( file_exists( OPALMEDICAL_PLUGIN_DIR . 'inc/vendors/cmb2/libraries/init.php' ) ) {
			require_once OPALMEDICAL_PLUGIN_DIR . 'inc/vendors/cmb2/libraries/init.php';
			//Customize CMB2 URL
			add_filter( 'cmb2_meta_box_url', array($this, 'setup_cmb2_url') );
		}
		// /end include CMB2

		//-- include admin setting
		$this->_include('inc/admin/register-settings.php');
		$opalmedical_options = opalmedical_get_settings();
		//-- include teamplate loader
		$this->_include('inc/class-template-loader.php');
		//--
		$this->_include("inc/mixes-functions.php");
		//--
		$this->_include("inc/ajax-functions.php");
		//--
		$this->_include("inc/class-opalmedical-roles.php");
		//--
		$this->_include('inc/class-opalmedical-query.php');

		//-- include all file *.php in directories , call function in inc/mixes-functions.php
		opalmedical_includes( OPALMEDICAL_PLUGIN_DIR . 'inc/post-types/*.php' );
		opalmedical_includes( OPALMEDICAL_PLUGIN_DIR . 'inc/taxonomies/*.php' );
		//--
		$this->_include("inc/class-opalmedical-appointment-email.php");
		//--
		$this->_include("inc/class-opalmedical-appointments.php"); //***
		//--
		$this->_include("inc/template-functions.php");
		//-- 
		$this->_include("inc/class-opalmedical-doctor.php"); //***
		//--
		$this->_include("inc/class-opalmedical-service.php"); //***
		//--
		$this->_include('inc/class-opalmedical-scripts.php');
		//--
		$this->_include("inc/class-opalmedical-shortcodes.php");
		
		if( class_exists("KingComposer") ){
			//--
			$this->_include("inc/vendors/kingcomposer.php"); //**
			//--
		}

		$this->_include('install.php');
		//--
		if ( get_option( 'opalmedical_setup', false ) != 'installed' ) {
			register_activation_hook( __FILE__, 'opalmedical_install' );
			update_option( 'opalmedical_setup', 'installed' );
		}
		$this->_include('uninstall.php');
		// uninstall
		register_uninstall_hook( __FILE__, 'opalmedical_uninstall' );
		//--
		// // add widgets
		// add_action( 'widgets_init', array($this, 'widgets_init') );
		//add_action( 'init', array($this, 'widgets_area') );
	}

	/**
	* this is function Load all Widgets
	*/
	public function widgets_init() {
		opalmedical_includes( OPALMEDICAL_PLUGIN_DIR . 'inc/widgets/*.php' );
	}
	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	*/
	public function load_textdomain() {
			// Set filter for Opalmedical's languages directory
		$lang_dir = dirname( plugin_basename( OPALMEDICAL_PLUGIN_DIR ) ) . '/languages/';
		$lang_dir = apply_filters( 'opalmedical_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), 'opalmedical' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'opalmedical', $locale );

			// Setup paths to current locale file
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/opalmedical/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/opalmedical folder
			load_textdomain( 'opalmedical', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/opalmedical/languages/ folder
			load_textdomain( 'opalmedical', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'opalmedical', false, $lang_dir );
		}
	}

}// end Class Root
endif; // End if class_exists check





/**
 * The main function responsible for returning the one true Opalmedical
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $dpemployee = Opalmedical(); ?>
 *
 * @since 1.0
 * @return object - The one true Opalmedical Instance
 */
function Opalmedical() {
	return OpalMedical::getInstance();
}

// Get Opalmedical Running
Opalmedical();

