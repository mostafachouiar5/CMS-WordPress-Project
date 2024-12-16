<?php

namespace SureCart\Controllers\Admin\AffiliationPayouts;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Affiliation Requests Scripts Controller
 */
class AffiliationPayoutsScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/affiliation-payout';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/affiliation-payouts';
}
