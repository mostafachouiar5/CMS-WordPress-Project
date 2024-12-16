<?php

namespace SureCart\Controllers\Admin\Affiliations;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Afiiation scripts controller.
 */
class AffiliationsScriptsController extends AdminModelEditController {
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
	protected $handle = 'surecart/scripts/admin/affiliation';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/affiliations';

	/**
	 * Add the app url to the data.
	 */
	public function __construct() {
		$this->data['api_url'] = \SureCart::requests()->getBaseUrl();
	}
}
