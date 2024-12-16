<?php

namespace SureCart\Controllers\Admin\Cart;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Coupon page
 */
class CartScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/cart';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/cart/edit';
}
