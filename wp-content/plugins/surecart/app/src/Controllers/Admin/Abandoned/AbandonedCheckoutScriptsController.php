<?php

namespace SureCart\Controllers\Admin\Abandoned;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Coupon page
 */
class AbandonedCheckoutScriptsController extends AdminModelEditController {
	/**
	 * What types of data to add the the page.
	 *
	 * @var array
	 */
	protected $with_data = [ 'currency', 'supported_currencies' ];

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/abandoned_checkout';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/abandoned-checkouts';
}
