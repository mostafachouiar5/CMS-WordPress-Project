<?php

namespace SureCartBlocks\Blocks\Upsell\CountdownTimer;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Upsell Count Down Timer Block.
 */
class Block extends BaseBlock {
	/**
	 * Keep track of the instance number of this block.
	 *
	 * @var integer
	 */
	public static $instance;

	/**
	 * Get the style for the block
	 *
	 * @param  array  $attr Style variables.
	 * @param  string $prefix Prefix for the css variables.
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
		$upsell = get_query_var( 'surecart_current_upsell' );
		if ( empty( $upsell ) ) {
			return '';
		}

		$width_class = ! empty( $attributes['width'] ) ? 'has-custom-width sc-countdown-timer__width-' . $attributes['width'] : '';

		return wp_sprintf(
			'<div %s>%s</div>',
			get_block_wrapper_attributes( [ 'class' => $width_class . ' ' . ($attributes['className'] ?? '') . ' ' . 'sc-countdown-timer' ] ),
			wp_sprintf(
				'<sc-upsell-countdown-timer showIcon="%s" class="%s" style="%s">
					<span slot="offer-expire-text">%s</span>
				</sc-upsell-countdown-timer>',
				esc_attr( $attributes['show_icon'] ),
				esc_attr( $this->getClasses( $attributes ) ),
				esc_attr( $this->getStyles( $attributes ) ),
				esc_attr( $attributes['offer_expire_text'] ?? '' )
			)
		);
	}
}
