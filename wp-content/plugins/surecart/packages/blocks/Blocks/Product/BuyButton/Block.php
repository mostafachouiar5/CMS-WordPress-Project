<?php

namespace SureCartBlocks\Blocks\Product\BuyButton;

use SureCartBlocks\Blocks\Product\ProductBlock;

/**
 * Product Title Block
 */
class Block extends ProductBlock {
	/**
	 * Keep track of the instance number of this block.
	 *
	 * @var integer
	 */
	public static $instance;

	/**
	 * Get the style for the block.
	 *
	 * @param array  $attr Style variables.
	 * @param string $prefix Prefix.
	 * @return string
	 */
	public function getVars( $attr, $prefix ) {
		$style = '';
		// padding.
		if ( ! empty( $attr['style']['spacing']['padding'] ) ) {
			$padding = $attr['style']['spacing']['padding'];
			$style  .= $prefix . '-padding-top: ' . $this->getSpacingPresetCssVar( array_key_exists( 'top', $padding ) ? $padding['top'] : '0' ) . ';';
			$style  .= $prefix . '-padding-bottom: ' . $this->getSpacingPresetCssVar( array_key_exists( 'bottom', $padding ) ? $padding['bottom'] : '0' ) . ';';
			$style  .= $prefix . '-padding-left: ' . $this->getSpacingPresetCssVar( array_key_exists( 'left', $padding ) ? $padding['left'] : '0' ) . ';';
			$style  .= $prefix . '-padding-right: ' . $this->getSpacingPresetCssVar( array_key_exists( 'right', $padding ) ? $padding['right'] : '0' ) . ';';
		}
		// margin.
		if ( ! empty( $attr['style']['spacing']['margin'] ) ) {
			$margin = $attr['style']['spacing']['margin'];
			$style .= $prefix . '-margin-top: ' . $this->getSpacingPresetCssVar( array_key_exists( 'top', $margin ) ? $margin['top'] : '0' ) . ';';
			$style .= $prefix . '-margin-bottom: ' . $this->getSpacingPresetCssVar( array_key_exists( 'bottom', $margin ) ? $margin['bottom'] : '0' ) . ';';
			$style .= $prefix . '-margin-left: ' . $this->getSpacingPresetCssVar( array_key_exists( 'left', $margin ) ? $margin['left'] : '0' ) . ';';
			$style .= $prefix . '-margin-right: ' . $this->getSpacingPresetCssVar( array_key_exists( 'right', $margin ) ? $margin['right'] : '0' ) . ';';
		}
		// aspect ratio.
		if ( ! empty( $attr['ratio'] ) ) {
			$style .= $prefix . '-aspect-ratio: ' . $attr['ratio'] . ';';
		}
		// border width.
		if ( ! empty( $attr['style']['border']['width'] ) ) {
			$style .= $prefix . '-border-width: ' . $attr['style']['border']['width'] . ';';
		}
		// border radius.
		if ( ! empty( $attr['style']['border']['radius'] ) ) {
			$style .= $prefix . '-border-radius: ' . $attr['style']['border']['radius'] . ';';
		}
		// font weight.
		if ( ! empty( $attr['style']['typography']['fontWeight'] ) ) {
			$style .= $prefix . '-font-weight: ' . $attr['style']['typography']['fontWeight'] . ';';
		}
		// font size.
		if ( ! empty( $attr['fontSize'] ) || ! empty( $attr['style']['typography']['fontSize'] ) ) {
			$font_size = ! empty( $attr['fontSize'] ) ? $this->getFontSizePresetCssVar( $attr['fontSize'] ) : $attr['style']['typography']['fontSize'];
			$style    .= $prefix . '-font-size: ' . $font_size . ';';
		}
		// border color.
		if ( ! empty( $attr['borderColor'] ) || ! empty( $attr['style']['border']['color'] ) ) {
			$border_color = ! empty( $attr['borderColor'] ) ? $this->getColorPresetCssVar( $attr['borderColor'] ) : $attr['style']['border']['color'];
			$style       .= $prefix . '-border-color: ' . $border_color . ';';
		}
		// text color.
		if ( ! empty( $attr['textColor'] ) || ! empty( $attr['style']['color']['text'] ) ) {
			$text_color = ! empty( $attr['textColor'] ) ? $this->getColorPresetCssVar( $attr['textColor'] ) : $attr['style']['color']['text'];
			$style     .= $prefix . '-text-color: ' . $text_color . ';';
		}
		// background color.
		if ( ! empty( $attr['backgroundColor'] ) || ! empty( $attr['style']['color']['background'] ) ) {
			$text_color = ! empty( $attr['backgroundColor'] ) ? $this->getColorPresetCssVar( $attr['backgroundColor'] ) : $attr['style']['color']['background'];
			$style     .= $prefix . '-background-color: ' . $text_color . ';';
		}
		// text align.
		if ( ! empty( $attr['align'] ) ) {
			$style .= $prefix . '-align: ' . $attr['align'] . ';';
		}

		if ( ! empty( $attr['width'] ) ) {
			$style .= $prefix . '-width: ' . $attr['width'] . '%;';
		}

		return $style;
	}

	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		self::$instance++;

		$product = $this->getProductAndSetInitialState( $attributes['id'] ?? '' );

		if ( empty( $product ) ) {
			return '';
		}

		// set width class.
		$width_class = ! empty( $attributes['width'] ) ? 'has-custom-width sc-block-button__width-' . $attributes['width'] : '';
		$form        = \SureCart::forms()->getDefault();

		ob_start();
		?>
		<sc-product-buy-button
			<?php echo wp_validate_boolean( $attributes['add_to_cart'] ) ? 'add-to-cart' : ''; ?>
			class="wp-block-button sc-block-button <?php echo esc_attr( $width_class ); ?> <?php echo esc_attr( $attributes['className'] ?? '' ); ?>"
			button-text="<?php echo esc_attr( $attributes['text'] ); ?>"
			product-id="<?php echo esc_attr( $product->id ); ?>"
			form-id="<?php echo (int) $form->ID; ?>"
			checkout-link="<?php echo esc_attr( \SureCart::pages()->url( 'checkout' ) ); ?>"
			id="sc-product-buy-button-<?php echo esc_attr( (int) self::$instance ); ?>"
			>
			<a href="#" class="wp-block-button__link sc-block-button__link wp-element-button <?php echo esc_attr( $this->getClasses( $attributes ) ); ?>" style="<?php echo esc_attr( $this->getStyles( $attributes ) ); ?>">
				<span data-text><?php echo wp_kses_post( $product->archived || empty( $product->prices->data ) ? __( 'Unavailable For Purchase', 'surecart' ) : $attributes['text'] ); ?></span>
				<?php echo wp_validate_boolean( $attributes['add_to_cart'] ) ? '<sc-spinner data-loader></sc-spinner>' : ''; ?>
			</a>
			<button disabled class="wp-block-button__link sc-block-button__link wp-element-button sc-block-button--sold-out <?php echo esc_attr( $this->getClasses( $attributes ) ); ?>" style="<?php echo esc_attr( $this->getStyles( $attributes ) ); ?>">
				<span data-text><?php echo esc_html( $attributes['out_of_stock_text'] ?? __( 'Sold Out', 'surecart' ) ); ?></span>
			</button>
			<button disabled class="wp-block-button__link sc-block-button__link wp-element-button sc-block-button--unavailable <?php echo esc_attr( $this->getClasses( $attributes ) ); ?>" style="<?php echo esc_attr( $this->getStyles( $attributes ) ); ?>">
				<span data-text><?php echo esc_html( $attributes['unavailable_text'] ?? __( 'Unavailable', 'surecart' ) ); ?></span>
			</button>
		</sc-product-buy-button>

		<?php

		// add this to the footer to make sure it's not covered by any other elements
		// and can escape the container query.
		add_action(
			'wp_footer',
			function() use ( $attributes, $product ) {
				?>
		<sc-product-price-modal product-id="<?php echo esc_attr( $product->id ); ?>" <?php echo esc_attr( wp_validate_boolean( $attributes['add_to_cart'] ) ? 'add-to-cart' : '' ); ?>>
				<?php echo wp_kses_post( $product->archived || empty( $product->prices->data ) ? __( 'Unavailable For Purchase', 'surecart' ) : $attributes['text'] ); ?>
		</sc-product-price-modal>
				<?php
			}
		);

		return ob_get_clean();
	}
}
