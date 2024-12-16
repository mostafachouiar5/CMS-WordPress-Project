<?php

namespace SureCartBlocks\Blocks\CartCoupon;

use SureCartBlocks\Blocks\CartBlock;

/**
 * Checkout block
 */
class Block extends CartBlock {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		ob_start();
		?>
		<sc-order-coupon-form
			label="<?php echo esc_attr( $attributes['text'] ?? '' ); ?>"
			placeholder="<?php echo esc_attr( $attributes['placeholder'] ); ?>"
			class="<?php echo esc_attr( $attributes['className'] ?? '' ); ?>"
			style="<?php echo esc_attr( $this->getStyle( $attributes ) ); ?>"
			<?php echo ! empty( $attributes['collapsed'] ) || ! isset( $attributes['collapsed'] ) ? 'collapsed' : ''; ?>>
			<?php echo wp_kses_post( $attributes['button_text'] ?? __( 'Apply', 'surecart' ) ); ?>
		</sc-order-coupon-form>
		<?php
		return ob_get_clean();
	}
}
