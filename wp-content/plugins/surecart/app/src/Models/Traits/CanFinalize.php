<?php

namespace SureCart\Models\Traits;

/**
 * If the model has an attached customer.
 */
trait CanFinalize {
	/**
	 * Finalize the session for checkout.
	 *
	 * @return $this|\WP_Error
	 */
	protected function finalize() {
		if ( $this->fireModelEvent( 'finalizing' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the checkout session.' );
		}

		$finalized = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/finalize/',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $this->getAttributes(),
				],
			]
		);

		if ( is_wp_error( $finalized ) ) {
			return $finalized;
		}

		$this->resetAttributes();

		$this->fill( $finalized );

		$this->fireModelEvent( 'finalized' );

		return $this;
	}

}
