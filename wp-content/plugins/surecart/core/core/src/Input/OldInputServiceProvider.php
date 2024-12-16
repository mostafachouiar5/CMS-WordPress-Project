<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Input;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide old input dependencies.
 *
 * @codeCoverageIgnore
 */
class OldInputServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		$container[ SURECART_OLD_INPUT_KEY ] = function ( $c ) {
			return new OldInput( $c[ SURECART_FLASH_KEY ] );
		};

		$container[ OldInputMiddleware::class ] = function ( $c ) {
			return new OldInputMiddleware( $c[ SURECART_OLD_INPUT_KEY ] );
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'oldInput', SURECART_OLD_INPUT_KEY );
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		// Nothing to bootstrap.
	}
}
