<?php

namespace SureCartBlocks\Blocks\CartSubtotal;

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

		<sc-line-item-total
			total="subtotal"
			size="large"
			class="<?php echo esc_attr( $attributes['className'] ?? '' ); ?>"
			style="<?php echo esc_attr( $this->getStyle( $attributes ) ); ?>"
		>
			<span slot="title"><?php echo wp_kses_post( $attributes['label'] ?? __( 'Total', 'surecart' ) ); ?></span>
		</sc-line-item-total>

		<?php
		return ob_get_clean();
	}
}
