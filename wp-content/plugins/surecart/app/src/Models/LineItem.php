<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasCheckout;
use SureCart\Models\Traits\HasPrice;
use SureCart\Support\Currency;
use SureCart\Models\Traits\HasProduct;

/**
 * Price model
 */
class LineItem extends Model {
	use HasPrice;
	use HasCheckout;
	use HasProduct;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'line_items';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'line_item';

	/**
	 * Set the variant attribute.
	 *
	 * @param  string $value Variant properties.
	 * @return void
	 */
	public function setVariantAttribute( $value ) {
		$this->setRelation( 'variant', $value, Variant::class );
	}

	/**
	 * Upsell a line item.
	 *
	 * @param array $attributes The attributes to update.
	 * @return \WP_Error|mixed
	 */
	protected function upsell( $attributes = [] ) {
		if ( $this->fireModelEvent( 'upselling' ) === false ) {
			return false;
		}

		$updated = $this->makeRequest(
			[
				'method' => 'POST',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $attributes,
				],
			],
			'line_items/upsell'
		);

		if ( $this->isError( $updated ) ) {
			return $updated;
		}

		$this->resetAttributes();

		$this->fill( $updated );

		$this->fireModelEvent( 'upsold' );

		// clear account cache.
		if ( $this->cachable || $this->clears_account_cache ) {
			\SureCart::account()->clearCache();
		}

		return $this;
	}

	/**
	 * Get the currency attribute.
	 *
	 * TODO: Remove this method once currency added on line item.
	 *
	 * @return string
	 */
	public function getCurrencyAttribute() {
		return $this->checkout->currency ?? \SureCart::account()->currency;
	}

	/**
	 * Get the display ad hoc amount attribute.
	 *
	 * @return string
	 */
	public function getAdHocDisplayAmountAttribute() {
		return ! empty( $this->ad_hoc_amount ) ? Currency::format( $this->ad_hoc_amount, $this->currency ) : '';
	}

	/**
	 * Get the bump amount display attribute.
	 *
	 * @return string
	 */
	public function getBumpDisplayAmountAttribute() {
		return ! empty( $this->bump_amount ) ? Currency::format( $this->bump_amount, $this->currency ) : '';
	}

	/**
	 * Get the display scratch amount attribute.
	 *
	 * @return string
	 */
	public function getScratchDisplayAmountAttribute() {
		return ! empty( $this->scratch_amount ) ? Currency::format( $this->scratch_amount, $this->currency ) : '';
	}

	/**
	 * Get the display tax amount attribute.
	 *
	 * @return string
	 */
	public function getTaxDisplayAmountAttribute() {
		return ! empty( $this->tax_amount ) ? Currency::format( $this->tax_amount, $this->currency ) : '';
	}

	/**
	 * Get the display subtotal amount attribute.
	 *
	 * @return string
	 */
	public function getSubtotalDisplayAmountAttribute() {
		return Currency::format( (int) $this->subtotal_amount, $this->currency );
	}

	/**
	 * Get the display total amount attribute.
	 *
	 * @return string
	 */
	public function getTotalDisplayAmountAttribute() {
		return Currency::format( (int) $this->total_amount, $this->currency );
	}

	/**
	 * Get the display full amount attribute.
	 *
	 * @return string
	 */
	public function getFullDisplayAmountAttribute() {
		return ! empty( $this->full_amount ) ? Currency::format( $this->full_amount, $this->currency ) : '';
	}

	/**
	 * Get the display trial amount attribute.
	 *
	 * @return string
	 */
	public function getTrialDisplayAmountAttribute() {
		return ! empty( $this->trial_amount ) ? Currency::format( $this->trial_amount, $this->currency ) : '';
	}

	/**
	 * Get the line item image.
	 */
	public function getImageAttribute() {
		// if we have a variant, use the variant image.
		if ( ! empty( $this->variant ) && is_a( $this->variant, Variant::class ) && ! empty( (array) $this->variant->line_item_image ) ) {
			return $this->variant->line_item_image;
		}

		// if we have a product, use the product image.
		if ( isset( $this->price->product->line_item_image ) ) {
			return $this->price->product->line_item_image;
		}

		return null;
	}

	/**
	 * Get the converted discount amount attribute.
	 *
	 * @return string
	 */
	public function getConvertedDiscountAmountAttribute() {
		if ( $this->is_zero_decimal || empty( $this->discount_amount ) ) {
			return $this->discount_amount;
		}
		return $this->discount_amount / 100;
	}

	/**
	 * Purchasable status display
	 *
	 * @return string
	 */
	public function getPurchasableStatusDisplayAttribute() {
		if ( 'purchasable' === $this->purchasable_status ) {
			return;
		}

		// translations for purchaseable status.
		$translations = array(
			'price_gone'             => __( 'No longer available', 'surecart' ),
			'price_old_version'      => __( 'Price has changed', 'surecart' ),
			'variant_missing'        => __( 'Options no longer available', 'surecart' ),
			'variant_old_version'    => __( 'Price has changed', 'surecart' ),
			'variant_gone'           => __( 'Item no longer available', 'surecart' ),
			'out_of_stock'           => __( 'Out of stock', 'surecart' ),
			'exceeds_purchase_limit' => __( 'Exceeds purchase limit', 'surecart' ),
		);

		if ( $this->quantity > 1 ) {
			$translations['out_of_stock'] = __( 'Quantity unavailable', 'surecart' );
		}

		return $translations[ $this->purchasable_status ] ?? '';
	}
}
