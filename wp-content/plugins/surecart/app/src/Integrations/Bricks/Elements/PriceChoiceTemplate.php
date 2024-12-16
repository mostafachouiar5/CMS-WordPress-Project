<?php


namespace SureCart\Integrations\Bricks\Elements;

use SureCart\Integrations\Bricks\Concerns\ConvertsBlocks;
use SureCart\Integrations\Bricks\Concerns\NestableBlockChildren;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Price Choice Template element.
 */
class PriceChoiceTemplate extends \Bricks\Element {
	use ConvertsBlocks; // we have to use a trait since we can't extend the surecart class.

	/**
	 * Element name.
	 *
	 * @var string
	 */
	public $name = 'surecart-product-price-choice-template';

	/**
	 * Element block name.
	 *
	 * @var string
	 */
	public $block_name = 'surecart/product-price-choice-template';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'fas fa-money-bill-1';

	/**
	 * This is nestable.
	 *
	 * @var bool
	 */
	public $nestable = true;

	/**
	 * Constructor.
	 *
	 * @param array $element Element.
	 *
	 * @return void
	 */
	public function __construct( $element = null ) {
		$element['settings']['_gap'] = '0';
		parent::__construct( $element );
	}

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Price Choice', 'surecart' );
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls() {
		$this->controls['highlight_border'] = array(
			'label' => esc_html__( 'Highlight Border', 'surecart' ),
			'type'  => 'color',
		);
	}

	/**
	 * Get nestable children.
	 *
	 * @return array
	 */
	public function get_nestable_children() {
		return array(
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
				\Bricks\Frontend::render_children( $this ),
				'sc-choice'
			);
			return;
		}

		echo $this->raw( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			[
				'highlight_border' => esc_html( $this->get_raw_color( 'highlight_border' ) ),
			],
			\Bricks\Frontend::render_children( $this ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
}
