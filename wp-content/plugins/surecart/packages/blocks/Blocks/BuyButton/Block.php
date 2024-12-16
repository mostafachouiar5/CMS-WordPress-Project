<?php

namespace SureCartBlocks\Blocks\BuyButton;

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
	public function render( $attributes, $content = '' ) {

		$styles = '';
		if ( ! empty( $attributes['backgroundColor'] ) ) {
			$styles .= "background-color: {$attributes['backgroundColor']}; ";
		}
		if ( ! empty( $attributes['textColor'] ) ) {
			$styles .= "color: {$attributes['textColor']}; ";
		}

		return \SureCart::block()->render(
			'blocks/buy-button',
			[
				'type'  => $attributes['type'] ?? 'primary',
				'size'  => $attributes['size'] ?? 'medium',
				'style' => $styles,
				'class' => 'sc-button wp-element-button wp-block-button__link sc-button__link',
				'href'  => $this->href( $attributes['line_items'] ?? [] ),
				'label' => $attributes['label'] ?? __( 'Buy Now', 'surecart' ),
			]
		);
	}

	/**
	 * Build the line items array.
	 *
	 * @param array $line_items Line items.
	 * @return array Line items.
	 */
	public function lineItems( $line_items ) {
		return array_map(
			function( $item ) {
				return [
					'price_id'   => $item['id'] ?? null,
					'variant_id' => $item['variant_id'] ?? null,
					'quantity'   => $item['quantity'] ?? 1,
				];
			},
			$line_items ?? []
		);
	}

	/**
	 * Build the button url.
	 *
	 * @param array $line_items Line items.
	 * @return string url
	 */
	public function href( $line_items = [] ) {
		return add_query_arg(
			[
				'line_items' => $this->lineItems( $line_items ?? [] ),
				'no_cart'    => true,
			],
			\SureCart::pages()->url( 'checkout' )
		);
	}
}
