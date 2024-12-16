<?php

namespace SureCart\Controllers\Admin\Licenses;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Licenses Page
 */
class LicensesScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/licenses';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/licenses';
}
