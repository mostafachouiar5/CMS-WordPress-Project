<?php

namespace SureCart\Models;

/**
 * Affiliation Request Model
 */
class AffiliationRequest extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'affiliation_requests';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'affiliation_request';

	/**
	 * Approve the affiliate request.
	 *
	 * @param string|null $id Request ID.
	 *
	 * @return self|\WP_Error
	 */
	protected function approve( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'approving' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the affiliation request.' );
		}

		$approved = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/approve',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $this->getAttributes(),
				],
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
	 * Deny the affiliate request.
	 *
	 * @param string|null $id The model id.
	 *
	 * @return self|\WP_Error
	 */
	protected function deny( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'denying' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the affiliation request.' );
		}

		$denied = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/deny',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $this->getAttributes(),
				],
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
	 * Get the display status attribute.
	 *
	 * @return string
	 */
	public function getStatusDisplayTextAttribute() {
		$statuses = [
			'approved' => __( 'Approved', 'surecart' ),
			'pending'  => __( 'Pending', 'surecart' ),
			'denied'   => __( 'Denied', 'surecart' ),
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
			'approved' => 'info',
			'pending'  => 'warning',
			'denied'   => 'danger',
		];
		return $types[ $this->status ] ?? 'default';
	}
}
