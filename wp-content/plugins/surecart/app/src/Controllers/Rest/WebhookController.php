<?php
namespace SureCart\Controllers\Rest;

use SureCart\Models\Webhook;

/**
 * Handles webhooks
 */
class WebhookController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Webhook::class;
}
