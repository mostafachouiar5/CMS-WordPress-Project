<?php

namespace SureCart\Controllers\Admin\Coupons;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Coupon page
 */
class CouponScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/coupon';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/coupons';
}
