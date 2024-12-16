<?php

namespace SureCartBlocks\Blocks\Product\CollectionBadges;

use SureCartBlocks\Blocks\Product\ProductBlock;
use SureCartBlocks\Util\BlockStyleAttributes;

/**
 * Product Collection Block
 */
class Block extends ProductBlock {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		return \SureCart::block()
			->productCollectionBadgesMigration( $attributes, $this->block )
			->render();
	}
}
