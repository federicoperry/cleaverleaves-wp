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

class Opalmedical_Plugin_Settings {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'opalmedical_settings';

	/**
	 * Array of metaboxes/fields
	 * @var array
	 */
	protected $option_metabox = array();

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 1.0
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_menu' ) , 10 );

		add_action( 'admin_init', array( $this, 'init' ) );

		//Custom CMB2 Settings Fields
		add_action( 'cmb2_render_opalmedical_title', 'opalmedical_title_callback', 10, 5 );

		add_action( 'cmb2_render_api', 'opalmedical_api_callback', 10, 5 );
		add_action( 'cmb2_render_license_key', 'opalmedical_license_key_callback', 10, 5 );
		add_action( "cmb2_save_options-page_fields", array( $this, 'settings_notices' ), 10, 3 );

		// Include CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles-opalmedical_doctor_page_opalmedical-settings", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );

	}

	public function admin_menu() {
		//Settings
	 	add_submenu_page( 'edit.php?post_type=opalmedical_doctor', __( 'Settings', 'opalmedical' ), __( 'Settings', 'opalmedical' ), 'manage_options', 'opalmedical-settings', 
	 		array( $this, 'admin_page_display' ) );
	 	add_submenu_page( 'edit.php?post_type=opalmedical_service', __( 'Settings', 'opalmedical' ), __( 'Settings', 'opalmedical' ), 'manage_options', 'opalmedical-settings', 
	 		array( $this, 'admin_page_display' ) );
	}

	/**
	 * Register our setting to WP
	 * @since  1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );

	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since 1.0
	 * @return array $tabs
	 */
	public function opalmedical_get_settings_tabs() {

		$settings = $this->opalmedical_settings( null );

		$tabs             = array();
		$tabs['general']  = __( 'General', 'opalmedical' );
		$tabs['pageview']  	= __( 'Page View', 'opalmedical' );
		//$tabs['contact_email']   = __( 'Contact Emails', 'opalmedical' );
		$tabs['emails']   = __( 'Appointment Email', 'opalmedical' );
		$tabs['statuses'] = __( 'Appointment Status', 'opalmedical' );
		$tabs['topics'] = __( 'Appointment Topics', 'opalmedical' );

		//$tabs['sample_data']   = __( 'Sample Data', 'opalmedical' );
		if ( ! empty( $settings['addons']['fields'] ) ) {
			$tabs['addons'] = __( 'Add-ons', 'opalmedical' );
		}

		if ( ! empty( $settings['licenses']['fields'] ) ) {
			$tabs['licenses'] = __( 'Licenses', 'opalmedical' );
		}

		return apply_filters( 'opalmedical_settings_tabs', $tabs );
	}


	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  1.0
	 */
	public function admin_page_display() {

		$active_tab = isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $this->opalmedical_get_settings_tabs() ) ? $_GET['tab'] : 'general';

		?>

		<div class="wrap opalmedical_settings_page cmb2_options_page <?php echo $this->key; ?>">
			<h2 class="nav-tab-wrapper">
				<?php
				foreach ( $this->opalmedical_get_settings_tabs() as $tab_id => $tab_name ) {

					$tab_url = esc_url( add_query_arg( array(
						'settings-updated' => false,
						'tab'              => $tab_id
					) ) );

					$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

					echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
					echo esc_html( $tab_name );

					echo '</a>';
				}
				?>
			</h2>

			<?php cmb2_metabox_form( $this->opalmedical_settings( $active_tab ), $this->key ); ?>

		</div><!-- .wrap -->

		<?php
	}

	/**
	 * Define General Settings Metabox and field configurations.
	 *
	 * Filters are provided for each settings section to allow add-ons and other plugins to add their own settings
	 *
	 * @param $active_tab active tab settings; null returns full array
	 *
	 * @return array
	 */
	public function opalmedical_settings( $active_tab ) {
		$number = 0;
		$list_tags = '<td>
					<p class="tags-description">Use the following tags to automatically add appointment information to the emails. Tags labeled with an asterisk (*) can be used in the email subject as well.</p>
				<div class="rtb-template-tags-box">
					<strong>{user_email}</strong> Email of the user who made the appointment
				</div>
				<div class="rtb-template-tags-box">
					<strong>{user_name}</strong> * Name of the user who made the appointment
				</div>
				<div class="rtb-template-tags-box">
					<strong>{date}</strong> * Date and time of the appointment
				</div>
				<div class="rtb-template-tags-box">
					<strong>{phone}</strong> Phone number if supplied with the request
				</div>
				<div class="rtb-template-tags-box">
					<strong>{message}</strong> Message added to the request
				</div>
				<div class="rtb-template-tags-box">
					<strong>{site_name}</strong> The name of this website
				</div>
				<div class="rtb-template-tags-box">
					<strong>{site_link}</strong> A link to this website
				</div>
				<div class="rtb-template-tags-box">
					<strong>{current_time}</strong> Current date and time
				</div></td>';

		$opalmedical_settings = array(
			/**
			 * General Settings
			 */
			'general'     => array(
				'id'         => 'options_page',
				'title' => __( 'General Settings', 'opalmedical' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalmedical_settings_general', array(
						array(
							'name' => __( 'Slug Link Setting', 'opalmedical' ),
							'desc' => '<td><hr><p class="tags-description"><b>Note: When you edit Slug bellow you must apply them in left doctor > Setting > Permalinks > Save Changes</b></p><hr></td>',
							'type' => 'title',
							'id'   => 'opalmedical_title_general_settings_2'
						),
						
						array(
							'name'    => __( 'Slug Doctor', 'opalmedical' ),
							'desc'    => __( 'You can change slug name of doctor link . (e.g: http://localhost/wordpress/<span style="color:red;" >doctor</span>/spicy-potato-2/)<br> the <span style="color:red;" >doctor</span> is slug name', 'opalmedical' ),
							'id'      => 'slug_doctor',
							'type'    => 'text',
							'default' => 'doctor',
							
						),
						array(
							'name'    => __( 'Slug category doctor', 'opalmedical' ),
							'desc'    => __( 'You can change slug name of category doctor link . (e.g: http://localhost/wordpress/<span style="color:red;" >category-doctor</span>/desserts/)<br> the <span style="color:red;" >category-doctor</span> is slug name', 'opalmedical' ),
							'id'      => 'slug_category_doctor',
							'type'    => 'text',
							'default' => 'category_doctor',
							
						),

						array(
							'name'    => __( 'Slug service', 'opalmedical' ),
							'desc'    => __( 'You can change slug name of doctor link . (e.g: http://localhost/wordpress/<span style="color:red;" >service</span>/jane-done/)<br> the <span style="color:red;" >service</span> is slug name', 'opalmedical' ),
							'id'      => 'slug_service',
							'type'    => 'text',
							'default' => 'service',
							
						),
						array(
							'name'    => __( 'Slug category service', 'opalmedical' ),
							'desc'    => __( 'You can change slug name of category service link . (e.g: http://localhost/wordpress/<span style="color:red;" >category-service</span>/jane-done/)<br> the <span style="color:red;" >category-service</span> is slug name', 'opalmedical' ),
							'id'      => 'slug_category_service',
							'type'    => 'text',
							'default' => 'category_service',
							
						),

						array(
							'name' => __( 'Currency Settings', 'opalmedical' ),
							'desc' => '',
							'type' => 'opalmedical_title',
							'id'   => 'opalmedical_title_general_settings_3'
						),
						
						array(
							'name'    => __( 'Currency', 'opalmedical' ),
							'desc'    => 'Choose your currency. Note that some payment gateways have currency restrictions.',
							'id'      => 'currency',
							'type'    => 'select',
							'options' => opalmedical_get_currencies(),
							'default' => 'USD',
						),
						array(
							'name'    => __( 'Currency Position', 'opalmedical' ),
							'desc'    => 'Choose the position of the currency sign.',
							'id'      => 'currency_position',
							'type'    => 'select',
							'options' => array(
								'before' => __( 'Before - $10', 'opalmedical' ),
								'after'  => __( 'After - 10$', 'opalmedical' )
							),
							'default' => 'before',
						),
					)
				)
			),// end general


			/**
			 * Page View Settings
			 */
			'pageview'     => array(
				'id'         => 'options_page',
				'title' => __( 'Page View Settings', 'opalmedical' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalmedical_settings_pageview', array(
						array(
							'name' => __( 'Page Doctor Settings', 'opalmedical' ),
							'type' => 'title',
							'id'   => 'opalmedical_title_pageview_settings_1',
							'before_row' => 'cmb_before_row_cb',
							'after_row' => 'cmb_before_row_cb',
						),

						array(
							'name'    => __( 'Doctor page view', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display your doctor items within doctor Page.', 'opalmedical' ),
							'id'      => 'doctor_view',
							'type'    => 'select',
							'options' => array(
								'grid' => __( 'Grid', 'opalmedical' ),
								'list'  => __( 'List', 'opalmedical' )
							),
							'default' => 'gird',
						),
						array(
							'name'    => __( 'Column Doctor page', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display your doctor items within doctor page.', 'opalmedical' ),
							'id'      => 'column_doctor',
							'type'    => 'text',
							'default' => '4',	
						),
						array(
							'type'      => 'select',
							'name'      => __( 'Image Size', 'opalmedical' ),
							'id'        => 'doctor_image_size',
							'desc' 		=> __( 'Thumbnail (default 150px x 150px max)<br>Medium resolution (default 300px x 300px max)<br>Large resolution (default 640px x 640px max)<br>Full resolution (original size uploaded)<br>Other resolutions', 'opalmedical' ),
							'options'     => array(
								'thumbnail'      	=> 'Thumbnail',
								'medium'          => 'Medium',
								'large'          	=> 'Large',
								'full'          	=> 'Full',
								'other'          	=> 'Other size',
							),			
						),

						array(
							'type'      => 'text',
							'name'      => esc_html__('Other Image Size', 'opalmedical'),
							'id'        => 'doctor_other_size',
							'classes' 	=> 'doctor_other_size',
							'desc' 		=> __( 'the set Image size for all image doctor , example: 150x150. is width = 150px and height = 150px', 'opalmedical' ),
							'default'	     => __( '150x150', 'opalmedical' ),

						),
						array(
							'name'    => __( 'Show Thumnail', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display thumbnail on items page.', 'opalmedical' ),
							'id'      => 'doctor_show_thumbnail',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opalmedical' ),
						        1   => __( 'Yes', 'opalmedical' ),
						   ),
						   'default' => 1,
						),
						array(
							'name'    => __( 'Show Category', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display category on items page.', 'opalmedical' ),
							'id'      => 'doctor_show_category',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opalmedical' ),
						        1   => __( 'Yes', 'opalmedical' ),
						   ),
						   'default' => 1,
						),

						array(
							'name'    => __( 'Show Description', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display description on items page.', 'opalmedical' ),
							'id'      => 'doctor_show_description',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opalmedical' ),
						        1   => __( 'Yes', 'opalmedical' ),
						   ),
						   'default' => 1,
						),

						array(
							'name'    => __( 'Show Button Booking', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display View Detail button on items page.', 'opalmedical' ),
							'id'      => 'doctor_show_booking_btn',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opalmedical' ),
						        1   => __( 'Yes', 'opalmedical' ),
						   ),
						   'default' => 1,
						),

						array(
							'name'    => __( 'Description Max Chars', 'opalmedical' ),
							'desc'    => __( 'the set number max character for description doctor on items page.', 'opalmedical' ),
							'id'      => 'doctor_max_char',
							'type'    => 'text',
						   'default' => '10',
						),

					

						//------***********************************

						array(
							'name' => __( 'Page Service Settings', 'opalmedical' ),
							'type' => 'title',
							'id'   => 'opalmedical_title_pageview_settings_2',
							'before_row' => 'cmb_before_row_cb',
							'after_row' => 'cmb_before_row_cb',

						),

						array(
							'name'    => __( 'Service page view', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display your doctor items within doctor Page.', 'opalmedical' ),
							'id'      => 'service_view',
							'type'    => 'select',
							'options' => array(
								'grid' => __( 'Grid', 'opalmedical' ),
								'list'  => __( 'List', 'opalmedical' )
							),
							'default' => 'gird',
						),
						array(
							'name'    => __( 'Column Service page', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display your doctor items within service page.', 'opalmedical' ),
							'id'      => 'column_service',
							'type'    => 'text',
							'default' => '4',	
						),

												array(
							'type'      => 'select',
							'name'      => __( 'Image Size', 'opalmedical' ),
							'id'        => 'service_image_size',
							'desc' 		=> __( 'Thumbnail (default 150px x 150px max)<br>Medium resolution (default 300px x 300px max)<br>Large resolution (default 640px x 640px max)<br>Full resolution (original size uploaded)<br>Other resolutions', 'opalmedical' ),
							'options'     => array(
								'thumbnail'      	=> 'Thumbnail',
								'medium'          => 'Medium',
								'large'          	=> 'Large',
								'full'          	=> 'Full',
								'other'          	=> 'Other size',
							),			
						),

						array(
							'type'      => 'text',
							'name'      => esc_html__('Other Image Size', 'opalmedical'),
							'id'        => 'service_other_size',
							'classes' 	=> 'service_other_size',
							'desc' 		=> __( 'the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opalmedical' ),
							'default'	     => __( '150x150', 'opalmedical' ),

						),
						array(
							'name'    => __( 'Show Thumnail', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display thumbnail on items page.', 'opalmedical' ),
							'id'      => 'service_show_thumbnail',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opalmedical' ),
						        1   => __( 'Yes', 'opalmedical' ),
						   ),
						   'default' => 1,
						),
						array(
							'name'    => __( 'Show Category', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display category on items page.', 'opalmedical' ),
							'id'      => 'service_show_category',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opalmedical' ),
						        1   => __( 'Yes', 'opalmedical' ),
						   ),
						   'default' => 1,
						),

						array(
							'name'    => __( 'Show Description', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display description on items page.', 'opalmedical' ),
							'id'      => 'service_show_description',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opalmedical' ),
						        1   => __( 'Yes', 'opalmedical' ),
						   ),
						   'default' => 1,
						),

						array(
							'name'    => __( 'Show Learn More', 'opalmedical' ),
							'desc'    => __( 'Choose the way to display View Detail button on items page.', 'opalmedical' ),
							'id'      => 'service_show_learnmore',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opalmedical' ),
						        1   => __( 'Yes', 'opalmedical' ),
						   ),
						   'default' => 1,
						),

						array(
							'name'    => __( 'Description Max Chars', 'opalmedical' ),
							'desc'    => __( 'the set number max character for description service on items page.', 'opalmedical' ),
							'id'      => 'service_max_char',
							'type'    => 'text',
						   'default' => '10',
						),


					)
				)
			),// end page view

			//=============================================================

			/**
			 * Appointment Emails Options
			 */
			'emails'      => array(
				'id'         => 'options_page',
				'title' => __( 'Opalmedical Email Settings', 'opalmedical' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalmedical_settings_emails', array(
						array(
							'name' => __( 'Email Settings', 'opalmedical' ),
							'desc' => '<hr>',
							'id'   => 'opalmedical_title_email_settings_1',
							'type' => 'title'
						),
						array(
							'id'      => 'from_name',
							'name'    => __( 'From Name', 'opalmedical' ),
							'desc'    => __( 'The name donation receipts are said to come from. This should probably be your site or shop name.', 'opalmedical' ),
							'default' => get_bloginfo( 'name' ),
							'type'    => 'text'
						),
						array(
							'id'      => 'from_email',
							'name'    => __( 'From Email', 'opalmedical' ),
							'desc'    => __( 'Email to send donation receipts from. This will act as the "from" and "reply-to" address.', 'opalmedical' ),
							'default' => get_bloginfo( 'admin_email' ),
							'type'    => 'text'
						),
						array(
							'id'      => 'mail_message_success',
							'name'    => __( 'Success Message', 'opalmedical' ),
							'type'    => 'textarea_small',
							'desc'	=> __( 'Enter the message to display when a appointment request is made.', 'opalmedical' ),
							'default' => trim(preg_replace('/\t+/', '','
								Thanks, your appointment request is waiting to be confirmed. Updates will be sent to the email address you provided.'))
						),
						array(
							'name' => __( 'Email Templates (Template Tags)', 'opalmedical' ),
							'desc' => $list_tags.'<br><hr>',
							'id'   => 'opalmedical_title_email_settings_2',
							'type' => 'title'
						),
						array(
							'name' => __( 'Email Settings (Admin Notification Email)', 'opalmedical' ),
							'desc' => '<hr>',
							'id'   => 'opalmedical_title_email_settings_3',
							'type' => 'title'
						),
						array(
							'name'    => __( 'Active Email', 'opalmedical' ),
							'desc' => __( 'Do you want to activate this e-mail template?', 'opalmedical' ),
							'id'      => 'admin_email_enable',
							'type'    => 'select',
							'options' => array( 'yes' => __( 'Yes', 'opalmedical' ), 'no' => __( 'No', 'opalmedical' ) ),
							'default' => 'yes'
						),

						array(
							'id'      			=> 'admin_email_subject',
							'name'    			=> __( 'Email Subject', 'opalmedical' ),
							'type'    			=> 'text',
							'desc'				=> __( 'The email subject for admin notifications.', 'opalmedical' ),
							'attributes'  		=> array(
		        										'placeholder' 		=> 'New Appointment Request',
		        										'rows'       	 	=> 3,
		    										),
							'default' => 'New Appointment Request',

						),
						array(
							'id'      => 'admin_email_body',
							'name'    => __( 'Email Body', 'opalmedical' ),
							'type'    => 'wysiwyg',
							'desc'	=> __( 'Enter the email an admin should receive when an initial appointment request is made.', 'opalmedical' ),
							'default' => trim(preg_replace('/\t+/', '','
								A new appointment request has been made at {site_name}:<br>
								<br>
								{user_name}<br>
								{date}<br>
								Message:<br>
								{message}
								<br>
								{doctor_link}<br>
								<br>
								&nbsp;<br>
								<br>
								<em>This message was sent by {site_link} on {current_time}.</em>'))
						),
						//------------------------------------------
						array(
							'name' => __( 'Email Settings (New Request Email)', 'opalmedical' ),
							'desc' => '<hr>',
							'id'   => 'opalmedical_title_email_settings_4',
							'type' => 'title'
						),
						array(
							'id'      		=> 'newrequest_email_subject',
							'name'    		=> __( 'Email Subject', 'opalmedical' ),
							'type'    		=> 'text',
							'desc'			=> __( 'The email subject a user should receive when they make an initial appointment request.', 'opalmedical' ),
							'attributes'  	=> array(
		        									'placeholder' 		=> 'Your appointment at '.get_bloginfo( 'name' ).' is pending',
		        									'rows'       	 	=> 3,
		    									),
							'default' 		=> 'Your appointment at '.get_bloginfo( 'name' ).' is pending',
						),
						array(
							'id'      	=> 'newrequest_email_body',
							'name'    	=> __( 'Email Body', 'opalmedical' ),
							'type'    	=> 'wysiwyg',
							'desc'		=> __( 'Enter the email a user should receive when they make an initial appointment request.', 'opalmedical' ),
							'default' 	=> trim(preg_replace('/\t+/', '', "Thanks {user_name},<br>
							<br>
							Your appointment request is <strong>waiting to be confirmed</strong>.<br>
							<br>
							Give us a few moments to make sure that we've got space for you. You will receive another email from us soon. If this request was made outside of our normal working hours, we may not be able to confirm it until we're open again.<br>
							<br>
							<strong>Your request details:</strong><br>
							{user_name}<br>
							{date}<br>
							Your Message:<br>
							{message}
							<br>
							&nbsp;<br>
							<br>
							<em>This message was sent by {site_link} on {current_time}.</em>"))


						),
						//=======================================
						array(
							'name' => __( 'Email Settings (Confirmed Email)', 'opalmedical' ),
							'desc' => '<hr>',
							'id'   => 'opalmedical_title_email_settings_5',
							'type' => 'title'
						),
						
						array(
							'id'      => 'confirmed_email_subject',
							'name'    => __( 'Email Subject', 'opalmedical' ),
							'type'    => 'text',
							'desc'			=> __( 'The email subject a user should receive when their appointment has been confirmed.', 'opalmedical' ),
							'attributes'  	=> array(
		        									'placeholder' 		=> 'Your appointment at '.get_bloginfo( 'name' ).' is Confirmed',
		        									'rows'       	 	=> 3,
		    									),
							'default' 		=> 'Your appointment at '.get_bloginfo( 'name' ).' is Confirmed',
						),
						array(
							'id'      => 'confirmed_email_body',
							'name'    => __( 'Email Body', 'opalmedical' ),
							'type'    => 'wysiwyg',
							'desc'	=> __( 'Enter the email a user should receive when their appointment has been confirmed.', 'opalmedical' ),
							'default' => trim(preg_replace('/\t+/', '','Hi {user_name},<br>
							<br>
							Your appointment request has been <strong>confirmed</strong>. We look forward to seeing you soon.<br>
							<br>
							<strong>Your appointment:</strong><br>
							{user_name}<br>
							{date}<br>
							{message}
							<br>
							&nbsp;<br>
							<br>
							<em>This message was sent by {site_link} on {current_time}.</em>'))
						),
						//-----------------------------------------------
						array(
							'name' => __( 'Email Settings (Rejected Email)', 'opalmedical' ),
							'desc' => '<hr>',
							'id'   => 'opalmedical_title_email_settings_6',
							'type' => 'title'
						),
						
						array(
							'id'      		=> 'rejected_email_subject',
							'name'    		=> __( 'Email Subject', 'opalmedical' ),
							'type'    		=> 'text',
							'desc'			=> __( 'The email subject a user should receive when their appointment has been rejected.', 'opalmedical' ),
							'attributes'  	=> array(
		        									'placeholder' 		=> 'Your appointment at '.get_bloginfo( 'name' ).' was not accepted',
		        									'rows'       	 	=> 3,
		    									),
							'default' => 'Your appointment at '.get_bloginfo( 'name' ).' was not accepted',
						),
						array(
							'id'      => 'rejected_email_body',
							'name'    => __( 'Email Body', 'opalmedical' ),
							'type'    => 'wysiwyg',
							'desc'	=> __( 'Enter the email a user should receive when their appointment has been rejected.', 'opalmedical' ),
							'default' => trim(preg_replace('/\t+/', '',"Hi {user_name},<br>
							<br>
							Sorry, we could not accomodate your appointment request. We're full or not open at the time you requested:<br>
							<br>
							{user_name}<br>
							{date}<br>
							{message}
							<br>
							&nbsp;<br>
							<br>
							<em>This message was sent by {site_link} on {current_time}.</em>"))
						),
					)
				)
			),// end mail
			//=============================================================
			/**
			 * Topics Settings
			 */
			'topics'   => array(
				'id'         => 'options_page',
				'title' 		 => __( 'Topics Settings', 'opalmedical' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opaltransport_settings_topics', array(
						array(
							'name' => __( 'Email Settings (Rejected Email)', 'opalmedical' ),
							'desc' => '<hr>',
							'id'   => 'opaltransport_title_email_settings_1',
							'type' => 'title'
						),
					   	array(
							'id'                => 'topic_lists_group',
							'type'              => 'group',
							'fields'            => array(
								array(
									'id'                => 'topic_lists_key',
									'name'              => __( 'Content', 'opalmedical' ),
									'type'              => 'text',
								),
								
							),
							'options'     => array(
						        'group_title'   => __( 'Topic {#}', 'opalmedical' ), // since version 1.1.4, {#} gets replaced by row 76
						        'add_button'    => __( 'Add Another Entry', 'opalmedical' ),
						        'remove_button' => __( 'Remove Entry', 'opalmedical' ),
						        'sortable'      => true, // beta
						        'closed'     	=> false, // true to have the groups closed by default
						   ),
						)
					)
				)
			),// end topics
			//=============================================================
			/**
			 * Sample Data Settings
			 */
			'sample_data'   => array(
				'id'         => 'options_page',
				'title' 		 => __( 'Sample Data', 'opalmedical' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalmedical_settings_sample_data', array(
						array(
							'name' => __( 'Import Settings', 'opalmedical' ),
							'desc' => '<div class="opal-setting-install-sampledata" >
									<a class="btn-install-sample-data btn" > Click to install Sample </a>
									</div>',
							'type' => 'title',
							'id'   => 'opalmedical_title_sample_data_settings_1'
						),
					)
				)
			),// end Sample
			'statuses'     => array(
				'id'         => 'options_page',
				'opalmedical_title' => __( 'Status Settings', 'opalmedical' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => array()
			),
		);
		
		$statuses = opalmedical_register_status();
		$fields = array();
		$i = 1;
		foreach ($statuses as $key => $status) {
			$fields[] = array(
				'name' => '',
				'desc' => '<hr>',
				'id'   => 'opalmedical_title_status_settings_'.$i,
				'type' => 'opalmedical_title'
			);
			$fields[] = array(
		        'name'    => sprintf( __( 'Background Color %s status', 'opalmedical' ), $status['label'] ),
			    'id'      => $key.'_bg_color',
			    'type'    => 'colorpicker',
			    'default' => isset($status['default_bg_color']) ? $status['default_bg_color'] : ''
		    );
		    $fields[] = array(
		        'name'    => sprintf( __( 'Text Color %s status', 'opalmedical' ), $status['label'] ),
			    'id'      => $key.'_text_color',
			    'type'    => 'colorpicker',
			    'default' => isset($status['default_text_color']) ? $status['default_text_color'] : ''
		    );
		    $i++;
		}
		$opalmedical_settings['statuses']['fields'] = apply_filters( 'opalmedical_settings_statuses', $fields );


	
		
		//Return all settings array if necessary
		if ( $active_tab === null || ! isset( $opalmedical_settings[ $active_tab ] ) ) {
			return apply_filters( 'opalmedical_registered_settings', $opalmedical_settings );
		}

		// Add other tabs and settings fields as needed
		return apply_filters( 'opalmedical_registered_settings', $opalmedical_settings[ $active_tab ] );

	}

	/**
	 * Show Settings Notices
	 *
	 * @param $object_id
	 * @param $updated
	 * @param $cmb
	 */
	public function settings_notices( $object_id, $updated, $cmb ) {

		//Sanity check
		if ( $object_id !== $this->key ) {
			return;
		}

		if ( did_action( 'cmb2_save_options-page_fields' ) === 1 ) {
			settings_errors( 'opalmedical-notices' );
		}

		add_settings_error( 'opalmedical-notices', 'global-settings-updated', __( 'Settings updated.', 'opalmedical' ), 'updated' );

	}


	/**
	 * Public getter method for retrieving protected/private variables
	 *
	 * @since  1.0
	 *
	 * @param  string $field Field to retrieve
	 *
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {

		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'fields', 'opalmedical_title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		if ( 'option_metabox' === $field ) {
			return $this->option_metabox();
		}

		throw new Exception( 'Invalid doctor: ' . $field );
	}


}

// Get it started
$Opalmedical_Settings = new Opalmedical_Plugin_Settings();

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 *
 * @param  string $key Options array key
 *
 * @return mixed        Option value
 */
function opalmedical_get_option( $key = '', $default = false ) {
	global $opalmedical_options;
	$value = ! empty( $opalmedical_options[ $key ] ) ? $opalmedical_options[ $key ] : $default;
	$value = apply_filters( 'opalmedical_get_option', $value, $key, $default );

	return apply_filters( 'opalmedical_get_option_' . $key, $value, $key, $default );
}


/**
 * Update an option
 *
 * Updates an opalmedical setting value in both the db and the global variable.
 * Warning: Passing in an empty, false or null string value will remove
 *          the key from the opalmedical_options array.
 *
 * @since 1.0
 *
 * @param string          $key   The Key to update
 * @param string|bool|int $value The value to set the key to
 *
 * @return boolean True if updated, false if not.
 */
function opalmedical_update_option( $key = '', $value = false ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	if ( empty( $value ) ) {
		$remove_option = opalmedical_delete_option( $key );

		return $remove_option;
	}

	// First let's grab the current settings
	$options = get_option( 'opalmedical_settings' );

	// Let's let devs alter that value coming in
	$value = apply_filters( 'opalmedical_update_option', $value, $key );

	// Next let's try to update the value
	$options[ $key ] = $value;
	$did_update      = update_option( 'opalmedical_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opalmedical_options;
		$opalmedical_options[ $key ] = $value;
	}

	return $did_update;
}

/**
 * Remove an option
 *
 * Removes an opalmedical setting value in both the db and the global variable.
 *
 * @since 1.0
 *
 * @param string $key The Key to delete
 *
 * @return boolean True if updated, false if not.
 */
function opalmedical_delete_option( $key = '' ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	// First let's grab the current settings
	$options = get_option( 'opalmedical_settings' );

	// Next let's try to update the value
	if ( isset( $options[ $key ] ) ) {

		unset( $options[ $key ] );

	}

	$did_update = update_option( 'opalmedical_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opalmedical_options;
		$opalmedical_options = $options;
	}

	return $did_update;
}


/**
 * Get Settings
 *
 * Retrieves all Opalmedical plugin settings
 *
 * @since 1.0
 * @return array Opalmedical settings
 */
function opalmedical_get_settings() {

	$settings = get_option( 'opalmedical_settings' );

	return (array) apply_filters( 'opalmedical_get_settings', $settings );

}

/**
 * Gateways Callback
 *
 * Renders gateways fields.
 *
 * @since 1.0
 *
 * @global $opalmedical_options Array of all the Opalmedical Options
 * @return void
 */
function opalmedical_enabled_gateways_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$field_description = $field_type_object->field->args['desc'];
	$gateways          = opalmedical_get_payment_gateways();

	echo '<ul class="cmb2-checkbox-list cmb2-list">';

	foreach ( $gateways as $key => $option ) :

		if ( is_array( $escaped_value ) && array_key_exists( $key, $escaped_value ) ) {
			$enabled = '1';
		} else {
			$enabled = null;
		}

		echo '<li><input name="' . $id . '[' . $key . ']" id="' . $id . '[' . $key . ']" type="checkbox" value="1" ' . checked( '1', $enabled, false ) . '/>&nbsp;';
		echo '<label for="' . $id . '[' . $key . ']">' . $option['admin_label'] . '</label></li>';

	endforeach;

	if ( $field_description ) {
		echo '<p class="cmb2-metabox-description">' . $field_description . '</p>';
	}

	echo '</ul>';


}

/**
 * Output a message if the current page has the id of (the about page)
 * @param  object $field_args Current field args
 * @param  object $field      Current field object
 */
function cmb_before_row_cb( $field_args, $field ) {
   echo '<hr><hr>';
    
}

/**
 * Gateways Callback (drop down)
 *
 * Renders gateways select doctor
 *
 * @since 1.0
 *
 * @param $field_object , $escaped_value, $object_id, $object_type, $field_type_object Arguments passed by CMB2
 *
 * @return void
 */
function opalmedical_default_gateway_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$field_description = $field_type_object->field->args['desc'];
	$gateways          = opalmedical_get_enabled_payment_gateways();

	echo '<select class="cmb2_select" name="' . $id . '" id="' . $id . '">';

	//Add a field to the Opalmedical Form admin single post view of this field
	if ( $field_type_object->field->object_type === 'post' ) {
		echo '<option value="global">' . __( 'Global Default', 'opalmedical' ) . '</option>';
	}

	foreach ( $gateways as $key => $option ) :

		$selected = isset( $escaped_value ) ? selected( $key, $escaped_value, false ) : '';


		echo '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $option['admin_label'] ) . '</option>';

	endforeach;

	echo '</select>';

	echo '<p class="cmb2-metabox-description">' . $field_description . '</p>';

}

/**
 * Opalmedical Title
 *
 * Renders custom section titles output; Really only an <hr> because CMB2's output is a bit funky
 *
 * @since 1.0
 *
 * @param       $field_object , $escaped_value, $object_id, $object_type, $field_type_object
 *
 * @return void
 */
function opalmedical_title_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$title             = $field_type_object->field->args['name'];
	$field_description = $field_type_object->field->args['desc'];

	echo '<hr>';

}

/**
 * Gets a number of posts and displays them as options
 *
 * @param  array $query_args Optional. Overrides defaults.
 * @param  bool  $force      Force the pages to be loaded even if not on settings
 *
 * @see: https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types
 * @return array An array of options that matches the CMB2 options array
 */
function opalmedical_cmb2_get_post_options( $query_args, $force = false ) {

	$post_options = array( '' => '' ); // Blank option

	if ( ( ! isset( $_GET['page'] ) || 'opalmedical-settings' != $_GET['page'] ) && ! $force ) {
		return $post_options;
	}

	$args = wp_parse_args( $query_args, array(
		'post_type'   => 'page',
		'numberposts' => 10,
	) );

	$posts = get_posts( $args );

	if ( $posts ) {
		foreach ( $posts as $post ) {

			$post_options[ $post->ID ] = $post->post_title;

		}
	}

	return $post_options;
}


/**
 * Modify CMB2 Default Form Output
 *
 * @param string @args
 *
 * @since 1.0
 */

add_filter( 'cmb2_get_metabox_form_format', 'opalmedical_modify_cmb2_form_output', 10, 3 );

function opalmedical_modify_cmb2_form_output( $form_format, $object_id, $cmb ) {

	//only modify the opalmedical settings form
	if ( 'opalmedical_settings' == $object_id && 'options_page' == $cmb->cmb_id ) {

		return '<form class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<div class="opalmedical-submit-wrap"><input type="submit" name="submit-cmb" value="' . __( 'Save Settings', 'opalmedical' ) . '" class="button-primary"></div></form>';
	}

	return $form_format;

}


/**
 * Opalmedical License Key Callback
 *
 * @description Registers the license field callback for EDD's Software Licensing
 * @since       1.0
 *
 * @param array $field_object , $escaped_value, $object_id, $object_type, $field_type_object Arguments passed by CMB2
 *
 * @return void
 */
if ( ! function_exists( 'opalmedical_license_key_callback' ) ) {
	function opalmedical_license_key_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

		$id                = $field_type_object->field->args['id'];
		$field_description = $field_type_object->field->args['desc'];
		$license_status    = get_option( $field_type_object->field->args['options']['is_valid_license_option'] );
		$field_classes     = 'regular-text opalmedical-license-field';
		$type              = empty( $escaped_value ) ? 'text' : 'password';

		if ( $license_status === 'valid' ) {
			$field_classes .= ' opalmedical-license-active';
		}

		$html = $field_type_object->input( array(
			'class' => $field_classes,
			'type'  => $type
		) );

		//License is active so show deactivate button
		if ( $license_status === 'valid' ) {
			$html .= '<input type="submit" class="button-secondary opalmedical-license-deactivate" name="' . $id . '_deactivate" value="' . __( 'Deactivate License', 'opalmedical' ) . '"/>';
		} else {
			//This license is not valid so delete it
			opalmedical_delete_option( $id );
		}

		$html .= '<label for="opalmedical_settings[' . $id . ']"> ' . $field_description . '</label>';

		wp_nonce_field( $id . '-nonce', $id . '-nonce' );

		echo $html;
	}
}


/**
 * Display the API Keys
 *
 * @since       2.0
 * @return      void
 */
function opalmedical_api_callback() {

	if ( ! current_user_can( 'manage_opalmedical_settings' ) ) {
		return;
	}

	do_action( 'opalmedical_tools_api_keys_before' );

	require_once OPALESTATE_PLUGIN_DIR . 'includes/admin/class-api-keys-table.php';

	$api_keys_table = new Opalmedical_API_Keys_Table();
	$api_keys_table->prepare_items();
	$api_keys_table->display();
	?>
	<p>
		<?php printf(
			__( 'API keys allow users to use the <a href="%s">Opalmedical REST API</a> to retrieve donation data in JSON or XML for external applications or devices, such as <a href="%s">Zapier</a>.', 'opalmedical' ),
			'https://opalmedicalwp.com/documentation/opalmedical-api-reference/',
			'https://opalmedicalwp.com/addons/zapier/'
		); ?>
	</p>

	<style>
		.opalmedical_doctor_page_opalmedical-settings .opalmedical-submit-wrap {
			display: none; /* Hide Save settings button on System Info Tab (not needed) */
		}
	</style>
	<?php

	do_action( 'opalmedical_tools_api_keys_after' );
}

add_action( 'opalmedical_settings_tab_api_keys', 'opalmedical_api_callback' );

/**
 * Hook Callback
 *
 * Adds a do_action() hook in place of the field
 *
 * @since 1.0
 *
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function opalmedical_hook_callback( $args ) {
	do_action( 'opalmedical_' . $args['id'] );
}