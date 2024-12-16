<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasProduct;
use SureCart\Support\Currency;

/**
 * Price model
 */
class Price extends Model {
	use HasProduct;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'prices';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'price';

	/**
	 * Is this cachable?
	 *
	 * @var boolean
	 */
	protected $cachable = true;

	/**
	 * Clear cache when products are updated.
	 *
	 * @var string
	 */
	protected $cache_key = 'products';

	/**
	 * Set the product attribute
	 *
	 * @param array $attributes Attributes to update.
	 *
	 * @return $this|false
	 */
	protected function create( $attributes = array() ) {
		// update parent.
		$updated = parent::create( $attributes );

		// sync the product.
		$this->sync();

		// return.
		return $updated;
	}

	/**
	 * Update a model
	 *
	 * @param array $attributes Attributes to update.
	 *
	 * @return $this|false
	 */
	protected function update( $attributes = array() ) {
		// update parent.
		$updated = parent::update( $attributes );

		// sync the product.
		$this->sync();

		// return.
		return $updated;
	}

	/**
	 * Update a model
	 *
	 * @param string $id ID to delete.
	 *
	 * @return $this|false
	 */
	protected function delete( $id = '' ) {
		// find price as we need the product id.
		$this->find( $id );

		// update parent.
		$response = parent::delete( $id );

		// sync product.
		$this->sync();

		// return.
		return $response;
	}

	/**
	 * Sync the product
	 *
	 * @return $this
	 */
	protected function sync() {
		$product = Product::sync( $this->product_id );

		// if the product is an error, return it.
		if ( is_wp_error( $product ) ) {
			return $product;
		}

		return $this;
	}

	/**
	 * Get the display amount attribute
	 *
	 * @return string
	 */
	public function getDisplayAmountAttribute() {
		if ( $this->ad_hoc ) {
			return esc_html__( 'Custom Amount', 'surecart' );
		}
		if ( empty( $this->amount ) && empty( $this->recurring_interval ) ) {
			return apply_filters( 'surecart/display_amount/free', esc_html__( 'Free', 'surecart' ) );
		}
		return Currency::format( $this->amount, $this->currency );
	}

	/**
	 * Get the formatted amount attribute
	 *
	 * @return string
	 */
	public function getConvertedAmountAttribute() {
		if ( $this->is_zero_decimal || empty( $this->amount ) ) {
			return $this->amount;
		}
		return $this->amount / 100;
	}

	/**
	 * Get the converted_ad_hoc_min_amount attribute
	 *
	 * @return string
	 */
	public function getConvertedAdHocMinAmountAttribute() {
		if ( $this->is_zero_decimal || empty( $this->ad_hoc_min_amount ) ) {
			return $this->ad_hoc_min_amount;
		}
		return $this->ad_hoc_min_amount / 100;
	}

	/**
	 * Get the converted_ad_hoc_max_amount attribute
	 *
	 * @return string
	 */
	public function getConvertedAdHocMaxAmountAttribute() {
		if ( $this->is_zero_decimal || empty( $this->ad_hoc_max_amount ) ) {
			return $this->ad_hoc_max_amount;
		}
		return $this->ad_hoc_max_amount / 100;
	}

	/**
	 * The the scratch display amount attribute.
	 *
	 * @return string
	 */
	public function getScratchDisplayAmountAttribute() {
		return empty( $this->scratch_amount ) ? '' : Currency::format( $this->scratch_amount, $this->currency );
	}

	/**
	 * Get the display price attribute
	 *
	 * @return string
	 */
	public function getIsOnSaleAttribute() {
		if ( $this->ad_hoc ) {
			return false;
		}
		return empty( $this->scratch_amount ) ? false : $this->scratch_amount > $this->amount;
	}

	/**
	 * Get the trial display text attribute
	 *
	 * @return string
	 */
	public function getTrialTextAttribute() {
		return $this->trial_duration_days ? sprintf(
			// translators: %s is the number of days.
			_n(
				'Starting in %s day.',
				'Starting in %s days.',
				$this->trial_duration_days,
				'surecart'
			),
			$this->trial_duration_days
		)
		: '';
	}

	/**
	 * Get the setup fee text attribute
	 */
	public function getSetupFeeTextAttribute() {
		if ( empty( $this->setup_fee_enabled ) || empty( $this->setup_fee_amount ) ) {
			return '';
		}
		return sprintf(
			// translators: %1$1s is the setup fee amount, %2$2s is the setup fee name.
			__( '%1$1s %2$2s.', 'surecart' ),
			Currency::format( $this->setup_fee_amount, $this->currency ),
			$this->setup_fee_name ?? __( 'Setup Fee', 'surecart' )
		);
	}

	/**
	 * Get the payments text attribute
	 *
	 * @return string
	 */
	public function getPaymentsTextAttribute() {
		return ! empty( $this->recurring_period_count ) && $this->recurring_period_count > 1 ? sprintf(
			// translators: %d is the number of payments.
			_n(
				'%d payment',
				'%d payments',
				$this->recurring_period_count,
				'surecart'
			),
			$this->recurring_period_count
		) : '';
	}

	/**
	 * Get the interval text attribute
	 *
	 * @return string
	 */
	public function getIntervalTextAttribute() {
		$intervals = array(
			'day'   => [
				'single' => __( 'day', 'surecart' ),
				'plural' => __( 'days', 'surecart' ),
			],
			'week'  => [
				'single' => __( 'week', 'surecart' ),
				'plural' => __( 'weeks', 'surecart' ),
			],
			'month' => [
				'single' => __( 'month', 'surecart' ),
				'plural' => __( 'months', 'surecart' ),
			],
			'year'  => [
				'single' => __( 'year', 'surecart' ),
				'plural' => __( 'years', 'surecart' ),
			],
		);

		$key = (int) $this->recurring_interval_count > 1 ? 'plural' : 'single';

		if ( empty( $intervals[ $this->recurring_interval ][ $key ] ) ) {
			return '';
		}

		return sprintf(
			// translators: %1$d is the number of intervals, %2$s is the interval.
			_n( 'every %2$2s', 'every %1$1s %2$2s', $this->recurring_interval_count, 'surecart' ),
			(int) $this->recurring_interval_count,
			$intervals[ $this->recurring_interval ][ $key ],
		);
	}

	/**
	 * Get the interval text attribute
	 *
	 * @return string
	 */
	public function getShortIntervalTextAttribute() {
		$intervals = array(
			'day'   => [
				'single' => __( 'day', 'surecart' ),
				'plural' => __( 'days', 'surecart' ),
			],
			'week'  => [
				'single' => __( 'wk', 'surecart' ),
				'plural' => __( 'wks', 'surecart' ),
			],
			'month' => [
				'single' => __( 'mo', 'surecart' ),
				'plural' => __( 'mos', 'surecart' ),
			],
			'year'  => [
				'single' => __( 'yr', 'surecart' ),
				'plural' => __( 'yrs', 'surecart' ),
			],
		);

		$key = (int) $this->recurring_interval_count > 1 ? 'plural' : 'single';

		if ( empty( $intervals[ $this->recurring_interval ][ $key ] ) ) {
			return '';
		}

		return sprintf(
			// translators: %1$d is the number of intervals, %2$s is the interval.
			_n( '/ %2$2s', '/ %1$1s %2$2s', $this->recurring_interval_count, 'surecart' ),
			(int) $this->recurring_interval_count,
			$intervals[ $this->recurring_interval ][ $key ],
		);
	}

	/**
	 * Get the interval count text attribute
	 *
	 * @return string
	 */
	public function getShortIntervalCountTextAttribute() {
		if ( (int) $this->recurring_period_count < 2 ) {
			return '';
		}

		// translators: %d is the number of intervals.
		return sprintf( __( ' x %s', 'surecart' ), (int) $this->recurring_period_count );
	}

	/**
	 * Get the interval count text attribute
	 *
	 * @return string
	 */
	public function getIntervalCountTextAttribute() {
		if ( (int) $this->recurring_period_count < 2 ) {
			return '';
		}

		// translators: %d is the number of intervals.
		return sprintf( __( '(%d payments)', 'surecart' ), (int) $this->recurring_period_count );
	}

	/**
	 * Is this a zero decimal currency price?
	 *
	 * @return boolean
	 */
	public function getIsZeroDecimalAttribute() {
		return Currency::isZeroDecimal( $this->currency );
	}

	/**
	 * Get the currency symbol attribute
	 *
	 * @return string
	 */
	public function getCurrencySymbolAttribute() {
		return html_entity_decode( Currency::getCurrencySymbol( $this->currency ) );
	}
}
