<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ShippingProtocol;

/**
 * Handle Shipping Protocol requests through the REST API
 */
class ShippingProtocolController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ShippingProtocol::class;
}
