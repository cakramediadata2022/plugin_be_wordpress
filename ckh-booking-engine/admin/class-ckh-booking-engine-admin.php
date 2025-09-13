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

		wp_enqueue_style($this->ckh_booking_engine, plugin_dir_url(__FILE__) . 'css/ckh_booking_engine-admin.css', array(), $this->version, 'all');

		// Enqueue color picker CSS
		wp_enqueue_style('wp-color-picker');
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

		// Localize script for AJAX
		wp_localize_script($this->ckh_booking_engine, 'ckhBookingEngineAdmin', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ckh_booking_engine_nonce')
		));

		// Enqueue color picker
		wp_enqueue_script('wp-color-picker');
	}

	/**
	 * Add admin menu
	 *
	 * @since    1.0.0
	 */
	public function add_admin_menu()
	{
		add_options_page(
			'CKH Booking Engine Settings',
			'CKH Booking Engine',
			'manage_options',
			'ckh-booking-engine',
			array($this, 'admin_page_display')
		);
	}

	/**
	 * Display admin notices
	 *
	 * @since    1.0.0
	 */
	public function display_admin_notices()
	{
		// Only show notices on our settings page
		$screen = get_current_screen();
		if (!$screen || $screen->id !== 'settings_page_ckh-booking-engine') {
			return;
		}

		// Check for API test result
		$api_test_result = get_transient('ckh_booking_engine_api_test_result');
		if ($api_test_result) {
			// Delete the transient
			delete_transient('ckh_booking_engine_api_test_result');

			$notice_class = $api_test_result['success'] ? 'notice-success' : 'notice-error';
			echo '<div class="notice ' . esc_attr($notice_class) . ' is-dismissible">';
			echo '<p><strong>API Connection Test:</strong> ' . esc_html($api_test_result['message']) . '</p>';
			echo '</div>';
		}

		// Check API connection status on page load
		$this->check_api_status_on_load();
	}

	/**
	 * Check API status when loading the settings page
	 *
	 * @since    1.0.0
	 */
	private function check_api_status_on_load()
	{
		$current_settings = get_option('ckh_booking_engine_options', array());
		$api_key = isset($current_settings['api_key']) ? $current_settings['api_key'] : '';

		if (!empty($api_key)) {
			// Check if we've tested this API key recently (avoid repeated tests)
			$last_test_result = get_transient('ckh_booking_engine_api_status_' . md5($api_key));

			if ($last_test_result === false) {
				// Test the API connection
				$api_test_result = CKH_Booking_Engine::test_api_connection($api_key);

				// Store result for 5 minutes to avoid repeated tests
				set_transient('ckh_booking_engine_api_status_' . md5($api_key), $api_test_result, 300);

				// Show the result
				$notice_class = $api_test_result['success'] ? 'notice-info' : 'notice-warning';
				echo '<div class="notice ' . esc_attr($notice_class) . '">';
				echo '<p><strong>Current API Status:</strong> ' . esc_html($api_test_result['message']) . '</p>';
				echo '</div>';
			} else {
				// Show cached result if it's an error
				if (!$last_test_result['success']) {
					echo '<div class="notice notice-warning">';
					echo '<p><strong>Current API Status:</strong> ' . esc_html($last_test_result['message']) . '</p>';
					echo '</div>';
				}
			}
		} else {
			// No API key configured
			echo '<div class="notice notice-warning">';
			echo '<p><strong>API Configuration:</strong> Please configure your API key to enable booking functionality.</p>';
			echo '</div>';
		}
	}

	/**
	 * Display admin page
	 *
	 * @since    1.0.0
	 */
	public function admin_page_display()
	{
		include_once plugin_dir_path(__FILE__) . 'partials/ckh-booking-engine-admin-display.php';
	}

	/**
	 * Initialize settings
	 *
	 * @since    1.0.0
	 */
	public function init_settings()
	{
		// Register settings group - this is what saves to the database
		register_setting(
			'ckh_booking_engine_settings',      // Options group
			'ckh_booking_engine_options',       // Option name (database key)
			array($this, 'sanitize_settings')   // Sanitization callback
		);
	}

	/**
	 * Sanitize settings
	 *
	 * @since    1.0.0
	 */
	public function sanitize_settings($input)
	{
		$sanitized = array();
		$api_test_result = null;

		if (isset($input['api_key'])) {
			$sanitized['api_key'] = sanitize_text_field($input['api_key']);

			// Test API connection if API key is provided and changed
			if (!empty($sanitized['api_key'])) {
				$current_settings = get_option('ckh_booking_engine_options', array());
				$current_api_key = isset($current_settings['api_key']) ? $current_settings['api_key'] : '';

				// Test connection if API key is new or changed
				if ($sanitized['api_key'] !== $current_api_key) {
					$api_test_result = CKH_Booking_Engine::test_api_connection($sanitized['api_key']);

					// Store the test result in a transient to show in admin notice
					set_transient('ckh_booking_engine_api_test_result', $api_test_result, 60);
				}
			}
		}

		// Handle callback URL
		if (isset($input['callback_url'])) {
			$callback_url = trim($input['callback_url']);

			// If empty, use default
			if (empty($callback_url)) {
				$sanitized['callback_url'] = 'https://cakrasoft.net/confirmation-payment';
			} else {
				// Sanitize the URL
				$sanitized['callback_url'] = esc_url_raw($callback_url);

				// If sanitization failed, use default
				if (empty($sanitized['callback_url'])) {
					$sanitized['callback_url'] = 'https://cakrasoft.net/confirmation-payment';
				}
			}
		} else {
			// If not provided, use default
			$sanitized['callback_url'] = 'https://cakrasoft.net/confirmation-payment';
		}

		if (isset($input['primary_color'])) {
			$sanitized['primary_color'] = sanitize_hex_color($input['primary_color']);
		}

		if (isset($input['secondary_color'])) {
			$sanitized['secondary_color'] = sanitize_hex_color($input['secondary_color']);
		}

		if (isset($input['accent_color'])) {
			$sanitized['accent_color'] = sanitize_hex_color($input['accent_color']);
		}

		if (isset($input['button_color'])) {
			$sanitized['button_color'] = sanitize_hex_color($input['button_color']);
		}

		if (isset($input['button_text_color'])) {
			$sanitized['button_text_color'] = sanitize_hex_color($input['button_text_color']);
		}

		if (isset($input['font_family'])) {
			$sanitized['font_family'] = sanitize_text_field($input['font_family']);
		}

		if (isset($input['font_size'])) {
			$sanitized['font_size'] = absint($input['font_size']);
		}

		if (isset($input['border_radius'])) {
			$sanitized['border_radius'] = absint($input['border_radius']);
		}

		return $sanitized;
	}

	/**
	 * Add an admin notice when settings are saved
	 *
	 * @since    1.0.0
	 */
	public function admin_notices()
	{
		// Call our main admin notices function
		$this->display_admin_notices();

		// Show settings saved notice
		if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
			echo '<div class="notice notice-success is-dismissible">';
			echo '<p><strong>CKH Booking Engine settings saved successfully!</strong></p>';
			echo '</div>';
		}
	}

	/**
	 * Add settings link to plugin page
	 *
	 * @since    1.0.0
	 */
	public function add_settings_link($links)
	{
		$settings_link = '<a href="' . admin_url('options-general.php?page=ckh-booking-engine') . '">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/**
	 * AJAX handler for API connection test
	 *
	 * @since    1.0.0
	 */
	public function ajax_test_api_connection()
	{
		// Verify nonce
		if (!wp_verify_nonce($_POST['nonce'], 'ckh_booking_engine_nonce')) {
			wp_die('Security check failed');
		}

		// Check user permissions
		if (!current_user_can('manage_options')) {
			wp_die('Insufficient permissions');
		}

		// Get API key from request
		$api_key = sanitize_text_field($_POST['api_key']);

		// Test the API connection
		$result = CKH_Booking_Engine::test_api_connection($api_key);

		// Return the result
		wp_send_json_success($result);
	}
}
