<?php

namespace SureCart\Models;

/**
 * Processor model.
 */
class Processor extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'processors';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'processor';

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
	protected $cache_key = 'processors';

	/**
	 * Get payment method types.
	 *
	 * @return array|\WP_Error
	 */
	protected function paymentMethodTypes() {
		if ( $this->fireModelEvent( 'payment_method_types' ) === false ) {
			return false;
		}

		if ( empty( $this->attributes['id'] ) ) {
			return new \WP_Error( 'not_saved', 'Please create the payment method.' );
		}

		$types = $this->makeRequest(
			[
				'method' => 'GET',
				'query'  => $this->getQuery(),
			],
			$this->endpoint . '/' . $this->attributes['id'] . '/payment_method_types/',
		);

		return $types;
	}
}
