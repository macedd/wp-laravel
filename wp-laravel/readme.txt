=== WP Laravel ===
Contributors: thiagof
Tags: laravel, data-models, scaling
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Laravel Integration to WordPress

== Description ==

This integrates a laravel installation into the WordPress runtime.
Will enable the use of any Laravel APIs from WordPress code.

### Installation

The plugin can be used both as a regular plugin and in a bundled fashion (eg. in themes or custom plugins).

It requires that Laravel is installed in the same server of the WordPress run-time.

After that, include a new setting on WordPress pointing to the **Laravel folder**.
The constant can be set in `wp-config.php`:

    define('LARAVEL_PATH', '/var/www/laravel');

### Usage

The plugin will automatically include Laravel **composer autoload.php** into WordPress run-time.
This means that, after enabled/included, it will provide access to any packages and classes in the Laravel installation.

    // instantiate the app classes by namespace
    $core = new App\Core();
    // make use of laravel helpers
    array_get($list, 'profile.name');
    // reuse installed libraries (eg. guzzle)
    $client = new \GuzzleHttp\Client();

Yet for full usage of the application APIs, we have to bootstrap the Laravel application first:

    $app = wp_laravel_app();

At this point any Laravel functionality should be ready to use.
This include Database Connections, Queue, Mail, File System and any `Service Provider` dependent components.

The Laravel `config/` and `.env` definitions bootstrapped are from Laravel run-time and that's where we maintain them - in the Laravel application.
