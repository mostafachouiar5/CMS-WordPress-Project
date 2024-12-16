<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Upload;

/**
 * Handle Price requests through the REST API
 */
class UploadsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Upload::class;
}
