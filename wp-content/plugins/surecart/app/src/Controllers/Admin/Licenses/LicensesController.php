<?php

namespace SureCart\Controllers\Admin\Licenses;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Controllers\Admin\Licenses\LicensesListTable;

/**
 * Handles product admin requests.
 */
class LicensesController extends AdminController {

	/**
	 * Products index.
	 */
	public function index() {
		$table = new LicensesListTable();
		$table->prepare_items();
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'licenses' => [
						'title' => __( 'Licenses', 'surecart' ),
					],
				],
			)
		);
		return \SureCart::view( 'admin/licenses/index' )->with( [ 'table' => $table ] );
	}

	/**
	 * Licenses edit.
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( LicensesScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/licenses/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}
}
