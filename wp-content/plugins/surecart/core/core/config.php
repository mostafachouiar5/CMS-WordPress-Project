<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

/**
 * Absolute path to application's directory.
 */
if ( ! defined( 'SURECART_DIR' ) ) {
	define( 'SURECART_DIR', __DIR__ );
}

/**
 * Service container keys.
 */
if ( ! defined( 'SURECART_CONFIG_KEY' ) ) {
	define( 'SURECART_CONFIG_KEY', 'surecart.config' );
}

if ( ! defined( 'SURECART_APPLICATION_KEY' ) ) {
	define( 'SURECART_APPLICATION_KEY', 'surecart.application.application' );
}

if ( ! defined( 'SURECART_APPLICATION_GENERIC_FACTORY_KEY' ) ) {
	define( 'SURECART_APPLICATION_GENERIC_FACTORY_KEY', 'surecart.application.generic_factory' );
}

if ( ! defined( 'SURECART_APPLICATION_CLOSURE_FACTORY_KEY' ) ) {
	define( 'SURECART_APPLICATION_CLOSURE_FACTORY_KEY', 'surecart.application.closure_factory' );
}

if ( ! defined( 'SURECART_HELPERS_HANDLER_FACTORY_KEY' ) ) {
	define( 'SURECART_HELPERS_HANDLER_FACTORY_KEY', 'surecart.handlers.helper_factory' );
}

if ( ! defined( 'SURECART_WORDPRESS_HTTP_KERNEL_KEY' ) ) {
	define( 'SURECART_WORDPRESS_HTTP_KERNEL_KEY', 'surecart.kernels.wordpress_http_kernel' );
}

if ( ! defined( 'SURECART_SESSION_KEY' ) ) {
	define( 'SURECART_SESSION_KEY', 'surecart.session' );
}

if ( ! defined( 'SURECART_REQUEST_KEY' ) ) {
	define( 'SURECART_REQUEST_KEY', 'surecart.request' );
}

if ( ! defined( 'SURECART_RESPONSE_KEY' ) ) {
	define( 'SURECART_RESPONSE_KEY', 'surecart.response' );
}

if ( ! defined( 'SURECART_EXCEPTIONS_ERROR_HANDLER_KEY' ) ) {
	define( 'SURECART_EXCEPTIONS_ERROR_HANDLER_KEY', 'surecart.exceptions.error_handler' );
}

if ( ! defined( 'SURECART_EXCEPTIONS_CONFIGURATION_ERROR_HANDLER_KEY' ) ) {
	define( 'SURECART_EXCEPTIONS_CONFIGURATION_ERROR_HANDLER_KEY', 'surecart.exceptions.configuration_error_handler' );
}

if ( ! defined( 'SURECART_RESPONSE_SERVICE_KEY' ) ) {
	define( 'SURECART_RESPONSE_SERVICE_KEY', 'surecart.responses.response_service' );
}

if ( ! defined( 'SURECART_ROUTING_ROUTER_KEY' ) ) {
	define( 'SURECART_ROUTING_ROUTER_KEY', 'surecart.routing.router' );
}

if ( ! defined( 'SURECART_ROUTING_ROUTE_BLUEPRINT_KEY' ) ) {
	define( 'SURECART_ROUTING_ROUTE_BLUEPRINT_KEY', 'surecart.routing.route_registrar' );
}

if ( ! defined( 'SURECART_ROUTING_CONDITIONS_CONDITION_FACTORY_KEY' ) ) {
	define( 'SURECART_ROUTING_CONDITIONS_CONDITION_FACTORY_KEY', 'surecart.routing.conditions.condition_factory' );
}

if ( ! defined( 'SURECART_ROUTING_CONDITION_TYPES_KEY' ) ) {
	define( 'SURECART_ROUTING_CONDITION_TYPES_KEY', 'surecart.routing.conditions.condition_types' );
}

if ( ! defined( 'SURECART_VIEW_SERVICE_KEY' ) ) {
	define( 'SURECART_VIEW_SERVICE_KEY', 'surecart.view.view_service' );
}

if ( ! defined( 'SURECART_VIEW_COMPOSE_ACTION_KEY' ) ) {
	define( 'SURECART_VIEW_COMPOSE_ACTION_KEY', 'surecart.view.view_compose_action' );
}

if ( ! defined( 'SURECART_VIEW_ENGINE_KEY' ) ) {
	define( 'SURECART_VIEW_ENGINE_KEY', 'surecart.view.view_engine' );
}

if ( ! defined( 'SURECART_VIEW_PHP_VIEW_ENGINE_KEY' ) ) {
	define( 'SURECART_VIEW_PHP_VIEW_ENGINE_KEY', 'surecart.view.php_view_engine' );
}

if ( ! defined( 'SURECART_SERVICE_PROVIDERS_KEY' ) ) {
	define( 'SURECART_SERVICE_PROVIDERS_KEY', 'surecart.service_providers' );
}

if ( ! defined( 'SURECART_FLASH_KEY' ) ) {
	define( 'SURECART_FLASH_KEY', 'surecart.flash.flash' );
}

if ( ! defined( 'SURECART_OLD_INPUT_KEY' ) ) {
	define( 'SURECART_OLD_INPUT_KEY', 'surecart.old_input.old_input' );
}

if ( ! defined( 'SURECART_CSRF_KEY' ) ) {
	define( 'SURECART_CSRF_KEY', 'surecart.csrf.csrf' );
}
