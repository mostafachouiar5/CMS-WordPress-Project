<?php

namespace SureCart\Support;

/**
 * Handles interval translations
 */
class Interval {
	/**
	 * Translate the interval.
	 *
	 * @param int    $amount The interval amount.
	 * @param string $interval The interval type (e.g., "day", "week").
	 * @param string $prefix (optional) The prefix to use before the interval. Default: "every".
	 * @param string $fallback (optional) The fallback text for non-standard intervals. Default: "once".
	 * @param bool   $showSingle (optional) Whether to use singular forms for amounts (e.g., "1 day" instead of "1 days"). Default: false.
	 * @return string The translated interval string.
	 */
	public static function translate(
		int $amount,
		string $interval,
		string $prefix = 'every',
		string $fallback = 'once',
		bool $showSingle = false
	) {
		switch ( $interval ) {
			case 'day':
				$text = sprintf(
					$showSingle ? _n( '%d day', '%d days', $amount, 'surecart' ) : _n( 'day', '%d days', $amount, 'surecart' ),
					$amount
				);
				return "$prefix $text";
			case 'week':
				$text = sprintf(
					$showSingle ? _n( '%d week', '%d weeks', $amount, 'surecart' ) : _n( 'week', '%d weeks', $amount, 'surecart' ),
					$amount
				);
				return "$prefix $text";
			case 'month':
				$text = sprintf(
					$showSingle ? _n( '%d month', '%d months', $amount, 'surecart' ) : _n( 'month', '%d months', $amount, 'surecart' ),
					$amount
				);
				return "$prefix $text";
			case 'year':
				$text = sprintf(
					$showSingle ? _n( '%d year', '%d years', $amount, 'surecart' ) : _n( 'year', '%d years', $amount, 'surecart' ),
					$amount
				);
				return "$prefix $text";
			default:
				return $fallback;
		}
	}

	/**
	 * Translate abbreviated interval.
	 *
	 * @param int    $amount The interval amount.
	 * @param string $interval The interval type (e.g., "day", "week").
	 * @param string $fallback (optional) The fallback text for non-standard intervals. Default: "once".
	 * @param bool   $showSingle (optional) Whether to use singular forms for amounts (e.g., "1 day" instead of "1 days"). Default: false.
	 * @return string The translated and abbreviated interval string.
	 */
	function translateAbbreviatedInterval(
		int $amount,
		string $interval,
		string $fallback = 'once',
		bool $showSingle = false
	) {
		switch ( $interval ) {
			case 'day':
				$text = sprintf(
					$showSingle ? _n( '%d d', '%d d', $amount, 'surecart' ) : _n( 'd', '%d d', $amount, 'surecart' ),
					$amount
				);
				return " / $text";
			case 'week':
				$text = sprintf(
					$showSingle ? _n( '%d wk', '%d wks', $amount, 'surecart' ) : _n( 'wk', '%d wks', $amount, 'surecart' ),
					$amount
				);
				return " / $text";
			case 'month':
				$text = sprintf(
					$showSingle ? _n( '%d mo', '%d mos', $amount, 'surecart' ) : _n( 'mo', '%d mos', $amount, 'surecart' ),
					$amount
				);
				return " / $text";
			case 'year':
				$text = sprintf(
					$showSingle ? _n( '%d yr', '%d yrs', $amount, 'surecart' ) : _n( 'yr', '%d yrs', $amount, 'surecart' ),
					$amount
				);
				return " / $text";
			default:
				return $fallback;
		}
	}
}
