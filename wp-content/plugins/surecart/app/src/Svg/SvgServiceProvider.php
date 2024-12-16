<?php

namespace SureCart\Svg;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide Svg dependencies.
 *
 * @codeCoverageIgnore
 */
class SvgServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		// Service for registering
		$container['surecart.svg'] = function () {
			return new Svg();
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'svg', 'surecart.svg' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		// Nothing to bootstrap.
	}
}
