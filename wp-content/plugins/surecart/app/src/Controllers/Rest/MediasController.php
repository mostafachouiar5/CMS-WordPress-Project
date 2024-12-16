<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Media;

/**
 * Handle File requests through the REST API
 */
class MediasController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Media::class;
}
