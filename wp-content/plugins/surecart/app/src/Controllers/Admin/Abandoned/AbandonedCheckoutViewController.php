<?php

namespace SureCart\Controllers\Admin\Abandoned;

use SureCart\Controllers\Admin\Abandoned\AbandonedCheckoutListTable;
use SureCart\Controllers\Admin\AdminController;

/**
 * Handles product admin requests.
 */
class AbandonedCheckoutViewController extends AdminController {
	/**
	 * Index.
	 */
	public function index() {
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'orders' => [
						'title' => __( 'Abandoned Checkouts', 'surecart' ),
					],
				],
				'report_url'       => SURECART_REPORTS_URL . 'abandoned_checkouts',
			)
		);

		$table = new AbandonedCheckoutListTable();
		$table->prepare_items();
		return \SureCart::view( 'admin/abandoned-orders/index' )->with(
			[
				'table'   => $table,
				'enabled' => \SureCart::account()->entitlements->abandoned_checkouts ?? false,
			]
		);
	}

	/**
	 * Edit abandoned order.
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( AbandonedCheckoutScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/settings',
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/abandoned_checkouts/' . $request->query( 'id' ) . '?context=edit&expand%5B0%5D=promotion&expand%5B1%5D=promotion.coupon&expand%5B2%5D=recovered_checkout&expand%5B3%5D=checkout&expand%5B4%5D=customer&expand%5B5%5D=checkout.tax_identifier&expand%5B6%5D=checkout.shipping_address&expand%5B7%5D=checkout.discount&expand%5B8%5D=checkout.line_items&expand%5B9%5D=discount.promotion&expand%5B10%5D=line_item.price&expand%5B11%5D=line_item.fees&expand%5B12%5D=customer.balances&expand%5B13%5D=price.product',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}
}
