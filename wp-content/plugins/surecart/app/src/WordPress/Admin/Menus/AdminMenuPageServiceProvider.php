<?php

namespace SureCart\WordPress\Admin\Menus;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register plugin options.
 */
class AdminMenuPageServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.admin.menus']                    = function () {
			return new AdminMenuPageService();
		};
		$container['surecart.product_collection_pages.menus'] = function () {
			return new ProductCollectionsMenuService();
		};
	}

	/**
	 * Bootstrap any services if needed.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		$container['surecart.admin.menus']->bootstrap();
		$container['surecart.product_collection_pages.menus']->bootstrap();
	}
}
