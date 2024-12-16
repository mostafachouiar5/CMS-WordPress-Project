<?php

namespace SureCart\Integrations\Bricks\Elements;

use SureCart\Integrations\Bricks\Concerns\ConvertsBlocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product element.
 */
class ProductCard extends \Bricks\Element {
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
	public $name = 'surecart-product-card';

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
	public $icon = 'ion-md-list-box';

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
		return esc_html__( 'Product Card', 'surecart' );
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls() {
		$this->controls['linkToPost'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Link to product', 'surecart' ),
			'type'    => 'checkbox',
			'default' => true,
		];
	}

	/**
	 * Get nestable children.
	 *
	 * @return array
	 */
	public function get_nestable_children() {
		return [
			[
				'name'     => 'block',
				'label'    => esc_html__( 'Product Image', 'surecart' ),
				'settings' => [
					'_position'   => 'relative',
					'_background' => [
						'color' => [ 'hex' => '#f3f4f6' ],
					],
					'_margin'     => [
						'bottom' => '10',
					],
					'_overflow'   => 'hidden',
					'_border'     => [
						'radius' => [
							'top'    => '10',
							'bottom' => '10',
							'left'   => '10',
							'right'  => '10',
						],
					],
				],
				'children' => [
					[
						'name'     => 'image',
						'settings' => [
							'image'           => [
								'useDynamicData' => '{featured_image}',
							],
							'_aspectRatio'    => '3 / 4',
							'_objectFit'      => 'cover',
							'_objectPosition' => 'center center',
						],
					],
					[
						'name'     => 'surecart-product-sale-badge',
						'settings' => [
							'_position' => 'absolute',
							'_top'      => '20px',
							'_right'    => '20px',
						],
					],
				],
			],
			[
				'name'     => 'post-title',
				'settings' => [
					'tag'         => 'h2',
					'_typography' => [
						'font-size'   => '15px',
						'font-weight' => 'normal',
						'font-style'  => 'normal',
						'line-height' => '1',
					],
					'_margin'     => [
						'bottom' => '5',
					],
				],
			],
			array(
				'name'     => 'block',
				'label'    => esc_html__( 'Pricing', 'surecart' ),
				'settings' => array(
					'_direction'  => 'row',
					'_columnGap'  => '5',
					'_rowGap'     => '5',
					'_typography' => array(
						'font-size'   => '18px',
						'font-weight' => '600',
						'line-height' => '1',
					),
				),
				'children' => [
					[
						'name'     => 'text-basic',
						'label'    => esc_html__( 'Scratch Price', 'surecart' ),
						'settings' => [
							'text'        => '{sc_product_scratch_price}',
							'_typography' => [
								'text-decoration' => 'line-through',
							],
							'_conditions' => [
								[
									[
										'key'          => 'dynamic_data',
										'compare'      => 'empty_not',
										'dynamic_data' => '{sc_product_scratch_price}',
									],
								],
							],
						],
					],
					[
						'name'     => 'text-basic',
						'label'    => esc_html__( 'Price', 'surecart' ),
						'settings' => [
							'text' => '{sc_product_price}',
						],
					],
				],
			),
		];
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render() {
		if ( $this->settings['linkToPost'] ) {
			echo '<a href="' . esc_url( get_permalink() ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo $this->html( [], \Bricks\Frontend::render_children( $this ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $this->settings['linkToPost'] ) {
			echo '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}
