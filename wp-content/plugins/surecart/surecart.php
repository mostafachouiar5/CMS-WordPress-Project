<?php
/**
 * Plugin Name: SureCart
 * Plugin URI: https://surecart.com/
 * Description: A simple yet powerful headless e-commerce platform designed to grow your business with effortlessly selling online.
 * Version: 3.1.3
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * Author: SureCart
 * Author URI: https://surecart.com
 * License: GPL-2.0-only
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: surecart
 * Domain Path: /languages
 *
 * YOU SHOULD NORMALLY NOT NEED TO ADD ANYTHING HERE - any custom functionality unrelated
 * to bootstrapping the theme should go into a service provider or a separate helper file
 * (refer to the directory structure in README.md).
 *
 * @package SureCart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SURECART_PLUGIN_FILE', __FILE__ );
define( 'SURECART_PLUGIN_DIR', __DIR__ );

define( 'SURECART_PLUGIN_DIR_NAME', dirname( plugin_basename( SURECART_PLUGIN_FILE ) ) );
define( 'SURECART_LANGUAGE_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'languages' );
define( 'SURECART_DIST_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'dist' );
define( 'SURECART_VENDOR_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'vendor' );
define( 'SURECART_PLUGIN_BASE', plugin_basename( SURECART_PLUGIN_FILE ) );

// define host url.
if ( ! defined( 'SURECART_APP_URL' ) ) {
	define( 'SURECART_APP_URL', 'https://app.surecart.com' );
}
if ( ! defined( 'SURECART_REPORTS_URL' ) ) {
	define( 'SURECART_REPORTS_URL', 'https://app.surecart.com/reports/' );
}
if ( ! defined( 'SURECART_API_URL' ) ) {
	define( 'SURECART_API_URL', 'https://api.surecart.com' );
}
if ( ! defined( 'SURECART_JS_URL' ) ) {
	define( 'SURECART_JS_URL', 'https://js.surecart.com' );
}
if ( ! defined( 'SURECART_CDN_IMAGE_BASE' ) ) {
	define( 'SURECART_CDN_IMAGE_BASE', 'https://surecart.com/cdn-cgi/image' );
}

// Load composer dependencies.
if ( file_exists( SURECART_VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php' ) ) {
	require_once SURECART_VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php';
}

// Load helpers.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'SureCart.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'helpers.php';

// Bootstrap plugin after all dependencies and helpers are loaded.
\SureCart::make()->bootstrap( require __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config.php' );

// Register hooks.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'hooks.php';
