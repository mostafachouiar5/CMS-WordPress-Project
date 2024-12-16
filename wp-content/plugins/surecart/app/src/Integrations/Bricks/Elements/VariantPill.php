<?php

namespace SureCart\Integrations\Bricks\Elements;

use SureCart\Integrations\Bricks\Concerns\ConvertsBlocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Variant Pill element.
 */
class VariantPill extends \Bricks\Element {
	use ConvertsBlocks; // we have to use a trait since we can't extend the surecart class.

	/**
	 * Element name.
	 *
	 * @var string
	 */
	public $name = 'surecart-product-variant-pill';

	/**
	 * Element block name.
	 *
	 * @var string
	 */
	public $block_name = 'surecart/product-variant-pill';

	/**
	 * Element icon
	 *
	 * @var string
	 */
	public $icon = 'ion-md-radio-button-on';

	/**
	 * Get element label
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Product Variant Pill', 'surecart' );
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls() {
		$this->controls['highlight_text'] = array(
			'label' => esc_html__( 'Highlight Text Color', 'surecart' ),
			'type'  => 'color',
		);

		$this->controls['highlight_background'] = array(
			'label' => esc_html__( 'Highlight Background Color', 'surecart' ),
			'type'  => 'color',
		);

		$this->controls['highlight_border'] = array(
			'label' => esc_html__( 'Highlight Border Color', 'surecart' ),
			'type'  => 'color',
		);
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render() {
		if ( $this->is_admin_editor() ) {
			echo $this->preview( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				esc_html__( 'Option Value', 'surecart' ),
				'sc-pill-option__button wp-block-surecart-product-variant-pill',
				'span'
			);
			return;
		}

		echo $this->raw( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				'highlight_text'       => esc_attr( $this->get_raw_color( 'highlight_text' ) ),
				'highlight_background' => esc_attr( $this->get_raw_color( 'highlight_background' ) ),
				'highlight_border'     => esc_attr( $this->get_raw_color( 'highlight_border' ) ),
			)
		);
	}
}
