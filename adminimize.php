<?php
/**
 * Plugin Name: Adminimize 2
 * Description: Visually compresses the administratrive meta-boxes so that more admin page content can be initially seen. The plugin that lets you hide 'unnecessary' items from the WordPress administration menu, for alle roles of your install. You can also hide post meta controls on the edit-area to simplify the interface. It is possible to simplify the admin in different for all roles.
 * Version:     2.0
 * Author:      Inpsyde GmbH
 * Author URI:  http://inpsyde.com
 * Licence:     GPLv3
 * Text Domain: adminimize
 * Domain Path: /language
 */

if ( ! class_exists( 'Adminimize' ) ) {

	if ( function_exists( 'add_filter' ) )
		add_filter( 'plugins_loaded' ,  array( 'Adminimize', 'get_instance' ) );

	class Adminimize {

		/**
		 * The plugins textdomain
		 *
		 * @since	0.1
		 * @access	public
		 * @static
		 * @var		string
		 */
		public static $textdomain = '';

		/**
		 * The plugins textdomain path
		 *
		 * @since	0.1
		 * @access	public
		 * @static
		 * @var		string
		 */
		public static $textdomainpath = '';

		/**
		 * Instance holder
		 *
		 * @since	0.1
		 * @access	private
		 * @static
		 * @var		NULL | Adminimize
		 */
		private static $instance = NULL;

		/**
		 * The plugins Name
		 *
		 * @since 	0.1
		 * @static
		 * @access	public
		 * @var 	string
		 */
		public static $plugin_name = '';

		/**
		 * The plugins plugin_base
		 *
		 * @since 	0.1
		 * @access	public
		 * @static
		 * @var 	string
		 */
		public static $plugin_base_name = '';

		/**
		 * The plugins URL
		 *
		 * @since 	0.1
		 * @access	public
		 * @static
		 * @var 	string
		 */
		public static $plugin_url = '';

		/**
		 * Method for ensuring that only one instance of this object is used
		 *
		 * @since	0.1
		 * @access	public
		 * @static
		 * @return	Adminimize
		 */
		public static function get_instance() {
				
			if ( ! self::$instance )
				self::$instance = new self;
				
			return self::$instance;
		}

		/**
		 * Setting up some data, initialize localization and load
		 * the features
		 *
		 * @since	0.1
		 * @access	public
		 * @return	void
		 */
		public function __construct () {
				
			// Textdomain
			self::$textdomain = $this->get_textdomain();
			// Textdomain Path
			self::$textdomainpath = $this->get_domain_path();
			// Initialize the localization
			$this->load_plugin_textdomain();
				
			// The Plugins Basename
			self::$plugin_base_name = plugin_basename( __FILE__ );
			// The Plugins URL
			self::$plugin_url = $this->get_plugin_header( 'PluginURI' );
			// The Plugins Name
			self::$plugin_name = $this->get_plugin_header( 'Name' );
				
			// Load the features
			$this->load_includes();
			$this->load_features();
			
			// javascript
			//add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
			add_action( 'admin_print_scripts-settings_page_adminimize-2/adminimize' , array( $this, 'register_admin_scripts' ) );
		}

		function register_admin_scripts() {
			
			wp_register_script(
				'adminimize_admin',
				plugins_url( '/js/admin.js', __FILE__ ),
				array( 'jquery' ),
				'1.0'
			);
			wp_enqueue_script( 'adminimize_admin' );
		
		}

		/**
		 * Get a value of the plugin header
		 *
		 * @since	0.1
		 * @access	public
		 * @param	string $value
		 * @uses	get_plugin_data, ABSPATH
		 * @return	string The plugin header value
		 */
		public function get_plugin_header( $value = 'TextDomain' ) {
				
			if ( ! function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_value = $plugin_data[ $value ];

			return $plugin_value;
		}

		/**
		 * Get the Textdomain
		 *
		 * @since	0.1
		 * @access	public
		 * @return	string The plugins textdomain
		 */
		public function get_textdomain() {
				
			return $this->get_plugin_header( 'TextDomain' );
		}

		/**
		 * Get the Textdomain Path where the language files are located
		 *
		 * @since	0.1
		 * @access	public
		 * @return	string The plugins textdomain path
		 */
		public function get_domain_path() {
				
			return $this->get_plugin_header( 'DomainPath' );
		}

		public function get_plugin_basename() {
			return self::$plugin_base_name;
		}

		/**
		 * Load the localization
		 *
		 * @since	0.1
		 * @access	public
		 * @uses	load_plugin_textdomain, plugin_basename
		 * @return	void
		 */
		public function load_plugin_textdomain() {
				
			load_plugin_textdomain( self::$textdomain, FALSE, dirname( plugin_basename( __FILE__ ) ) . self::$textdomainpath );
		}

		public function is_active_for_multisite() {
			
			return is_multisite() && is_plugin_active_for_network( self::$plugin_base_name );
		}

		/**
		 * Autoloads all files in $dir subdirectory
		 * 
		 * @param  string $dir name of plugin subdirectory
		 * @return void
		 */
		private function autoload_subdirectory( $dir ) {
			
			// load all files with the pattern *.php from the $dir directory
			foreach( glob( dirname( __FILE__ ) . '/' . $dir . '/*.php' ) as $file )
				require_once $file;
		}

		/**
		 * Autoloads all files in "/inc" subdirectory
		 * @return void
		 */
		protected function load_includes() {
			
			$this->autoload_subdirectory( 'inc' );
		}

		/**
		 * Autoloads all files in "/features" subdirectory
		 *
		 * @since	0.1
		 * @access	protected
		 * @return	void
		 */
		protected function load_features() {
			
			$this->autoload_subdirectory( 'features' );
		}
	}

	if ( ! function_exists( 'p' ) ) {
		/**
		 * This helper function outputs a given string,
		 * object or array
		 *
		 * @since	0.1
		 * @param 	mixed $output
		 * @return	void
		 */
		function p( $output ) {
				
			print '<br /><br /><br /><pre>';
			print_r( $output );
			print '</pre>';
		}
	}
}