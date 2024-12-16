<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasAffiliation;
use SureCart\Models\Traits\HasCheckout;
use SureCart\Models\Traits\HasPayout;
use SureCart\Models\Traits\HasReferralItems;

/**
 * Referral model
 */
class Referral extends Model {
	use HasAffiliation, HasCheckout, HasPayout, HasReferralItems;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'referrals';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'referral';

	/**
	 * Approve a referral
	 *
	 * @param string $id Referral ID.
	 *
	 * @return $this|\WP_Error
	 */
	protected function approve( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'approving' ) === false ) {
			return $this;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the referral.' );
		}

		$approved = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/approve',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			]
		);

		if ( is_wp_error( $approved ) ) {
			return $approved;
		}

		$this->resetAttributes();
		$this->fill( $approved );
		$this->fireModelEvent( 'approved' );

		return $this;
	}

	/**
	 * Deny a referral
	 *
	 * @param string $id Referral ID.
	 *
	 * @return $this|\WP_Error
	 */
	protected function deny( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'denying' ) === false ) {
			return $this;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the referral.' );
		}

		$denied = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/deny',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			]
		);

		if ( is_wp_error( $denied ) ) {
			return $denied;
		}

		$this->resetAttributes();
		$this->fill( $denied );
		$this->fireModelEvent( 'denied' );

		return $this;
	}

	/**
	 * Make a referral as in review
	 *
	 * @param string $id Referral ID.
	 *
	 * @return $this|\WP_Error
	 */
	protected function make_reviewing( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'making_reviewing' ) === false ) {
			return $this;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the referral.' );
		}

		$reviewing = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/make_reviewing',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			]
		);

		if ( is_wp_error( $reviewing ) ) {
			return $reviewing;
		}

		$this->resetAttributes();
		$this->fill( $reviewing );
		$this->fireModelEvent( 'made_reviewing' );

		return $this;
	}

	/**
	 * Set the affiliation attribute
	 *
	 * @param object $value Array of payout objects.
	 *
	 * @return void
	 */
	public function setAttributedClickAttribute( $value ) {
		$this->setRelation( 'attributed_click', $value, Click::class );
	}

	/**
	 * Get the display status attribute.
	 *
	 * @return string
	 */
	public function getStatusDisplayTextAttribute() {
		$statuses = [
			'reviewing' => __( 'Reviewing', 'surecart' ),
			'paid'      => __( 'In Payout', 'surecart' ),
			'denied'    => __( 'Denied', 'surecart' ),
			'cancelled' => __( 'Cancelled', 'surecart' ),
			'approved'  => __( 'Approved', 'surecart' ),
		];
		return $statuses[ $this->status ] ?? '';
	}

	/**
	 * Get the display status attribute.
	 *
	 * @return string
	 */
	public function getStatusTypeAttribute() {
		$types = [
			'reviewing' => 'warning',
			'paid'      => 'success',
			'denied'    => 'danger',
			'cancelled' => 'default',
			'approved'  => 'info',
		];
		return $types[ $this->status ] ?? 'default';
	}

	/**
	 * Get the editable attribute.
	 *
	 * @return bool
	 */
	public function getEditableAttribute() {
		return 'paid' !== $this->status;
	}
}
