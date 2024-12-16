<?php

namespace SureCart\Controllers\Admin\CancellationInsights;

use SureCart\Controllers\Admin\CancellationInsights\CancellationInsightsListTable;
use SureCart\Controllers\Admin\AdminController;

/**
 * Handles product admin requests.
 */
class CancellationInsightsController extends AdminController {
	/**
	 * Index.
	 */
	public function index() {
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'subscriptions' => [
						'title' => __( 'Subscription Saver & Insights', 'surecart' ),
					],
				],
				'report_url'       => SURECART_REPORTS_URL . 'cancellation_acts',
			)
		);

		$table = new CancellationInsightsListTable();
		$table->prepare_items();
		return \SureCart::view( 'admin/cancellation-insights/index' )->with(
			[
				'table'   => $table,
				'enabled' => \SureCart::account()->entitlements->subscription_preservation ?? false,
			]
		);
	}
}
