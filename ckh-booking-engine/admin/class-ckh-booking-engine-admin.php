<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cakrasoft.com/
 * @since      1.0.0
 *
 * @package    CKH_Booking_Engine
 * @subpackage CKH_Booking_Engine/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CKH_Booking_Engine
 * @subpackage CKH_Booking_Engine/admin
 * @author     cakrasoft <info@cakrasoft.com>
 */
class CKH_Booking_Engine_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $ckh_booking_engine    The ID of this plugin.
	 */
	private $ckh_booking_engine;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $ckh_booking_engine       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($ckh_booking_engine, $version)
	{

		$this->ckh_booking_engine = $ckh_booking_engine;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CKH_Booking_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CKH_Booking_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->ckh_booking_engine, plugin_dir_url(__FILE__) . 'css/ckh-booking-engine-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CKH_Booking_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CKH_Booking_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->ckh_booking_engine, plugin_dir_url(__FILE__) . 'js/ckh-booking-engine-admin.js', array('jquery'), $this->version, false);
	}
}
