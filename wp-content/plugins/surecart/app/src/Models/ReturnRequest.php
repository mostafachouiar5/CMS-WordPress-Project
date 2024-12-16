<?php

namespace SureCart\Models;

use SureCart\Models\Model;
use SureCart\Models\Traits\HasOrder;

/**
 * ReturnRequest model.
 */
class ReturnRequest extends Model {
	use HasOrder;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'return_requests';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'return_request';

	/**
	 * Open a return request.
	 *
	 * @param string $id Model id.
	 * @return $this|\WP_Error
	 */
	protected function open( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'opening' ) === false ) {
			return false;
		}

		if ( empty( $this->id ) ) {
			return new \WP_Error( 'not_saved', 'You can only open an existing return request.' );
		}

		$attributes = $this->attributes;
		unset( $attributes['id'] );

		$opened = $this->makeRequest(
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $attributes,
				],
			],
			$this->endpoint . '/' . $this->id . '/open/'
		);

		if ( is_wp_error( $opened ) ) {
			return $opened;
		}

		$this->resetAttributes();
		$this->fill( $opened );
		$this->fireModelEvent( 'opened' );

		return $this;
	}

	/**
	 * Complete a return request.
	 *
	 * @param string $id Model id.
	 * @return $this|\WP_Error
	 */
	protected function complete( $id = null ) {
		if ( $id ) {
			$this->setAttribute( 'id', $id );
		}

		if ( $this->fireModelEvent( 'completing' ) === false ) {
			return false;
		}

		if ( empty( $this->id ) ) {
			return new \WP_Error( 'not_saved', 'You can only complete an existing return request.' );
		}

		$attributes = $this->attributes;
		unset( $attributes['id'] );

		$completed = $this->makeRequest(
			[
				'method' => 'PATCH',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $attributes,
				],
			],
			$this->endpoint . '/' . $this->id . '/complete/'
		);

		if ( is_wp_error( $completed ) ) {
			return $completed;
		}

		$this->resetAttributes();
		$this->fill( $completed );
		$this->fireModelEvent( 'completed' );

		return $this;
	}
}
