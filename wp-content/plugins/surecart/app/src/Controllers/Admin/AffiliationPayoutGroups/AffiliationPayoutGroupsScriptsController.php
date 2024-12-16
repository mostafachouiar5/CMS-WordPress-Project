<?php

namespace SureCart\Controllers\Admin\AffiliationPayoutGroups;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Affiliation Payout Groups Requests Scripts Controller
 */
class AffiliationPayoutGroupsScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/affiliation-payout-groups';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/affiliation-payouts-groups';
}
