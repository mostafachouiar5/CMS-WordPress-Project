<?php

namespace SureCart\Controllers\Admin\AffiliationReferrals;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Affiliation Requests Scripts Controller
 */
class AffiliationReferralsScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/affiliation-referral';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/affiliation-referrals';

	/**
	 * Add the app url to the data.
	 */
	public function __construct() {
		$this->data['api_url'] = \SureCart::requests()->getBaseUrl();
	}
}
