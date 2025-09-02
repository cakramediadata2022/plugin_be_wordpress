
# CKH Booking Engine

A powerful, modern WordPress plugin for integrating a booking engine into your WordPress site. Built with PHP and Alpine.js for a seamless, reactive user experience.

## Features
- Easy installation as a standard WordPress plugin
- Modern, reactive UI powered by Alpine.js
- Modular codebase for easy extension
- Ready for custom booking logic and UI


## Folder Structure
```
ckh-booking-engine/
├── admin/
│   ├── class-ckh-booking-engine-admin.php
│   ├── css/
│   │   └── ckh_booking_engine-admin.css
│   ├── js/
│   │   ├── alpine.min.js
│   │   └── ckh-booking-engine-admin.js
│   └── partials/
│       └── ckh-booking-engine-admin-display.php
├── ckh-booking-engine.php
├── includes/
│   ├── class-ckh-booking-engine-activator.php
│   ├── class-ckh-booking-engine-deactivator.php
│   ├── class-ckh-booking-engine-i18n.php
│   ├── class-ckh-booking-engine-loader.php
│   └── class-ckh-booking-engine.php
├── index.php
├── languages/
│   └── ckh-booking-engine.pot
├── public/
│   ├── class-ckh-booking-engine-public.php
│   ├── css/
│   │   └── ckh-booking-engine-public.css
│   ├── js/
│   │   └── ckh-booking-engine-public.js
│   └── partials/
│       └── ckh-booking-engine-public-display.php
└── uninstall.php
```



## Download

Visit the [Releases page](https://github.com/cakramediadata2022/plugin_be_wordpress/releases/latest) to download the latest version of the CKH Booking Engine plugin.

> The plugin zip file is named with its version, e.g., `ckh-booking-engine-1.0.0.zip`. Always choose the highest version number for the newest release.

## Getting Started
1. Download the plugin using the link above, or clone this repository.
2. Place the extracted `wp-ckh-booking-engine` folder in your WordPress `wp-content/plugins/` directory.
3. Activate the plugin from the WordPress admin dashboard.

## Development
- **PHP**: Main plugin logic and WordPress integration
- **Alpine.js**: For reactive frontend components (add your custom JS in `assets/js/`)
- **CSS**: Add your styles in `assets/css/wpbe-style.css`

## Customization
- Extend the main class in `includes/class-wpbe-main.php` for new features.
- Add or modify JS/CSS assets as needed.


## License
This plugin is licensed under the GNU General Public License v2.0 or later. See the [LICENSE](LICENSE) file for details.

---
**Copyright (C) 2025 PT. Cakra Media Data (Cakrasoft)**  
JL. Abdul Kudus Perumahan Barombong Permai C5 Kel. Tamalate Kec. Barombong 90225

---
Created by cakramediadata2022
