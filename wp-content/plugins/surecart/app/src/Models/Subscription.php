<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasCustomer;
use SureCart\Models\Traits\HasPrice;
use SureCart\Models\Traits\HasPurchase;

/**
 * Subscription model
 */
class Subscription extends Model {
	use HasCustomer;
	use HasPrice;
	use HasPurchase;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'subscriptions';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'subscription';

	/**
	 * Set the current period attribute
	 *
	 * @param  object $value Return request properties.
	 * @return void
	 */
	public function setCurrentPeriodAttribute( $value ) {
		$this->setRelation( 'current_period', $value, Period::class );
	}

	/**
	 * Update the model.
	 *
	 * @param array $attributes Attributes to update.
	 * @return $this|false
	 */
	protected function update( $attributes = [] ) {
		// find existing subscription with purchase record.
		$existing = ( new Subscription() )->with( [ 'purchase' ] )->find( $attributes['id'] ?? $this->attributes['id'] );

		// do the update and also get the purchase record.
		$this->with( [ 'purchase' ] );
		$updated = parent::update( $attributes );
		if ( is_wp_error( $updated ) ) {
			return $updated;
		}

		// do the purchase updated event.
		if ( ! empty( $updated->purchase ) ) {
			do_action(
				'surecart/purchase_updated',
				$updated->purchase,
				(object) [
					'data' => (object) [
						'object'              => (object) $updated->purchase->toArray(),
						'previous_attributes' => (object) array_filter(
							[
								// conditionally have the previous product and quantity as the previous attributes.
								'product'  => $updated->purchase->product_id !== $existing->purchase->product_id ? ( $existing->purchase->product_id ?? null ) : null,
								'quantity' => $updated->purchase->quantity !== $existing->purchase->quantity ? ( $existing->purchase->quantity ?? 1 ) : null,
							]
						),
					],
				]
			);
		}

		return $this;
	}

	/**
	 * Cancel a subscription
	 *
	 * @param string $id Model id.
	 * @return $this|\WP_Error
	 */
	protected function cancel( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'canceling' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the subscription.' );
		}

		$attributes = $this->attributes;
		unset( $attributes['id'] );

		$canceled = $this->with(
			[
				'purchase',
			]
		)->makeRequest(
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $attributes,
				],
			],
			$this->endpoint . '/' . $this->attributes['id'] . '/cancel/'
		);

		if ( is_wp_error( $canceled ) ) {
			return $canceled;
		}

		$this->resetAttributes();

		$this->fill( $canceled );

		$this->fireModelEvent( 'canceled' );

		// purchase revoked event.
		if ( ! empty( $this->purchase->revoked ) ) {
			do_action( 'surecart/purchase_revoked', $this->purchase );
		}

		return $this;
	}

	/**
	 * Complete a subscription
	 *
	 * @param string $id Model id.
	 * @return $this|\WP_Error
	 */
	protected function complete( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'completeing' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the subscription.' );
		}

		$completed = $this->with(
			[
				'purchase',
			]
		)->makeRequest(
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			],
			$this->endpoint . '/' . $this->attributes['id'] . '/complete/'
		);

		if ( is_wp_error( $completed ) ) {
			return $completed;
		}

		$this->resetAttributes();

		$this->fill( $completed );

		$this->fireModelEvent( 'completed' );

		return $this;
	}

	/**
	 * Restore a subscription
	 *
	 * @param string $id Model id.
	 * @return $this|\WP_Error
	 */
	protected function restore( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'restoring' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the subscription.' );
		}

		$restored = $this->with( array( 'purchase' ) )
		->makeRequest(
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			],
			$this->endpoint . '/' . $this->attributes['id'] . '/restore/'
		);

		if ( is_wp_error( $restored ) ) {
			return $restored;
		}

		$this->resetAttributes();

		$this->fill( $restored );

		$this->fireModelEvent( 'restored' );

		// purchase invoked event.
		if ( ! empty( $this->purchase ) ) {
			do_action( 'surecart/purchase_invoked', $this->purchase );
		}

		return $this;
	}

	/**
	 * Renew a subscription.
	 *
	 * @param string $id Model id.
	 * @return $this|\WP_Error
	 */
	protected function renew( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'renewing' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the subscription.' );
		}

		$renewed = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'],
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => [
						'cancel_at_period_end' => false,
					],
				],
			]
		);

		if ( is_wp_error( $renewed ) ) {
			return $renewed;
		}

		$this->resetAttributes();

		$this->fill( $renewed );

		$this->fireModelEvent( 'renewed' );

		return $this;
	}

	/**
	 * Preserve a subscription.
	 *
	 * @param string $id Model id.
	 * @return $this|\WP_Error
	 */
	protected function preserve( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'preserving' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the subscription.' );
		}

		$preserved = $this->makeRequest(
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			],
			$this->endpoint . '/' . $this->attributes['id'] . '/preserve/'
		);

		if ( is_wp_error( $preserved ) ) {
			return $preserved;
		}

		$this->resetAttributes();

		$this->fill( $preserved );

		$this->fireModelEvent( 'preserved' );

		return $this;
	}

	/**
	 * Preview the upcoming invoice.
	 *
	 * @param string $args Arguments
	 * @return Period|\WP_Error
	 */
	protected function upcomingPeriod( $args = [] ) {
		if ( ! empty( $args['id'] ) ) {
			$this->setAttribute( 'id', $args['id'] );
			unset( $args['id'] );
		}

		if ( $this->fireModelEvent( 'previewingUpcomingPeriod' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the subscription' );
		}

		$upcoming_period = $this->makeRequest(
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $args,
				],
			],
			$this->endpoint . '/' . $this->attributes['id'] . '/upcoming_period/'
		);

		if ( is_wp_error( $upcoming_period ) ) {
			return $upcoming_period;
		}

		$upcoming_period = new Period( $upcoming_period );

		$this->fireModelEvent( 'previewedUpcomingPeriod' );

		return $upcoming_period;
	}

	/**
	 * Pay off a subscription
	 *
	 * @param string $id Model id.
	 * @return $this|\WP_Error
	 */
	protected function payOff( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'payingOff' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the subscription' );
		}

		$paid_off = $this->makeRequest(
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			],
			$this->endpoint . '/' . $this->attributes['id'] . '/pay_off/'
		);

		if ( is_wp_error( $paid_off ) ) {
			return $paid_off;
		}

		$this->resetAttributes();

		$this->fill( $paid_off );

		$this->fireModelEvent( 'paidOff' );

		return $this;
	}

	/**
	 * Is this subscription a lifetime one?
	 *
	 * @return boolean
	 */
	protected function isLifetime() {
		return $this->attributes['id'] && empty( $this->attributes['current_period_end_at'] );
	}

	/**
	 * Can the user upgrade this subscription?
	 *
	 * @return boolean
	 */
	protected function canBeSwitched() {
		return apply_filters( 'surecart/subscription/can_be_changed', $this->checkIfCanBeSwitched(), $this );
	}

	/**
	 * Can the subscription be changed?
	 *
	 * @return boolean
	 */
	private function checkIfCanBeSwitched() {
		// updates are not enabled for the account.
		if ( empty( \SureCart::account()->customer_portal_protocol->subscription_updates_enabled ) ) {
			return false;
		}
		// already set to canceling.
		if ( $this->attributes['cancel_at_period_end'] ) {
			return false;
		}
		// can't update canceled, incomplete, or past due subscriptions.
		if ( in_array( $this->attributes['status'], [ 'canceled', 'incomplete', 'past_due' ] ) ) {
			return false;
		}
		// must not be lifetime.
		if ( $this->isLifetime() ) {
			return false;
		}
		return true;
	}

	/**
	 * Can we cancel the subscription?
	 *
	 * @return boolean
	 */
	public function canBeCanceled() {
		return apply_filters( 'surecart/subscription/can_be_canceled', $this->checkIfCanBeSwitched(), $this );
	}

	/**
	 * Should delay subscription cancellation?
	 *
	 * @return boolean
	 */
	public function shouldDelayCancellation(): bool {
		$protocol = \SureCart::account()->subscription_protocol;

		if ( ! $protocol->cancel_window_enabled || empty( $protocol->cancel_window_days ) || empty( $this->attributes['current_period_end_at'] ) ) {
			return false;
		}

		$cancel_window_days = $protocol->cancel_window_days;
		$now                = ( new \DateTime() )->format( 'Y-m-d' );
		$end                = new \DateTime();
		$end->setTimestamp( $this->attributes['current_period_end_at'] );
		$end = $end->modify( "-{$cancel_window_days} days" );
		$end = $end->format( 'Y-m-d' );

		return $now < $end;
	}

	/**
	 * Can the subscription be canceled?
	 *
	 * @return boolean
	 */
	private function checkIfCanBeCanceled() {
		// updates are not enabled for the account.
		if ( empty( \SureCart::account()->customer_portal_protocol->subscription_cancellations_enabled ) ) {
			return false;
		}

		// can't cancel canceled, incomplete, or past due subscriptions.
		if ( in_array( $this->attributes['status'], [ 'canceled', 'incomplete', 'past_due' ] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Can we update the quantity?
	 *
	 * @return boolean
	 */
	protected function canUpdateQuantity() {
		return apply_filters( 'surecart/subscription/can_update_quantity', $this->checkIfCanBeSwitched(), $this );
	}

	/**
	 * Check if we can update the quantity.
	 *
	 * @return boolean
	 */
	private function checkIfCanUpdateQuantity() {
		// quantity changes are not enabled for this account.
		if ( empty( \SureCart::account()->customer_portal_protocol->subscription_quantity_updates_enabled ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Get stats for the subscription
	 *
	 * @param array $args Array of arguments for the statistics.
	 *
	 * @return \SureCart\Models\Statistic;
	 */
	protected function stats( $args = [] ) {
		$stat = new Statistic();
		return $stat->where( $args )->find( 'subscriptions' );
	}
}
