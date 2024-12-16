<?php

namespace SureCart\Controllers\Admin\Dashboard;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Coupon page
 */
class DashboardScriptsController extends AdminModelEditController {
	/**
	 * What types of data to add the the page.
	 *
	 * @var array
	 */
	protected $with_data = [ 'currency', 'supported_currencies', 'claimed', 'claim_url' ];

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/dashboard';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/dashboard';
}
