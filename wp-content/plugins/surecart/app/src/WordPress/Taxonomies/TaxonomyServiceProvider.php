<?php

namespace SureCart\WordPress\Taxonomies;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register our form post type
 */
class TaxonomyServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 *
	 *  @param  \Pimple\Container $container Service Container.
	 */
	public function register( $container ) {
		$container['surecart.taxonommies.collection'] = function ( $container ) {
			return new CollectionTaxonomyService();
		};

		$container['surecart.taxonommies.store'] = function ( $container ) {
			return new StoreTaxonomyService();
		};

		$container['surecart.taxonommies'] = function ( $container ) {
			return new TaxonomyService();
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'taxonomies', 'surecart.taxonommies' );
	}

	/**
	 * {@inheritDoc}
	 *
	 *  @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$container['surecart.taxonommies.collection']->bootstrap();
		$container['surecart.taxonommies.store']->bootstrap();
		$container['surecart.taxonommies']->bootstrap();
	}
}
