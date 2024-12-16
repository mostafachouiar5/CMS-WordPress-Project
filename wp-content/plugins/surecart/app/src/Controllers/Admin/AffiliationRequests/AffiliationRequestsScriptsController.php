<?php

namespace SureCart\Controllers\Admin\AffiliationRequests;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Affiliation Requests Scripts Controller
 */
class AffiliationRequestsScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/affiliation-request';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/affiliation-requests';

	/**
	 * Add the app url to the data.
	 */
	public function __construct() {
		$this->data['api_url'] = \SureCart::requests()->getBaseUrl();
	}
}
