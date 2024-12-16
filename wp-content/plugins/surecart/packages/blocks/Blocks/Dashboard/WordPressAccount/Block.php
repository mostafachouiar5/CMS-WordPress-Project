<?php

namespace SureCartBlocks\Blocks\Dashboard\WordPressAccount;

use SureCartBlocks\Blocks\Dashboard\DashboardPage;
use SureCartBlocks\Controllers\UserController;

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
		return ( new UserController() )->show( $attributes, $content );
	}
}
