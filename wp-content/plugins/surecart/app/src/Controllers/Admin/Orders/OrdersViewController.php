<?php

namespace SureCart\Controllers\Admin\Orders;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Controllers\Admin\Orders\OrdersListTable;

/**
 * Handles product admin requests.
 */
class OrdersViewController extends AdminController {
	/**
	 * Orders index.
	 */
	public function index() {
		$table = new OrdersListTable();
		$table->prepare_items();
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'orders' => [
						'title' => __( 'Orders', 'surecart' ),
					],
				],
				'report_url'       => SURECART_REPORTS_URL . 'orders',
			)
		);
		return \SureCart::view( 'admin/orders/index' )->with(
			[
				'table' => $table,
			]
		);
	}

	/**
	 * Orders edit
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( OrderScriptsController::class, 'enqueue' ) );

		// preload some requests.
		if ( $request->query( 'id' ) ) {
			$this->preloadPaths(
				[
					'/wp/v2/users/me',
					'/wp/v2/types?context=view',
					'/wp/v2/types?context=edit',
					'/surecart/v1/orders/' . $request->query( 'id' ) . '?context=edit&expand[0]=checkout&expand[1]=checkout.charge&expand[2]=checkout.customer&expand[3]=checkout.tax_identifier&expand[4]=checkout.payment_failures&expand[5]=checkout.shipping_address&expand[6]=checkout.discount&expand[7]=checkout.line_items&expand[8]=discount.promotion&expand[9]=line_item.price&expand[10]=line_item.fees&expand[11]=customer.balances&expand[12]=price.product',
				]
			);
		}

		// return view.
		return '<div id="app"></div>';
	}

	/**
	 * Archive orders.
	 */
	public function archive( $request ) {
		// flash an error message
		\SureCart::flash()->add( 'errors', 'Please enter a valid email address.' );
		// redirect to order index page.
		return \SureCart::redirect()->to( \SureCart::getUrl()->index( 'order' ) );
	}
}
