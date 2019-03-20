<?php

/**
 * Makes the laravel environment available within the wordpress runtime
 * That's going to be the default.
 *
 * @since    1.0.0
 * @access   public
 */
function wp_laravel_init() {
  wp_laravel_autoload();
}

// includes laravel composer autoload on runtime by default
if (function_exists('add_action')) {
  add_action( 'init', 'wp_laravel_init', 9999 );
}
