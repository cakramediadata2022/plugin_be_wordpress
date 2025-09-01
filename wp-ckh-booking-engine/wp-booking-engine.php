<?php
/*

Plugin Name: CKH Booking Engine
Description: A powerful booking engine plugin for WordPress.
Version: 0.1.0
Author: PT. Cakra Media Data (Cakrasoft)
Copyright: (C) 2025 PT. Cakra Media Data (Cakrasoft)
Address: JL. Abdul Kudus Perumahan Barombong Permai C5 Kel. Tamalate Kec. Barombong 90225
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

// Define plugin path

if (! defined('CKHBE_PLUGIN_DIR')) {
    define('CKHBE_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

// Include main plugin class
require_once CKHBE_PLUGIN_DIR . 'includes/class-wpbe-main.php';

// Activation and deactivation hooks
register_activation_hook(__FILE__, array('CKHBE_Main', 'activate'));
register_deactivation_hook(__FILE__, array('CKHBE_Main', 'deactivate'));

// Initialize plugin
add_action('plugins_loaded', array('CKHBE_Main', 'get_instance'));
