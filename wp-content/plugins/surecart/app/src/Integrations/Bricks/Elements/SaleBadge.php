<?php

namespace SureCart\Integrations\Bricks\Elements;

use SureCart\Integrations\Bricks\Concerns\ConvertsBlocks;
use SureCart\Support\Currency;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Sale Badge element.
 */
class SaleBadge extends \Bricks\Element {
	use ConvertsBlocks; // we have to use a trait since we can't extend the surecart class.

	/**
	 * Element category.
	 *
	 * @var string
	 */
	public $category = 'SureCart Elements';

	/**
	 * Element name.
	 *
	 * @var string
	 */
	public $name = 'surecart-product-sale-badge';

	/**
	 * Element block name.
	 *
	 * @var string
	 */
	public $block_name = 'surecart/product-sale-badge';

	/**
	 * Element icon
	 *
	 * @var string
	 */
	public $icon = 'ion-md-ribbon';

	/**
	 * Get element label
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Sale Badge', 'surecart' );
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls() {
		$this->controls['text'] = array(
			'label' => esc_html__( 'Text', 'surecart' ),
			'type'  => 'text',
		);
	}

	/**
	 * Render element.
	 */
	public function render() {
		$text = ! empty( $this->settings['text'] ) ? $this->settings['text'] : esc_html__( 'Sale', 'surecart' );

		if ( $this->is_admin_editor() ) {
			echo $this->preview( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				esc_attr( $text ),
				'sc-tag sc-tag--primary',
			);
			return;
		}

		echo $this->raw( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				'text' => esc_attr( $text ),
			)
		);
	}
}
