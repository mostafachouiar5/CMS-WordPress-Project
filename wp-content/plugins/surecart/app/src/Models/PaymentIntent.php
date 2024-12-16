<?php
namespace SureCart\Models;

use SureCart\Models\Traits\HasCustomer;

/**
 * Payment intent model.
 */
class PaymentIntent extends Model {
	use HasCustomer;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'payment_intents';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'payment_intent';

	/**
	 * Capture the payment intent
	 *
	 * @return $this|\WP_Error
	 */
	protected function capture() {
		if ( $this->fireModelEvent( 'capturing' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create a payment intent.' );
		}

		$captured = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/capture/',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $this->getAttributes(),
				],
			]
		);

		if ( is_wp_error( $captured ) ) {
			return $captured;
		}

		$this->resetAttributes();

		$this->fill( $captured );

		$this->fireModelEvent( 'captured' );

		return $this;
	}
}
