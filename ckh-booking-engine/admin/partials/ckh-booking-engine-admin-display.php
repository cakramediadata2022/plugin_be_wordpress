<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://cakrasoft.com/
 * @since      1.0.0
 *
 * @package    CKH_Booking_Engine
 * @subpackage CKH_Booking_Engine/admin/partials
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <div class="ckh-booking-engine-admin-header">
        <h2>Configure your CKH Booking Engine settings</h2>
        <p>Customize the appearance, API settings, and typography for your booking engine plugin. These settings will be
            applied globally across all booking engine instances on your site.</p>
    </div>

    <div class="ckh-booking-engine-admin-content">
        <form method="post" action="options.php">
            <?php
            settings_fields('ckh_booking_engine_settings');
            ?>

            <div class="ckh-booking-engine-settings-tabs">
                <nav class="nav-tab-wrapper">
                    <a href="#api-settings" class="nav-tab nav-tab-active">API Settings</a>
                    <a href="#appearance-settings" class="nav-tab">Appearance</a>
                    <a href="#typography-settings" class="nav-tab">Typography</a>
                </nav>

                <div id="api-settings" class="tab-content active">
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">Shortcode</th>
                                <td>
                                    <p class="description">
                                        <strong>Use this shortcode to embed the booking engine anywhere on your
                                            site:</strong>
                                        <code>[ckh_booking_engine]</code>
                                        <button id="copy-shortcode-btn" type="button"
                                            style="background:none;border:none;cursor:pointer;vertical-align:middle;margin-left:6px;"
                                            title="Copy shortcode">
                                            <span id="copy-shortcode-icon" style="font-size:16px;">📋</span>
                                        </button>
                                        <script type="text/javascript">
                                            jQuery(function($) {
                                                var $btn = $('#copy-shortcode-btn');
                                                var $code = $btn.prev('code');
                                                $btn.on('click', function() {
                                                    var shortcode = $code.text();
                                                    var $temp = $('<input>');
                                                    $('body').append($temp);
                                                    $temp.val(shortcode).select();
                                                    document.execCommand('copy');
                                                    $temp.remove();
                                                    $btn.attr('title', 'Copied!');
                                                    setTimeout(function() {
                                                        $btn.attr('title', 'Copy shortcode');
                                                    }, 1200);
                                                });
                                                $code.on('keydown', function(e) {
                                                    if ((e.ctrlKey || e.metaKey) && e.key === 'c') {
                                                        var shortcode = $code.text();
                                                        var $temp = $('<input>');
                                                        $('body').append($temp);
                                                        $temp.val(shortcode).select();
                                                        document.execCommand('copy');
                                                        $temp.remove();
                                                        $btn.attr('title', 'Copied!');
                                                        setTimeout(function() {
                                                            $btn.attr('title', 'Copy shortcode');
                                                        }, 1200);
                                                    }
                                                });
                                            });
                                        </script>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">API Key</th>
                                <td>
                                    <?php
                                    $options = get_option('ckh_booking_engine_options', array());
                                    $api_key = isset($options['api_key']) ? $options['api_key'] : '';
                                    ?>
                                    <input type="password" name="ckh_booking_engine_options[api_key]" id="ckh-api-key"
                                        value="<?php echo esc_attr($api_key); ?>" class="regular-text" />
                                    <button type="button" id="test-api-connection" class="button button-secondary"
                                        style="margin-left: 10px;">
                                        Test Connection
                                    </button>
                                    <div id="api-test-result" style="margin-top: 10px;"></div>
                                    <p class="description">Enter your booking engine API key and test the connection.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">API URL</th>
                                <td>
                                    <p class="description">
                                        <strong>Static API URL:</strong>
                                        <?php echo esc_html(CKH_Booking_Engine::get_api_url()); ?>
                                        <br>
                                        <em>The API URL is now configured statically in the plugin and cannot be changed
                                            from this settings page.</em>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Callback URL</th>
                                <td>
                                    <?php
                                    $callback_url = isset($options['callback_url']) ? $options['callback_url'] : 'https://cakrasoft.net/confirmation-payment';
                                    ?>
                                    <input type="url" name="ckh_booking_engine_options[callback_url]" id="ckh-callback-url"
                                        value="<?php echo esc_attr($callback_url); ?>" class="regular-text"
                                        placeholder="https://cakrasoft.net/confirmation-payment" />
                                    <p class="description">
                                        URL where customers will be redirected after completing payment.
                                        <br><strong>Default:</strong> https://cakrasoft.net/confirmation-payment
                                        (used if left blank)
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="appearance-settings" class="tab-content">
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">Primary Color</th>
                                <td>
                                    <?php
                                    $primary_color = isset($options['primary_color']) ? $options['primary_color'] : '#007cba';
                                    ?>
                                    <input type="text" name="ckh_booking_engine_options[primary_color]"
                                        value="<?php echo esc_attr($primary_color); ?>" class="color-picker" />
                                    <p class="description">Primary color for the booking engine.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Secondary Color</th>
                                <td>
                                    <?php
                                    $secondary_color = isset($options['secondary_color']) ? $options['secondary_color'] : '#f0f0f1';
                                    ?>
                                    <input type="text" name="ckh_booking_engine_options[secondary_color]"
                                        value="<?php echo esc_attr($secondary_color); ?>" class="color-picker" />
                                    <p class="description">Secondary color for the booking engine.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Accent Color</th>
                                <td>
                                    <?php
                                    $accent_color = isset($options['accent_color']) ? $options['accent_color'] : '#ff6900';
                                    ?>
                                    <input type="text" name="ckh_booking_engine_options[accent_color]"
                                        value="<?php echo esc_attr($accent_color); ?>" class="color-picker" />
                                    <p class="description">Accent color for highlights and emphasis.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Button Color</th>
                                <td>
                                    <?php
                                    $button_color = isset($options['button_color']) ? $options['button_color'] : '#007cba';
                                    ?>
                                    <input type="text" name="ckh_booking_engine_options[button_color]"
                                        value="<?php echo esc_attr($button_color); ?>" class="color-picker" />
                                    <p class="description">Button background color.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Button Text Color</th>
                                <td>
                                    <?php
                                    $button_text_color = isset($options['button_text_color']) ? $options['button_text_color'] : '#ffffff';
                                    ?>
                                    <input type="text" name="ckh_booking_engine_options[button_text_color]"
                                        value="<?php echo esc_attr($button_text_color); ?>" class="color-picker" />
                                    <p class="description">Button text color.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Border Radius</th>
                                <td>
                                    <?php
                                    $border_radius = isset($options['border_radius']) ? $options['border_radius'] : 4;
                                    ?>
                                    <input type="number" name="ckh_booking_engine_options[border_radius]"
                                        value="<?php echo esc_attr($border_radius); ?>" min="0" max="20" /> px
                                    <p class="description">Border radius for buttons and form elements (0-20).</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="ckh-booking-engine-preview">
                        <h3>Preview</h3>
                        <div class="preview-container">
                            <div class="preview-button" id="preview-button">Book Now</div>
                            <div class="preview-form">
                                <div class="preview-field">
                                    <label>Check-in Date</label>
                                    <input type="text" placeholder="Select date" readonly>
                                </div>
                                <div class="preview-field">
                                    <label>Check-out Date</label>
                                    <input type="text" placeholder="Select date" readonly>
                                </div>
                                <div class="preview-field">
                                    <label>Guests</label>
                                    <select>
                                        <option>1 Guest</option>
                                        <option>2 Guests</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="typography-settings" class="tab-content">
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">Font Family</th>
                                <td>
                                    <?php
                                    $font_family = isset($options['font_family']) ? $options['font_family'] : 'inherit';
                                    $fonts = array(
                                        'inherit' => 'Inherit from theme',
                                        'Arial, sans-serif' => 'Arial',
                                        'Helvetica, sans-serif' => 'Helvetica',
                                        '"Times New Roman", serif' => 'Times New Roman',
                                        'Georgia, serif' => 'Georgia',
                                        '"Courier New", monospace' => 'Courier New',
                                        '"Open Sans", sans-serif' => 'Open Sans',
                                        '"Roboto", sans-serif' => 'Roboto',
                                        '"Lato", sans-serif' => 'Lato',
                                        '"Montserrat", sans-serif' => 'Montserrat'
                                    );
                                    ?>
                                    <select name="ckh_booking_engine_options[font_family]">
                                        <?php foreach ($fonts as $font_value => $font_name): ?>
                                            <option value="<?php echo esc_attr($font_value); ?>"
                                                <?php selected($font_family, $font_value); ?>>
                                                <?php echo esc_html($font_name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Select the font family for the booking engine.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Base Font Size</th>
                                <td>
                                    <?php
                                    $font_size = isset($options['font_size']) ? $options['font_size'] : 14;
                                    ?>
                                    <input type="number" name="ckh_booking_engine_options[font_size]"
                                        value="<?php echo esc_attr($font_size); ?>" min="10" max="24" /> px
                                    <p class="description">Base font size in pixels (10-24).</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    <div class="ckh-booking-engine-admin-sidebar">
        <div class="sidebar-box">
            <h3>Documentation</h3>
            <p>Need help setting up your booking engine? Check out our documentation for detailed instructions.</p>
            <a href="https://cflow.cakrasoft.com/docs/category/api-docs" class="button button-secondary">View
                Documentation</a>
        </div>

        <div class="sidebar-box">
            <h3>Support</h3>
            <p>Having issues? Our support team is here to help you get everything working perfectly.</p>
            <a href="https://cakrasoft.com/contact/" class="button button-secondary">Get Support</a>
        </div>

        <div class="sidebar-box">
            <h3>Export/Import Settings</h3>
            <p>Save your current settings or import a configuration.</p>
            <button type="button" class="button button-secondary" id="export-settings">Export Settings</button>
            <input type="file" id="import-settings" accept=".json" style="display: none;">
            <button type="button" class="button button-secondary"
                onclick="document.getElementById('import-settings').click();">Import Settings</button>
        </div>
    </div>
</div>

<style>
    .ckh-booking-engine-admin-content {
        float: left;
        width: 75%;
        margin-right: 2%;
    }

    .ckh-booking-engine-admin-sidebar {
        float: right;
        width: 23%;
    }

    .ckh-booking-engine-admin-header {
        margin-bottom: 20px;
        padding: 20px;
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
    }

    .ckh-booking-engine-settings-tabs {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
    }

    .tab-content {
        display: none;
        padding: 20px;
    }

    .tab-content.active {
        display: block;
    }

    .ckh-booking-engine-preview {
        margin-top: 20px;
        padding: 20px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .preview-container {
        background: white;
        padding: 20px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .preview-button {
        display: inline-block;
        padding: 12px 24px;
        margin-bottom: 20px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        text-align: center;
        transition: all 0.3s ease;
    }

    .preview-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .preview-field {
        display: flex;
        flex-direction: column;
    }

    .preview-field:last-child {
        grid-column: 1 / -1;
    }

    .preview-field label {
        margin-bottom: 5px;
        font-weight: 500;
    }

    .preview-field input,
    .preview-field select {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .sidebar-box {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .sidebar-box h3 {
        margin-top: 0;
    }

    .sidebar-box .button {
        display: block;
        text-align: center;
        margin-top: 10px;
    }

    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Color picker improvements */
    .wp-picker-container {
        display: inline-block;
    }

    /* Form improvements */
    .form-table th {
        width: 200px;
    }

    .regular-text {
        width: 300px;
    }
</style>