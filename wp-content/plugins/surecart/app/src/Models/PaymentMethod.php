<?php
namespace SureCart\Models;

use SureCart\Models\Traits\HasCustomer;
use SureCart\Models\Traits\HasPaymentInstrument;
use SureCart\Models\Traits\HasPaymentIntent;

/**
 * Payment method model.
 */
class PaymentMethod extends Model {
	use HasCustomer, HasPaymentIntent, HasPaymentInstrument;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'payment_methods';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'payment_method';

	/**
	 * Detach from a customer.
	 *
	 * @return $this|\WP_Error
	 */
	protected function detach() {
		if ( $this->fireModelEvent( 'detaching' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the payment method.' );
		}

		$detached = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/detach/',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $this->getAttributes(),
				],
			]
		);

		if ( is_wp_error( $detached ) ) {
			return $detached;
		}

		$this->resetAttributes();

		$this->fill( $detached );

		$this->fireModelEvent( 'detached' );

		return $this;
	}

	/**
	 * Get the translated payment method name.
	 *
	 * @return string
	 */
	public function getPaymentMethodNameAttribute(): string {
		return $this->payment_instrument->display_name ?? '';
	}
}
