<?php

namespace SureCart\Support;

/**
 * Handles currency coversion and formatting
 */
class URL {
	/**
	 * Get the scheme and http host.
	 *
	 * @param string $url The url.
	 *
	 * @return string
	 */
	public static function getSchemeAndHttpHost( string $url ): string {
		if ( empty( $url ) ) {
			return '';
		}

		$parsed_url = parse_url( $url );

		if ( empty( $parsed_url['scheme'] ) || empty( $parsed_url['host'] ) ) {
			return '';
		}

		return $parsed_url['scheme'] . '://' . $parsed_url['host'];
	}
}
