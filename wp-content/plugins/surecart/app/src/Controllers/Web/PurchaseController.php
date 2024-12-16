<?php

namespace SureCart\Controllers\Web;

/**
 * Thank you routes
 */
class PurchaseController {
	/**
	 * Edit a product.
	 */
	public function show() {
		return \SureCart::view( 'web.purchased' );
	}
}
