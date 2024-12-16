<?php

namespace SureCart\Integrations\Bricks\Elements;

use SureCart\Integrations\Bricks\Concerns\ConvertsBlocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Selected Price element.
 */
class PriceData extends \Bricks\Element {
	use ConvertsBlocks; // we have to use a trait since we can't extend the surecart class.

	/**
	 * Element category.
	 *
	 * @var string
	 */
	public $category = 'SureCart Elements';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-receipt';

	/**
	 * Element name.
	 *
	 * @var string
	 */
	public $name = 'surecart-price-data';

	/**
	 * Element block name.
	 *
	 * @var string
	 */
	public function get_label() {
		return esc_html__( 'Price Data', 'surecart' );
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls() {
		$this->controls['meta'] = [
			'tab'           => 'content',
			'type'          => 'repeater',
			'titleProperty' => 'dynamicData',
			'placeholder'   => esc_html__( 'Product data', 'surecart' ),
			'fields'        => [
				'dynamicData' => [
					'label' => esc_html__( 'Dynamic data', 'surecart' ),
					'type'  => 'text',
				],
			],
			'default'       => [
				[
					'dynamicData' => '{sc_price_name}',
					'id'          => \Bricks\Helpers::generate_random_id( false ),
				],
				[
					'dynamicData' => '{sc_price_amount}',
					'id'          => \Bricks\Helpers::generate_random_id( false ),
				],
				[
					'dynamicData' => '{sc_price_trial}',
					'id'          => \Bricks\Helpers::generate_random_id( false ),
				],
				[
					'dynamicData' => '{sc_price_setup_fee}',
					'id'          => \Bricks\Helpers::generate_random_id( false ),
				],
			],
		];

		$this->controls['direction'] = [
			'tab'    => 'content',
			'label'  => esc_html__( 'Direction', 'surecart' ),
			'type'   => 'direction',
			'css'    => [
				[
					'property' => 'flex-direction',
					'selector' => '',
				],
			],
			'inline' => true,
		];

		$this->controls['direction'] = [
			'tab'    => 'content',
			'label'  => esc_html__( 'Direction', 'surecart' ),
			'type'   => 'direction',
			'css'    => [
				[
					'property' => 'flex-direction',
					'selector' => '',
				],
			],
			'inline' => true,
		];

		$this->controls['justifyContent'] = [
			'label'   => esc_html__( 'Align main axis', 'surecart' ),
			'tooltip' => [
				'content'  => 'justify-content',
				'position' => 'top-left',
			],
			'type'    => 'justify-content',
			'css'     => [
				[
					'property' => 'justify-content',
				],
			],
		];

		$this->controls['alignItems'] = [
			'label'   => esc_html__( 'Align cross axis', 'surecart' ),
			'tooltip' => [
				'content'  => 'align-items',
				'position' => 'top-left',
			],
			'type'    => 'align-items',
			'css'     => [
				[
					'property' => 'align-items',
				],
			],
		];

		$this->controls['gutter'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Gap', 'surecart' ),
			'type'        => 'number',
			'units'       => true,
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '',
				],
			],
			'placeholder' => 5,
			'default'     => 5,
		];
	}


	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render() {
		$settings = $this->settings;

		if ( empty( $settings['meta'] ) ) {
			return $this->render_element_placeholder(
				[
					'title' => esc_html__( 'No price data selected.', 'surecart' ),
				]
			);
		}

		global $post;

		$post_id   = $this->post_id;
		$post      = get_post( $post_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$meta_data = [];

		foreach ( $settings['meta'] as $index => $meta ) {
			$meta_html = '';

			if ( ! empty( $meta['dynamicData'] ) ) {
				$meta_html .= bricks_render_dynamic_data( $meta['dynamicData'], $post_id );
			}

			$meta_data[] = $meta_html;
		}

		$this->set_attribute( '_root', 'class', 'post-meta' );

		echo "<div {$this->render_attributes( '_root' )}>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo join( '', $meta_data ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo '</div>';
	}
}
