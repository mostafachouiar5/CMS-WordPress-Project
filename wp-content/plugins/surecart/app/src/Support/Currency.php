<?php

namespace SureCart\Support;

/**
 * Handles currency coversion and formatting
 */
class Currency {
	/**
	 * Get all available Currency symbols.
	 * Currency symbols and names should follow the Unicode CLDR recommendation (http://cldr.unicode.org/translation/currency-names)
	 */
	public static function getCurrencySymbol( $key = null ) {
		$key     = strtoupper( $key ?? \SureCart::account()->currency ?? '' );
		$symbols = apply_filters(
			'surecart/currency_symbols',
			array(
				'AED' => '&#x62f;.&#x625;',
				'AFN' => '&#x60b;',
				'ALL' => 'L',
				'AMD' => 'AMD',
				'ANG' => '&fnof;',
				'AOA' => 'Kz',
				'ARS' => '&#36;',
				'AUD' => '&#36;',
				'AWG' => 'Afl.',
				'AZN' => 'AZN',
				'BAM' => 'KM',
				'BBD' => '&#36;',
				'BDT' => '&#2547;&nbsp;',
				'BGN' => '&#1083;&#1074;.',
				'BHD' => '.&#x62f;.&#x628;',
				'BIF' => 'Fr',
				'BMD' => '&#36;',
				'BND' => '&#36;',
				'BOB' => 'Bs.',
				'BRL' => '&#82;&#36;',
				'BSD' => '&#36;',
				'BTC' => '&#3647;',
				'BTN' => 'Nu.',
				'BWP' => 'P',
				'BYR' => 'Br',
				'BYN' => 'Br',
				'BZD' => '&#36;',
				'CAD' => '&#36;',
				'CDF' => 'Fr',
				'CHF' => '&#67;&#72;&#70;',
				'CLP' => '&#36;',
				'CNY' => '&yen;',
				'COP' => '&#36;',
				'CRC' => '&#x20a1;',
				'CUC' => '&#36;',
				'CUP' => '&#36;',
				'CVE' => '&#36;',
				'CZK' => '&#75;&#269;',
				'DJF' => 'Fr',
				'DKK' => 'DKK',
				'DOP' => 'RD&#36;',
				'DZD' => '&#x62f;.&#x62c;',
				'EGP' => 'EGP',
				'ERN' => 'Nfk',
				'ETB' => 'Br',
				'EUR' => '&euro;',
				'FJD' => '&#36;',
				'FKP' => '&pound;',
				'GBP' => '&pound;',
				'GEL' => '&#x20be;',
				'GGP' => '&pound;',
				'GHS' => '&#x20b5;',
				'GIP' => '&pound;',
				'GMD' => 'D',
				'GNF' => 'Fr',
				'GTQ' => 'Q',
				'GYD' => '&#36;',
				'HKD' => '&#36;',
				'HNL' => 'L',
				'HRK' => 'kn',
				'HTG' => 'G',
				'HUF' => '&#70;&#116;',
				'IDR' => 'Rp',
				'ILS' => '&#8362;',
				'IMP' => '&pound;',
				'INR' => '&#8377;',
				'IQD' => '&#x639;.&#x62f;',
				'IRR' => '&#xfdfc;',
				'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
				'ISK' => 'kr.',
				'JEP' => '&pound;',
				'JMD' => '&#36;',
				'JOD' => '&#x62f;.&#x627;',
				'JPY' => '&yen;',
				'KES' => 'KSh',
				'KGS' => '&#x441;&#x43e;&#x43c;',
				'KHR' => '&#x17db;',
				'KMF' => 'Fr',
				'KPW' => '&#x20a9;',
				'KRW' => '&#8361;',
				'KWD' => '&#x62f;.&#x643;',
				'KYD' => '&#36;',
				'KZT' => '&#8376;',
				'LAK' => '&#8365;',
				'LBP' => '&#x644;.&#x644;',
				'LKR' => '&#xdbb;&#xdd4;',
				'LRD' => '&#36;',
				'LSL' => 'L',
				'LYD' => '&#x644;.&#x62f;',
				'MAD' => '&#x62f;.&#x645;.',
				'MDL' => 'MDL',
				'MKD' => '&#x434;&#x435;&#x43d;',
				'MMK' => 'Ks',
				'MNT' => '&#x20ae;',
				'MOP' => 'P',
				'MRU' => 'UM',
				'MUR' => '&#x20a8;',
				'MVR' => '.&#x783;',
				'MWK' => 'MK',
				'MXN' => '&#36;',
				'MYR' => '&#82;&#77;',
				'MZN' => 'MT',
				'NAD' => 'N&#36;',
				'NGN' => '&#8358;',
				'NIO' => 'C&#36;',
				'NOK' => '&#107;&#114;',
				'NPR' => '&#8360;',
				'NZD' => '&#36;',
				'OMR' => '&#x631;.&#x639;.',
				'PAB' => 'B/.',
				'PEN' => 'S/',
				'PGK' => 'K',
				'PHP' => '&#8369;',
				'PKR' => '&#8360;',
				'PLN' => '&#122;&#322;',
				'PRB' => '&#x440;.',
				'PYG' => '&#8370;',
				'QAR' => '&#x631;.&#x642;',
				'RMB' => '&yen;',
				'RON' => 'lei',
				'RSD' => '&#1088;&#1089;&#1076;',
				'RUB' => '&#8381;',
				'RWF' => 'Fr',
				'SAR' => '&#x631;.&#x633;',
				'SBD' => '&#36;',
				'SCR' => '&#x20a8;',
				'SDG' => '&#x62c;.&#x633;.',
				'SEK' => '&#107;&#114;',
				'SGD' => '&#36;',
				'SHP' => '&pound;',
				'SLL' => 'Le',
				'SOS' => 'Sh',
				'SRD' => '&#36;',
				'SSP' => '&pound;',
				'STN' => 'Db',
				'SYP' => '&#x644;.&#x633;',
				'SZL' => 'L',
				'THB' => '&#3647;',
				'TJS' => '&#x405;&#x41c;',
				'TMT' => 'm',
				'TND' => '&#x62f;.&#x62a;',
				'TOP' => 'T&#36;',
				'TRY' => '&#8378;',
				'TTD' => '&#36;',
				'TWD' => '&#78;&#84;&#36;',
				'TZS' => 'Sh',
				'UAH' => '&#8372;',
				'UGX' => 'UGX',
				'USD' => '&#36;',
				'UYU' => '&#36;',
				'UZS' => 'UZS',
				'VEF' => 'Bs F',
				'VES' => 'Bs.S',
				'VND' => '&#8363;',
				'VUV' => 'Vt',
				'WST' => 'T',
				'XAF' => 'CFA',
				'XCD' => '&#36;',
				'XOF' => 'CFA',
				'XPF' => 'Fr',
				'YER' => '&#xfdfc;',
				'ZAR' => '&#82;',
				'ZMW' => 'ZK',
			)
		);
		return $symbols[ $key ] ?? '&#36;';
	}

	/**
	 * Format the currency into the current locale.
	 *
	 * @param integer $amount Amount as an integer.
	 * @param string  $currency_code 3 digit currency code.
	 *
	 * @return string
	 */
	public static function format( $amount, $currency_code = null ) {
		if ( empty( $currency_code ) ) {
			$currency_code = \SureCart::account()->currency;
		}

		if ( class_exists( 'NumberFormatter' ) ) {
			$fmt              = new \NumberFormatter( get_locale(), \NumberFormatter::CURRENCY );
			$converted_amount = self::maybeConvertAmount( $amount, $currency_code );

			// Extract the fractional part.
			$fractional_part = fmod( $converted_amount, 1 );

			// Check if the fractional part is .00.
			$minimum_fraction_digits = ( 0.00 === $fractional_part ) ? 0 : 2;

			$fmt->setAttribute( \NumberFormatter::MAX_FRACTION_DIGITS, apply_filters( 'surecart/currency/max_cents', $minimum_fraction_digits, $amount, $converted_amount ) );
			return apply_filters( 'surecart/currency/format', $fmt->formatCurrency( $converted_amount, strtoupper( $currency_code ) ), $amount, $currency_code );
		}

		return apply_filters( 'surecart/currency/format', html_entity_decode( self::getCurrencySymbol( $currency_code ) ) . self::formatCurrencyNumber( $amount ), $amount, $currency_code );
	}

	/**
	 * Get zero decimal currencies in uppercase.
	 *
	 * @return array
	 */
	public static function getZeroDecicalCurrencies(): array {
		return array(
			'BIF',
			'BYR',
			'CLP',
			'DJF',
			'GNF',
			'ISK',
			'JPY',
			'KMF',
			'KRW',
			'PYG',
			'RWF',
			'UGX',
			'VND',
			'VUV',
			'XAF',
			'XAG',
			'XAU',
			'XBA',
			'XBB',
			'XBC',
			'XBD',
			'XDR',
			'XOF',
			'XPD',
			'XPF',
			'XPT',
			'XTS',
		);
	}

	/**
	 * Format the currency number
	 */
	public static function formatCurrencyNumber( $amount, $currency_code = 'usd' ) {
		$amount = (float) $amount;
		// TODO: Test this.
		if ( in_array( strtoupper( $currency_code ), self::getZeroDecicalCurrencies(), true ) ) {
			return self::formatCents( $amount, 1 );
		}
		return self::formatCents( $amount / 100, 1 );
	}

	/**
	 * Format the cents.
	 *
	 * @param integer $number Number.
	 * @param integer $cents Cents.
	 *
	 * @return string
	 */
	public static function formatCents( $number, $cents = 1 ) {
		// cents: 0=never, 1=if needed, 2=always.
		if ( is_numeric( $number ) ) { // a number.
			if ( ! $number ) { // zero.
				$money = ( 2 === $cents ? '0.00' : '0' ); // output zero.
			} else { // value.
				if ( floor( $number ) == $number ) { // whole number.
					$money = number_format_i18n( (float) $number, ( 2 === $cents ? 2 : 0 ) ); // format.
				} else { // cents.
					$money = number_format_i18n( round( (float) $number, 2 ), ( 0 === $cents ? 0 : 2 ) ); // format.
				} // integer or decimal.
			} // value.

			// Remove any comma separators.
			$money = str_replace( ',', '', $money );

			return number_format_i18n( (float) $money, 2 );
		} // numeric.
	}

	/**
	 * Get a list of supported currencies.
	 *
	 * @param string $provider Provider.
	 */
	public static function getSupportedCurrencies() {
		return [
			'all' => __( 'Albanian Lek', 'surecart' ),
			'dzd' => __( 'Algerian Dinar', 'surecart' ),
			'aoa' => __( 'Angolan Kwanza', 'surecart' ),
			'ars' => __( 'Argentine Peso', 'surecart' ),
			'amd' => __( 'Armenian Dram', 'surecart' ),
			'awg' => __( 'Aruban Florin', 'surecart' ),
			'aud' => __( 'Australian Dollar', 'surecart' ),
			'azn' => __( 'Azerbaijani Manat', 'surecart' ),
			'bsd' => __( 'Bahamian Dollar', 'surecart' ),
			'bdt' => __( 'Bangladeshi Taka', 'surecart' ),
			'bbd' => __( 'Barbadian Dollar', 'surecart' ),
			'byn' => __( 'Belarusian Ruble', 'surecart' ),
			'bzd' => __( 'Belize Dollar', 'surecart' ),
			'bmd' => __( 'Bermudian Dollar', 'surecart' ),
			'bob' => __( 'Bolivian Boliviano', 'surecart' ),
			'bam' => __( 'Bosnia and Herzegovina Convertible Mark', 'surecart' ),
			'bwp' => __( 'Botswana Pula', 'surecart' ),
			'brl' => __( 'Brazilian Real', 'surecart' ),
			'gbp' => __( 'British Pound', 'surecart' ),
			'bnd' => __( 'Brunei Dollar', 'surecart' ),
			'bgn' => __( 'Bulgarian Lev', 'surecart' ),
			'bif' => __( 'Burundian Franc', 'surecart' ),
			'khr' => __( 'Cambodian Riel', 'surecart' ),
			'cad' => __( 'Canadian Dollar', 'surecart' ),
			'cve' => __( 'Cape Verdean Escudo', 'surecart' ),
			'kyd' => __( 'Cayman Islands Dollar', 'surecart' ),
			'xaf' => __( 'Central African Cfa Franc', 'surecart' ),
			'xpf' => __( 'Cfp Franc', 'surecart' ),
			'clp' => __( 'Chilean Peso', 'surecart' ),
			'cny' => __( 'Chinese Renminbi Yuan', 'surecart' ),
			'cop' => __( 'Colombian Peso', 'surecart' ),
			'kmf' => __( 'Comorian Franc', 'surecart' ),
			'cdf' => __( 'Congolese Franc', 'surecart' ),
			'crc' => __( 'Costa Rican Colón', 'surecart' ),
			'hrk' => __( 'Croatian Kuna', 'surecart' ),
			'czk' => __( 'Czech Koruna', 'surecart' ),
			'dkk' => __( 'Danish Krone', 'surecart' ),
			'djf' => __( 'Djiboutian Franc', 'surecart' ),
			'dop' => __( 'Dominican Peso', 'surecart' ),
			'xcd' => __( 'East Caribbean Dollar', 'surecart' ),
			'egp' => __( 'Egyptian Pound', 'surecart' ),
			'etb' => __( 'Ethiopian Birr', 'surecart' ),
			'eur' => __( 'Euro', 'surecart' ),
			'fkp' => __( 'Falkland Pound', 'surecart' ),
			'fjd' => __( 'Fijian Dollar', 'surecart' ),
			'gmd' => __( 'Gambian Dalasi', 'surecart' ),
			'gel' => __( 'Georgian Lari', 'surecart' ),
			'ghs' => __( 'Ghanaian Cedi', 'surecart' ),
			'gip' => __( 'Gibraltar Pound', 'surecart' ),
			'gtq' => __( 'Guatemalan Quetzal', 'surecart' ),
			'gnf' => __( 'Guinean Franc', 'surecart' ),
			'gyd' => __( 'Guyanese Dollar', 'surecart' ),
			'htg' => __( 'Haitian Gourde', 'surecart' ),
			'hnl' => __( 'Honduran Lempira', 'surecart' ),
			'hkd' => __( 'Hong Kong Dollar', 'surecart' ),
			'huf' => __( 'Hungarian Forint', 'surecart' ),
			'isk' => __( 'Icelandic Króna', 'surecart' ),
			'inr' => __( 'Indian Rupee', 'surecart' ),
			'idr' => __( 'Indonesian Rupiah', 'surecart' ),
			'ils' => __( 'Israeli New Sheqel', 'surecart' ),
			'jmd' => __( 'Jamaican Dollar', 'surecart' ),
			'jpy' => __( 'Japanese Yen', 'surecart' ),
			'kzt' => __( 'Kazakhstani Tenge', 'surecart' ),
			'kes' => __( 'Kenyan Shilling', 'surecart' ),
			'kgs' => __( 'Kyrgyzstani Som', 'surecart' ),
			'lak' => __( 'Lao Kip', 'surecart' ),
			'lbp' => __( 'Lebanese Pound', 'surecart' ),
			'lsl' => __( 'Lesotho Loti', 'surecart' ),
			'lrd' => __( 'Liberian Dollar', 'surecart' ),
			'mop' => __( 'Macanese Pataca', 'surecart' ),
			'mkd' => __( 'Macedonian Denar', 'surecart' ),
			'mwk' => __( 'Malawian Kwacha', 'surecart' ),
			'myr' => __( 'Malaysian Ringgit', 'surecart' ),
			'mvr' => __( 'Maldivian Rufiyaa', 'surecart' ),
			'mro' => __( 'Mauritanian Ouguiya', 'surecart' ),
			'mur' => __( 'Mauritian Rupee', 'surecart' ),
			'mxn' => __( 'Mexican Peso', 'surecart' ),
			'mdl' => __( 'Moldovan Leu', 'surecart' ),
			'mnt' => __( 'Mongolian Tögrög', 'surecart' ),
			'mad' => __( 'Moroccan Dirham', 'surecart' ),
			'mzn' => __( 'Mozambican Metical', 'surecart' ),
			'mmk' => __( 'Myanmar Kyat', 'surecart' ),
			'nad' => __( 'Namibian Dollar', 'surecart' ),
			'npr' => __( 'Nepalese Rupee', 'surecart' ),
			'ang' => __( 'Netherlands Antillean Gulden', 'surecart' ),
			'twd' => __( 'New Taiwan Dollar', 'surecart' ),
			'nzd' => __( 'New Zealand Dollar', 'surecart' ),
			'nio' => __( 'Nicaraguan Córdoba', 'surecart' ),
			'ngn' => __( 'Nigerian Naira', 'surecart' ),
			'nok' => __( 'Norwegian Krone', 'surecart' ),
			'pkr' => __( 'Pakistani Rupee', 'surecart' ),
			'pab' => __( 'Panamanian Balboa', 'surecart' ),
			'pgk' => __( 'Papua New Guinean Kina', 'surecart' ),
			'pyg' => __( 'Paraguayan Guaraní', 'surecart' ),
			'pen' => __( 'Peruvian Sol', 'surecart' ),
			'php' => __( 'Philippine Peso', 'surecart' ),
			'pln' => __( 'Polish Złoty', 'surecart' ),
			'qar' => __( 'Qatari Riyal', 'surecart' ),
			'ron' => __( 'Romanian Leu', 'surecart' ),
			'rub' => __( 'Russian Ruble', 'surecart' ),
			'rwf' => __( 'Rwandan Franc', 'surecart' ),
			'shp' => __( 'Saint Helenian Pound', 'surecart' ),
			'wst' => __( 'Samoan Tala', 'surecart' ),
			'sar' => __( 'Saudi Riyal', 'surecart' ),
			'rsd' => __( 'Serbian Dinar', 'surecart' ),
			'scr' => __( 'Seychellois Rupee', 'surecart' ),
			'sll' => __( 'Sierra Leonean Leone', 'surecart' ),
			'sgd' => __( 'Singapore Dollar', 'surecart' ),
			'sbd' => __( 'Solomon Islands Dollar', 'surecart' ),
			'sos' => __( 'Somali Shilling', 'surecart' ),
			'zar' => __( 'South African Rand', 'surecart' ),
			'krw' => __( 'South Korean Won', 'surecart' ),
			'lkr' => __( 'Sri Lankan Rupee', 'surecart' ),
			'srd' => __( 'Surinamese Dollar', 'surecart' ),
			'szl' => __( 'Swazi Lilangeni', 'surecart' ),
			'sek' => __( 'Swedish Krona', 'surecart' ),
			'chf' => __( 'Swiss Franc', 'surecart' ),
			'std' => __( 'São Tomé and Príncipe Dobra', 'surecart' ),
			'tjs' => __( 'Tajikistani Somoni', 'surecart' ),
			'tzs' => __( 'Tanzanian Shilling', 'surecart' ),
			'thb' => __( 'Thai Baht', 'surecart' ),
			'top' => __( 'Tongan Paʻanga', 'surecart' ),
			'ttd' => __( 'Trinidad and Tobago Dollar', 'surecart' ),
			'try' => __( 'Turkish Lira', 'surecart' ),
			'ugx' => __( 'Ugandan Shilling', 'surecart' ),
			'uah' => __( 'Ukrainian Hryvnia', 'surecart' ),
			'aed' => __( 'United Arab Emirates Dirham', 'surecart' ),
			'usd' => __( 'United States Dollar', 'surecart' ),
			'uyu' => __( 'Uruguayan Peso', 'surecart' ),
			'uzs' => __( 'Uzbekistan Som', 'surecart' ),
			'vuv' => __( 'Vanuatu Vatu', 'surecart' ),
			'vnd' => __( 'Vietnamese Đồng', 'surecart' ),
			'xof' => __( 'West African Cfa Franc', 'surecart' ),
			'yer' => __( 'Yemeni Rial', 'surecart' ),
			'zmw' => __( 'Zambian Kwacha', 'surecart' ),
			'tnd' => __( 'Tunisian Dinar', 'surecart' ),
		];
	}

	/**
	 * Determine if this is a zero decimal currency.
	 *
	 * @param string $currency The currency code.
	 *
	 * @return bool
	 */
	public static function isZeroDecimal( $currency ) {
		return in_array( strtoupper( $currency ), self::getZeroDecicalCurrencies(), true );
	}

	/**
	 * Convery product amount.
	 *
	 * @param int    $amount The Amount.
	 * @param string $currency The Currency.
	 *
	 * @return int
	 */
	public static function maybeConvertAmount( $amount, $currency = null ) {
		if ( ! $currency ) {
			$currency = \SureCart::account()->currency;
		}
		return self::isZeroDecimal( (string) $currency ) ? $amount : $amount / 100;
	}
}
