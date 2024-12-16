<?php

namespace SureCart\Models\Blocks;

/**
 * The product list service.
 */
class ProductPageBlock {
	/**
	 * The URL.
	 *
	 * @var object
	 */
	protected $url;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->url = \SureCart::block()->urlParams();
	}

	/**
	 * Get the variants query.
	 *
	 * @return array|null
	 */
	public function getVariantsQuery() {
		$product = sc_get_product();

		if ( empty( $product ) || empty( $product->variants->data ) ) {
			return null;
		}

		// get the initial defaults if there were no args.
		// we need to turn into slugs for comparison to make sure capitalization,
		// spacing, etc. doesn't matter.
		$initial_defaults = array_reduce(
			$product->variant_options->data ?? [],
			function ( $carry, $option ) {
				$name           = sanitize_title( $option->name );
				$carry[ $name ] = sanitize_title( $option->values[0] );
				return $carry;
			},
			[]
		);

		// use initial defaults to only get args needed.
		$args = [];
		foreach ( $initial_defaults as $key => $value ) {
			$args[ $key ] = $this->url->getArg( $key );
		}

		// merge the args with the initial defaults.
		$attributes = wp_parse_args(
			array_filter( $args ),
			$initial_defaults
		);

		// loop through the attributes.
		$keys = [];
		foreach ( $attributes as $option_name => $value ) {
			// find the option index based on the name.
			$option_index = array_search(
				// get the sanitized option name for comparison.
				sanitize_title( $option_name ),
				// get the sanitized option names for comparison.
				array_map(
					fn( $name ) => sanitize_title( $name ),
					array_column( $product->variant_options->data, 'name' )
				),
				true
			);

			// if the option index is not found, skip.
			$keys[ 'option_' . ( $option_index + 1 ) ] = $value;
		}

		return $keys;
	}

	/**
	 * Get the URL.
	 *
	 * @return object|null
	 */
	public function getSelectedVariant() {
		$product = sc_get_product();

		if ( empty( $product ) || empty( $product->variants->data ) ) {
			return null;
		}

		// loop through the attributes.
		$keys = $this->getVariantsQuery();

		$variants = array_values(
			array_filter(
				( $product->variants->data ?? [] ),
				function ( $variant ) use ( $keys ) {
					foreach ( $keys as $key => $value ) {
						if ( sanitize_title( $variant->$key ) !== sanitize_title( $value ) ) {
							return false;
						}
					}
					return true;
				}
			)
		);

		if ( ! empty( $variants[0] ) ) {
			return $variants[0];
		}

		if ( ! empty( $product->first_variant_with_stock ) ) {
			return $product->first_variant_with_stock;
		}

		return $product->variants->data[0] ?? null;
	}

	/**
	 * Get the URL.
	 *
	 * @return object|null
	 */
	public function urlParams() {
		return $this->url;
	}

	/**
	 * Get the context.
	 *
	 * @param array $context The context to add to the existing context.
	 *
	 * @return array
	 */
	public function context( $context = [] ) {
		$product = sc_get_product();
		if ( empty( $product ) ) {
			return [];
		}

		$selected_variant = $this->getSelectedVariant();

		return wp_parse_args(
			$context,
			array(
				'formId'          => \SureCart::forms()->getDefaultId(),
				'mode'            => \SureCart\Models\Form::getMode( \SureCart::forms()->getDefaultId() ),
				'checkoutUrl'     => \SureCart::pages()->url( 'checkout' ),
				'urlPrefix'       => $this->urlParams()->getKey(),
				'product'         => ! empty( $product ) ? $product->only( [ 'id', 'name', 'has_unlimited_stock', 'available_stock', 'archived', 'permalink' ] ) : null,
				'selectedPrice'   => ! empty( $product->initial_price ) ? $product->initial_price->only(
					[
						'id',
						'archived',
						'amount',
						'display_amount',
						'scratch_amount',
						'scratch_display_amount',
						'ad_hoc',
						'is_on_sale',
						'is_zero_decimal',
						'currency',
						'currency_symbol',
						'converted_ad_hoc_min_amount',
						'converted_ad_hoc_max_amount',
						'setup_fee_text',
						'interval_text',
						'short_interval_text',
						'interval_count_text',
						'payments_text',
						'trial_text',
					]
				) : null,
				'prices'          => array_map(
					fn( $price ) => $price->only(
						[
							'id',
							'archived',
							'amount',
							'display_amount',
							'scratch_amount',
							'scratch_display_amount',
							'ad_hoc',
							'is_on_sale',
							'is_zero_decimal',
							'currency',
							'currency_symbol',
							'converted_ad_hoc_min_amount',
							'converted_ad_hoc_max_amount',
							'setup_fee_text',
							'interval_text',
							'short_interval_text',
							'interval_count_text',
							'payments_text',
							'trial_text',
						]
					),
					$product->active_prices
				),
				'variants'        => array_map(
					fn( $variant ) => $variant->only(
						[
							'id',
							'option_1',
							'option_2',
							'option_3',
							'price',
							'amount',
							'display_amount',
							'available_stock',
						]
					),
					$product->variants->data ?? array()
				),
				'quantity'        => 1,
				'busy'            => false,
				'adHocAmount'     => ( ! empty( $product->initial_price->ad_hoc ) ? $product->initial_price->amount : 0 ) / ( ! empty( $product->initial_price->is_zero_decimal ) ? 1 : 100 ),
				'variantValues'   => array_filter(
					array(
						'option_1' => $selected_variant->option_1 ?? null,
						'option_2' => $selected_variant->option_2 ?? null,
						'option_3' => $selected_variant->option_3 ?? null,
					)
				),
				'text'            => __( 'Add to Cart', 'surecart' ),
				'outOfStockText'  => __( 'Sold Out', 'surecart' ),
				'unavailableText' => __( 'Unavailable For Purchase', 'surecart' ),
			),
		);
	}

	/**
	 * Get the state.
	 *
	 * @param array $state The state to add to the existing state.
	 *
	 * @return array
	 */
	public function state( $state = [] ) {
		$product = sc_get_product();
		if ( empty( $product ) ) {
			return [];
		}
		$selected_price   = $product->initial_price;
		$selected_variant = $this->getSelectedVariant();

		return wp_parse_args(
			$state,
			[
				'quantity'              => 1,
				'selectedDisplayAmount' => $product->display_amount,
				'isOnSale'              => function () {
					$context        = wp_interactivity_get_context();
					$selected_price = $context['selectedPrice'];
					return $selected_price['is_on_sale'] ?? false;
				},
				'selectedAmount'        => function () {
					$context        = wp_interactivity_get_context();
					$state          = wp_interactivity_state();
					$selected_price = $context['selectedPrice'];
					$prices         = $context['prices'];

					if ( ! empty( $prices ) && count( $prices ) > 1 ) {
						return $selected_price['amount'];
					}

					return $state['selectedVariant']['amount'] ?? $selected_price['amount'];
				},
				'busy'                  => false,
				'shouldDisplayImage'    => function () {
					$context = wp_interactivity_get_context();
					$state   = wp_interactivity_state();

					if ( empty( $context['variants'] ) ) {
						return true;
					}

					return $state['isOptionValueSelected']();
				},
				'adHocAmount'           => ( ! empty( $selected_price->ad_hoc ) ? $selected_price->amount : 0 ) / ( ! empty( $selected_price->is_zero_decimal ) ? 1 : 100 ),
				'selectedVariant'       => ! empty( $selected_variant ) ? $selected_variant->only(
					[
						'id',
						'option_1',
						'option_2',
						'option_3',
						'price',
						'amount',
						'display_amount',
						'available_stock',
					]
				) : [],
				'isOptionUnavailable'   => function () {
					$context        = wp_interactivity_get_context();
					$variants       = $context['variants'];
					$option         = $context['option_value'];
					$product        = $context['product'];
					$variant_values = $context['variantValues'];
					$option_number  = $context['optionNumber'];

					// stock is not enabled.
					if ( $product['has_unlimited_stock'] ) {
						return false;
					}

					if ( 1 === $option_number ) {
						$items         = array_filter(
							$variants ?? [],
							function ( $variant ) use ( $option ) {
								return $variant['option_1'] === $option;
							}
						);
						$highest_stock = max(
							array_map(
								function ( $item ) {
										return $item['available_stock'];
								},
								$items ?? []
							)
						);

						return $highest_stock <= 0;
					}

					if ( 2 === $option_number ) {
						$items         = array_filter(
							$variants ?? [],
							function ( $variant ) use ( $variant_values, $option ) {
								return $variant['option_1'] === $variant_values['option_1'] && $variant['option_2'] === $option;
							}
						);
						$highest_stock = max(
							array_map(
								function ( $item ) {
									return $item['available_stock'];
								},
								$items
							)
						);
						return $highest_stock <= 0;
					}

					$items = array_filter(
						$variants ?? [],
						function ( $variant ) use ( $variant_values, $option ) {
							return $variant['option_1'] === $variant_values['option_1'] && $variant['option_2'] === $variant_values['option_2'] && $variant['option_3'] === $option;
						}
					);

					$highest_stock = max(
						array_map(
							function ( $item ) {
								return $item['available_stock'];
							},
							$items
						)
					);

					return $highest_stock <= 0;
				},
				'isOptionValueSelected' => function () {
					$context = wp_interactivity_get_context();

					if ( empty( $context['optionValue'] ) ) {
						return true;
					}

					$values = array_map(
						function ( $value ) {
							return strtolower( $value );
						},
						array_values( $context['variantValues'] )
					);

					return in_array( strtolower( $context['optionValue'] ), $values );
				},
				'imageDisplay'          => function () {
					$state = wp_interactivity_state();
					return $state['shouldDisplayImage']() ? 'inherit' : 'none';
				},
				'isSoldOut'             => function () {
					$context = wp_interactivity_get_context();
					$state   = wp_interactivity_state();
					$product = $context['product'];
					if ( $product['has_unlimited_stock'] ) {
						return false;
					}
					if ( ! empty( $context['variants'] ) && empty( $state['selectedVariant'] ) ) {
						return false;
					}
					return ! empty( $state['selectedVariant']['id'] ) ? $state['selectedVariant']['available_stock'] <= 0 : $product['available_stock'] <= 0;
				},
				'isUnavailable'         => function () {
					$context = wp_interactivity_get_context();
					$state   = wp_interactivity_state();
					if ( ! empty( $context['product']->archived ) || ! empty( $state['isSoldOut']() ) ) {
						return true;
					}
					if ( ! empty( $context['variants'] ) && empty( $state['selectedVariant'] ) ) {
						return true;
					}
					return false;
				},
				'isOptionSelected'      => function () {
					$context       = wp_interactivity_get_context();
					$option_number = $context['optionNumber'] ?? '';
					if ( ! isset( $context['variantValues'][ "option_$option_number" ] ) || ! isset( $context['option_value'] ) ) {
						return false;
					}
					return $context['variantValues'][ "option_$option_number" ] === $context['option_value'];
				},
				'isPriceSelected'       => function () {
					$context = wp_interactivity_get_context();
					if ( ! isset( $context['price'] ) || ! isset( $context['selectedPrice'] ) ) {
						return false;
					}
					return $context['price']['id'] === $context['selectedPrice']['id'];
				},
				'buttonText'            => function () {
					$state   = wp_interactivity_state();
					$context = wp_interactivity_get_context();
					if ( $state['isSoldOut']() ) {
						return $context['outOfStockText'] ?? $context['text'];
					}
					if ( $state['isUnavailable']() ) {
						return $context['unavailableText'] ?? $context['text'];
					}
					return $context['text'];
				},
			]
		);
	}
}
