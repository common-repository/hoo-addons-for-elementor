<?php
/*
Plugin Name: Hoo Addons for Elementor
Plugin URI:
Description: Hoo Addons for Elementor is a free addon to supercharge the functionality of your Elementor page builder. All these elements are highly customizable and contains separate settings. You can simply drag and drop any elements on the editor and start the customization to add them on your website. Hoo Addons for Elementor plugin includes essential widgets and addons like Accordion, Alert, Audio playlist, Chart Bar, Dropcap, Fancy Flipbox and much more.
Version: 1.0.6
Author: Hoosoft
Author URI: https://www.hoosoft.com
License: GPLv2 or later
Text Domain: hoo-addons-for-elementor
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$plugin_version = $plugin_data['Version'];
define( 'HOO_ADDONS_URL', plugins_url( '/', __FILE__  ) );
define( 'HOO_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
define( 'HOO_ADDONS_INCLUDE_DIR', HOO_ADDONS_DIR . 'includes/' );
define( 'HOO_ADDONS_VERSION', $plugin_version );

require_once HOO_ADDONS_DIR . 'includes/plugin.php';