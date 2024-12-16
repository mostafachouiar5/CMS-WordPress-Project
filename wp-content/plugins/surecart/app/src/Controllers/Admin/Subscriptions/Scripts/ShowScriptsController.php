<?php

namespace SureCart\Controllers\Admin\Subscriptions\Scripts;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Coupon page
 */
class ShowScriptsController extends AdminModelEditController {
	/**
	 * What types of data to add the the page.
	 *
	 * @var array
	 */
	protected $with_data = [ 'currency', 'tax_protocol', 'supported_currencies' ];

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/subscription/show';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/subscriptions/show';
}
