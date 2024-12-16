<?php

namespace SureCart\Controllers\Admin\Orders;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Coupon page
 */
class OrderScriptsController extends AdminModelEditController {
	/**
	 * What types of data to add the the page.
	 *
	 * @var array
	 */
	protected $with_data = [ 'currency', 'supported_currencies', 'links', 'shipping_protocol' ];

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/order';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/orders';
}
