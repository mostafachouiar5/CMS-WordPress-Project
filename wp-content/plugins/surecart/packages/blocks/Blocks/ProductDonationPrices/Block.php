<?php

namespace SureCartBlocks\Blocks\ProductDonationPrices;

use SureCart\Models\Product;
use SureCartBlocks\Blocks\BaseBlock;

/**
 * Product Title Block
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
		$product = Product::with( [ 'prices' ] )->find( $this->block->context['surecart/product-donation/product_id'] );
		if ( is_wp_error( $product ) ) {
			return $product->get_error_message();
		}

		// must have a minimum of 2 prices to show choices.
		if ( count( $product->activeAdHocPrices() ?? [] ) < 2
		) {
			return false;
		}

		$wrapper_attributes = get_block_wrapper_attributes(
			[
				'style' => implode(
					' ',
					[
						'border: none;',
						esc_attr( $this->getVars( $attributes, '--sc-choice' ) ),
						'--columns:' . intval( $attributes['columns'] ) . ';',
						! empty( $attributes['style']['spacing']['blockGap'] ) ? '--sc-choices-gap:' . $this->getSpacingPresetCssVar( $attributes['style']['spacing']['blockGap'] ) . ';' : '',
					]
				),
			]
		);

		return wp_sprintf(
			'<div %s>
				<sc-choices label="%s" required="%s">
					%s
				</sc-choices>
			</div>',
			$wrapper_attributes,
			esc_attr( $attributes['label'] ),
			$this->block->context['surecart/product-donation/required'] ? 'true' : 'false',
			filter_block_content( $content )
		);
	}
}
