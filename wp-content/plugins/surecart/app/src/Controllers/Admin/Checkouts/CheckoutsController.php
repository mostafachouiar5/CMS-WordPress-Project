<?php

namespace SureCart\Controllers\Admin\Checkouts;

use SureCart\Controllers\Admin\AdminController;

/**
 * Handles product admin requests.
 */
class CheckoutsController extends AdminController {
	/**
	 * Create a checkout.
	 */
	public function edit() {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( CheckoutScriptsController::class, 'enqueue' ) );
		// return view.
		return '<div id="app"></div>';
	}
}
