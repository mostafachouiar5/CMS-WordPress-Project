<?php

namespace SureCartBlocks\Blocks\Dashboard\CustomerPaymentMethods;

use SureCartBlocks\Blocks\Dashboard\DashboardPage;
use SureCartBlocks\Controllers\PaymentMethodController;

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
		return ( new PaymentMethodController() )->index( $attributes, $content );
	}
}
