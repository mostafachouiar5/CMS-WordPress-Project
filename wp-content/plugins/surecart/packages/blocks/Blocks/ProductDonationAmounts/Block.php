<?php

namespace SureCartBlocks\Blocks\ProductDonationAmounts;

use SureCartBlocks\Blocks\BaseBlock;
use SureCartBlocks\Util\BlockStyleAttributes;

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
		[ 'styles' => $styles ] = BlockStyleAttributes::getClassesAndStylesFromAttributes( $attributes, [ 'margin' ] );

		$wrapper_attributes = get_block_wrapper_attributes(
			[
				'style' => implode(
					' ',
					[
						'border: none;',
						esc_attr( $this->getVars( $attributes, '--sc-choice' ) ),
						'--columns:' . intval( $attributes['columns'] ) . ';',
						! empty( $attributes['style']['spacing']['blockGap'] ) ? '--sc-choices-gap:' . $this->getSpacingPresetCssVar( $attributes['style']['spacing']['blockGap'] ) . ';' : '',
						$styles,
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
