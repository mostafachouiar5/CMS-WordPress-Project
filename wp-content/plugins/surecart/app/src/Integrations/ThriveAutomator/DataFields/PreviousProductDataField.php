<?php

namespace SureCart\Integrations\ThriveAutomator\DataFields;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

/**
 * Class ProductDataField
 */
class PreviousProductDataField extends ProductDataField {
	/**
	 * Get the data field identifier
	 *
	 * @return string
	 */
	public static function get_id() {
		return 'surecart_previous_product_data_field';
	}

	/**
	 * Get the data field name
	 *
	 * @return string
	 */
	public static function get_name() {
		return 'Previous Product';
	}
}
