<?php

require_once __DIR__ .'/../wp-laravel/wp-laravel.php';

use PHPUnit\Framework\TestCase;

class LaravelIntegrationTest extends TestCase
{
  public function testLaravelPathException()
  {
    $path = env('LARAVEL_PATH');
    $_ENV['LARAVEL_PATH'] = null;

    $this->expectException(InvalidArgumentException::class);

    try {
      wp_laravel_path();
    } catch (\Exception $e) {
      throw $e;
    } finally {
      $_ENV['LARAVEL_PATH'] = $path;
    }
  }
  public function testLaravelAutoload()
  {
    wp_laravel_autoload();
    $this->assertTrue(function_exists('app'));
    $this->assertTrue(function_exists('app_path'));
  }

  public function testLaravelApp()
  {
    $app = wp_laravel_app();
    global $wp_laravel_app_container;

    $this->assertInstanceOf(Illuminate\Container\Container::class, $app);
    $this->assertNotEmpty($wp_laravel_app_container);
  }
  public function testLaravelAppSingleton()
  {
    $app1 = wp_laravel_app();
    $app2 = wp_laravel_app();
    global $wp_laravel_app_container;

    $this->assertSame($app1, $wp_laravel_app_container);
    $this->assertSame($app2, $wp_laravel_app_container);
    $this->assertSame($app1, $app2);
  }
}
