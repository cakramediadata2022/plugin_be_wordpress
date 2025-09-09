<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cakrasoft.com/
 * @since      1.0.0
 *
 * @package    CKH_Booking_Engine
 * @subpackage CKH_Booking_Engine/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    CKH_Booking_Engine
 * @subpackage CKH_Booking_Engine/includes
 * @author     cakrasoft <info@cakrasoft.com>
 */
class CKH_Booking_Engine
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      CKH_Booking_Engine_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $ckh_booking_engine    The string used to uniquely identify this plugin.
     */
    protected $ckh_booking_engine;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * The API URL for the booking engine.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $api_url    The API URL for all booking engine operations.
     */
    public static $api_url = 'https://chsres.com/api/plugin/v1';

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('CKH_BOOKING_ENGINE_VERSION')) {
            $this->version = CKH_BOOKING_ENGINE_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->ckh_booking_engine = 'ckh-booking-engine';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - CKH_Booking_Engine_Loader. Orchestrates the hooks of the plugin.
     * - CKH_Booking_Engine_i18n. Defines internationalization functionality.
     * - CKH_Booking_Engine_Admin. Defines all hooks for the admin area.
     * - CKH_Booking_Engine_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ckh-booking-engine-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ckh-booking-engine-i18n.php';

        /**
         * The class responsible for handling plugin settings.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ckh-booking-engine-settings.php';

        /**
         * The test file for debugging settings (remove in production).
         */
        if (defined('WP_DEBUG') && WP_DEBUG) {
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ckh-booking-engine-test.php';
        }

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-ckh-booking-engine-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-ckh-booking-engine-public.php';

        $this->loader = new CKH_Booking_Engine_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the CKH_Booking_Engine_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new CKH_Booking_Engine_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new CKH_Booking_Engine_Admin($this->get_ckh_booking_engine(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        // Add admin menu and settings
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'init_settings');

        // Add admin notices
        $this->loader->add_action('admin_notices', $plugin_admin, 'admin_notices');

        // Add AJAX handlers
        $this->loader->add_action('wp_ajax_test_api_connection', $plugin_admin, 'ajax_test_api_connection');

        // Add settings link to plugin page
        $plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->ckh_booking_engine . '.php');
        $this->loader->add_filter("plugin_action_links_$plugin_basename", $plugin_admin, 'add_settings_link');
    }
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new CKH_Booking_Engine_Public($this->get_ckh_booking_engine(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_ckh_booking_engine()
    {
        return $this->ckh_booking_engine;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    CKH_Booking_Engine_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Get the API URL for the booking engine.
     *
     * @since     1.0.0
     * @return    string    The API URL for booking engine operations.
     */
    public static function get_api_url()
    {
        return self::$api_url;
    }

    /**
     * Test API connection
     *
     * @since     1.0.0
     * @param     string    $api_key    The API key to test
     * @return    array     Response array with success status and message
     */
    public static function test_api_connection($api_key = null)
    {
        // Get API key from parameter or settings
        if (empty($api_key)) {
            $api_key = CKH_Booking_Engine_Settings::get_setting('api_key');
        }

        // Check if API key is provided
        if (empty($api_key)) {
            return array(
                'success' => false,
                'message' => 'API key is required for testing connection.',
                'error_code' => 'missing_api_key'
            );
        }

        // Prepare the test endpoint
        $test_url = self::get_api_url() . '/test';

        // Get the current site URL for Origin header
        $site_url = get_site_url();
        $site_domain = parse_url($site_url, PHP_URL_HOST);
        $site_scheme = parse_url($site_url, PHP_URL_SCHEME);
        $site_port = parse_url($site_url, PHP_URL_PORT);

        // Construct the origin URL
        $origin_url = $site_scheme . '://' . $site_domain;
        if ($site_port && !in_array($site_port, [80, 443])) {
            $origin_url .= ':' . $site_port;
        }

        // Prepare request arguments with explicit Origin header
        $args = array(
            'method' => 'GET',
            'timeout' => 30,
            'headers' => array(
                'token' => $api_key,
                'Content-Type' => 'application/json',
                'User-Agent' => 'CKH-Booking-Engine-Plugin/' . CKH_BOOKING_ENGINE_VERSION,
                'Origin' => $origin_url,
                'Referer' => $site_url,
                'X-Requested-With' => 'XMLHttpRequest'
            )
        );

        // Make the HTTP request
        $response = wp_remote_request($test_url, $args);

        // Check for WP errors
        if (is_wp_error($response)) {
            return array(
                'success' => false,
                'message' => 'Connection failed: ' . $response->get_error_message(),
                'error_code' => 'connection_error'
            );
        }

        // Get response code and body
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        // Parse JSON response
        $data = json_decode($response_body, true);

        // Handle different response codes
        switch ($response_code) {
            case 200:
                return array(
                    'success' => true,
                    'message' => 'API connection successful! Your API key is valid.',
                    'data' => $data,
                    'debug_info' => array(
                        'origin' => $origin_url,
                        'site_url' => $site_url,
                        'test_url' => $test_url,
                        'headers_sent' => $args['headers']
                    )
                );

            case 401:
                return array(
                    'success' => false,
                    'message' => 'Invalid API key. Please check your API key and try again.',
                    'error_code' => 'invalid_api_key',
                    'debug_info' => array(
                        'origin' => $origin_url,
                        'site_url' => $site_url,
                        'test_url' => $test_url,
                        'headers_sent' => $args['headers']
                    )
                );

            case 403:
                return array(
                    'success' => false,
                    'message' => 'Access forbidden. Your domain (' . $origin_url . ') may not be authorized for this API key.',
                    'error_code' => 'access_forbidden',
                    'debug_info' => array(
                        'origin' => $origin_url,
                        'site_url' => $site_url,
                        'test_url' => $test_url,
                        'headers_sent' => $args['headers']
                    )
                );

            case 404:
                return array(
                    'success' => false,
                    'message' => 'API endpoint not found. Please contact support.',
                    'error_code' => 'endpoint_not_found',
                    'debug_info' => array(
                        'origin' => $origin_url,
                        'test_url' => $test_url
                    )
                );

            case 429:
                return array(
                    'success' => false,
                    'message' => 'Too many requests. Please wait a moment and try again.',
                    'error_code' => 'rate_limit_exceeded'
                );

            case 500:
            case 502:
            case 503:
                return array(
                    'success' => false,
                    'message' => 'Server error. Please try again later or contact support.',
                    'error_code' => 'server_error'
                );

            default:
                return array(
                    'success' => false,
                    'message' => 'Unexpected response from API (HTTP ' . $response_code . '). Please contact support.',
                    'error_code' => 'unexpected_response',
                    'response_code' => $response_code,
                    'debug_info' => array(
                        'origin' => $origin_url,
                        'site_url' => $site_url,
                        'test_url' => $test_url,
                        'headers_sent' => $args['headers'],
                        'response_body' => $response_body
                    )
                );
        }
    }
}
