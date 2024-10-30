<?php
namespace HooAddons;
use HooAddons\Classes\Helper;
use HooAddons\Classes\Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {

    /**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;
    /**
	 * Plugin constructor.
	 *
	 * Initializing HooAddons plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 */
    private function __construct() {
        
		$this->register_autoloader();
        Helper::get_instance();
        Elements::get_instance()->init();
        
	}

    /**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			do_action( 'hooaddons/loaded' );
		}

		return self::$instance;
	}
    /**
	 * Register autoloader.
	 *
	 * @since 1.0.0
	 * @access private
	 */
    private function register_autoloader() {
		require_once HOO_ADDONS_DIR . 'includes/autoloader.php';
		Autoloader::run();
	}
}

Plugin::instance();
