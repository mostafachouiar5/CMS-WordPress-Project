<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ShippingProfile;

/**
 * Handle Shipping Profiles requests through the REST API
 */
class ShippingProfileController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ShippingProfile::class;
}
