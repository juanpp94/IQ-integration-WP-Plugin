<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://juan.com
 * @since             1.0.0
 * @package           Iq_I
 *
 * @wordpress-plugin
 * Plugin Name:       IntegracionIQ
 * Plugin URI:        https://iqtsystems.com
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Juan 
 * Author URI:        https://juan.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iq-i
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IQ_I_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-iq-i-activator.php
 */
function activate_iq_i() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iq-i-activator.php';
	Iq_I_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-iq-i-deactivator.php
 */
function deactivate_iq_i() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iq-i-deactivator.php';
	Iq_I_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_iq_i' );
register_deactivation_hook( __FILE__, 'deactivate_iq_i' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-iq-i.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_iq_i() {

	$plugin = new Iq_I();
	$plugin->run();

}
run_iq_i();
