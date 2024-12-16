<?php

namespace SureCart\Integrations\ThriveAutomator\DataFields;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

use SureCart\Integrations\ThriveAutomator\DataObjects\ProductDataObject;
use Thrive\Automator\Items\Data_Field;

/** Product name field. */
class ProductIDDataField extends Data_Field {
	/**
	 * The id for the data field.
	 *
	 * @return string
	 */
	public static function get_id() {
		return 'surecart_product_id_data_field';
	}

	/**
	 * The name for the data field.
	 *
	 * @return string
	 */
	public static function get_name() {
		return __( 'Product ID', 'surecart' );
	}

	/**
	 * The description for the data field.
	 *
	 * @return string
	 */
	public static function get_description() {
		return __( 'A specific product id.', 'surecart' );
	}

	/**
	 * The placeholder for the data field.
	 *
	 * @return string
	 */
	public static function get_placeholder() {
		return __( 'Product ID', 'surecart' );
	}

	/**
	 * The supported filters for the data field.
	 *
	 * @return array
	 */
	public static function get_supported_filters() {
		return [ 'string_ec' ];
	}

	/**
	 * The validators for the data field.
	 *
	 * @return array
	 */
	public static function get_validators() {
		return [ 'required' ];
	}

	/**
	 * The value type for the data field.
	 *
	 * @return string
	 */
	public static function get_field_value_type() {
		return static::TYPE_STRING;
	}

	/**
	 * The dummy value for the data field.
	 *
	 * @return string
	 */
	public static function get_dummy_value() {
		return __( 'Product ID', 'surecart' );
	}

	/**
	 * The primary key for the data field.
	 *
	 * @return string
	 */
	public static function primary_key() {
		return ProductDataObject::get_id();
	}
}
