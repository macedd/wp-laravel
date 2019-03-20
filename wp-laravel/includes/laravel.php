<?php

/**
 * Gets the Laravel configured folder path.
 * In order to run the plugin wordpress runtime must have one of the following:
 * - environment variable: LARAVEL_PATH
 * - constant definition: LARAVEL_PATH
 * This should be an absolute path to laravel installation directory within the same server instance.
 * Usually the folder structure is:
 * - /var/www
 *    - wordpress
 *    - laravel
 * And then LARAVEL_PATH value must set `/var/www/laravel`.
 *
 * @since    1.0.0
 * @access   public
 * @return   string       The configured laravel installation absolute path
 */
function wp_laravel_path() {
  $laravel_path = $_ENV['LARAVEL_PATH'];
  if (defined('LARAVEL_PATH')) {
    $laravel_path = constant('LARAVEL_PATH');
  }
  if (!$laravel_path) {
    throw new InvalidArgumentException("Missing LARAVEL_PATH env configuration", 1);
  }
  return $laravel_path;
}

/**
 * This function will require the composer autoload from the laravel installation.
 * That's usefull for reusing composer packages and laravel classes (eg. helpers).
 * For a full laravel experience the app bootstrapping must occur: wp_laravel_app()
 *
 * @since    1.0.0
 * @access   public
 */
function wp_laravel_autoload() {
  $laravel_autoload = $_ENV['LARAVEL_AUTOLOAD'];
  if (!$laravel_autoload) {
    $laravel_autoload = wp_laravel_path() ."/vendor/autoload.php";
  }
  require_once $laravel_autoload;
}

/**
 * Creates the laravel app instance.
 * This bootstraps the whole Laravel Application (eg databases).
 * After this Laravel will be fully available inside WordPress runtime.
 *
 * @since    1.0.0
 * @access   public
 * @return   Illuminate\Container\Container                                 The singleton Laravel Application instance
 */
function wp_laravel_env() {
    // require laravel autoload file
    wp_laravel_autoload();
    // start the laravel .env
    $laravel_path = wp_laravel_path();
    (new Dotenv\Dotenv($laravel_path))->load();
}

/**
 * The Laravel App Container instance
 *
 * @since    1.0.0
 * @access   public
 * @var      Illuminate\Container\Container    $wp_laravel_app_container    The singleton app container instance
 */
global $wp_laravel_app_container;

/**
 * Creates the laravel app instance.
 * This bootstraps the whole Laravel Application (eg databases).
 * After this Laravel will be fully available inside WordPress runtime.
 *
 * @since    1.0.0
 * @access   public
 * @return   Illuminate\Container\Container                                 The singleton Laravel Application instance
 */
function wp_laravel_app() {
  global $wp_laravel_app_container;
  if (!$wp_laravel_app_container) {
    // bootstrap laravel application
    $laravel_path = wp_laravel_path();
    $laravel_bootstrap = $laravel_path ."/bootstrap/app.php";
    $laravel_app = require_once $laravel_bootstrap;

    // app was already included
    if ($laravel_app === true) {
      $laravel_app = app();
    }

    // stores global app singleton
    $wp_laravel_app_container = $laravel_app;

    // restores wordpress error handling
    wp_laravel_restore_error_handling();
  }

  return $wp_laravel_app_container;
}

/**
 * Will restore default Error Handling, after laravel bootstrap.
 * Laravel has it's own error handling mechanism. Since we bootstraped it'll be enabled.
 * WordPress is not stric about many error types and this will change with Laravel bootstraping.
 * This can cause issues on some wordpress runtimes, by changing how errors and warnings are handled,
 * so we try to restore original error handling.
 *
 * The function can be replaced for restoring alternate error handlers.
 *
 * @since    1.0.0
 * @access   public
 */
if (!function_exists('wp_laravel_restore_error_handling')) {
  function wp_laravel_restore_error_handling() {
    // php default error handler (remove laravel handlers)
    restore_error_handler();
    restore_exception_handler();

    // wordpress default error report level
    error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
  }
}
