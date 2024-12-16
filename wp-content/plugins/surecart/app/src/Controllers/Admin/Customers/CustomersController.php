<?php

namespace SureCart\Controllers\Admin\Customers;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Models\Product;
use SureCartCore\Responses\RedirectResponse;
use SureCart\Controllers\Admin\Customers\CustomersListTable;

/**
 * Handles product admin requests.
 */
class CustomersController extends AdminController {

	/**
	 * Products index.
	 */
	public function index() {
		$table = new CustomersListTable();
		$table->prepare_items();
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'customers' => [
						'title' => __( 'Customers', 'surecart' ),
					],
				],
			)
		);
		return \SureCart::view( 'admin/customers/index' )->with( [ 'table' => $table ] );
	}

	/**
	 * Customers edit.
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( CustomersScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/customers/' . $request->query( 'id' ) . '?context=edit&expand%5B0%5D=balances',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}
}
