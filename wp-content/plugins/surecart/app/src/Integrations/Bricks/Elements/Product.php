<?php

namespace SureCart\Integrations\Bricks\Elements;

use SureCart\Integrations\Bricks\Concerns\ConvertsBlocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product element.
 */
class Product extends \Bricks\Element {
	use ConvertsBlocks; // we have to use a trait since we can't extend the bricks class.

	/**
	 * Element category.
	 *
	 * @var string
	 */
	public $category = 'SureCart Layout';

	/**
	 * Element name.
	 *
	 * @var string
	 */
	public $name = 'surecart-product-page';

	/**
	 * Element block name.
	 *
	 * @var string
	 */
	public $block_name = 'surecart/product-page';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-tag';

	/**
	 * This is nestable.
	 *
	 * @var bool
	 */
	public $nestable = true;

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Product Form', 'surecart' );
	}

	/**
	 * Get nestable children.
	 *
	 * @return array
	 */
	public function get_nestable_children() {

		$left_column_children = array(
			array( 'name' => 'surecart-product-media' ),
		);

		$right_column_children = array(
			array(
				'name'     => 'surecart-product-collection-tags',
				'children' => array(
					array(
						'name'     => 'surecart-product-collection-tag',
						'settings' => array(
							'_width' => 'max-content',
						),
					),
				),
			),
			array( 'name' => 'post-title' ),
			array(
				'name'     => 'block',
				'label'    => esc_html__( 'Pricing', 'surecart' ),
				'settings' => [
					'_rowGap' => '8px',
				],
				'children' => array(
					array(
						'name'     => 'block',
						'label'    => esc_html__( 'Amount', 'surecart' ),
						'settings' => array(
							'_direction'  => 'row',
							'_alignItems' => 'flex-end',
							'_columnGap'  => '8px',
						),
						'children' => array(
							array(
								'name'     => 'surecart-product-data',
								'label'    => esc_html__( 'Price', 'surecart' ),
								'settings' => array(
									'direction'   => 'row',
									'_fontSize'   => '1.4em',
									'_gap'        => '5px',
									'_typography' => array(
										'font-size' => '1.4em',
									),
									'meta'        => [
										[
											'dynamicData' => '{sc_product_selected_scratch_price}',
										],
										[
											'dynamicData' => '{sc_product_selected_price}',
										],
									],
								),
							),
							array(
								'name'     => 'surecart-product-data',
								'label'    => esc_html__( 'Interval', 'surecart' ),
								'settings' => array(
									'direction' => 'row',
									'_gap'      => '5px',
									'meta'      => [
										[
											'dynamicData' => '{sc_product_selected_billing_interval}',
										],
									],
								),
							),
							array( 'name' => 'surecart-product-sale-badge' ),
						),
					),
					array(
						'name'     => 'surecart-product-data',
						'label'    => esc_html__( 'Trial/Fees', 'surecart' ),
						'settings' => array(
							'direction' => 'row',
							'_gap'      => '5px',
							'meta'      => [
								[
									'dynamicData' => '{sc_product_selected_trial}',
								],
								[
									'dynamicData' => '{sc_product_selected_setup_fee}',
								],
							],
						),
					),
				),
			),
			array(
				'name'     => 'text-basic',
				'settings' => array(
					'text' => '{sc_product_description}',
				),
			),
			array(
				'name'     => 'surecart-product-price-chooser',
				'children' => array(
					array(
						'name'     => 'surecart-product-price-choice-template',
						'settings' => array(
							'_display'        => 'flex',
							'_direction'      => 'row',
							'_justifyContent' => 'flex-start',
							'_alignItems'     => 'center',
							'_width'          => '100%',
							'_gap'            => '10px',
						),
						'children' => array(
							array(
								'name'     => 'surecart-price-data',
								'label'    => esc_html__( 'Name', 'surecart' ),
								'settings' => array(
									'direction'       => 'column',
									'alignItems'      => 'flex-start',
									'_justifyContent' => 'center',
									'_width'          => '50%',
									'_flexBasis'      => '50%',
									'meta'            => [
										[
											'dynamicData' => '{sc_price_name}',
										],
									],
								),
							),
							array(
								'name'     => 'surecart-price-data',
								'label'    => esc_html__( 'Details', 'surecart' ),
								'settings' => array(
									'direction'       => 'column',
									'alignItems'      => 'flex-end',
									'_justifyContent' => 'center',
									'_width'          => '50%',
									'_flexBasis'      => '50%',
									'_gap'            => '0',
									'_lineHeight'     => '1',
									'meta'            => [
										[
											'dynamicData' => '{sc_price_amount}',
										],
										[
											'dynamicData' => '{sc_price_trial}',
										],
										[
											'dynamicData' => '{sc_price_setup_fee}',
										],
									],
								),
							),
						),
					),
				),
			),
			array( 'name' => 'surecart-product-selected-price-ad-hoc-amount' ),
			array(
				'name'     => 'surecart-product-variant-pills',
				'children' => array(
					array( 'name' => 'surecart-product-variant-pill' ),
				),
			),
			array( 'name' => 'surecart-product-quantity' ),
			array(
				'name'     => 'surecart-product-buy-button',
				'settings' => array(
					'buy_now' => false,
					'_width'  => '100%',
					'size'    => 'lg',
					'circle'  => true,
					'style'   => 'primary',
					'content' => esc_html__( 'Add to Cart', 'surecart' ),
				),
			),
			array(
				'name'     => 'surecart-product-buy-button',
				'settings' => array(
					'buy_now' => true,
					'size'    => 'lg',
					'style'   => 'primary',
					'circle'  => true,
					'outline' => true,
					'_width'  => '100%',
					'content' => esc_html__( 'Buy Now', 'surecart' ),
				),
			),
		);

		return array(
			array(
				'name'     => 'container',
				'settings' => array(
					'_direction' => 'row',
					'_columnGap' => '60px',
					'_rowGap'    => '30px',
				),
				'children' => array(
					array(
						'name'     => 'block',
						'label'    => esc_html__( 'Column', 'surecart' ),
						'settings' => array(
							'_width'                  => '50%',
							'_width:mobile_portrait'  => '100%',
							'_width:mobile_landscape' => '100%',
						),
						'children' => $left_column_children,
					),
					array(
						'name'     => 'block',
						'label'    => esc_html__( 'Column', 'surecart' ),
						'settings' => array(
							'_width'                  => '50%',
							'_width:mobile_portrait'  => '100%',
							'_width:mobile_landscape' => '100%',
							'_direction'              => 'column',
							'_rowGap'                 => '0.75em',
						),
						'children' => $right_column_children,
					),
				),
			),
		);
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render() {
		echo $this->html( [], \Bricks\Frontend::render_children( $this ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
