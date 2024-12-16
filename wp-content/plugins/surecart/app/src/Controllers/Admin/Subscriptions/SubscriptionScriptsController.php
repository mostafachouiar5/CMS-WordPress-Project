<?php

namespace SureCart\Controllers\Admin\Subscriptions;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Coupon page
 */
class SubscriptionScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/subscription';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/subscriptions';
}
