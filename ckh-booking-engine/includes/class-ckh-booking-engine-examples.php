<?php

/**
 * Example usage of CKH Booking Engine Settings
 * 
 * This file demonstrates how to use the global settings throughout your plugin.
 * You can use these examples in your own custom code.
 */

// Prevent direct access
if (!defined('WPINC')) {
    die;
}

/**
 * Example: Get all settings
 */
function example_get_all_settings()
{
    $all_settings = CKH_Booking_Engine_Settings::get_settings();
    return $all_settings;
}

/**
 * Example: Get a specific setting
 */
function example_get_primary_color()
{
    $primary_color = CKH_Booking_Engine_Settings::get_setting('primary_color');
    return $primary_color; // Returns '#007cba' or custom value
}

/**
 * Example: Get API settings for making API calls
 */
function example_make_api_call()
{
    $api_settings = CKH_Booking_Engine_Settings::get_api_settings();

    if (!CKH_Booking_Engine_Settings::is_api_configured()) {
        return new WP_Error('api_not_configured', 'API key and URL must be configured');
    }

    $api_key = $api_settings['api_key'];
    $api_url = $api_settings['api_url'];

    // Make your API call here
    $response = wp_remote_get($api_url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json',
        ),
    ));

    return $response;
}

/**
 * Example: Apply settings to custom HTML output
 */
function example_custom_booking_widget()
{
    $appearance = CKH_Booking_Engine_Settings::get_appearance_settings();
    $typography = CKH_Booking_Engine_Settings::get_typography_settings();

    $style = sprintf(
        'background-color: %s; color: %s; font-family: %s; font-size: %spx; border-radius: %spx;',
        $appearance['button_color'],
        $appearance['button_text_color'],
        $typography['font_family'],
        $typography['font_size'],
        $appearance['border_radius']
    );

    return sprintf(
        '<button class="ckh-booking-button" style="%s">Book Now</button>',
        esc_attr($style)
    );
}

/**
 * Example: Update a setting programmatically
 */
function example_update_setting()
{
    $success = CKH_Booking_Engine_Settings::update_setting('primary_color', '#ff0000');
    return $success;
}

/**
 * Example: Use settings in a shortcode
 */
function example_booking_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'type' => 'button',
        'text' => 'Book Now',
    ), $atts);

    $settings = CKH_Booking_Engine_Settings::get_settings();

    if ($atts['type'] === 'button') {
        return sprintf(
            '<button class="ckh-booking-button" style="background-color: %s; color: %s; border-radius: %spx;">%s</button>',
            esc_attr($settings['button_color']),
            esc_attr($settings['button_text_color']),
            esc_attr($settings['border_radius']),
            esc_html($atts['text'])
        );
    }

    return '';
}
add_shortcode('ckh_booking_button', 'example_booking_shortcode');

/**
 * Example: Enqueue custom CSS with settings
 */
function example_enqueue_custom_styles()
{
    $settings = CKH_Booking_Engine_Settings::get_settings();

    $custom_css = "
        .ckh-custom-widget {
            background-color: {$settings['primary_color']};
            color: {$settings['button_text_color']};
            font-family: {$settings['font_family']};
            font-size: {$settings['font_size']}px;
            border-radius: {$settings['border_radius']}px;
            border: 2px solid {$settings['accent_color']};
        }
        
        .ckh-custom-widget:hover {
            background-color: {$settings['accent_color']};
        }
    ";

    wp_add_inline_style('ckh-booking-engine-public', $custom_css);
}
add_action('wp_enqueue_scripts', 'example_enqueue_custom_styles');

/**
 * Example: Use settings in AJAX handler
 */
function example_ajax_booking_handler()
{
    // Verify nonce
    check_ajax_referer('ckh_booking_nonce', 'nonce');

    $api_settings = CKH_Booking_Engine_Settings::get_api_settings();

    if (!CKH_Booking_Engine_Settings::is_api_configured()) {
        wp_send_json_error('API not configured');
    }

    // Process booking with API settings
    $booking_data = array(
        'check_in' => sanitize_text_field($_POST['check_in']),
        'check_out' => sanitize_text_field($_POST['check_out']),
        'guests' => intval($_POST['guests']),
    );

    // Make API call using settings
    $response = wp_remote_post($api_settings['api_url'] . '/bookings', array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_settings['api_key'],
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode($booking_data),
    ));

    if (is_wp_error($response)) {
        wp_send_json_error('Booking failed');
    }

    wp_send_json_success('Booking created');
}
add_action('wp_ajax_ckh_create_booking', 'example_ajax_booking_handler');
add_action('wp_ajax_nopriv_ckh_create_booking', 'example_ajax_booking_handler');

/**
 * Example: Check if plugin is properly configured
 */
function example_check_plugin_configuration()
{
    if (!CKH_Booking_Engine_Settings::is_api_configured()) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p>';
            echo 'CKH Booking Engine: Please configure your API settings in ';
            echo '<a href="' . admin_url('options-general.php?page=ckh-booking-engine') . '">Settings</a>';
            echo '</p></div>';
        });
    }
}
add_action('admin_init', 'example_check_plugin_configuration');

/**
 * Example: Export settings for backup
 */
function example_export_settings()
{
    $settings = CKH_Booking_Engine_Settings::get_settings();

    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="ckh-booking-engine-settings.json"');

    echo json_encode($settings, JSON_PRETTY_PRINT);
    exit;
}

/**
 * Example: Import settings from backup
 */
function example_import_settings($settings_json)
{
    $settings = json_decode($settings_json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error('invalid_json', 'Invalid JSON format');
    }

    $sanitized_settings = CKH_Booking_Engine_Settings::sanitize_settings($settings);
    $success = CKH_Booking_Engine_Settings::update_settings($sanitized_settings);

    if ($success) {
        return true;
    } else {
        return new WP_Error('update_failed', 'Failed to update settings');
    }
}

/**
 * Example: Use settings in a custom post type
 */
function example_booking_post_meta_box()
{
    $settings = CKH_Booking_Engine_Settings::get_settings();

    echo '<div style="background-color: ' . esc_attr($settings['secondary_color']) . '; padding: 15px; border-radius: ' . esc_attr($settings['border_radius']) . 'px;">';
    echo '<h4 style="color: ' . esc_attr($settings['primary_color']) . ';">Booking Details</h4>';
    echo '<p>Configure booking details using the global plugin settings.</p>';
    echo '</div>';
}

/**
 * Example: Use settings in email templates
 */
function example_booking_confirmation_email($booking_id)
{
    $settings = CKH_Booking_Engine_Settings::get_settings();

    $email_style = sprintf(
        'font-family: %s; font-size: %spx; color: %s;',
        $settings['font_family'],
        $settings['font_size'],
        $settings['primary_color']
    );

    $button_style = sprintf(
        'background-color: %s; color: %s; padding: 12px 24px; border-radius: %spx; text-decoration: none; display: inline-block;',
        $settings['button_color'],
        $settings['button_text_color'],
        $settings['border_radius']
    );

    $message = sprintf(
        '<div style="%s">
            <h2>Booking Confirmation</h2>
            <p>Your booking has been confirmed!</p>
            <a href="#" style="%s">View Booking Details</a>
        </div>',
        $email_style,
        $button_style
    );

    return $message;
}
