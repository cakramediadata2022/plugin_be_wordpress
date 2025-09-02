<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cakrasoft.com
 * @since             1.0.0
 * @package           CKH_Booking_Engine
 *
 * @wordpress-plugin
 * Plugin Name:       CKH Booking Engine
 * Plugin URI:        https://cakrasoft.com/ckh-booking-engine/
 * Description:       Booking engine plugin by cakrasoft.
 * Version:           1.0.0
 * Author:            cakrasoft
 * Author URI:        https://cakrasoft.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ckh-booking-engine
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('CKH_BOOKING_ENGINE_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ckh-booking-engine-activator.php
 */
function activate_ckh_booking_engine()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-ckh-booking-engine-activator.php';
	CKH_Booking_Engine_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ckh-booking-engine-deactivator.php
 */
function deactivate_ckh_booking_engine()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-ckh-booking-engine-deactivator.php';
	CKH_Booking_Engine_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_ckh_booking_engine');
register_deactivation_hook(__FILE__, 'deactivate_ckh_booking_engine');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-ckh-booking-engine.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ckh_booking_engine()
{
	$plugin = new CKH_Booking_Engine();
	$plugin->run();
}
run_ckh_booking_engine();
