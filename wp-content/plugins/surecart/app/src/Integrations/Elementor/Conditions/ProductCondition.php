<?php
namespace SureCart\Integrations\Elementor\Conditions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor SureCart Product Condition
 */
class ProductCondition extends \ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base {

	/**
	 * Get the type of the condition.
	 *
	 * @return string
	 */
	public static function get_type() {
		return 'surecart-product';
	}

	/**
	 * Get the name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'surecart-product';
	}

	/**
	 * Get the label.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Product', 'surecart' );
	}

	/**
	 * Get the all label.
	 *
	 * @return string
	 */
	public function get_all_label() {
		return esc_html__( 'All Products', 'surecart' );
	}

	/**
	 * Register sub conditions.
	 *
	 * @return void
	 */
	public function register_sub_conditions() {
		$this->register_sub_condition( new ProductSingle() );
	}

	/**
	 * Check condition.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function check( $args ) {
		return get_query_var( 'surecart_current_product' );
	}
}
