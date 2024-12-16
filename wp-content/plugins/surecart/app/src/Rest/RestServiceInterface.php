<?php

namespace SureCart\Rest;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

interface RestServiceInterface extends ServiceProviderInterface {
	/**
	 * Register REST Routes
	 *
	 * @return void
	 */
	public function registerModelRoutes();
}
