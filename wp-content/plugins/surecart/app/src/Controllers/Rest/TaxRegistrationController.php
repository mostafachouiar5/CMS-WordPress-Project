<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\TaxRegistration;

/**
 * Handle coupon requests through the REST API
 */
class TaxRegistrationController extends RestController {
	/**
	 * Always fetch with these subcollections.
	 *
	 * @var array
	 */
	protected $with = [ 'tax_identifier', 'tax_zone' ];
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = TaxRegistration::class;
}
