<?php
/**
 * Plugin Name: Opal job
 * Plugin URI: http://www.wpopal.com/job/
 * Description: An e-commerce toolkit that helps you sell anything. Beautifully.
 * Version: 1.0
 * Author: WPOPAL
 * Author URI: http://www.wpopal.com
 * Requires at least: 3.8
 * Tested up to: 4.1
 *
 * Text Domain: opaljob
 * Domain Path: /i18n/languages/
 *
 * @package Opal-job
 * @category Plugins
 * @author WPOPAL
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists("Opaljob") ){
	
	final class Opaljob{

		/**
		 * @var Opaljob The one true Opaljob
		 * @since 1.0
		 */
		private static $instance;

		/**
		 * Opaljob Roles Object
		 *
		 * @var object
		 * @since 1.0
		 */
		public $roles;

		/**
		 * Opaljob Settings Object
		 *
		 * @var object
		 * @since 1.0
		 */
		public $opaljob_settings;

		/**
		 * Opaljob Session Object
		 *
		 * This holds donation data for user's session
		 *
		 * @var object
		 * @since 1.0
		 */
		public $session;

		/**
		 * Opaljob HTML Element Helper Object
		 *
		 * @var object
		 * @since 1.0
		 */
		public $html;


		/**
		 * Opaljob Emails Object
		 *
		 * @var object
		 * @since 1.0
		 */
		public $emails;

		/**
		 * Opaljob Email Template Tags Object
		 *
		 * @var object
		 * @since 1.0
		 */
		public $email_tags;

		/**
		 * Opaljob Customers DB Object
		 *
		 * @var object
		 * @since 1.0
		 */
		public $customers;

		/**
		 * Opaljob API Object
		 *
		 * @var object
		 * @since 1.1
		 */
		public $api;

		/**
		 *
		 */
		public function __construct() {

		}

		/**
		 * Main Opaljob Instance
		 *
		 * Insures that only one instance of Opaljob exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since     1.0
		 * @static
		 * @staticvar array $instance
		 * @uses      Opaljob::setup_constants() Setup the constants needed
		 * @uses      Opaljob::includes() Include the required files
		 * @uses      Opaljob::load_textdomain() load the language files
		 * @see       Opaljob()
		 * @return    Opaljob
		 */
		public static function getInstance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Opaljob ) ) {
				self::$instance = new Opaljob;
				self::$instance->setup_constants();

				add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

				self::$instance->includes();
			 	self::$instance->roles              = new Opaljob_Roles(); 
				//self::$instance->api                = new Opaljob_API();
			//	self::$instance->opaljob_settings      = new Opaljob_Plugin_Settings();
			//	self::$instance->session            = new Opaljob_Session();
				//self::$instance->html               = new Opaljob_HTML_Elements();
				//self::$instance->emails             = new Opaljob_Emails();
				//self::$instance->email_tags         = new Opaljob_Email_Template_Tags();
				//self::$instance->donators_gravatars = new Opaljob_Donators_Gravatars();
				//self::$instance->customers          = new Opaljob_DB_Customers();
				//self::$instance->template_loader    = new Opaljob_Template_Loader();

			}

			return self::$instance;
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
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'opaljob' ), '1.0' );
		}

		/**
		 *
		 */
		public function setup_constants(){
			// Plugin version
			if ( ! defined( 'OPALJOB_VERSION' ) ) {
				define( 'OPALJOB_VERSION', '1.3.1.1' );
			}

			// Plugin Folder Path
			if ( ! defined( 'OPALJOB_PLUGIN_DIR' ) ) {
				define( 'OPALJOB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'OPALJOB_PLUGIN_URL' ) ) {
				define( 'OPALJOB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File
			if ( ! defined( 'OPALJOB_PLUGIN_FILE' ) ) {
				define( 'OPALJOB_PLUGIN_FILE', __FILE__ );
			}

			// Plugin Root File
			if ( ! defined( 'OPALJOB_THEMER_WIDGET_TEMPLATES' ) ) {
				define( 'OPALJOB_THEMER_WIDGET_TEMPLATES', get_template_directory().'/' );
			}

			if( !defined("OPALJOB_CLUSTER_ICON_URL") ){
				define( 'OPALJOB_CLUSTER_ICON_URL',  apply_filters( 'opalestate_cluster_icon_url', OPALJOB_PLUGIN_URL.'assets/images/map/cluster-icon.png') );
			} 

		}

		public function setup_cmb2_url() {
			return OPALJOB_PLUGIN_URL . 'inc/vendors/cmb2/libraries';
		}

		public function includes(){  
			global $opaljob_options;
			
			/**
			 * Get the CMB2 bootstrap!
			 *
			 * @description: Checks to see if CMB2 plugin is installed first the uses included CMB2; we can still use it even it it's not active. This prevents fatal error conflicts with other themes and users of the CMB2 WP.org plugin
			 *
			 */
			if ( file_exists( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php' ) ) {
				require_once WP_PLUGIN_DIR . '/woocommerce/woocommerce.php';
			}

			if ( file_exists( WP_PLUGIN_DIR . '/cmb2/init.php' ) ) {
				require_once WP_PLUGIN_DIR . '/cmb2/init.php';
			} elseif ( file_exists( OPALJOB_PLUGIN_DIR . 'inc/vendors/cmb2/libraries/init.php' ) ) {
				require_once OPALJOB_PLUGIN_DIR . 'inc/vendors/cmb2/libraries/init.php';
				//Customize CMB2 URL
				add_filter( 'cmb2_meta_box_url', array($this, 'setup_cmb2_url') );
			}
			// cmb2 custom field
			require_once OPALJOB_PLUGIN_DIR . 'inc/vendors/cmb2/custom-fields/map/map.php';
		///	require_once OPALJOB_PLUGIN_DIR . 'inc/vendors/cmb2/custom-fields/calendar/calendar.php';
			// membership
			
			
			require_once OPALJOB_PLUGIN_DIR . 'inc/admin/register-settings.php';
			$opaljob_options = opaljob_get_settings();
			
			

			require_once OPALJOB_PLUGIN_DIR . 'inc/class-template-loader.php';

			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-query.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opal-base.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/opal-function.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/mixes-functions.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/ajax-functions.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-importdemo.php';
			
			

			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-roles.php';
			opaljob_includes( OPALJOB_PLUGIN_DIR . 'inc/post-types/*.php' );
			opaljob_includes( OPALJOB_PLUGIN_DIR . 'inc/taxonomies/*.php' );
						
			require_once OPALJOB_PLUGIN_DIR . 'inc/template-functions.php';
			
			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-save-work.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-work.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-company.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-resume.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-apply.php';

			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-scripts.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-shortcodes.php';

			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-metabox.php';

			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-submission.php';
			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-search.php';

			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-account.php';

			require_once OPALJOB_PLUGIN_DIR . 'install.php';


			require_once OPALJOB_PLUGIN_DIR . 'inc/class-opaljob-vc.php';

			require_once OPALJOB_PLUGIN_DIR . 'inc/function-search-fields.php';	
			

			// install plugin
			if ( get_option( 'opaljob_setup', false ) != 'installed' ) {
				register_activation_hook( __FILE__, 'opaljob_create_pages');
				update_option( 'opaljob_setup', 'installed' );
			}
			add_action( 'widgets_init', array($this, 'widgets_init') );
			/**
			* init theme function
			* @author dattq
			*/ 
			register_activation_hook( __FILE__,'opal_init_function');
			
		}

		/**
		 *
		 */
		public function load_textdomain() {
			// Set filter for Opaljob's languages directory
			$lang_dir = dirname( plugin_basename( OPALJOB_PLUGIN_FILE ) ) . '/languages/';
			$lang_dir = apply_filters( 'opaljob_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'opaljob' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'opaljob', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/opaljob/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/opaljob folder
				load_textdomain( 'opaljob', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/opaljob/languages/ folder
				load_textdomain( 'opaljob', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'opaljob', false, $lang_dir );
			}
		}

		public function widgets_init() {
			opaljob_includes( OPALJOB_PLUGIN_DIR . 'inc/widgets/*.php' );
		}
	}
}

function Opaljob(){
	return Opaljob::getInstance();
}

Opaljob();
