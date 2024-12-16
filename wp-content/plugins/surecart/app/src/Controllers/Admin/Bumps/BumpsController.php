<?php

namespace SureCart\Controllers\Admin\Bumps;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Controllers\Admin\Bumps\BumpsListTable;

/**
 * Handles product admin requests.
 */
class BumpsController extends AdminController {

	/**
	 * Bumps index.
	 */
	public function index() {
		$table = new BumpsListTable();
		$table->prepare_items();
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'bumps' => [
						'title' => __( 'Bumps', 'surecart' ),
					],
				],
				'report_url'       => SURECART_REPORTS_URL . 'bumps',
			)
		);
		return \SureCart::view( 'admin/bumps/index' )->with( [ 'table' => $table ] );
	}

	/**
	 * Edit
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( BumpScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/bumps/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}
}
