<?php

namespace SureCart\Controllers\Admin\Subscriptions;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Controllers\Admin\Subscriptions\SubscriptionsListTable;
use SureCart\Controllers\Admin\Subscriptions\Scripts\EditScriptsController;
use SureCart\Controllers\Admin\Subscriptions\Scripts\ShowScriptsController;

/**
 * Handles product admin requests.
 */
class SubscriptionsController extends AdminController {
	/**
	 * Orders index.
	 */
	public function index() {
		$table = new SubscriptionsListTable();
		$table->prepare_items();
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'subscriptions' => [
						'title' => __( 'Subscriptions', 'surecart' ),
					],
				],
				'report_url'       => SURECART_REPORTS_URL . 'subscriptions',
			)
		);
		return \SureCart::view( 'admin/subscriptions/index' )->with(
			[
				'table' => $table,
			]
		);
	}

	/**
	 * Edit
	 *
	 * @return string
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( EditScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/subscriptions/' . $request->query( 'id' ) . '?context=edit&expand%5B0%5D=current_period&expand%5B1%5D=current_period.checkout&expand%5B2%5D=discount',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}

	/**
	 * Show
	 *
	 * @return string
	 */
	public function show( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( ShowScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/subscriptions?context=edit&ids[0]=' . $request->query( 'id' ) . '&expand[0]=current_period&expand[1]=period.checkout&expand[2]=checkout.line_items&expand[3]=line_item.price&expand[4]=line_item.fees&expand[5]=price&expand[6]=price.product&expand[7]=customer&expand[8]=customer.balances&expand[9]=purchase&expand[10]=discount&expand[11]=discount.coupon&expand[12]=order&expand[13]=current_cancellation_act&expand[14]=payment_method&expand[15]=payment_method.card&expand[16]=payment_method.payment_instrument&expand[17]=payment_method.paypal_account&expand[18]=payment_method.bank_account',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}
}
