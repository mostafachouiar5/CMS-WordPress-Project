<?php

namespace SureCartBlocks\Blocks\Upsell\UpsellTotals;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Upsell Description Block
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
		return wp_sprintf(
			'<sc-upsell-totals %s></sc-upsell-totals>',
			get_block_wrapper_attributes()
		);
	}
}
