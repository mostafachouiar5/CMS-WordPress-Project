<?php

namespace SureCart\WordPress;

/**
 * LineItemStateService class
 */
class LineItemStateService {
	/**
	 * Keeps track of already parsed blocks.
	 *
	 * @var array
	 */
	protected static $parsed_blocks = [];

	/**
	 * Get existing line items from the checkout.
	 *
	 * @param string $store The store name.
	 * @param string $key The key to get.
	 */
	public function get( $store = 'checkout', $key = 'initialLineItems' ) {
		$initial = sc_initial_state();
		return ! empty( $initial[ $store ][ $key ] ) ? $initial[ $store ][ $key ] : [];
	}

	/**
	 * Add line items to the checkout.
	 *
	 * @param array  $line_items The line items to add.
	 * @param string $store The store name.
	 * @param string $key The key to get.
	 *
	 * @return array The new line items.
	 */
	public function merge( $line_items = [], $store = 'checkout', $key = 'initialLineItems' ) {
		$initial       = sc_initial_state();
		$initial_items = $initial[ $store ][ $key ] ?? [];

		// filter out any line items that were already added.
		$merged_line_items = array_filter(
			$line_items,
			function ( $line_item ) use ( $initial_items ) {
				// if the line item does not exist, add it.
				return ! $this->lineItemExists( $line_item, $initial_items );
			}
		);

		return array_merge( $initial_items, $merged_line_items );
	}

	/**
	 * Does the line item exist?
	 *
	 * @param array $line_item The line item to check.
	 *
	 * @return boolean
	 */
	public function lineItemExists( $line_item, $line_items ) {
		return array_reduce(
			$line_items,
			function ( $carry, $existing_line_item ) use ( $line_item ) {
				$existing_price_id   = $existing_line_item['price_id'] ?? $existing_line_item['price'] ?? null;
				$existing_variant_id = $existing_line_item['variant_id'] ?? $existing_line_item['variant'] ?? null;
				$price_id            = $line_item['price_id'] ?? $line_item['price'] ?? null;
				$variant_id          = $line_item['variant_id'] ?? $line_item['variant'] ?? null;

				if ( (bool) $existing_variant_id && (bool) $variant_id && $existing_variant_id === $variant_id ) {
					if ( $existing_price_id === $price_id ) {
						return true;
					}
				}

				if ( (bool) $existing_price_id && (bool) $price_id && $existing_price_id === $price_id ) {
					return true;
				}

				return $carry;
			},
			false
		);
	}
}
