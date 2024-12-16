<?php
/**
 * @package   SureCartAppCore
 * @author    SureCart <support@surecart.com>
 * @copyright  SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com
 */

namespace SureCartAppCore\AppCore;

use SureCartCore\ServiceProviders\ExtendsConfigTrait;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide theme dependencies.
 *
 * @codeCoverageIgnore
 */
class AppCoreServiceProvider implements ServiceProviderInterface {
	use ExtendsConfigTrait;

	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		$this->extendConfig(
			$container,
			'app_core',
			[
				'path' => '',
				'url'  => '',
			]
		);

		$container['surecart_app_core.app_core.app_core'] = function( $c ) {
			return new AppCore( $c[ SURECART_APPLICATION_KEY ] );
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'core', 'surecart_app_core.app_core.app_core' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		// Nothing to bootstrap.
	}
}
