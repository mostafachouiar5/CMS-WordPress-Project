<?php

namespace SureCartBlocks\Blocks\PriceSelector;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Checkout block
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
		sc_initial_state(
			[
				'checkout' => [
					'initialLineItems' => sc_initial_line_items( $this->getInitialLineItems() ),
				],
			]
		);

		return '<sc-price-choices
					class="wp-block-surecart-price-choice ' . esc_attr( $this->getClasses( $attributes ) || '' ) . '"
					label="' . esc_attr( $attributes['label'] ?? '' ) . '"
					type="' . esc_attr( $attributes['type'] ?? 'radio' ) . '"
					columns="' . intval( $attributes['columns'] ?? 1 ) . '"
				>' .
					$this->getRemovedPriceChoicesWrapper( $content )
				. '</sc-price-choices>';
	}

	/**
	 * Get the initial line items.
	 *
	 * @return array
	 */
	public function getInitialLineItems() {
		// get choice blocks.
		$choices = $this->getInnerPriceChoices();

		// are any checked by default?
		$checked = array_filter(
			$choices,
			function( $block ) {
				return ! empty( $block['attrs']['checked'] );
			}
		);

		// there are no checked, so use the first one.
		if ( empty( $checked ) ) {
			$checked = ! empty( $choices[0] ) ? [ $choices[0] ] : [];
		}

		// get the line items.
		return $this->convertPriceBlocksToLineItems( $checked );
	}

	/**
	 * Get the inner price choice blocks.
	 *
	 * @return array
	 */
	public function getInnerPriceChoices() {
		return array_filter(
			$this->block->parsed_block['innerBlocks'],
			function( $block ) {
				return 'surecart/price-choice' === $block['blockName'] && ! empty( $block['attrs']['price_id'] );
			}
		);
	}

	/**
	 * Convert price blocks to line items
	 *
	 * @param array $blocks Array of parsed blocks.
	 *
	 * @return array    Array of line items.
	 */
	public function convertPriceBlocksToLineItems( $blocks ) {
		return array_values(
			array_map(
				function( $block ) {
					return [
						'price'    => $block['attrs']['price_id'],
						'quantity' => $block['attrs']['quantity'] ?? 1,
					];
				},
				$blocks
			)
		);
	}

	/**
	 * Remove price choice wrapper and return the html.
	 *
	 * @param string $content Block content.
	 *
	 * @return string
	 */
	public function getRemovedPriceChoicesWrapper( $content ): string {
		if(empty($content)){
			return '';
		}

		$price_choices_tag = trim(str_replace('</sc-price-choices>', '', strip_tags($content, '<sc-price-choices>')));
		$content = str_replace($price_choices_tag, '', $content);
		$content = str_replace('</sc-price-choices>', '', $content);

		return filter_block_content( $content, 'post' );
	}
}
