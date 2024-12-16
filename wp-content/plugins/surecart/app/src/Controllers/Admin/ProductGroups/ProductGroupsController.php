<?php

namespace SureCart\Controllers\Admin\ProductGroups;

use SureCart\Controllers\Admin\AdminController;

/**
 * Handles product admin requests.
 */
class ProductGroupsController extends AdminController {
	/**
	 * Index.
	 */
	public function index() {
		$table = new ProductGroupsListTable();
		$table->prepare_items();
		return \SureCart::view( 'admin/product-groups/index' )->with(
			[
				'table' => $table,
			]
		);
	}

	/**
	 * Show
	 */
	public function show( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( ProductGroupsScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/product_groups/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}
}
