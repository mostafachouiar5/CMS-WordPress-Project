<?php

namespace SureCartBlocks\Blocks\CartMenuButton;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Cart Menu Button CTA Block.
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
	public function render( $attributes, $content = '' ) {
		return \SureCart::block()->cartMenuIconMigration( $attributes, $this->block )->render();
	}
}
