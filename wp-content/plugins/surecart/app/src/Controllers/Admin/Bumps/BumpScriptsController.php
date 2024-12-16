<?php

namespace SureCart\Controllers\Admin\Bumps;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Bump Page
 */
class BumpScriptsController extends AdminModelEditController {
	/**
	 * What types of data to add the the page.
	 *
	 * @var array
	 */
	protected $with_data = [ 'currency', 'supported_currencies', 'tax_protocol', 'checkout_page_url' ];

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/bump';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/bumps';
}
