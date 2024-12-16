<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Kernels;

use SureCartCore\ServiceProviders\ExtendsConfigTrait;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide old input dependencies.
 *
 * @codeCoverageIgnore
 */
class KernelsServiceProvider implements ServiceProviderInterface {
	use ExtendsConfigTrait;

	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		$this->extendConfig(
			$container,
			'middleware',
			[
				'flash'           => \SureCartCore\Flash\FlashMiddleware::class,
				'old_input'       => \SureCartCore\Input\OldInputMiddleware::class,
				'csrf'            => \SureCartCore\Csrf\CsrfMiddleware::class,
				'user.logged_in'  => \SureCartCore\Middleware\UserLoggedInMiddleware::class,
				'user.logged_out' => \SureCartCore\Middleware\UserLoggedOutMiddleware::class,
				'user.can'        => \SureCartCore\Middleware\UserCanMiddleware::class,
			]
		);

		$this->extendConfig(
			$container,
			'middleware_groups',
			[
				'surecart' => [
					'flash',
					'old_input',
				],
				'global'   => [],
				'web'      => [],
				'ajax'     => [],
				'admin'    => [],
			]
		);

		$this->extendConfig( $container, 'middleware_priority', [] );

		$container[ SURECART_WORDPRESS_HTTP_KERNEL_KEY ] = function ( $c ) {
			$kernel = new HttpKernel(
				$c,
				$c[ SURECART_APPLICATION_GENERIC_FACTORY_KEY ],
				$c[ SURECART_HELPERS_HANDLER_FACTORY_KEY ],
				$c[ SURECART_RESPONSE_SERVICE_KEY ],
				$c[ SURECART_REQUEST_KEY ],
				$c[ SURECART_ROUTING_ROUTER_KEY ],
				$c[ SURECART_VIEW_SERVICE_KEY ],
				$c[ SURECART_EXCEPTIONS_ERROR_HANDLER_KEY ]
			);

			$kernel->setMiddleware( $c[ SURECART_CONFIG_KEY ]['middleware'] );
			$kernel->setMiddlewareGroups( $c[ SURECART_CONFIG_KEY ]['middleware_groups'] );
			$kernel->setMiddlewarePriority( $c[ SURECART_CONFIG_KEY ]['middleware_priority'] );

			return $kernel;
		};

		$app = $container[ SURECART_APPLICATION_KEY ];

		$app->alias(
			'run',
			function () use ( $app ) {
				$kernel = $app->resolve( SURECART_WORDPRESS_HTTP_KERNEL_KEY );
				return call_user_func_array( [ $kernel, 'run' ], func_get_args() );
			}
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		// Nothing to bootstrap.
	}
}
