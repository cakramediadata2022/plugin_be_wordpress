<?php

/**
 * The settings helper class for the plugin.
 *
 * @link       https://cakrasoft.com/
 * @since      1.0.0
 *
 * @package    CKH_Booking_Engine
 * @subpackage CKH_Booking_Engine/includes
 */

/**
 * The settings helper class.
 *
 * This class provides easy access to plugin settings throughout the plugin.
 * It includes default values and helper methods for getting and setting options.
 *
 * @since      1.0.0
 * @package    CKH_Booking_Engine
 * @subpackage CKH_Booking_Engine/includes
 * @author     cakrasoft <info@cakrasoft.com>
 */
class CKH_Booking_Engine_Settings
{
    /**
     * The option name in the database
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $option_name    The option name.
     */
    private static $option_name = 'ckh_booking_engine_options';

    /**
     * Default settings
     *
     * @since    1.0.0
     * @access   private
     * @var      array    $defaults    Default settings array.
     */
    private static $defaults = array(
        'api_key' => '',
        'callback_url' => 'https://cakrasoft.net/confirmation-payment',
        'primary_color' => '#007cba',
        'secondary_color' => '#f0f0f1',
        'accent_color' => '#ff6900',
        'button_color' => '#007cba',
        'button_text_color' => '#ffffff',
        'font_family' => 'inherit',
        'font_size' => 14,
        'border_radius' => 4,
    );

    /**
     * Get all settings
     *
     * @since    1.0.0
     * @return   array    The settings array with defaults merged.
     */
    public static function get_settings()
    {
        $settings = get_option(self::$option_name, array());
        return wp_parse_args($settings, self::$defaults);
    }

    /**
     * Get a specific setting
     *
     * @since    1.0.0
     * @param    string    $key        The setting key.
     * @param    mixed     $default    Default value if setting doesn't exist.
     * @return   mixed     The setting value or default.
     */
    public static function get_setting($key, $default = null)
    {
        $settings = self::get_settings();

        if (isset($settings[$key])) {
            return $settings[$key];
        }

        // Return provided default or fall back to class default
        if ($default !== null) {
            return $default;
        }

        return isset(self::$defaults[$key]) ? self::$defaults[$key] : null;
    }

    /**
     * Update a specific setting
     *
     * @since    1.0.0
     * @param    string    $key      The setting key.
     * @param    mixed     $value    The setting value.
     * @return   bool      True if successful, false otherwise.
     */
    public static function update_setting($key, $value)
    {
        $settings = self::get_settings();
        $settings[$key] = $value;
        return update_option(self::$option_name, $settings);
    }

    /**
     * Update multiple settings
     *
     * @since    1.0.0
     * @param    array     $new_settings    Array of settings to update.
     * @return   bool      True if successful, false otherwise.
     */
    public static function update_settings($new_settings)
    {
        $settings = self::get_settings();
        $settings = array_merge($settings, $new_settings);
        return update_option(self::$option_name, $settings);
    }

    /**
     * Get API settings
     *
     * @since    1.0.0
     * @return   array    API settings (api_key, api_url).
     */
    public static function get_api_settings()
    {
        return array(
            'api_key' => self::get_setting('api_key'),
            'api_url' => CKH_Booking_Engine::get_api_url(),
        );
    }

    /**
     * Get appearance settings
     *
     * @since    1.0.0
     * @return   array    Appearance settings (colors, border_radius).
     */
    public static function get_appearance_settings()
    {
        return array(
            'primary_color' => self::get_setting('primary_color'),
            'secondary_color' => self::get_setting('secondary_color'),
            'accent_color' => self::get_setting('accent_color'),
            'button_color' => self::get_setting('button_color'),
            'button_text_color' => self::get_setting('button_text_color'),
            'border_radius' => self::get_setting('border_radius'),
        );
    }

    /**
     * Get typography settings
     *
     * @since    1.0.0
     * @return   array    Typography settings (font_family, font_size).
     */
    public static function get_typography_settings()
    {
        return array(
            'font_family' => self::get_setting('font_family'),
            'font_size' => self::get_setting('font_size'),
        );
    }

    /**
     * Generate CSS variables from settings
     *
     * @since    1.0.0
     * @return   string   CSS custom properties.
     */
    public static function get_css_variables()
    {
        $settings = self::get_settings();

        $css = ':root {';
        $css .= '--ckh-primary-color: ' . $settings['primary_color'] . ';';
        $css .= '--ckh-secondary-color: ' . $settings['secondary_color'] . ';';
        $css .= '--ckh-accent-color: ' . $settings['accent_color'] . ';';
        $css .= '--ckh-button-color: ' . $settings['button_color'] . ';';
        $css .= '--ckh-button-text-color: ' . $settings['button_text_color'] . ';';
        $css .= '--ckh-font-family: ' . $settings['font_family'] . ';';
        $css .= '--ckh-font-size: ' . $settings['font_size'] . 'px;';
        $css .= '--ckh-border-radius: ' . $settings['border_radius'] . 'px;';
        $css .= '}';

        return $css;
    }

    /**
     * Check if API is configured
     *
     * @since    1.0.0
     * @return   bool     True if API key and URL are set.
     */
    public static function is_api_configured()
    {
        $api_key = self::get_setting('api_key');
        $api_url = CKH_Booking_Engine::get_api_url();

        return !empty($api_key) && !empty($api_url);
    }

    /**
     * Get settings for JavaScript
     *
     * @since    1.0.0
     * @return   array    Settings array formatted for JS.
     */
    public static function get_js_settings()
    {
        $settings = self::get_settings();

        return array(
            'apiKey' => $settings['api_key'],
            'apiUrl' => CKH_Booking_Engine::get_api_url(),
            'colors' => array(
                'primary' => $settings['primary_color'],
                'secondary' => $settings['secondary_color'],
                'accent' => $settings['accent_color'],
                'button' => $settings['button_color'],
                'buttonText' => $settings['button_text_color'],
            ),
            'typography' => array(
                'fontFamily' => $settings['font_family'],
                'fontSize' => $settings['font_size'],
            ),
            'borderRadius' => $settings['border_radius'],
        );
    }

    /**
     * Reset settings to defaults
     *
     * @since    1.0.0
     * @return   bool     True if successful, false otherwise.
     */
    public static function reset_settings()
    {
        return update_option(self::$option_name, self::$defaults);
    }

    /**
     * Delete all settings
     *
     * @since    1.0.0
     * @return   bool     True if successful, false otherwise.
     */
    public static function delete_settings()
    {
        return delete_option(self::$option_name);
    }

    /**
     * Validate and sanitize settings
     *
     * @since    1.0.0
     * @param    array     $settings    Raw settings array.
     * @return   array     Sanitized settings array.
     */
    public static function sanitize_settings($settings)
    {
        $sanitized = array();

        // API Key
        if (isset($settings['api_key'])) {
            $sanitized['api_key'] = sanitize_text_field($settings['api_key']);
        }

        // Callback URL
        if (isset($settings['callback_url'])) {
            $callback_url = trim($settings['callback_url']);

            // If empty, use default
            if (empty($callback_url)) {
                $callback_url = self::$defaults['callback_url'];
            } else {
                // Sanitize the URL but be more permissive
                $callback_url = esc_url_raw($callback_url);

                // Only fall back to default if sanitization completely failed
                if (empty($callback_url)) {
                    $callback_url = self::$defaults['callback_url'];
                }
            }
            $sanitized['callback_url'] = $callback_url;
        } else {
            // If not set at all, use default
            $sanitized['callback_url'] = self::$defaults['callback_url'];
        }

        // Colors
        $color_fields = array('primary_color', 'secondary_color', 'accent_color', 'button_color', 'button_text_color');
        foreach ($color_fields as $field) {
            if (isset($settings[$field])) {
                $sanitized[$field] = sanitize_hex_color($settings[$field]);
            }
        }

        // Font Family
        if (isset($settings['font_family'])) {
            $sanitized['font_family'] = sanitize_text_field($settings['font_family']);
        }

        // Font Size (ensure it's within reasonable range)
        if (isset($settings['font_size'])) {
            $font_size = absint($settings['font_size']);
            $sanitized['font_size'] = ($font_size >= 10 && $font_size <= 24) ? $font_size : 14;
        }

        // Border Radius (ensure it's within reasonable range)
        if (isset($settings['border_radius'])) {
            $border_radius = absint($settings['border_radius']);
            $sanitized['border_radius'] = ($border_radius >= 0 && $border_radius <= 20) ? $border_radius : 4;
        }

        return $sanitized;
    }
}
