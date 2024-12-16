<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Middleware;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide middleware dependencies.
 *
 * @codeCoverageIgnore
 */
class MiddlewareServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		$container[ UserLoggedOutMiddleware::class ] = function ( $c ) {
			return new UserLoggedOutMiddleware( $c[ SURECART_RESPONSE_SERVICE_KEY ] );
		};

		$container[ UserLoggedInMiddleware::class ] = function ( $c ) {
			return new UserLoggedInMiddleware( $c[ SURECART_RESPONSE_SERVICE_KEY ] );
		};

		$container[ UserCanMiddleware::class ] = function ( $c ) {
			return new UserCanMiddleware( $c[ SURECART_RESPONSE_SERVICE_KEY ] );
		};
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		// Nothing to bootstrap.
	}
}
