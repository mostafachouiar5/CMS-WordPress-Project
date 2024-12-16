<?php

namespace SureCart\Integrations\ThriveAutomator\DataObjects;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

use SureCart\Integrations\ThriveAutomator\DataFields\PreviousProductDataField;
use SureCart\Integrations\ThriveAutomator\DataFields\PreviousProductIDDataField;
use SureCart\Integrations\ThriveAutomator\DataFields\PreviousProductNameField;

/**
 * Class ProductDataObject
 */
class PreviousProductDataObject extends ProductDataObject {
	/**
	 * Get the data-object identifier
	 *
	 * @return string
	 */
	public static function get_id() {
		return 'surecart_previous_product_data';
	}

	/**
	 * Array of field object keys that are contained by this data-object
	 *
	 * @return array
	 */
	public static function get_fields() {
		return [
			PreviousProductDataField::get_id(),
			PreviousProductIDDataField::get_id(),
			PreviousProductNameField::get_id(),
		];
	}
}
