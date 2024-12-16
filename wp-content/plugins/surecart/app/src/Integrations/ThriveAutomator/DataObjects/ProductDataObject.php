<?php

namespace SureCart\Integrations\ThriveAutomator\DataObjects;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

use SureCart\Integrations\ThriveAutomator\DataFields\PreviousProductDataField;
use SureCart\Integrations\ThriveAutomator\DataFields\ProductDataField;
use SureCart\Integrations\ThriveAutomator\DataFields\ProductIDDataField;
use SureCart\Integrations\ThriveAutomator\DataFields\ProductNameDataField;
use Thrive\Automator\Items\Data_Object;
use SureCart\Models\Product;

/**
 * Class ProductDataObject
 */
class ProductDataObject extends Data_Object {
	/**
	 * Get the data-object identifier
	 *
	 * @return string
	 */
	public static function get_id() {
		return 'surecart_product_data';
	}

	/**
	 * Nice name for the data-object.
	 *
	 * @return string
	 */
	public static function get_nice_name() {
		return __( 'SureCart product object', 'surecart' );
	}

	/**
	 * Array of field object keys that are contained by this data-object
	 *
	 * @return array
	 */
	public static function get_fields() {
		return [
			ProductNameDataField::get_id(),
			ProductIDDataField::get_id(),
			ProductDataField::get_id(),
		];
	}

	/**
	 * Create the object from the given product.
	 *
	 * @param string|\SureCart\Models\Product $param Product model or id.
	 *
	 * @throws \Exception If no parameter is provided.
	 *
	 * @return array
	 */
	public static function create_object( $param ) {
		if ( empty( $param ) ) {
			throw new \Exception( 'No parameter provided for SureCart ProductData object' );
		}

		$product = null;
		if ( is_a( $param, Product::class ) ) {
			$product = $param;
		} else {
			$product = Product::find( $param );
		}

		if ( $product ) {
			return [
				ProductNameDataField::get_id()     => $product->id,
				ProductIDDataField::get_id()       => $product->id,
				ProductDataField::get_id()         => $product->id,
				PreviousProductDataField::get_id() => $product->id,
			];
		}

		return $product;
	}

	/**
	 * Get the options.
	 *
	 * @return array
	 */
	public static function get_data_object_options() {
		$options = [];

		foreach ( Product::get() as $product ) {
			$name           = $product->name;
			$id             = $product->id;
			$options[ $id ] = [
				'id'    => $id,
				'label' => $name,
			];
		}

		return $options;
	}

}
