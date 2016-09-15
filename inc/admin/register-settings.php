<?php

/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opaljob
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

class Opaljob_Plugin_Settings {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'opaljob_settings';

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
		add_action( 'cmb2_render_opaljob_title', 'opaljob_title_callback', 10, 5 );

		add_action( 'cmb2_render_api', 'opaljob_api_callback', 10, 5 );
		add_action( 'cmb2_render_license_key', 'opaljob_license_key_callback', 10, 5 );
		add_action( "cmb2_save_options-page_fields", array( $this, 'settings_notices' ), 10, 3 );

		// Include CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles-opaljob_works_page_opaljob-settings", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );

	}

	public function admin_menu() {
		//Settings
	 	$give_settings_page = add_submenu_page( 'edit.php?post_type=opaljob_work', __( 'Settings', 'opaljob' ), __( 'Settings', 'opaljob' ), 'manage_options', 'opaljob-settings', 
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
	public function opaljob_get_settings_tabs() {

		$settings = $this->opaljob_settings( null );

		$tabs             = array();
		$tabs['general']  = __( 'General', 'opaljob' );
		$tabs['emails']   = __( 'Emails', 'opaljob' );
		$tabs['import']	  = __( 'Import Demo','opaljob');	

		if ( ! empty( $settings['addons']['fields'] ) ) {
			$tabs['addons'] = __( 'Add-ons', 'opaljob' );
		}

		if ( ! empty( $settings['licenses']['fields'] ) ) {
			$tabs['licenses'] = __( 'Licenses', 'opaljob' );
		}

		return apply_filters( 'opaljob_settings_tabs', $tabs );
	}
	
	


	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  1.0
	 */
	public function admin_page_display() {

		$active_tab = isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $this->opaljob_get_settings_tabs() ) ? $_GET['tab'] : 'general';

		?>

		<div class="wrap opaljob_settings_page cmb2_options_page <?php echo $this->key; ?>">
			<h2 class="nav-tab-wrapper">
				<?php
				foreach ( $this->opaljob_get_settings_tabs() as $tab_id => $tab_name ) {

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

			<?php cmb2_metabox_form( $this->opaljob_settings( $active_tab ), $this->key ); ?>

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
	public function opaljob_settings( $active_tab ) {

		$opaljob_settings = array(
			/**
			 * General Settings
			 */
			'general'     => array(
				'id'         => 'options_page',
				'opaljob_title' => __( 'General Settings', 'opaljob' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opaljob_settings_general', array(
						array(
							'name' => __( 'General Settings', 'opaljob' ),
							'desc' => '<hr>',
							'type' => 'opaljob_title',
							'id'   => 'opaljob_title_general_settings_1'
						),
						
						array(
							'name'    => __( 'Submission Page', 'opaljob' ),
							'desc'    => __( 'This is the submission page. The <code>[opaljob_submission]</code> shortcode should be on this page.', 'opaljob' ),
							'id'      => 'submission_page',
							'type'    => 'select',
							'options' => opaljob_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
						),
						array(
							'name'    => __( 'Submission List Page', 'opaljob' ),
							'desc'    => __( 'This is the submission list page. The <code>[opaljob_submission_list]</code> shortcode should be on this page.', 'opaljob' ),
							'id'      => 'submission_list_page',
							'type'    => 'select',
							'options' => opaljob_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
						),
						array(
							'name'    => __( 'Submission Profile Page', 'opaljob' ),
							'desc'    => __( 'This is the Submission Profile page. The <code>[opaljob_submission_profile]</code> shortcode should be on this page.', 'opaljob' ),
							'id'      => 'submission_profile_page',
							'type'    => 'select',
							'options' => opaljob_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
						),
						array(
							'name'    => __( 'Submission Resume Page', 'opaljob' ),
							'desc'    => __( 'This is the submission resume page. The <code>[opaljob_submission_resume]</code> shortcode should be on this page.', 'opaljob' ),
							'id'      => 'submission_resume_page',
							'type'    => 'select',
							'options' => opaljob_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
						),
						array(
							'name'    => __( 'Submission List Resume Page', 'opaljob' ),
							'desc'    => __( 'This is the submission list page. The <code>[opaljob_submission_list_resume]</code> shortcode should be on this page.', 'opaljob' ),
							'id'      => 'submission_list_resume_page',
							'type'    => 'select',
							'options' => opaljob_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
						),
						array(
							'name'    => __( 'Submission Job Apply Page', 'opaljob' ),
							'desc'    => __( 'This is the submission list page. The <code>[opaljob_submission_job_apply]</code> shortcode should be on this page.', 'opaljob' ),
							'id'      => 'submission_job_apply_page',
							'type'    => 'select',
							'options' => opaljob_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
						),
						array(
							'name'    => __( 'Search Resume Page Result', 'opaljob' ),
							'desc'    => __( 'This is the seach  page. The <code>[opaljob_seach_resumes_result]</code> shortcode should be on this page.', 'opaljob' ),
							'id'      => 'search_resume_page',
							'type'    => 'select',
							'options' => opaljob_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
						),
						array(
							'name'    => __( 'Search Work  Page Result', 'opaljob' ),
							'desc'    => __( 'This is the seach  page. The <code>[opaljob_search_works_result]</code> shortcode should be on this page.', 'opaljob' ),
							'id'      => 'search_work_page',
							'type'    => 'select',
							'options' => opaljob_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
						),
						array(
							'name'    => __( 'Wishlist Page', 'opaljob' ),
							'desc'    => __( 'This is the Wishlist  page. The <code>[opaljob_submission_list_wishlist]</code> shortcode should be on this page.', 'opaljob' ),
							'id'      => 'submission_list_wishlist_page',
							'type'    => 'select',
							'options' => opaljob_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
						),
						array(
							'name'    => __( 'Enable Admin Approve', 'opaljob' ),
							'desc'    => __( 'the Work will be auto approve when user submit, if you do not enable it.', 'opaljob' ),
							'id'      => 'admin_approve',
							'type'    => 'checkbox'
						),

						array(
							'name' => __( 'Currency Settings', 'opaljob' ),
							'desc' => '',
							'type' => 'opaljob_title',
							'id'   => 'opaljob_title_general_settings_2'
						),
						
						array(
							'name'    => __( 'Currency', 'opaljob' ),
							'desc'    => 'Choose your currency. Note that some payment gateways have currency restrictions.',
							'id'      => 'currency',
							'type'    => 'select',
							'options' => opaljob_get_currencies(),
							'default' => 'USD',
						),
						array(
							'name'    => __( 'Currency Position', 'opaljob' ),
							'desc'    => 'Choose the position of the currency sign.',
							'id'      => 'currency_position',
							'type'    => 'select',
							'options' => array(
								'before' => __( 'Before - $10', 'opaljob' ),
								'after'  => __( 'After - 10$', 'opaljob' )
							),
							'default' => 'before',
						),
						array(
							'name'    => __( 'Thousands Separator', 'opaljob' ),
							'desc'    => __( 'The symbol (typically , or .) to separate thousands', 'opaljob' ),
							'id'      => 'thousands_separator',
							'type'    => 'text_small',
							'default' => ',',
						),
						array(
							'name'    => __( 'Decimal Separator', 'opaljob' ),
							'desc'    => __( 'The symbol (usually , or .) to separate decimal points', 'opaljob' ),
							'id'      => 'decimal_separator',
							'type'    => 'text_small',
							'default' => '.',
						),

						array(
							'name'    => __( 'Measurement Unit', 'opaljob' ),
							'desc'    => __( 'Measurement Unit', 'opaljob' ),
							'id'      => 'measurement_unit',
							'type'    => 'select',
							'options' => array(
								'sq ft' => __( 'sq ft', 'opaljob' ),
								'sq m'  => __( 'sq m', 'opaljob' )
							),
							'default' => 'sq ft',
						),
					)
				)
			),
			
			/**
			 * Emails Options
			 */
			'emails'      => array(
				'id'         => 'options_page',
				'opaljob_title' => __( 'Opaljob Email Settings', 'opaljob' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opaljob_settings_emails', array(
						array(
							'name' => __( 'Email Settings', 'opaljob' ),
							'desc' => '<hr>',
							'id'   => 'opaljob_title_email_settings_1',
							'type' => 'opaljob_title'
						),
						array(
							'id'      => 'from_name',
							'name'    => __( 'From Name', 'opaljob' ),
							'desc'    => __( 'The name donation receipts are said to come from. This should probably be your site or shop name.', 'opaljob' ),
							'default' => '',
							'type'    => 'text'
						),
						array(
							'id'      => 'from_email',
							'name'    => __( 'From Email', 'opaljob' ),
							'desc'    => __( 'Email to send donation receipts from. This will act as the "from" and "reply-to" address.', 'opaljob' ),
							'default' => get_bloginfo( 'admin_email' ),
							'type'    => 'text'
						),
						array(
							'name' => __( 'Email Settings (Submit A Submission Completed)', 'opaljob' ),
							'desc' => '<hr>',
							'id'   => 'opaljob_title_email_settings_2',
							'type' => 'opaljob_title'
						),
						array(
							'id'      	=> 'submission_email_subject',
							'name'    	=> __( 'Email Subject', 'opaljob' ),
							'default' 	=> '',
							'type'    	=> 'text',

						),
						array(
							'id'      => 'submission_email_body',
							'name'    => __( 'Email Body', 'opaljob' ),
							'default' => '',
							'type'    => 'textarea'
						),

						array(
							'name' => __( 'Email Settings (Change Submission From Pending To Publish )', 'opaljob' ),
							'desc' => '<hr>',
							'id'   => 'opaljob_title_email_settings_3',
							'type' => 'opaljob_title'
						),
						array(
							'id'      => 'publish_submission_email_subject',
							'name'    => __( 'Email Subject', 'opaljob' ),
							'default' => '',
							'type'    => 'text'
						),
						array(
							'id'      => 'publish_submission_email_body',
							'name'    => __( 'Email Body', 'opaljob' ),
							'default' => '',
							'type'    => 'textarea'
						),

						array(
							'name' => __( 'Email Settings (Sent Contact Aplly Form)', 'opaljob' ),
							'desc' => '<hr>',
							'id'   => 'opaljob_title_email_settings_4',
							'type' => 'opaljob_title'
						),
						array(
							'id'      => 'sent_contact_form_email_subject',
							'name'    => __( 'Email Subject', 'opaljob' ),
							'default' => '',
							'type'    => 'text'
						),
						array(
							'id'      => 'sent_contact_form_email_body',
							'name'    => __( 'Email Body', 'opaljob' ),
							'default' => 'Dear {recruier_name}<strong>My name:</strong> {name}
							This email is to inform you that a apply job has been made on your website:{work_link}
							Send to {email}
							Link resume: {link_resume}
							Message {message}',
							'type'    => 'wysiwyg'
						),
						array(
							'name' => __( 'Email Settings (Sent Contact Aplly Approve  Form)', 'opaljob' ),
							'desc' => '<hr>',
							'id'   => 'opaljob_title_email_settings_5',
							'type' => 'opaljob_title'
						),
						array(
							'id'      => 'sent_approve_form_email_subject',
							'name'    => __( 'Email Subject', 'opaljob' ),
							'default' => '',
							'type'    => 'text'
						),
						array(
							'id'      => 'sent_approve_form_email_body',
							'name'    => __( 'Email Body', 'opaljob' ),
							'default' => '',
							'type'    => 'wysiwyg',
							'desc'		=> ' '	
						),
						array(
							'name' => __( 'Email Settings (Sent Contact Aplly Rejected  Form)', 'opaljob' ),
							'desc' => '<hr>',
							'id'   => 'opaljob_title_email_settings_6',
							'type' => 'opaljob_title'
						),
						array(
							'id'      => 'sent_rejected_form_email_subject',
							'name'    => __( 'Email Subject', 'opaljob' ),
							'default' => '',
							'type'    => 'text'
						),
						array(
							'id'      => 'sent_rejected_form_email_body',
							'name'    => __( 'Email Body', 'opaljob' ),
							'default' => '',
							'type'    => 'textarea'
						)
					)
				)
			),
			// import demo
			/**
			 * import demo Options
			 */
			'import'      => array(
				'id'         => 'options_page',
				'opaljob_title' => __( 'Opaljob Import demo', 'opaljob' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opaljob_importdemo', array(
						array(
							'id'      => 'install_demo',
							'name'    => __( 'Install demo', 'opaljob' ),
							'default' => '',
							'type'    => 'checkbox'
						)
					)
				)
			),
		);
		

		//Return all settings array if necessary
		if ( $active_tab === null || ! isset( $opaljob_settings[ $active_tab ] ) ) {
			return apply_filters( 'opaljob_registered_settings', $opaljob_settings );
		}

		// Add other tabs and settings fields as needed
		return apply_filters( 'opaljob_registered_settings', $opaljob_settings[ $active_tab ] );

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
			settings_errors( 'opaljob-notices' );
		}

		add_settings_error( 'opaljob-notices', 'global-settings-updated', __( 'Settings updated.', 'opaljob' ), 'updated' );

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
		if ( in_array( $field, array( 'key', 'fields', 'opaljob_title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		if ( 'option_metabox' === $field ) {
			return $this->option_metabox();
		}

		throw new Exception( 'Invalid work: ' . $field );
	}


}

// Get it started
$Opaljob_Settings = new Opaljob_Plugin_Settings();

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 *
 * @param  string $key Options array key
 *
 * @return mixed        Option value
 */
function opaljob_get_option( $key = '', $default = false ) {
	global $opaljob_options;
	$value = ! empty( $opaljob_options[ $key ] ) ? $opaljob_options[ $key ] : $default;
	$value = apply_filters( 'opaljob_get_option', $value, $key, $default );

	return apply_filters( 'opaljob_get_option_' . $key, $value, $key, $default );
}


/**
 * Update an option
 *
 * Updates an opaljob setting value in both the db and the global variable.
 * Warning: Passing in an empty, false or null string value will remove
 *          the key from the opaljob_options array.
 *
 * @since 1.0
 *
 * @param string          $key   The Key to update
 * @param string|bool|int $value The value to set the key to
 *
 * @return boolean True if updated, false if not.
 */
function opaljob_update_option( $key = '', $value = false ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	if ( empty( $value ) ) {
		$remove_option = opaljob_delete_option( $key );

		return $remove_option;
	}

	// First let's grab the current settings
	$options = get_option( 'opaljob_settings' );

	// Let's let devs alter that value coming in
	$value = apply_filters( 'opaljob_update_option', $value, $key );

	// Next let's try to update the value
	$options[ $key ] = $value;
	$did_update      = update_option( 'opaljob_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opaljob_options;
		$opaljob_options[ $key ] = $value;
	}

	return $did_update;
}

/**
 * Remove an option
 *
 * Removes an opaljob setting value in both the db and the global variable.
 *
 * @since 1.0
 *
 * @param string $key The Key to delete
 *
 * @return boolean True if updated, false if not.
 */
function opaljob_delete_option( $key = '' ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	// First let's grab the current settings
	$options = get_option( 'opaljob_settings' );

	// Next let's try to update the value
	if ( isset( $options[ $key ] ) ) {

		unset( $options[ $key ] );

	}

	$did_update = update_option( 'opaljob_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opaljob_options;
		$opaljob_options = $options;
	}

	return $did_update;
}


/**
 * Get Settings
 *
 * Retrieves all Opaljob plugin settings
 *
 * @since 1.0
 * @return array Opaljob settings
 */
function opaljob_get_settings() {

	$settings = get_option( 'opaljob_settings' );

	return (array) apply_filters( 'opaljob_get_settings', $settings );

}

/**
 * Gateways Callback
 *
 * Renders gateways fields.
 *
 * @since 1.0
 *
 * @global $opaljob_options Array of all the Opaljob Options
 * @return void
 */
function opaljob_enabled_gateways_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$field_description = $field_type_object->field->args['desc'];
	$gateways          = opaljob_get_payment_gateways();

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
 * Gateways Callback (drop down)
 *
 * Renders gateways select menu
 *
 * @since 1.0
 *
 * @param $field_object , $escaped_value, $object_id, $object_type, $field_type_object Arguments passed by CMB2
 *
 * @return void
 */
function opaljob_default_gateway_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$field_description = $field_type_object->field->args['desc'];
	$gateways          = opaljob_get_enabled_payment_gateways();

	echo '<select class="cmb2_select" name="' . $id . '" id="' . $id . '">';

	//Add a field to the Opaljob Form admin single post view of this field
	if ( $field_type_object->field->object_type === 'post' ) {
		echo '<option value="global">' . __( 'Global Default', 'opaljob' ) . '</option>';
	}

	foreach ( $gateways as $key => $option ) :

		$selected = isset( $escaped_value ) ? selected( $key, $escaped_value, false ) : '';


		echo '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $option['admin_label'] ) . '</option>';

	endforeach;

	echo '</select>';

	echo '<p class="cmb2-metabox-description">' . $field_description . '</p>';

}

/**
 * Opaljob Title
 *
 * Renders custom section titles output; Really only an <hr> because CMB2's output is a bit funky
 *
 * @since 1.0
 *
 * @param       $field_object , $escaped_value, $object_id, $object_type, $field_type_object
 *
 * @return void
 */
function opaljob_title_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

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
function opaljob_cmb2_get_post_options( $query_args, $force = false ) {

	$post_options = array( '' => '' ); // Blank option

	if ( ( ! isset( $_GET['page'] ) || 'opaljob-settings' != $_GET['page'] ) && ! $force ) {
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

add_filter( 'cmb2_get_metabox_form_format', 'opaljob_modify_cmb2_form_output', 10, 3 );

function opaljob_modify_cmb2_form_output( $form_format, $object_id, $cmb ) {

	//only modify the opaljob settings form
	if ( 'opaljob_settings' == $object_id && 'options_page' == $cmb->cmb_id ) {

		return '<form class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<div class="opaljob-submit-wrap"><input type="submit" name="submit-cmb" value="' . __( 'Save Settings', 'opaljob' ) . '" class="button-primary"></div></form>';
	}

	return $form_format;

}


/**
 * Opaljob License Key Callback
 *
 * @description Registers the license field callback for EDD's Software Licensing
 * @since       1.0
 *
 * @param array $field_object , $escaped_value, $object_id, $object_type, $field_type_object Arguments passed by CMB2
 *
 * @return void
 */
if ( ! function_exists( 'opaljob_license_key_callback' ) ) {
	function opaljob_license_key_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

		$id                = $field_type_object->field->args['id'];
		$field_description = $field_type_object->field->args['desc'];
		$license_status    = get_option( $field_type_object->field->args['options']['is_valid_license_option'] );
		$field_classes     = 'regular-text opaljob-license-field';
		$type              = empty( $escaped_value ) ? 'text' : 'password';

		if ( $license_status === 'valid' ) {
			$field_classes .= ' opaljob-license-active';
		}

		$html = $field_type_object->input( array(
			'class' => $field_classes,
			'type'  => $type
		) );

		//License is active so show deactivate button
		if ( $license_status === 'valid' ) {
			$html .= '<input type="submit" class="button-secondary opaljob-license-deactivate" name="' . $id . '_deactivate" value="' . __( 'Deactivate License', 'opaljob' ) . '"/>';
		} else {
			//This license is not valid so delete it
			opaljob_delete_option( $id );
		}

		$html .= '<label for="opaljob_settings[' . $id . ']"> ' . $field_description . '</label>';

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
function opaljob_api_callback() {

	if ( ! current_user_can( 'manage_opaljob_settings' ) ) {
		return;
	}

	do_action( 'opaljob_tools_api_keys_before' );

	require_once OPALJOB_PLUGIN_DIR . 'includes/admin/class-api-keys-table.php';

	$api_keys_table = new Opaljob_API_Keys_Table();
	$api_keys_table->prepare_items();
	$api_keys_table->display();
	?>
	<p>
		<?php printf(
			__( 'API keys allow users to use the <a href="%s">Opaljob REST API</a> to retrieve donation data in JSON or XML for external applications or devices, such as <a href="%s">Zapier</a>.', 'opaljob' ),
			'https://opaljobwp.com/documentation/opaljob-api-reference/',
			'https://opaljobwp.com/addons/zapier/'
		); ?>
	</p>

	<style>
		.opaljob_works_page_opaljob-settings .opaljob-submit-wrap {
			display: none; /* Hide Save settings button on System Info Tab (not needed) */
		}
	</style>
	<?php

	do_action( 'opaljob_tools_api_keys_after' );
}

add_action( 'opaljob_settings_tab_api_keys', 'opaljob_api_callback' );

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
function opaljob_hook_callback( $args ) {
	do_action( 'opaljob_' . $args['id'] );
}