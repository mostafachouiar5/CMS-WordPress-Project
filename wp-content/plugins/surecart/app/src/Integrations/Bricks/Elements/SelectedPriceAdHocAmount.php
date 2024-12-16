<?php

namespace SureCart\Integrations\Bricks\Elements;

use SureCart\Integrations\Bricks\Concerns\ConvertsBlocks;
use SureCart\Support\Currency;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Selected Price Ad Hoc Amount element.
 */
class SelectedPriceAdHocAmount extends \Bricks\Element {
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
	public $name = 'surecart-product-selected-price-ad-hoc-amount';

	/**
	 * Element block name.
	 *
	 * @var string
	 */
	public $block_name = 'surecart/product-selected-price-ad-hoc-amount';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ion-md-create';

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Custom Amount', 'surecart' );
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls() {
		$this->controls['label'] = array(
			'label' => esc_html__( 'Label', 'surecart' ),
			'type'  => 'text',
		);
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render() {
		$label = ! empty( $this->settings['label'] ) ? $this->settings['label'] : esc_html__( 'Enter an amount', 'surecart' );

		if ( $this->is_admin_editor() ) {
			ob_start();
			?>
			<div class="wp-block-surecart-product-selected-price-ad-hoc-amount" data-sc-block-id="custom-amount">
				<label for="sc-product-custom-amount" class="sc-form-label">
					<?php echo wp_kses_post( $label ); ?>
				</label>
				<div class="sc-input-group">
					<span class="sc-input-group-text" id="basic-addon1"><?php echo esc_html( Currency::getCurrencySymbol() ); ?></span>
					<input class="sc-form-control" id="sc-product-custom-amount" type="number" step="0.01"/>
				</div>
			</div>
			<?php
			$output = ob_get_clean();
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}
		echo $this->raw( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			[
				'label' => wp_kses_post( $label ),
			]
		);
	}
}
