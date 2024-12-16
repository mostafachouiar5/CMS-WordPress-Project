<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasAffiliation;
use SureCart\Models\Traits\HasReferrals;

/**
 * Payout model
 */
class Payout extends Model {
	use HasReferrals;
	use HasAffiliation;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'payouts';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'payout';

	/**
	 * Set the payout group attribute.
	 *
	 * @param object $value Array of payout objects.
	 *
	 * @return void
	 */
	public function setPayoutGroupAttribute( $value ) {
		$this->setRelation( 'payout_group', $value, PayoutGroup::class );
	}

	/**
	 * Complete a payout
	 *
	 * @param string $id Payout ID.
	 *
	 * @return $this|\WP_Error
	 */
	protected function complete( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'completing' ) === false ) {
			return $this;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the payout.' );
		}

		$completed = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/complete',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			]
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
	 * Make a payout as processing
	 *
	 * @param string $id Payout ID.
	 *
	 * @return $this|\WP_Error
	 */
	protected function make_processing( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'processing' ) === false ) {
			return $this;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the payout.' );
		}

		$processing = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/make_processing',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			]
		);

		if ( is_wp_error( $processing ) ) {
			return $processing;
		}

		$this->resetAttributes();
		$this->fill( $processing );
		$this->fireModelEvent( 'processed' );

		return $this;
	}

	/**
	 * Get status display
	 *
	 * @return string
	 */
	protected function getStatusDisplayTextAttribute() {
		return 'completed' === $this->status ? esc_html__( 'Completed', 'surecart' ) : esc_html__( 'Processing', 'surecart' );
	}
}
