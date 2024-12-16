<?php
/**
 * Utility class for Presto Player.
 *
 * @package PrestoPlayer
 * @subpackage Support
 */

namespace PrestoPlayer\Support;

/**
 * Utility class containing helper functions.
 */
class Utility {

	/**
	 * Sanitize CSS input.
	 *
	 * @param string $css CSS to sanitize.
	 * @return string Sanitized CSS.
	 */
	public static function sanitizeCSS( $css ) {
		return preg_match( '#</?\w+#', $css ) ? '' : $css;
	}

	/**
	 * Insert a string after another string.
	 *
	 * @param string $str    The original string.
	 * @param string $search The string to search for.
	 * @param string $insert The string to insert.
	 * @return string Modified string.
	 */
	public static function insertAfterString( $str, $search, $insert ) {
		$index = strpos( $str, $search );
		if ( false === $index ) {
			return $str;
		}
		return substr_replace( $str, $search . $insert, $index, strlen( $search ) );
	}

	/**
	 * Convert snake_case to camelCase.
	 *
	 * @param string $input The input string in snake_case.
	 * @return string The output string in camelCase.
	 */
	public static function snakeToCamel( $input ) {
		return lcfirst( str_replace( ' ', '', ucwords( str_replace( '_', ' ', $input ) ) ) );
	}

	/**
	 * Convert a duration to human readable format.
	 *
	 * @since 5.1.0.
	 *
	 * @param string $duration Duration will be in string format (HH:ii:ss) OR (ii:ss),
	 *                         with a possible prepended negative sign (-).
	 * @return string|false A human readable duration string, false on failure.
	 */
	public static function human_readable_duration( $duration = '' ) {
		if ( ( empty( $duration ) || ! is_string( $duration ) ) ) {
			return __( '0 seconds', 'presto-player' );
		}

		$duration = trim( $duration );

		// Remove prepended negative sign.
		if ( '-' === substr( $duration, 0, 1 ) ) {
			$duration = substr( $duration, 1 );
		}

		// Extract duration parts.
		$duration_parts = array_reverse( explode( ':', $duration ) );
		$duration_count = count( $duration_parts );

		$hour   = null;
		$minute = null;
		$second = null;

		if ( 3 === $duration_count ) {
			// Validate HH:ii:ss duration format.
			if ( ! ( (bool) preg_match( '/^([0-9]+):([0-5]?[0-9]):([0-5]?[0-9])$/', $duration ) ) ) {
				return false;
			}
			// Three parts: hours, minutes & seconds.
			list($second, $minute, $hour) = $duration_parts;
		} elseif ( 2 === $duration_count ) {
			// Validate ii:ss duration format.
			if ( ! ( (bool) preg_match( '/^([0-5]?[0-9]):([0-5]?[0-9])$/', $duration ) ) ) {
				return false;
			}
			// Two parts: minutes & seconds.
			list($second, $minute) = $duration_parts;
		} else {
			return false;
		}

		$human_readable_duration = array();

		// Add the hour part to the string.
		if ( is_numeric( $hour ) && $hour > 0 ) {
			/* translators: %s: Time duration in hour or hours. */
			$human_readable_duration[] = sprintf( _n( '%s hour', '%s hours', $hour ), (int) $hour );
		}

		// Add the minute part to the string.
		if ( is_numeric( $minute ) && $minute > 0 ) {
			/* translators: %s: Time duration in minute or minutes. */
			$human_readable_duration[] = sprintf( _n( '%s minute', '%s minutes', $minute ), (int) $minute );
		}

		// Add the second part to the string.
		if ( is_numeric( $second ) && $second > 0 ) {
			/* translators: %s: Time duration in second or seconds. */
			$human_readable_duration[] = sprintf( _n( '%s second', '%s seconds', $second ), (int) $second );
		}

		return implode( ', ', $human_readable_duration );
	}

	/**
	 * Get the IP address.
	 *
	 * @param string $ip_address Optional. IP address to validate.
	 * @return string Valid IP address or empty string.
	 */
	public static function getIPAddress( $ip_address = '' ) {
		$ip = $ip_address ? $ip_address : ( isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '' );

		if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
			return $ip;
		} else {
			return '';
		}
	}

	/**
	 * Insert an array into another array before/after a certain key.
	 *
	 * @param array  $array The initial array.
	 * @param array  $pairs The array to insert.
	 * @param string $key The certain key.
	 * @param string $position Wether to insert the array before or after the key.
	 * @return array
	 */
	public static function arrayInsert( $array, $pairs, $key, $position = 'after' ) {
		$key_pos = array_search( $key, array_keys( $array ) );

		if ( 'after' == $position ) {
			++$key_pos;
		}

		if ( false !== $key_pos ) {
			$result = array_slice( $array, 0, $key_pos );
			$result = array_merge( $result, $pairs );
			$result = array_merge( $result, array_slice( $array, $key_pos ) );
		} else {
			$result = array_merge( $array, $pairs );
		}

		return $result;
	}

	/**
	 * Inserts a new key/value before the specified key in the array.
	 *
	 * @param string $key The key to insert before.
	 * @param array  $array An array to insert into.
	 * @param string $new_key The key to insert.
	 * @param mixed  $new_value The value to insert.
	 *
	 * @return array|false The new array if the key exists, FALSE otherwise.
	 */
	public static function arrayInsertBefore( $key, array &$array, $new_key, $new_value ) {
		if ( array_key_exists( $key, $array ) ) {
			$new = array();
			foreach ( $array as $k => $value ) {
				if ( $k === $key ) {
					$new[ $new_key ] = $new_value;
				}
				$new[ $k ] = $value;
			}
			return $new;
		}
		return false;
	}

	/**
	 * Inserts a new key/value pair after a specific key in an array.
	 *
	 * @param string $key       The key to insert after.
	 * @param array  $array     The array to insert into.
	 * @param string $new_key   The new key to insert.
	 * @param mixed  $new_value The new value to insert.
	 *
	 * @return array|false The new array if the key exists, FALSE otherwise.
	 */
	public static function arrayInsertAfter( $key, array &$array, $new_key, $new_value ) {
		if ( array_key_exists( $key, $array ) ) {
			$new = array();
			foreach ( $array as $k => $value ) {
				$new[ $k ] = $value;
				if ( $k === $key ) {
					$new[ $new_key ] = $new_value;
				}
			}
			return $new;
		}
		return false;
	}

	/**
	 * Convert hexadecimal color to RGBA.
	 *
	 * This function takes a hexadecimal color code and an optional opacity value
	 * and converts it to an RGBA color string.
	 *
	 * @param string $color   The hexadecimal color code.
	 * @param float  $opacity Optional. The opacity value between 0 and 1. Default false.
	 *
	 * @return string The RGBA color string.
	 */
	public static function hex2rgba( $color, $opacity = false ) {

		$default_color = 'rgb(0,0,0)';

		// Return default color if no color provided.
		if ( empty( $color ) ) {
			return $default_color;
		}

		// Ignore "#" if provided.
		if ( '#' === $color[0] ) {
			$color = substr( $color, 1 );
		}

		// Check if color has 6 or 3 characters, get values.
		if ( 6 === strlen( $color ) ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( 3 === strlen( $color ) ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default_color;
		}

		// Convert hex values to rgb values.
		$rgb = array_map( 'hexdec', $hex );

		// Check if opacity is set(rgba or rgb).
		if ( $opacity ) {
			if ( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ',', $rgb ) . ')';
		}

		// Return rgb(a) color string.
		return $output;
	}

	/**
	 * Flatten an array.
	 *
	 * @param array $array Array.
	 *
	 * @return array
	 */
	public static function flatten( array $array ) {
		$return = array();
		array_walk_recursive(
			$array,
			function ( $a ) use ( &$return ) {
				$return[] = $a;
			}
		);
		return $return;
	}
}
