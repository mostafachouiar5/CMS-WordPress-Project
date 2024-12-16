<?php

namespace SureCart\Support;

/**
 * Array support.
 */
class Arrays {
	/**
	 * Flatten an array
	 *
	 * @param array $array Array.
	 *
	 * @return array
	 */
	public static function flatten( array $array ) {
		$return = array();
		array_walk_recursive(
			$array,
			function( $a ) use ( &$return ) {
				$return[] = $a;
			}
		);
		return $return;
	}

	/**
	 * Insert an array after a key in another array.
	 *
	 * @param string $key          Key to insert after.
	 * @param array  $source_array Array to insert into.
	 * @param array  $insert_array Array to insert.
	 *
	 * @throws \Exception If key does not exist in the array.
	 *
	 * @return array
	 */
	public static function insertAfter( $key, $source_array, $insert_array ) {
		$keys  = array_keys( $source_array );
		$index = array_search( $key, $keys );

		if ( false === $index ) {
			throw new \Exception( "Key $key does not exist in the array" );
		}

		$pos = $index + 1;

		return array_slice( $source_array, 0, $pos, true ) +
			   $insert_array +
			   array_slice( $source_array, $pos, null, true );
	}
}
