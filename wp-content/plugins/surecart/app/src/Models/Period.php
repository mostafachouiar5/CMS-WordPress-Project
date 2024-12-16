<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasCheckout;
use SureCart\Models\Traits\HasPrice;
use SureCart\Models\Traits\HasSubscription;

/**
 * Period model
 */
class Period extends Model {
	use HasSubscription, HasCheckout, HasPrice;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'periods';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'period';

	/**
	 * Restore a subscription
	 *
	 * @param string $id Model id.
	 * @return $this|\WP_Error
	 */
	protected function retryPayment( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'retrying_payment' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the period.' );
		}

		$restored = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/retry_payment/',
			[
				'method' => 'PATCH',
				'query'  => $this->query,
			]
		);

		if ( is_wp_error( $restored ) ) {
			return $restored;
		}

		$this->resetAttributes();

		$this->fill( $restored );

		$this->fireModelEvent( 'payment_retry_success' );

		return $this;
	}

}

