<?php

namespace SureCart\Controllers\Admin\Subscriptions\Scripts;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Coupon page
 */
class EditScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/subscription/edit';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/subscriptions/edit';
}
