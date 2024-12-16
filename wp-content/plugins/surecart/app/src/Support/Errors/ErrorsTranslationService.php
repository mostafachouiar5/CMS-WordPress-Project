<?php

namespace SureCart\Support\Errors;

use SureCart\Support\Currency;

/**
 * Handles error translations from the API.
 */
class ErrorsTranslationService {
	/**
	 * Translate based on specific error code.
	 *
	 * @param string $code The error code.
	 * @return string|false The translated error message or false if not found.
	 */
	public function codeTranslation( $code = '' ) {
		if ( ! $code ) {
			return false;
		}

		// very specific.
		$code_translations = include 'Translations/codes.php';
		if ( ! empty( $code_translations[ $code ] ) ) {
			return $code_translations[ $code ];
		}

		return false;
	}

	/**
	 * Replaceable attribute translation
	 *
	 * @param string $attribute Attribute name.
	 * @param string $type Type of validation.
	 *
	 * @return string|false
	 */
	public function attributeTranslation( $attribute, $type, $options = [] ) {
		// if both are empty, return.
		if ( empty( $attribute ) && empty( $type ) ) {
			return false;
		}

		if ( ! empty( $options ) ) {
			$special = $this->attributeOptionsTranslation( $attribute, $type, $options );
			if ( $special ) {
				return $special;
			}
		}

		$attribute_translations        = include 'Translations/attributes.php';
		$type_translations_replaceable = include 'Translations/types-replaceable.php';

		// we have an attribute.
		if ( ! empty( $attribute_translations[ $attribute ] ) ) {
			// we have a type.
			if ( ! empty( $type_translations_replaceable[ $type ] ) ) {
				return sprintf( $type_translations_replaceable[ $type ], $attribute_translations[ $attribute ] );
			}
			// translators: field name.
			return sprintf( __( '%s is invalid.', 'surecart' ), $attribute_translations[ $attribute ] );
		}

		return false;
	}

	public function attributeOptionsTranslation( $attribute, $type, $options ) {
		if ( 'line_items.ad_hoc_amount' === $attribute && 'outside_range' === $type ) {
			// translators: 1. minimum amount, 2. maximum amount.
			return sprintf( __( 'You must enter an amount between %1$s and %2$s', 'surecart' ), $options['min'] / 100, $options['max'] / 100 );
		}

		if ( 'line_items.quantity' === $attribute && 'greater_than_or_equal_to' === $type ) {
			if ( $options['value'] < 1 ) {
				return __( 'The product is out of stock. Please remove it from your cart.', 'surecart' );
			}

			// translators: minimum quantity.
			return sprintf( __( 'You must enter a quantity greater than or equal to %s', 'surecart' ), $options['value'] );
		}

		if ( 'coupon' === $attribute && 'less_than_min_subtotal_amount' === $type && ! empty( $options['coupon_min_subtotal_amount'] ) && ! empty( $options['currency'] ) ) {
			// translators: minimum amount for coupon.
			return sprintf( __( 'You must spend at least %s to use this coupon.', 'surecart' ), Currency::format( $options['coupon_min_subtotal_amount'], $options['currency'] ) );
		}

		// Minimum order amount by processor.
		if ( 'amount_due' === $attribute && 'less_than_currency_minimum' === $type && ! empty( $options['minimum_amount'] ) && ! empty( $options['currency'] ) ) {
			// translators: minimum amount for processor.
			return sprintf( __( 'The minimum order amount for the processor is %s.', 'surecart' ), Currency::format( $options['minimum_amount'], $options['currency'] ) );
		}

		if ( 'line_items' === $attribute && 'not_purchasable' === $type && ! empty( $options['purchasable_statuses'] ) ) {
			$line_item_translations = array(
				'price_gone'             => __( 'One or more items in your cart is no longer available. Please update your cart and try again.', 'surecart' ),
				'price_old_version'      => __( 'The price of one of the items on cart has changed. Please review and try again.', 'surecart' ),
				'variant_missing'        => __( 'One of the items on cart is no longer available. Please review and try again.', 'surecart' ),
				'variant_gone'           => __( 'One of the items on cart is no longer available. Please review and try again.', 'surecart' ),
				'variant_old_version'    => __( 'One of the items on cart has changed. Please review and try again.', 'surecart' ),
				'out_of_stock'           => __( 'One of the items on cart is out of stock. Please review and try again.', 'surecart' ),
				'exceeds_purchase_limit' => __( 'One or more items in your cart exceed the purchase limit. Please adjust the quantity or remove the item to proceed with the checkout.', 'surecart' ),
			);

			$line_item_translated_error = $line_item_translations[ $options['purchasable_statuses'][0] ?? '' ] ?? false;

			if ( $line_item_translated_error ) {
				return $line_item_translated_error;
			}
		}

		// Unique name translation.
		if ( 'name' === $attribute && 'taken' === $type ) {
			return sprintf(
				// translators: %s is the name.
				__( 'The name "%s" is already taken. Please choose a different name.', 'surecart' ),
				$options['value'],
			);
		}

		return false;
	}

	/**
	 * Translate just the type field
	 *
	 * @param string $type Type sting.
	 * @return string|false
	 */
	public function typeTranslation( $type = '' ) {
		if ( ! $type ) {
			return false;
		}

		// we have no attribute.
		$type_translations = include 'Translations/types.php';

		if ( ! empty( $type_translations[ $type ] ) ) {
			return $type_translations[ $type ];
		}

		return false;
	}

	/**
	 * Translate a specific error response
	 *
	 * @param array $response Error response.
	 * @return \WP_Error
	 */
	public function translateErrorMessage( $response, $fallback = null ) {
		// translate specific error code.
		$translated = $this->codeTranslation( $response['code'] ?? '' );
		if ( $translated ) {
			return apply_filters( 'surecart/translated_error', $translated, $response );
		}

		// translate attribute.
		$translated = $this->attributeTranslation( $response['attribute'] ?? '', $response['type'] ?? '', $response['options'] ?? [] );
		if ( $translated ) {
			return apply_filters( 'surecart/translated_error', $translated, $response );
		}

		// translate type.
		$translated = $this->typeTranslation( $response['type'] ?? '' );
		if ( $translated ) {
			return apply_filters( 'surecart/translated_error', $translated, $response );
		}

		// fallback.
		return $fallback ?? __( 'Error.', 'surecart' );
	}

	/**
	 * Translate Errors
	 *
	 * @param array   $response Response from platform.
	 * @param integer $code Status code.
	 *
	 * @return \WP_Error
	 */
	public function translate( $response = null, $code = null ) {
		// fallback.
		if ( empty( $response['message'] ) ) {
			error_log( print_r( $response, 1 ) );
			return new \WP_Error( 'error', __( 'Error.', 'surecart' ) );
		}

		$formatted = new \WP_Error(
			$response['code'] ?? '',
			$this->translateErrorMessage( $response, $response['message'] ?? '' ),
			[
				'status'      => $code,
				'type'        => $response['type'] ?? '',
				'http_status' => $response['http_status'] ?? '',
			]
		);

		if ( ! empty( $response['validation_errors'] ) ) {
			foreach ( $response['validation_errors']  as $error ) {
				$formatted->add(
					$error['code'] ?? 'invalid',
					$this->translateErrorMessage( $error, $error['message'] ),
					[
						'attribute' => $error['attribute'] ?? '',
						'type'      => $error['type'] ?? '',
						'options'   => $error['options'] ?? [],
					]
				);
			}
		}

		return apply_filters( 'surecart/translated_errors', $formatted );
	}
}
