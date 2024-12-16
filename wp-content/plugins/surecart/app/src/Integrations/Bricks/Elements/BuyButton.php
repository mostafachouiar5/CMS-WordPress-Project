<?php

namespace SureCart\Integrations\Bricks\Elements;

use Bricks\Element;
use SureCart\Integrations\Bricks\Concerns\ConvertsBlocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Buy Button element.
 */
class BuyButton extends Element {
	use ConvertsBlocks; // we have to use a trait since we can't extend the bricks class.

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
	public $name = 'surecart-product-buy-button';

	/**
	 * Element block name.
	 *
	 * @var string
	 */
	public $block_name = 'surecart/product-buy-button';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-shopping-cart';

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Add To Cart', 'surecart' );
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls() {
		$this->controls['content'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Button Text', 'surecart' ),
			'type'    => 'text',
			'default' => esc_html__( 'Add To Cart', 'surecart' ),
		];

		$this->controls['buy_now'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Go Directly To Checkout', 'surecart' ),
			'type'        => 'checkbox',
			'description' => esc_html__( 'Bypass adding to cart and go directly to the checkout.', 'surecart' ),
		];

		$this->controls['styleSeparator'] = [
			'label' => esc_html__( 'Style', 'surecart' ),
			'type'  => 'separator',
		];

		$this->controls['size'] = [
			'label'       => esc_html__( 'Size', 'surecart' ),
			'type'        => 'select',
			'options'     => $this->control_options['buttonSizes'],
			'inline'      => true,
			'reset'       => true,
			'placeholder' => esc_html__( 'Default', 'surecart' ),
		];

		$this->controls['style'] = [
			'label'       => esc_html__( 'Style', 'surecart' ),
			'type'        => 'select',
			'options'     => $this->control_options['styles'],
			'inline'      => true,
			'reset'       => true,
			'default'     => 'primary',
			'placeholder' => esc_html__( 'None', 'surecart' ),
		];

		$this->controls['circle'] = [
			'label' => esc_html__( 'Circle', 'surecart' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		$this->controls['outline'] = [
			'label' => esc_html__( 'Outline', 'surecart' ),
			'type'  => 'checkbox',
			'reset' => true,
		];

		// Icon
		$this->controls['iconSeparator'] = [
			'label' => esc_html__( 'Icon', 'surecart' ),
			'type'  => 'separator',
		];

		$this->controls['icon'] = [
			'label' => esc_html__( 'Icon', 'surecart' ),
			'type'  => 'icon',
		];

		$this->controls['iconTypography'] = [
			'label'    => esc_html__( 'Typography', 'surecart' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => 'i',
				],
			],
			'required' => [ 'icon.icon', '!=', '' ],
		];

		$this->controls['iconPosition'] = [
			'label'       => esc_html__( 'Position', 'surecart' ),
			'type'        => 'select',
			'options'     => $this->control_options['iconPosition'],
			'inline'      => true,
			'placeholder' => esc_html__( 'Right', 'surecart' ),
			'required'    => [ 'icon', '!=', '' ],
		];

		$this->controls['iconGap'] = [
			'label'    => esc_html__( 'Gap', 'surecart' ),
			'type'     => 'number',
			'units'    => true,
			'css'      => [
				[
					'property' => 'gap',
				],
			],
			'required' => [ 'icon', '!=', '' ],
		];

		$this->controls['iconSpace'] = [
			'label'    => esc_html__( 'Space between', 'surecart' ),
			'type'     => 'checkbox',
			'css'      => [
				[
					'property' => 'justify-content',
					'value'    => 'space-between',
				],
			],
			'required' => [ 'icon', '!=', '' ],
		];
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render() {
		$settings = $this->settings;

		$this->set_attribute( '_root', 'class', 'bricks-button' );

		if ( ! empty( $settings['size'] ) ) {
			$this->set_attribute( '_root', 'class', $settings['size'] );
		}

		// Outline.
		if ( isset( $settings['outline'] ) ) {
			$this->set_attribute( '_root', 'class', 'outline' );
		}

		if ( ! empty( $settings['style'] ) ) {
			// Outline (border).
			if ( isset( $settings['outline'] ) ) {
				$this->set_attribute( '_root', 'class', "bricks-color-{$settings['style']}" );
			} else { // Background (= default).
				$this->set_attribute( '_root', 'class', "bricks-background-{$settings['style']}" );
			}
		}

		// Interactivity context.
		$this->set_attribute(
			'_root',
			'data-wp-context',
			wp_json_encode(
				array(
					'checkoutUrl'     => esc_url( \SureCart::pages()->url( 'checkout' ) ),
					'text'            => $settings['content'] ?? ( $settings['buy_now'] ? __( 'Add to Cart', 'surecart' ) : __( 'Buy Now', 'surecart' ) ),
					'outOfStockText'  => esc_attr( __( 'Sold Out', 'surecart' ) ),
					'unavailableText' => esc_attr( __( 'Unavailable For Purchase', 'surecart' ) ),
					'addToCart'       => $settings['buy_now'] ? false : true,
				),
				JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
			)
		);

		// Circle.
		if ( isset( $settings['circle'] ) ) {
			$this->set_attribute( '_root', 'class', 'circle' );
		}

		// Block.
		if ( isset( $settings['block'] ) ) {
			$this->set_attribute( '_root', 'class', 'block' );
		}

		// Link class for busy state.
		$this->set_attribute( '_root', 'class', 'sc-button__link' );

		// Set tag and attributes.
		if ( ! empty( $settings['buy_now'] ) ) {
			$this->tag = 'a';
			$this->set_attribute( '_root', 'data-wp-bind--disabled', 'state.isUnavailable' );
			$this->set_attribute( '_root', 'data-wp-bind--href', 'state.checkoutUrl' );
		} else {
			$this->tag = 'button';
			$this->set_attribute( '_root', 'data-wp-bind--disabled', 'state.isUnavailable' );
			$this->set_attribute( '_root', 'data-wp-class--sc-button__link--busy', 'context.busy' );
		}

		$output = "<{$this->tag} {$this->render_attributes( '_root' )}>";

		// Icon.
		$icon          = ! empty( $settings['icon'] ) ? self::render_icon( $settings['icon'] ) : false;
		$icon_position = ! empty( $settings['iconPosition'] ) ? $settings['iconPosition'] : 'right';

		if ( 'left' === $icon_position && $icon ) {
			$output .= $icon;
		}

		if ( isset( $settings['content'] ) ) {
			if ( $this->is_admin_editor() ) {
				$output .= trim( $settings['content'] );
			} else {
				$output .= '<span class="sc-spinner" aria-hidden="false"></span>';
				$output .= '<span class="sc-button__link-text" data-wp-text="state.buttonText"></span>';
			}
		}

		if ( 'right' === $icon_position && $icon ) {
			$output .= $icon;
		}

		$output .= "</{$this->tag}>";

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
