<?php

namespace SureCartBlocks\Blocks\Dashboard\CustomerDashboard;

use SureCartBlocks\Blocks\BaseBlock;
use SureCart\Models\User;

/**
 * Checkout block
 */
class Block extends BaseBlock {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		if ( ! is_user_logged_in() ) {
			return \SureCart::block()->render( 'web/login' );
		}

		// cannot get user.
		$user = User::current();
		if ( ! $user ) {
			return \SureCart::block()->render( 'web/login' );
		}

		return $content;
	}
}
