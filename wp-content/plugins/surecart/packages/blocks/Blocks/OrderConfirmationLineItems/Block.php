<?php

namespace SureCartBlocks\Blocks\OrderConfirmationLineItems;

use SureCartBlocks\Blocks\BaseBlock;
/**
 * Logout Button Block.
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
		ob_start(); ?>
			<sc-order-confirmation-details></sc-order-confirmation-details>
		<?php
		return ob_get_clean();
	}
}
