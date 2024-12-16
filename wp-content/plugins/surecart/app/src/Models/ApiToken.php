<?php

namespace SureCart\Models;

use SureCart\Support\Encryption;

/**
 * The API token model.
 */
class ApiToken {

	/**
	 * The option key.
	 *
	 * @var string
	 */
	protected $key = 'sc_api_token';

	/**
	 * Prevent php warnings.
	 */
	final public function __construct() {}

	/**
	 * Clear the API token.
	 *
	 * @return bool True if the value was updated, false otherwise.
	 */
	protected function clear() {
		return delete_option( $this->key );
	}

	/**
	 * Save and encrypt the API token.
	 *
	 * @param string $value The API token.
	 * @return bool True if the value was updated, false otherwise.
	 */
	protected function save( $value ) {
		return update_option( $this->key, Encryption::encrypt( $value ) );
	}

	/**
	 * Get and decrypt the API token
	 *
	 * @return string The decoded API token.
	 */
	protected function get() {
		if ( defined( 'SURECART_API_TOKEN' ) ) {
			return SURECART_API_TOKEN;
		}
		return Encryption::decrypt( get_option( $this->key, '' ) );
	}

	/**
	 * Forward call to method
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 */
	public function __call( $method, $params ) {
		return call_user_func_array( [ $this, $method ], $params );
	}

	/**
	 * Static Facade Accessor
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 *
	 * @return mixed
	 */
	public static function __callStatic( $method, $params ) {
		return call_user_func_array( [ new static(), $method ], $params );
	}
}
