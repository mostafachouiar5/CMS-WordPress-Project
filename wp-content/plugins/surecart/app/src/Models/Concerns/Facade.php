<?php

namespace SureCart\Models\Concerns;

trait Facade {
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
