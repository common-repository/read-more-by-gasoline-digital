<?php
/**
 * Plugin Name:	Read More by Gasoline.Digital
 * Version: 	1.1.2
 * Plugin URI: 	http://www.gasoline.digital
 * Description:	Just another read more plugin. Simple but flexible.
 * Author: 		Wilson Cavalcante
 * Author URI: 	http://www.wilnaweb.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Requires at least: 5.0
 * Tested up to: 5.6
 *
 * Text Domain: gd-read-more
 * Domain Path: /languages/
 *
 * @package Wpgdrm
 * @author Wilson Cavalcante <hello@gasoline.digital>
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WPGDRM_VERSION', '1.1.2' );

define( 'WPGDRM_REQUIRED_WP_VERSION', '4.9' );

define( 'WPGDRM_TXT_DOMAIN', 'gd-read-more' );

define( 'WPGDRM_PLUGIN', __FILE__ );

define( 'WPGDRM_PLUGIN_BASENAME', plugin_basename( WPGDRM_PLUGIN ) );

define( 'WPGDRM_PLUGIN_NAME', trim( dirname( WPGDRM_PLUGIN_BASENAME ), '/' ) );

define( 'WPGDRM_PLUGIN_DIR', untrailingslashit( dirname( WPGDRM_PLUGIN ) ) );

define( 'WPGDRM_PLUGIN_URL',untrailingslashit( plugins_url( '', WPGDRM_PLUGIN ) ) );

/**
 * The code that runs during plugin activation.
 */
function wpgdrm_activate() {
	require_once WPGDRM_PLUGIN_DIR. '/includes/class-wpgdrm-activator.php';
	Wpgdrm_Activator::activate();
}
register_activation_hook( __FILE__, 'wpgdrm_activate' );

/**
 * The code that runs during plugin deactivation.
 */
function wpgdrm_deactivate() {
	require_once WPGDRM_PLUGIN_DIR. '/includes/class-wpgdrm-deactivator.php';
	Wpgdrm_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'wpgdrm_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require WPGDRM_PLUGIN_DIR . '/includes/class-wpgdrm.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
function run_wpgdrm() {
	$plugin = new Wpgdrm();
	$plugin->run();
}
run_wpgdrm();