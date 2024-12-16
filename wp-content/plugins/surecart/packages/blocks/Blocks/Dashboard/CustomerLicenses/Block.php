<?php

namespace SureCartBlocks\Blocks\Dashboard\CustomerLicenses;

use SureCartBlocks\Blocks\Dashboard\DashboardPage;
use SureCartBlocks\Controllers\LicenseController;

/**
 * Checkout block
 */
class Block extends DashboardPage {
	/**
	 * Render the preview (overview)
	 *
	 * @param array  $attributes Block attributes
	 * @param string $content Post content
	 *
	 * @return function
	 */
	public function render( $attributes, $content ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		return ( new LicenseController() )->preview( $attributes );
	}
}
