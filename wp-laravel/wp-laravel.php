<?php
/**
 * WordPress plugin to integrate laravel codebase
 *
 * @link              https://github.com/thiagof/wp-laravel
 * @since             1.0.0
 * @package           WP-Laravel
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Laravel Integration
 * Plugin URI:        https://github.com/thiagof/wp-laravel
 * Description:       It will enable lazy loading laravel classes and features for reuse in the wordpress codebase.
 * Version:           1.0.0
 * Author:            Thiago Macedo
 * Author URI:        https://github.com/thiagof/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-laravel
 * Domain Path:       /languages
 */

/**
 * Current plugin version.
 */
if (defined('WP-LARAVEL_VERSION')) {
  // already enabled
  return;
}
define( 'WP-LARAVEL_VERSION', '1.0.0' );

// Laravel integration functions
require_once __DIR__ . '/includes/laravel.php';

/**
 * On activation do validate the plugin configuration.
 * It requires LARAVEL_PATH to be present as a constant or env var.
 */
function wp_laravel_activate() {
  // check for the laravel path configurations
  wp_laravel_path();
  wp_laravel_autoload();
}
if (function_exists('register_activation_hook')) {
  register_activation_hook( __FILE__, 'wp_laravel_activate' );
}

// Wordpress actions functions
require_once __DIR__ . '/includes/actions.php';
