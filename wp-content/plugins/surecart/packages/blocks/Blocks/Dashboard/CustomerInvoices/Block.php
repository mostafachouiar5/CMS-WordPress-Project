<?php

namespace SureCartBlocks\Blocks\Dashboard\CustomerInvoices;

use SureCartBlocks\Blocks\Dashboard\DashboardPage;
use SureCartBlocks\Controllers\InvoiceController;

/**
 * Checkout block
 */
class Block extends DashboardPage {
	/**
	 * Render the preview (overview)
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return function
	 */
	public function render( $attributes, $content ) {
		if ( ! is_user_logged_in() ) {
			return;
		}
		return ( new InvoiceController() )->preview( $attributes );
	}
}
