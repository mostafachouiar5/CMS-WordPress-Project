<?php

namespace SureCart\Models;

/**
 * Holds the data of the current account.
 */
class VerificationCode extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'verification_codes';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'verification_code';

	/**
	 * Verify the code.
	 *
	 * @param array $attributes The model attributes [ 'email' => email@email.com].
	 *
	 * @return this
	 */
	protected function verify( $attributes = [] ) {
		if ( $this->fireModelEvent( 'verifying' ) === false ) {
			return false;
		}

		if ( $attributes ) {
			$this->syncOriginal();
			$this->fill( $attributes );
		}

		$attributes = $this->attributes;
		unset( $attributes['id'] );

		$verified = \SureCart::request(
			$this->endpoint . '/verify/',
			[
				'method' => 'POST',
				'query'  => $this->query,
				'body'   => [
					$this->object_name => $this->getAttributes(),
				],
			]
		);

		if ( is_wp_error( $verified ) ) {
			return $verified;
		}

		$this->resetAttributes();

		$this->fill( $verified );

		$this->fireModelEvent( 'verified' );

		return $this;
	}
}
