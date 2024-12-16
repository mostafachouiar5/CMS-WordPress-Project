<?php

namespace SureCartBlocks\Blocks\CartBumpLineItem;

use SureCartBlocks\Blocks\CartBlock;

/**
 * Cart CTA Block.
 */
class Block extends CartBlock {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 * @param object $block Block object.
	 *
	 * @return string
	 */
	public function render( $attributes, $content, $block = null ) {
		ob_start(); ?>

		<sc-line-item-bump
			label="<?php echo esc_attr( $attributes['label'] ?? '' ); ?>"
			class="<?php echo esc_attr( $attributes['className'] ?? '' ); ?>"
			style="<?php echo esc_attr( $this->getStyle( $attributes ) ); ?>"></sc-line-item-bump>

		<?php
		return ob_get_clean();
	}
}
