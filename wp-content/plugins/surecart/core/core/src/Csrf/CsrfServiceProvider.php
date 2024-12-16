<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Csrf;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide CSRF dependencies.
 *
 * @codeCoverageIgnore
 */
class CsrfServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		$container[ SURECART_CSRF_KEY ] = function () {
			return new Csrf();
		};

		$container[ CsrfMiddleware::class ] = function ( $c ) {
			return new CsrfMiddleware( $c[ SURECART_CSRF_KEY ] );
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'csrf', SURECART_CSRF_KEY );
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		// Nothing to bootstrap.
	}
}
