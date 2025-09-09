<?php

/**
 * CKH Booking Engine Settings Test
 * 
 * This file helps you test if the settings are working correctly.
 * You can run this to check if settings are being saved to the database.
 */

// Prevent direct access
if (!defined('WPINC')) {
    die('Direct access not allowed');
}

/**
 * Test function to check if settings are working
 */
function ckh_booking_engine_test_settings()
{
    // Check if our settings helper class exists
    if (!class_exists('CKH_Booking_Engine_Settings')) {
        return array(
            'status' => 'error',
            'message' => 'Settings helper class not found'
        );
    }

    // Test getting settings
    $settings = CKH_Booking_Engine_Settings::get_settings();

    // Test getting from database directly
    $db_options = get_option('ckh_booking_engine_options', array());

    return array(
        'status' => 'success',
        'helper_settings' => $settings,
        'database_settings' => $db_options,
        'api_configured' => CKH_Booking_Engine_Settings::is_api_configured()
    );
}

/**
 * Admin page to test settings
 */
function ckh_booking_engine_test_page()
{
    if (!current_user_can('manage_options')) {
        wp_die('Access denied');
    }

    $test_results = ckh_booking_engine_test_settings();
?>
    <div class="wrap">
        <h1>CKH Booking Engine - Settings Test</h1>

        <div class="card">
            <h2>Test Results</h2>
            <p><strong>Status:</strong> <?php echo esc_html($test_results['status']); ?></p>

            <?php if ($test_results['status'] === 'success'): ?>
                <h3>Settings from Helper Class:</h3>
                <pre style="background: #f1f1f1; padding: 10px; border-radius: 4px;"><?php print_r($test_results['helper_settings']); ?></pre>

                <h3>Settings from Database:</h3>
                <pre style="background: #f1f1f1; padding: 10px; border-radius: 4px;"><?php print_r($test_results['database_settings']); ?></pre>

                <h3>API Configuration Status:</h3>
                <p><?php echo $test_results['api_configured'] ? '✅ API is configured' : '❌ API is not configured'; ?></p>

                <h3>Database Option Name:</h3>
                <p><code>ckh_booking_engine_options</code></p>

                <h3>How to Check in Database:</h3>
                <p>You can check the database directly by looking in the <code>wp_options</code> table for the option name <code>ckh_booking_engine_options</code>.</p>

                <h3>Quick Database Query:</h3>
                <pre style="background: #f1f1f1; padding: 10px; border-radius: 4px;">SELECT * FROM wp_options WHERE option_name = 'ckh_booking_engine_options';</pre>

            <?php else: ?>
                <p style="color: red;"><?php echo esc_html($test_results['message']); ?></p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2>Manual Test</h2>
            <p>To test if settings are saving:</p>
            <ol>
                <li>Go to <strong>Settings > CKH Booking Engine</strong></li>
                <li>Change some values (e.g., colors, API key)</li>
                <li>Click "Save Settings"</li>
                <li>Refresh this page to see if the values appear above</li>
            </ol>
        </div>

        <div class="card">
            <h2>CSS Variables Test</h2>
            <p>Current CSS variables generated:</p>
            <pre style="background: #f1f1f1; padding: 10px; border-radius: 4px;"><?php echo esc_html(CKH_Booking_Engine_Settings::get_css_variables()); ?></pre>
        </div>
    </div>

    <style>
        .card {
            background: white;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
        }
    </style>
<?php
}

// Add test page to admin menu
add_action('admin_menu', function () {
    add_submenu_page(
        'tools.php',
        'CKH Settings Test',
        'CKH Settings Test',
        'manage_options',
        'ckh-settings-test',
        'ckh_booking_engine_test_page'
    );
});
