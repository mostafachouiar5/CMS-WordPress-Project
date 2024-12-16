<?php

namespace SureCart\Controllers\Web;

/**
 * Thank you routes
 */
class SubscriptionsController {
	/**
	 * Show the user's subscriptions
	 */
	public function show( $request, $view ) {
		return \SureCart::view( $view );
	}
}
