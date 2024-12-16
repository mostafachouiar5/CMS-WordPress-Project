<?php

namespace SureCart\Controllers\Admin\Coupons;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Controllers\Admin\Coupons\CouponsListTable;

/**
 * Handles product admin requests.
 */
class CouponsController extends AdminController {

	/**
	 * Coupons index.
	 */
	public function index() {
		$table = new CouponsListTable();
		$table->prepare_items();

		$this->withHeader(
			array(
				'breadcrumbs' => [
					'coupons' => [
						'title' => __( 'Coupons', 'surecart' ),
					],
				],
			)
		);

		return \SureCart::view( 'admin/coupons/index' )->with(
			[
				'table' => $table,
			]
		);
	}

	/**
	 * Coupons edit.
	 */
	public function edit( $request ) {
		// admin edit page.
		do_action( 'surecart/admin/coupons/edit' );
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( CouponScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/coupons/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}
}
