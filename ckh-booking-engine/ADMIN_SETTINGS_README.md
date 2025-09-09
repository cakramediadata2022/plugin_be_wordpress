# CKH Booking Engine - Admin Settings Documentation

## Overview

The CKH Booking Engine plugin now includes a comprehensive admin settings page that allows you to configure the appearance, API settings, and typography for your booking engine globally. These settings can be accessed throughout your plugin and will be applied to all booking engine instances on your site.

## Admin Settings Location

The settings page can be found in your WordPress admin:
**Settings > CKH Booking Engine**

## Available Settings

### API Settings
- **API Key**: Your booking engine API key for authentication
- **API URL**: The base URL for your booking engine API

### Appearance Settings
- **Primary Color**: Main color used throughout the booking engine
- **Secondary Color**: Secondary color for backgrounds and borders
- **Accent Color**: Color used for highlights and emphasis
- **Button Color**: Background color for buttons
- **Button Text Color**: Text color for buttons
- **Border Radius**: Rounded corners for buttons and form elements (0-20px)

### Typography Settings
- **Font Family**: Font family for all text in the booking engine
- **Base Font Size**: Base font size in pixels (10-24px)

## Features

### Live Preview
The settings page includes a live preview that updates in real-time as you change settings, so you can see how your booking engine will look before saving.

### Export/Import Settings
- **Export**: Download your current settings as a JSON file for backup
- **Import**: Upload a previously exported settings file to restore configuration

### Tabbed Interface
Settings are organized into logical tabs for easy navigation:
- API Settings
- Appearance
- Typography

## Global Access to Settings

### Using the Settings Helper Class

The plugin includes a `CKH_Booking_Engine_Settings` class that provides easy access to all settings throughout your code.

#### Get All Settings
```php
$all_settings = CKH_Booking_Engine_Settings::get_settings();
```

#### Get a Specific Setting
```php
$primary_color = CKH_Booking_Engine_Settings::get_setting('primary_color');
$api_key = CKH_Booking_Engine_Settings::get_setting('api_key');
```

#### Get Settings by Category
```php
// API settings
$api_settings = CKH_Booking_Engine_Settings::get_api_settings();

// Appearance settings
$appearance_settings = CKH_Booking_Engine_Settings::get_appearance_settings();

// Typography settings
$typography_settings = CKH_Booking_Engine_Settings::get_typography_settings();
```

#### Update Settings Programmatically
```php
// Update a single setting
CKH_Booking_Engine_Settings::update_setting('primary_color', '#ff0000');

// Update multiple settings
CKH_Booking_Engine_Settings::update_settings(array(
    'primary_color' => '#ff0000',
    'button_color' => '#00ff00'
));
```

#### Check API Configuration
```php
if (CKH_Booking_Engine_Settings::is_api_configured()) {
    // API key and URL are set
    // Safe to make API calls
}
```

### CSS Variables

The plugin automatically generates CSS custom properties that you can use in your stylesheets:

```css
.my-booking-element {
    background-color: var(--ckh-primary-color);
    color: var(--ckh-button-text-color);
    font-family: var(--ckh-font-family);
    font-size: var(--ckh-font-size);
    border-radius: var(--ckh-border-radius);
}
```

Available CSS variables:
- `--ckh-primary-color`
- `--ckh-secondary-color`
- `--ckh-accent-color`
- `--ckh-button-color`
- `--ckh-button-text-color`
- `--ckh-font-family`
- `--ckh-font-size`
- `--ckh-border-radius`

### JavaScript Access

Settings are automatically localized to JavaScript and available in the `ckh_booking_engine` object:

```javascript
// Access settings in JavaScript
console.log(ckh_booking_engine.colors.primary);
console.log(ckh_booking_engine.apiKey);
console.log(ckh_booking_engine.typography.fontFamily);

// Example: Apply settings to an element
document.querySelector('.booking-button').style.backgroundColor = ckh_booking_engine.colors.button;
```

## Example Usage

### Custom Shortcode with Settings
```php
function my_custom_booking_button($atts) {
    $settings = CKH_Booking_Engine_Settings::get_settings();
    
    return sprintf(
        '<button style="background: %s; color: %s; border-radius: %spx;">Book Now</button>',
        esc_attr($settings['button_color']),
        esc_attr($settings['button_text_color']),
        esc_attr($settings['border_radius'])
    );
}
add_shortcode('my_booking_button', 'my_custom_booking_button');
```

### API Integration
```php
function make_booking_api_call($booking_data) {
    $api_settings = CKH_Booking_Engine_Settings::get_api_settings();
    
    if (!CKH_Booking_Engine_Settings::is_api_configured()) {
        return new WP_Error('api_not_configured', 'API not configured');
    }
    
    $response = wp_remote_post($api_settings['api_url'] . '/bookings', array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_settings['api_key'],
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode($booking_data),
    ));
    
    return $response;
}
```

### Custom CSS with Settings
```php
function add_custom_booking_styles() {
    $settings = CKH_Booking_Engine_Settings::get_settings();
    
    $custom_css = "
        .custom-booking-widget {
            background-color: {$settings['primary_color']};
            font-family: {$settings['font_family']};
            border-radius: {$settings['border_radius']}px;
        }
    ";
    
    wp_add_inline_style('my-theme-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'add_custom_booking_styles');
```

## Default Values

The plugin includes sensible defaults for all settings:

- **Primary Color**: `#007cba` (WordPress blue)
- **Secondary Color**: `#f0f0f1` (Light gray)
- **Accent Color**: `#ff6900` (Orange)
- **Button Color**: `#007cba` (WordPress blue)
- **Button Text Color**: `#ffffff` (White)
- **Font Family**: `inherit` (Use theme font)
- **Font Size**: `14px`
- **Border Radius**: `4px`

## Security

All settings are properly sanitized and validated:
- Colors are validated as hex colors
- URLs are sanitized with `esc_url_raw()`
- Text fields are sanitized with `sanitize_text_field()`
- Numeric values are validated within acceptable ranges

## Hooks and Filters

You can extend the settings functionality using WordPress hooks:

```php
// Modify settings before they are saved
add_filter('ckh_booking_engine_settings_before_save', function($settings) {
    // Modify settings here
    return $settings;
});

// Add custom validation
add_filter('ckh_booking_engine_settings_validation', function($errors, $settings) {
    // Add custom validation logic
    return $errors;
}, 10, 2);
```

## Troubleshooting

### Settings Not Saving
- Check that you have the `manage_options` capability
- Verify that nonces are being passed correctly
- Check the WordPress debug log for errors

### API Calls Failing
- Use `CKH_Booking_Engine_Settings::is_api_configured()` to check configuration
- Verify API key and URL are correct
- Check network connectivity and API endpoint status

### Styles Not Applying
- Ensure CSS variables are being enqueued properly
- Check that your theme supports CSS custom properties
- Verify that styles are being loaded in the correct order

## Support

For additional support and examples, check the `class-ckh-booking-engine-examples.php` file included with the plugin, which contains comprehensive usage examples for all features.
