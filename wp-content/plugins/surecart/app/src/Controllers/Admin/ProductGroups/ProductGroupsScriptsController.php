<?php

namespace SureCart\Controllers\Admin\ProductGroups;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Product Group Scripts
 */
class ProductGroupsScriptsController extends AdminModelEditController {
	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/product-groups';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/product-groups';
}
