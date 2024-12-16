<?php

namespace SureCartBlocks\Blocks\LogoutButton;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Logout Button Block.
 */
class Block extends BaseBlock {
	/**
	 * Run any block middleware before rendering.
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content   Post content.
	 *
	 * @return boolean
	 */
	public function middleware( $attributes, $content ) {
		return is_user_logged_in();
	}

	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		// Build the redirect URL.
		$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$current_url = remove_query_arg( 'tab', $current_url );

		return \SureCart::block()->render(
			'blocks/logout-button',
			[
				'href'      => esc_url( wp_logout_url( $attributes['redirectToCurrent'] ? $current_url : '' ) ),
				'type'      => $attributes['type'] ?? 'primary',
				'size'      => $attributes['size'] ?? 'medium',
				'show_icon' => (bool) $attributes['show_icon'] ?? false,
				'label'     => $attributes['label'] ?? __( 'Logout', 'surecart' ),
			]
		);
	}
}
