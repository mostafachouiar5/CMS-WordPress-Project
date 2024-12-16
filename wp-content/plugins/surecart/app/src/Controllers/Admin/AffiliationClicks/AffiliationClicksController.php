<?php

namespace SureCart\Controllers\Admin\AffiliationClicks;

use SureCart\Controllers\Admin\AdminController;

/**
 * Handles affiliate clicks admin routes.
 */
class AffiliationClicksController extends AdminController {
	/**
	 * Affiliate Clicks index.
	 */
	public function index() {
		$table = new AffiliationClicksListTable();
		$table->prepare_items();
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'affiliate_clicks' => [
						'title' => __( 'Clicks', 'surecart' ),
					],
				],
			)
		);
		return \SureCart::view( 'admin/affiliation-clicks/index' )->with( [ 'table' => $table ] );
	}
}
