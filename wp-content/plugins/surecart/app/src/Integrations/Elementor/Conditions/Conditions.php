<?php
namespace SureCart\Integrations\Elementor\Conditions;

use ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * SureCart Conditions.
 */
class Conditions extends Condition_Base {
	/**
	 * Get the type of the condition.
	 *
	 * @return string
	 */
	public static function get_type() {
		return 'surecart';
	}

	/**
	 * Get the name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'surecart';
	}

	/**
	 * Get the label.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'SureCart', 'surecart' );
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
	 * Check condition.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function check( $args ) {
		return sc_get_product() && empty( get_query_var( 'surecart_current_upsell' ) );
	}

	/**
	 * Register sub conditions.
	 *
	 * @return void
	 */
	public function register_sub_conditions() {
		$this->register_sub_condition( new ProductCondition() );
	}
}
