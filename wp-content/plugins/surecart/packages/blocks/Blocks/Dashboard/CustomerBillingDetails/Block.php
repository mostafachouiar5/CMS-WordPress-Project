<?php

namespace SureCartBlocks\Blocks\Dashboard\CustomerBillingDetails;

use SureCartBlocks\Blocks\Dashboard\DashboardPage;
use SureCartBlocks\Controllers\CustomerController;

/**
 * Checkout block
 */
class Block extends DashboardPage {
	/**
	 * Render the block
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
		return ( new CustomerController() )->preview( $attributes, $content );
	}
}
