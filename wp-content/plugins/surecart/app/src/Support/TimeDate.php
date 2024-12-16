<?php

namespace SureCart\Support;

/**
 * Datetime utilities.
 */
class TimeDate {
	/**
	 * Get the SureCart date format
	 *
	 * @return string
	 */
	public static function getDateFormat() {
		$date_format = get_option( 'date_format' );
		if ( empty( $date_format ) ) {
			// Return default date format if the option is empty.
			$date_format = 'F j, Y';
		}
		return apply_filters( 'surecart/date_format', $date_format );
	}

	/**
	 * Get the SureCart time format
	 *
	 * @return string
	 */
	public static function getTimeFormat() {
		$time_format = get_option( 'time_format' );
		if ( empty( $time_format ) ) {
			// Return default time format if the option is empty.
			$time_format = 'g:i a';
		}
		return apply_filters( 'surecart/time_format', $time_format );
	}

	/**
	 *  Date Format - Allows to change date format for everything SureCart
	 *
	 * @return string
	 */
	public static function formatDate( $timestamp ) {
		return wp_date( self::getDateFormat(), $timestamp );
	}

	/**
	 * WooCommerce Time Format - Allows to change time format for everything WooCommerce.
	 *
	 * @return string
	 */
	public static function formatTime( $timestamp ) {
		return wp_date( self::getTimeFormat(), $timestamp );
	}

	/**
	 * Format both date and time
	 *
	 * @param integer $timestamp
	 * @return string
	 */
	public static function formatDateAndTime( $timestamp ) {
		return self::formatDate( $timestamp ) . ' ' . self::formatTime( $timestamp );
	}

	/**
	 * Human readable Human Time Diff
	 *
	 * @param integer $timestamp Timestamp
	 * @return string
	 */
	public static function humanTimeDiff( $timestamp, $ignore_after = '1 day' ) {
		if ( $timestamp > strtotime( "-$ignore_after", time() ) ) {
			return sprintf(
			/* translators: %s: human-readable time difference */
				_x( '%s ago', '%s = human-readable time difference', 'surecart' ),
				human_time_diff( $timestamp, time() )
			);
		} else {
			return self::formatDate( $timestamp );
		}
	}

	public static function timezoneOptions() {
		return [
			'America/Adak'                   => __( '(GMT-10:00) America/Adak', 'surecart' ),
			'Pacific/Honolulu'               => __( '(GMT-10:00) Hawaii', 'surecart' ),
			'America/Juneau'                 => __( '(GMT-09:00) Alaska', 'surecart' ),
			'America/Anchorage'              => __( '(GMT-09:00) America/Anchorage', 'surecart' ),
			'America/Metlakatla'             => __( '(GMT-09:00) America/Metlakatla', 'surecart' ),
			'America/Nome'                   => __( '(GMT-09:00) America/Nome', 'surecart' ),
			'America/Sitka'                  => __( '(GMT-09:00) America/Sitka', 'surecart' ),
			'America/Yakutat'                => __( '(GMT-09:00) America/Yakutat', 'surecart' ),
			'America/Los_Angeles'            => __( '(GMT-08:00) Pacific Time (US & Canada)', 'surecart' ),
			'America/Boise'                  => __( '(GMT-07:00) America/Boise', 'surecart' ),
			'America/Phoenix'                => __( '(GMT-07:00) Arizona', 'surecart' ),
			'America/Denver'                 => __( '(GMT-07:00) Mountain Time (US & Canada)', 'surecart' ),
			'America/Indiana/Knox'           => __( '(GMT-06:00) America/Indiana/Knox', 'surecart' ),
			'America/Indiana/Tell_City'      => __( '(GMT-06:00) America/Indiana/Tell_City', 'surecart' ),
			'America/Menominee'              => __( '(GMT-06:00) America/Menominee', 'surecart' ),
			'America/North_Dakota/Beulah'    => __( '(GMT-06:00) America/North_Dakota/Beulah', 'surecart' ),
			'America/North_Dakota/Center'    => __( '(GMT-06:00) America/North_Dakota/Center', 'surecart' ),
			'America/North_Dakota/New_Salem' => __( '(GMT-06:00) America/North_Dakota/New_Salem', 'surecart' ),
			'America/Chicago'                => __( '(GMT-06:00) Central Time (US & Canada)', 'surecart' ),
			'America/Detroit'                => __( '(GMT-05:00) America/Detroit', 'surecart' ),
			'America/Indiana/Marengo'        => __( '(GMT-05:00) America/Indiana/Marengo', 'surecart' ),
			'America/Indiana/Petersburg'     => __( '(GMT-05:00) America/Indiana/Petersburg', 'surecart' ),
			'America/Indiana/Vevay'          => __( '(GMT-05:00) America/Indiana/Vevay', 'surecart' ),
			'America/Indiana/Vincennes'      => __( '(GMT-05:00) America/Indiana/Vincennes', 'surecart' ),
			'America/Indiana/Winamac'        => __( '(GMT-05:00) America/Indiana/Winamac', 'surecart' ),
			'America/Kentucky/Louisville'    => __( '(GMT-05:00) America/Kentucky/Louisville', 'surecart' ),
			'America/Kentucky/Monticello'    => __( '(GMT-05:00) America/Kentucky/Monticello', 'surecart' ),
			'America/New_York'               => __( '(GMT-05:00) Eastern Time (US & Canada)', 'surecart' ),
			'America/Indiana/Indianapolis'   => __( '(GMT-05:00) Indiana (East)', 'surecart' ),
			'Etc/GMT+12'                     => __( '(GMT-12:00) International Date Line West', 'surecart' ),
			'Pacific/Pago_Pago'              => __( '(GMT-11:00) American Samoa', 'surecart' ),
			'Pacific/Midway'                 => __( '(GMT-11:00) Midway Island', 'surecart' ),
			'America/Tijuana'                => __( '(GMT-08:00) Tijuana', 'surecart' ),
			'America/Chihuahua'              => __( '(GMT-07:00) Chihuahua', 'surecart' ),
			'America/Mazatlan'               => __( '(GMT-07:00) Mazatlan', 'surecart' ),
			'America/Guatemala'              => __( '(GMT-06:00) Central America', 'surecart' ),
			'America/Mexico_City'            => __( '(GMT-06:00) Guadalajara', 'surecart' ),
			'America/Mexico_City'            => __( '(GMT-06:00) Mexico City', 'surecart' ),
			'America/Monterrey'              => __( '(GMT-06:00) Monterrey', 'surecart' ),
			'America/Regina'                 => __( '(GMT-06:00) Saskatchewan', 'surecart' ),
			'America/Bogota'                 => __( '(GMT-05:00) Bogota', 'surecart' ),
			'America/Lima'                   => __( '(GMT-05:00) Lima', 'surecart' ),
			'America/Lima'                   => __( '(GMT-05:00) Quito', 'surecart' ),
			'America/Halifax'                => __( '(GMT-04:00) Atlantic Time (Canada)', 'surecart' ),
			'America/Caracas'                => __( '(GMT-04:00) Caracas', 'surecart' ),
			'America/Guyana'                 => __( '(GMT-04:00) Georgetown', 'surecart' ),
			'America/La_Paz'                 => __( '(GMT-04:00) La Paz', 'surecart' ),
			'America/Puerto_Rico'            => __( '(GMT-04:00) Puerto Rico', 'surecart' ),
			'America/Santiago'               => __( '(GMT-04:00) Santiago', 'surecart' ),
			'America/St_Johns'               => __( '(GMT-03:30) Newfoundland', 'surecart' ),
			'America/Sao_Paulo'              => __( '(GMT-03:00) Brasilia', 'surecart' ),
			'America/Argentina/Buenos_Aires' => __( '(GMT-03:00) Buenos Aires', 'surecart' ),
			'America/Godthab'                => __( '(GMT-03:00) Greenland', 'surecart' ),
			'America/Montevideo'             => __( '(GMT-03:00) Montevideo', 'surecart' ),
			'Atlantic/South_Georgia'         => __( '(GMT-02:00) Mid-Atlantic', 'surecart' ),
			'Atlantic/Azores'                => __( '(GMT-01:00) Azores', 'surecart' ),
			'Atlantic/Cape_Verde'            => __( '(GMT-01:00) Cape Verde Is.', 'surecart' ),
			'Europe/London'                  => __( '(GMT+00:00) Edinburgh', 'surecart' ),
			'Europe/Lisbon'                  => __( '(GMT+00:00) Lisbon', 'surecart' ),
			'Europe/London'                  => __( '(GMT+00:00) London', 'surecart' ),
			'Africa/Monrovia'                => __( '(GMT+00:00) Monrovia', 'surecart' ),
			'Etc/UTC'                        => __( '(GMT+00:00) UTC', 'surecart' ),
			'Europe/Amsterdam'               => __( '(GMT+01:00) Amsterdam', 'surecart' ),
			'Europe/Belgrade'                => __( '(GMT+01:00) Belgrade', 'surecart' ),
			'Europe/Berlin'                  => __( '(GMT+01:00) Berlin', 'surecart' ),
			'Europe/Zurich'                  => __( '(GMT+01:00) Bern', 'surecart' ),
			'Europe/Bratislava'              => __( '(GMT+01:00) Bratislava', 'surecart' ),
			'Europe/Brussels'                => __( '(GMT+01:00) Brussels', 'surecart' ),
			'Europe/Budapest'                => __( '(GMT+01:00) Budapest', 'surecart' ),
			'Africa/Casablanca'              => __( '(GMT+01:00) Casablanca', 'surecart' ),
			'Europe/Copenhagen'              => __( '(GMT+01:00) Copenhagen', 'surecart' ),
			'Europe/Dublin'                  => __( '(GMT+01:00) Dublin', 'surecart' ),
			'Europe/Ljubljana'               => __( '(GMT+01:00) Ljubljana', 'surecart' ),
			'Europe/Madrid'                  => __( '(GMT+01:00) Madrid', 'surecart' ),
			'Europe/Paris'                   => __( '(GMT+01:00) Paris', 'surecart' ),
			'Europe/Prague'                  => __( '(GMT+01:00) Prague', 'surecart' ),
			'Europe/Rome'                    => __( '(GMT+01:00) Rome', 'surecart' ),
			'Europe/Sarajevo'                => __( '(GMT+01:00) Sarajevo', 'surecart' ),
			'Europe/Skopje'                  => __( '(GMT+01:00) Skopje', 'surecart' ),
			'Europe/Stockholm'               => __( '(GMT+01:00) Stockholm', 'surecart' ),
			'Europe/Vienna'                  => __( '(GMT+01:00) Vienna', 'surecart' ),
			'Europe/Warsaw'                  => __( '(GMT+01:00) Warsaw', 'surecart' ),
			'Africa/Algiers'                 => __( '(GMT+01:00) West Central Africa', 'surecart' ),
			'Europe/Zagreb'                  => __( '(GMT+01:00) Zagreb', 'surecart' ),
			'Europe/Zurich'                  => __( '(GMT+01:00) Zurich', 'surecart' ),
			'Europe/Athens'                  => __( '(GMT+02:00) Athens', 'surecart' ),
			'Europe/Bucharest'               => __( '(GMT+02:00) Bucharest', 'surecart' ),
			'Africa/Cairo'                   => __( '(GMT+02:00) Cairo', 'surecart' ),
			'Africa/Harare'                  => __( '(GMT+02:00) Harare', 'surecart' ),
			'Europe/Helsinki'                => __( '(GMT+02:00) Helsinki', 'surecart' ),
			'Asia/Jerusalem'                 => __( '(GMT+02:00) Jerusalem', 'surecart' ),
			'Europe/Kaliningrad'             => __( '(GMT+02:00) Kaliningrad', 'surecart' ),
			'Europe/Kiev'                    => __( '(GMT+02:00) Kyiv', 'surecart' ),
			'Africa/Johannesburg'            => __( '(GMT+02:00) Pretoria', 'surecart' ),
			'Europe/Riga'                    => __( '(GMT+02:00) Riga', 'surecart' ),
			'Europe/Sofia'                   => __( '(GMT+02:00) Sofia', 'surecart' ),
			'Europe/Tallinn'                 => __( '(GMT+02:00) Tallinn', 'surecart' ),
			'Europe/Vilnius'                 => __( '(GMT+02:00) Vilnius', 'surecart' ),
			'Asia/Baghdad'                   => __( '(GMT+03:00) Baghdad', 'surecart' ),
			'Europe/Istanbul'                => __( '(GMT+03:00) Istanbul', 'surecart' ),
			'Asia/Kuwait'                    => __( '(GMT+03:00) Kuwait', 'surecart' ),
			'Europe/Minsk'                   => __( '(GMT+03:00) Minsk', 'surecart' ),
			'Europe/Moscow'                  => __( '(GMT+03:00) Moscow', 'surecart' ),
			'Africa/Nairobi'                 => __( '(GMT+03:00) Nairobi', 'surecart' ),
			'Asia/Riyadh'                    => __( '(GMT+03:00) Riyadh', 'surecart' ),
			'Europe/Moscow'                  => __( '(GMT+03:00) St. Petersburg', 'surecart' ),
			'Europe/Volgograd'               => __( '(GMT+03:00) Volgograd', 'surecart' ),
			'Asia/Tehran'                    => __( '(GMT+03:30) Tehran', 'surecart' ),
			'Asia/Muscat'                    => __( '(GMT+04:00) Abu Dhabi', 'surecart' ),
			'Asia/Baku'                      => __( '(GMT+04:00) Baku', 'surecart' ),
			'Asia/Muscat'                    => __( '(GMT+04:00) Muscat', 'surecart' ),
			'Europe/Samara'                  => __( '(GMT+04:00) Samara', 'surecart' ),
			'Asia/Tbilisi'                   => __( '(GMT+04:00) Tbilisi', 'surecart' ),
			'Asia/Yerevan'                   => __( '(GMT+04:00) Yerevan', 'surecart' ),
			'Asia/Kabul'                     => __( '(GMT+04:30) Kabul', 'surecart' ),
			'Asia/Yekaterinburg'             => __( '(GMT+05:00) Ekaterinburg', 'surecart' ),
			'Asia/Karachi'                   => __( '(GMT+05:00) Islamabad', 'surecart' ),
			'Asia/Karachi'                   => __( '(GMT+05:00) Karachi', 'surecart' ),
			'Asia/Tashkent'                  => __( '(GMT+05:00) Tashkent', 'surecart' ),
			'Asia/Kolkata'                   => __( '(GMT+05:30) Chennai', 'surecart' ),
			'Asia/Kolkata'                   => __( '(GMT+05:30) Kolkata', 'surecart' ),
			'Asia/Kolkata'                   => __( '(GMT+05:30) Mumbai', 'surecart' ),
			'Asia/Kolkata'                   => __( '(GMT+05:30) New Delhi', 'surecart' ),
			'Asia/Colombo'                   => __( '(GMT+05:30) Sri Jayawardenepura', 'surecart' ),
			'Asia/Kathmandu'                 => __( '(GMT+05:45) Kathmandu', 'surecart' ),
			'Asia/Almaty'                    => __( '(GMT+06:00) Almaty', 'surecart' ),
			'Asia/Dhaka'                     => __( '(GMT+06:00) Astana', 'surecart' ),
			'Asia/Dhaka'                     => __( '(GMT+06:00) Dhaka', 'surecart' ),
			'Asia/Urumqi'                    => __( '(GMT+06:00) Urumqi', 'surecart' ),
			'Asia/Rangoon'                   => __( '(GMT+06:30) Rangoon', 'surecart' ),
			'Asia/Bangkok'                   => __( '(GMT+07:00) Bangkok', 'surecart' ),
			'Asia/Bangkok'                   => __( '(GMT+07:00) Hanoi', 'surecart' ),
			'Asia/Jakarta'                   => __( '(GMT+07:00) Jakarta', 'surecart' ),
			'Asia/Krasnoyarsk'               => __( '(GMT+07:00) Krasnoyarsk', 'surecart' ),
			'Asia/Novosibirsk'               => __( '(GMT+07:00) Novosibirsk', 'surecart' ),
			'Asia/Shanghai'                  => __( '(GMT+08:00) Beijing', 'surecart' ),
			'Asia/Chongqing'                 => __( '(GMT+08:00) Chongqing', 'surecart' ),
			'Asia/Hong_Kong'                 => __( '(GMT+08:00) Hong Kong', 'surecart' ),
			'Asia/Irkutsk'                   => __( '(GMT+08:00) Irkutsk', 'surecart' ),
			'Asia/Kuala_Lumpur'              => __( '(GMT+08:00) Kuala Lumpur', 'surecart' ),
			'Australia/Perth'                => __( '(GMT+08:00) Perth', 'surecart' ),
			'Asia/Singapore'                 => __( '(GMT+08:00) Singapore', 'surecart' ),
			'Asia/Taipei'                    => __( '(GMT+08:00) Taipei', 'surecart' ),
			'Asia/Ulaanbaatar'               => __( '(GMT+08:00) Ulaanbaatar', 'surecart' ),
			'Asia/Tokyo'                     => __( '(GMT+09:00) Osaka', 'surecart' ),
			'Asia/Tokyo'                     => __( '(GMT+09:00) Sapporo', 'surecart' ),
			'Asia/Seoul'                     => __( '(GMT+09:00) Seoul', 'surecart' ),
			'Asia/Tokyo'                     => __( '(GMT+09:00) Tokyo', 'surecart' ),
			'Asia/Yakutsk'                   => __( '(GMT+09:00) Yakutsk', 'surecart' ),
			'Australia/Adelaide'             => __( '(GMT+09:30) Adelaide', 'surecart' ),
			'Australia/Darwin'               => __( '(GMT+09:30) Darwin', 'surecart' ),
			'Australia/Brisbane'             => __( '(GMT+10:00) Brisbane', 'surecart' ),
			'Australia/Melbourne'            => __( '(GMT+10:00) Canberra', 'surecart' ),
			'Pacific/Guam'                   => __( '(GMT+10:00) Guam', 'surecart' ),
			'Australia/Hobart'               => __( '(GMT+10:00) Hobart', 'surecart' ),
			'Australia/Melbourne'            => __( '(GMT+10:00) Melbourne', 'surecart' ),
			'Pacific/Port_Moresby'           => __( '(GMT+10:00) Port Moresby', 'surecart' ),
			'Australia/Sydney'               => __( '(GMT+10:00) Sydney', 'surecart' ),
			'Asia/Vladivostok'               => __( '(GMT+10:00) Vladivostok', 'surecart' ),
			'Asia/Magadan'                   => __( '(GMT+11:00) Magadan', 'surecart' ),
			'Pacific/Noumea'                 => __( '(GMT+11:00) New Caledonia', 'surecart' ),
			'Pacific/Guadalcanal'            => __( '(GMT+11:00) Solomon Is.', 'surecart' ),
			'Asia/Srednekolymsk'             => __( '(GMT+11:00) Srednekolymsk', 'surecart' ),
			'Pacific/Auckland'               => __( '(GMT+12:00) Auckland', 'surecart' ),
			'Pacific/Fiji'                   => __( '(GMT+12:00) Fiji', 'surecart' ),
			'Asia/Kamchatka'                 => __( '(GMT+12:00) Kamchatka', 'surecart' ),
			'Pacific/Majuro'                 => __( '(GMT+12:00) Marshall Is.', 'surecart' ),
			'Pacific/Auckland'               => __( '(GMT+12:00) Wellington', 'surecart' ),
			'Pacific/Chatham'                => __( '(GMT+12:45) Chatham Is.', 'surecart' ),
			'Pacific/Tongatapu'              => __( '(GMT+13:00) Nuku&#39;alofa', 'surecart' ),
			'Pacific/Apia'                   => __( '(GMT+13:00) Samoa', 'surecart' ),
			'Pacific/Fakaofo'                => __( '(GMT+13:00) Tokelau Is.', 'surecart' ),
		];
	}
}
