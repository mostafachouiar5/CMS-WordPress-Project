<?php

namespace SureCartBlocks\Blocks\ProductDonation;

use SureCart\Models\Product;
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
		if ( empty( $attributes['product_id'] ) ) {
			return '';
		}

		// get the product.
		$product = Product::with( array( 'prices' ) )->find( $attributes['product_id'] ?? '' );
		if ( is_wp_error( $product ) ) {
			return $product->get_error_message();
		}

		// no ad_hoc prices.
		if ( ! count( $product->activeAdHocPrices() ) ) {
			return false;
		}

		// get amounts from inner blocks.
		$amounts = $this->getAmounts();
		if ( empty( $amounts ) ) {
			return false;
		}

		// set initial state.
		sc_initial_state(
			array(
				'checkout'        => array(
					'initialLineItems' => sc_initial_line_items( $this->getInitialLineItems( $product, $amounts ) ),
				),
				'productDonation' => array(
					$attributes['product_id'] => array(
						'product'       => $product->toArray(),
						'amounts'       => $amounts,
						'ad_hoc_amount' => null,
						'custom_amount' => null,
						'selectedPrice' => ( $product->active_prices || array() )[0] ?? null,
					),
				),
			)
		);

		[ 'styles' => $styles, 'classes' => $classes ] = BlockStyleAttributes::getClassesAndStylesFromAttributes( $attributes );

		if ( ! empty( $attributes['textColor'] ) ) {
			$styles .= '--sc-input-label-color: ' . $attributes['textColor'] . '; ';
		}

		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'style' => esc_attr( $styles ),
				'class' => esc_attr( $classes ),
			)
		);

		return wp_sprintf(
			'<div %s>
				%s
			</div>',
			$wrapper_attributes,
			filter_block_content( $content )
		);

		return filter_block_content( $content );
	}

	/**
	 * Get the initial line items.
	 *
	 * @return array
	 */
	public function getInitialLineItems( $product, $amounts ) {
		if ( empty( $product->activeAdHocPrices()[0] ) ) {
			return array();
		}

		return array(
			array(
				'price'         => $product->activeAdHocPrices()[0]->id,
				'ad_hoc_amount' => $product->activeAdHocPrices()[0]->amount,
				'quantity'      => 1,
			),
		);
	}

	/**
	 * Get the amounts.
	 *
	 * @return array
	 */
	public function getAmounts() {
		$amounts_block = array_filter(
			$this->block->parsed_block['innerBlocks'],
			function ( $block ) {
				return 'surecart/product-donation-amounts' === $block['blockName'];
			},
		);

		if ( empty( $amounts_block[0]['innerBlocks'] ) ) {
			return false;
		}

		// get amounts from inner blocks.
		return array_values(
			array_map(
				function ( $block ) {
					return $block['attrs']['amount'] ?? 0;
				},
				$amounts_block[0]['innerBlocks']
			)
		);
	}
}
