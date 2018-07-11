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
class Opalmedical_Scripts{

	/**
	 * Init
	 */
	public static function init(){
		add_action( 'wp_head', array( __CLASS__, 'initAjaxUrl' ), 15 );
		
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'loadFrontendStyles' ), 999 );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'loadScripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'loadAdminStyles') );
	}

	/**
	 * load script file in backend
	 */
	public static function loadScripts(){

		wp_enqueue_script("magnific-popup-js", OPALMEDICAL_PLUGIN_URL . 'assets/js/libs/jquery.magnific-popup.min.js', null, "1.0.1", true);
		wp_register_script( 'validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'validation' );
		wp_enqueue_script("opalmedical-scripts", OPALMEDICAL_PLUGIN_URL . 'assets/js/scripts.js', array( 'jquery' ), "1.0.0", true);
		wp_enqueue_script("fitvids", OPALMEDICAL_PLUGIN_URL . 'assets/js/jquery.fitvids.js', array( 'jquery' ), "1.0.0", true);

	}

	/**
     * load javascript and css file in admin system.
     */
    public static function loadAdminStyles() {
    	global $pagenow;
      wp_enqueue_style( 'opalmedical-admin-css', OPALMEDICAL_PLUGIN_URL . 'assets/css/admin-styles.css', array(), '1.0.0' );

		wp_enqueue_script("opalmedical-js", OPALMEDICAL_PLUGIN_URL . 'assets/js/opalmedical.js', array( 'jquery' ), "1.0.0", true);
		wp_enqueue_media();
    }

    /**
     * load javascript and css file in frontend system.
     */
    public static function loadFrontendStyles() {
    	wp_enqueue_style( 'magnific-popup-cs', OPALMEDICAL_PLUGIN_URL . 'assets/css/lib/magnific-popup.css', array(), '1.0.0' );
		wp_register_script( 'validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'validation' );

	   wp_enqueue_style( 'opalmedical-frontend-css', OPALMEDICAL_PLUGIN_URL . 'assets/css/opalmedical.css', null, '3.0.3');
      wp_enqueue_style( 'datetimepicker-css', OPALMEDICAL_PLUGIN_URL . 'assets/css/lib/jquery.datetimepicker.css', null, '3.0.3');
      wp_enqueue_script("datetimepicker-js", OPALMEDICAL_PLUGIN_URL . 'assets/js/libs/jquery.datetimepicker.full.min.js', array( 'jquery' ), "2.0.0", true);
      wp_enqueue_script("bookings-frontend-js", OPALMEDICAL_PLUGIN_URL . 'assets/js/bookings_frontend.js', array( 'jquery' ), "1.0.0", true);
    }

    /**
     * add ajax url
     */
	public static function initAjaxUrl() {
		?>
		<script type="text/javascript">
			var ajaxurl = '<?php echo esc_js( admin_url('admin-ajax.php') ); ?>';
			var opalsiteurl = '<?php echo get_template_directory_uri(); ?>';
		</script>
		<?php
	}
}

Opalmedical_Scripts::init();