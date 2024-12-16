<?php

namespace SureCart\Controllers\Admin\Dashboard;

use SureCart\Controllers\Admin\AdminController;

/**
 * Handles dashboard admin requests.
 */
class DashboardController extends AdminController {

	/**
	 * Dashboard index.
	 */
	public function index() {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( DashboardScriptsController::class, 'enqueue' ) );

		// return view.
		return '<div id="app"></div>';
	}
}
