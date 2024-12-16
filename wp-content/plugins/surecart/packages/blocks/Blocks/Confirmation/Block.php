<?php

namespace SureCartBlocks\Blocks\Confirmation;

use SureCartBlocks\Blocks\BaseBlock;

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
		return '<sc-order-confirmation>' . filter_block_content( $content, 'post' ) . '</sc-order-confirmation>';
	}
}
