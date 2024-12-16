<?php
namespace SureCart\Integrations\Elementor\Conditions;

use ElementorPro\Modules\QueryControl\Module as QueryModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Single product condition.
 */
class ProductSingle extends \ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base {
	/**
	 * The type of the condition.
	 *
	 * @return string
	 */
	public static function get_type() {
		return 'surecart-single-product';
	}

	/**
	 * The priority.
	 *
	 * @return integer
	 */
	public static function get_priority() {
		return 40;
	}

	/**
	 * The name of the condition.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'surecart-single-product';
	}

	/**
	 * The label of the condition.
	 *
	 * @return string
	 */
	public function get_label() {
		return __( 'Product', 'surecart' );
	}

	/**
	 * The label of the condition.
	 *
	 * @return string
	 */
	public function get_all_label() {
		return __( 'Products', 'surecart' );
	}

	/**
	 * Check to see if the condition is valid for the current request.
	 *
	 * @param array $args Condition arguments.
	 *
	 * @return boolean
	 */
	public function check( $args ) {
		if ( isset( $args['id'] ) && $args['id'] ) {

			if ( ! empty( get_query_var( 'surecart_current_upsell' ) ) ) {
				return false;
			}

			if ( is_singular( 'sc_product' ) ) {
				$product = sc_get_product();
				if ( is_wp_error( $product ) || empty( $product->id ) ) {
					return false;
				}
				return $product->id === $args['id'];
			}
		}
		return false;
	}

	/**
	 * Register controls for the condition.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->add_control(
			'surecart_product_id',
			array(
				'section'        => 'settings',
				'type'           => QueryModule::QUERY_CONTROL_ID,
				'select2options' => array(
					'dropdownCssClass' => 'elementor-conditions-select2-dropdown',
				),
				'autocomplete'   => array(
					'object'      => 'surecart-product',
					'display'     => 'minimal',
					'filter_type' => 'surecart-product',
					'query'       => array(
						'post_type' => 'sc-product',
					),
				),
			)
		);
	}
}
