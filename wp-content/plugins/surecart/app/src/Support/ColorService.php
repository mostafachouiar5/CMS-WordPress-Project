<?php

namespace SureCart\Support;

/**
 * Color service.
 */
class ColorService {
	/**
	 * Calculate the foreground color based on the background color.
	 *
	 * @param string $color The background color.
	 * @return string   The foreground color.
	 */
	public function calculateForegroundColor( $color ) {
		list($red, $green, $blue) = $this->destructureColorToRgb( $color );
		$brightness               = $this->calculateBrightness( $red, $green, $blue );
		return $this->allocateWhiteOrBlack( $brightness );
	}

	/**
	 * Destructure the color to RGB.
	 *
	 * @param string $color The color.
	 */
	private function destructureColorToRgb( $color ) {
		return str_split( $color, 2 );
	}

	/**
	 * Calculate the brightness.
	 *
	 * @param string $red The red.
	 * @param string $green The green.
	 * @param string $blue The blue.
	 * @return string
	 */
	private function calculateBrightness( $red, $green, $blue ) {
		return ( hexdec( $red ) * 0.299 ) + ( hexdec( $green ) * 0.587 ) + ( hexdec( $blue ) * 0.114 );
	}

	/**
	 * Allocate white or black.
	 *
	 * @param string $brightness The brightness.
	 * @return string
	 */
	private function allocateWhiteOrBlack( $brightness ) {
		return ( $brightness > 180 ) ? '000000' : 'ffffff';
	}
}
