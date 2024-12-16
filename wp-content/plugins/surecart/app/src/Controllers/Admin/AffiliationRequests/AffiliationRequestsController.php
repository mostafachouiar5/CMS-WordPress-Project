<?php

namespace SureCart\Controllers\Admin\AffiliationRequests;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Controllers\Admin\AffiliationRequests\AffiliationRequestsListTable;

/**
 * Handles affiliate requests admin routes.
 */
class AffiliationRequestsController extends AdminController {
	/**
	 * Affiliate Requests index.
	 */
	public function index() {
		$table = new AffiliationRequestsListTable();
		$table->prepare_items();
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'affiliate-requests' => [
						'title' => __( 'Affiliate Requests', 'surecart' ),
					],
				],
			)
		);
		return \SureCart::view( 'admin/affiliation-requests/index' )->with( [ 'table' => $table ] );
	}

	/**
	 * Edit
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( AffiliationRequestsScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/affiliation_requests/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}
}
