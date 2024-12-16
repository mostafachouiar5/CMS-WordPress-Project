<?php

namespace SureCart\BlockLibrary;

/**
 * Provide general block-related functionality.
 */
class BlockStylesService {
	/**
	 * Block.
	 *
	 * @var object
	 */
	public $block = null;

	/**
	 * Get the spacing values from the block editor
	 *
	 * @return array
	 */
	public function getSpacingValues() {
		$block            = $this->block ? $this->block : \WP_Block_Supports::$block_to_render;
		$block_type       = \WP_Block_Type_Registry::get_instance()->get_registered(
			$block['blockName']
		);
		$block_attributes = $block['attrs'];

		$attributes          = array();
		$has_padding_support = block_has_support( $block_type, array( 'spacing', 'padding' ), false );
		$has_margin_support  = block_has_support( $block_type, array( 'spacing', 'margin' ), false );
		$block_styles        = isset( $block_attributes['style'] ) ? $block_attributes['style'] : null;

		if ( ! $block_styles ) {
			return $attributes;
		}

		$spacing_block_styles = array(
			'padding' => null,
			'margin'  => null,
		);
		if ( $has_padding_support ) {
			$spacing_block_styles['padding'] = isset( $block_styles['spacing']['padding'] ) ? $block_styles['spacing']['padding'] : null;
		}
		if ( $has_margin_support ) {
			$spacing_block_styles['margin'] = isset( $block_styles['spacing']['margin'] ) ? $block_styles['spacing']['margin'] : null;
		}

		return $spacing_block_styles;
	}

	/**
	 * Get the border values from the block editor
	 *
	 * @return array
	 */
	public function getBorderValues() {
		$block            = $this->block ? $this->block : \WP_Block_Supports::$block_to_render;
		$block_type       = \WP_Block_Type_Registry::get_instance()->get_registered(
			$block['blockName']
		);
		$block_attributes = $block['attrs'];

		$border_block_styles      = array();
		$has_border_color_support = wp_has_border_feature_support( $block_type, 'color' );
		$has_border_width_support = wp_has_border_feature_support( $block_type, 'width' );

		// Border radius.
		if (
			wp_has_border_feature_support( $block_type, 'radius' ) &&
			isset( $block_attributes['style']['border']['radius'] )
		) {
			$border_radius = $block_attributes['style']['border']['radius'];

			if ( is_numeric( $border_radius ) ) {
				$border_radius .= 'px';
			}

			$border_block_styles['radius'] = $border_radius;
		}

		// Border style.
		if (
			wp_has_border_feature_support( $block_type, 'style' ) &&
			isset( $block_attributes['style']['border']['style'] )
		) {
			$border_block_styles['style'] = $block_attributes['style']['border']['style'];
		}

		// Border width.
		if (
			$has_border_width_support &&
			isset( $block_attributes['style']['border']['width'] )
		) {
			$border_width = $block_attributes['style']['border']['width'];

			// This check handles original unitless implementation.
			if ( is_numeric( $border_width ) ) {
				$border_width .= 'px';
			}

			$border_block_styles['width'] = $border_width;
		}

		// Border color.
		if (
			$has_border_color_support
		) {
			$preset_border_color          = array_key_exists( 'borderColor', $block_attributes ) ? "var:preset|color|{$block_attributes['borderColor']}" : null;
			$custom_border_color          = isset( $block_attributes['style']['border']['color'] ) ? $block_attributes['style']['border']['color'] : null;
			$border_block_styles['color'] = $preset_border_color ? $preset_border_color : $custom_border_color;
		}

		// Generates styles for individual border sides.
		if ( $has_border_color_support || $has_border_width_support ) {
			foreach ( array( 'top', 'right', 'bottom', 'left' ) as $side ) {
				$border                       = isset( $block_attributes['style']['border'][ $side ] ) ? $block_attributes['style']['border'][ $side ] : null;
				$border_side_values           = array(
					'width' => isset( $border['width'] ) && ! wp_should_skip_block_supports_serialization( $block_type, '__experimentalBorder', 'width' ) ? $border['width'] : null,
					'color' => isset( $border['color'] ) && ! wp_should_skip_block_supports_serialization( $block_type, '__experimentalBorder', 'color' ) ? $border['color'] : null,
					'style' => isset( $border['style'] ) && ! wp_should_skip_block_supports_serialization( $block_type, '__experimentalBorder', 'style' ) ? $border['style'] : null,
				);
				$border_block_styles[ $side ] = $border_side_values;
			}
		}

		return $border_block_styles;
	}

	/**
	 * Get the color values from the block editor
	 *
	 * @return array
	 */
	public function getColorValues() {
		$block            = $this->block ? $this->block : \WP_Block_Supports::$block_to_render;
		$block_type       = \WP_Block_Type_Registry::get_instance()->get_registered(
			$block['blockName']
		);
		$block_attributes = $block['attrs'];

		$color_support = isset( $block_type->supports['color'] ) ? $block_type->supports['color'] : false;

		$has_text_colors_support       = true === $color_support ||
			( isset( $color_support['text'] ) && $color_support['text'] ) ||
			( is_array( $color_support ) && ! isset( $color_support['text'] ) );
		$has_background_colors_support = true === $color_support ||
			( isset( $color_support['background'] ) && $color_support['background'] ) ||
			( is_array( $color_support ) && ! isset( $color_support['background'] ) );
		$has_gradients_support         = isset( $color_support['gradients'] ) ? $color_support['gradients'] : false;
		$color_block_styles            = array();

		// Text colors.
		if ( $has_text_colors_support ) {
			$preset_text_color          = array_key_exists( 'textColor', $block_attributes ) ? "var:preset|color|{$block_attributes['textColor']}" : null;
			$custom_text_color          = isset( $block_attributes['style']['color']['text'] ) ? $block_attributes['style']['color']['text'] : null;
			$color_block_styles['text'] = $preset_text_color ? $preset_text_color : $custom_text_color;
		}

		// Background colors.
		if ( $has_background_colors_support ) {
			$preset_background_color          = array_key_exists( 'backgroundColor', $block_attributes ) ? "var:preset|color|{$block_attributes['backgroundColor']}" : null;
			$custom_background_color          = isset( $block_attributes['style']['color']['background'] ) ? $block_attributes['style']['color']['background'] : null;
			$color_block_styles['background'] = $preset_background_color ? $preset_background_color : $custom_background_color;
		}

		// Gradients.
		if ( $has_gradients_support ) {
			$preset_gradient_color          = array_key_exists( 'gradient', $block_attributes ) ? "var:preset|gradient|{$block_attributes['gradient']}" : null;
			$custom_gradient_color          = isset( $block_attributes['style']['color']['gradient'] ) ? $block_attributes['style']['color']['gradient'] : null;
			$color_block_styles['gradient'] = $preset_gradient_color ? $preset_gradient_color : $custom_gradient_color;
		}

		return $color_block_styles;
	}

	/**
	 * Get the style declarations
	 *
	 * @param bool   $combine Whether to combine the styles or not.
	 * @param object $block The block object.
	 *
	 * @return array
	 */
	public function get( $combine = true, $block = null ) {
		if ( $block ) {
			$this->block = $block;
		}

		if ( $combine ) {
			return wp_style_engine_get_styles(
				array(
					'spacing' => $this->getSpacingValues(),
					'border'  => $this->getBorderValues(),
					'color'   => $this->getColorValues(),
				),
				array(
					'context' => 'block-supports',
				)
			);
		}

		return array(
			'spacing' => wp_style_engine_get_styles( array( 'spacing' => $this->getSpacingValues() ) ),
			'border'  => wp_style_engine_get_styles( array( 'border' => $this->getBorderValues() ) ),
			'color'   => wp_style_engine_get_styles( array( 'color' => $this->getColorValues() ) ),
		);
	}

	/**
	 * Get the spacing preset css variable.
	 *
	 * @param string $value The value.
	 *
	 * @return string|void
	 */
	public function getBlockGapPresetCssVar( $value ) {
		if ( ! $value ) {
			return;
		}

		preg_match( '/var:preset\|spacing\|(.+)/', $value, $matches );

		if ( ! $matches ) {
			return $value;
		}

		return "var(--wp--preset--spacing--$matches[1])";
	}
}
