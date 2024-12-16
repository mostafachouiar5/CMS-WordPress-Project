<?php

namespace SureCart\Integrations\ThriveAutomator\DataFields;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

/** Product name field. */
class PreviousProductIDDataField extends ProductIDDataField {
	/**
	 * The id for the data field.
	 *
	 * @return string
	 */
	public static function get_id() {
		return 'surecart_previous_product_id_data_field';
	}

	/**
	 * The name for the data field.
	 *
	 * @return string
	 */
	public static function get_name() {
		return __( 'Previous Product ID', 'surecart' );
	}
}
