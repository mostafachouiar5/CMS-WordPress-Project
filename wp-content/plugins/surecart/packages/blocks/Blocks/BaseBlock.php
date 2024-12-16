<?php

namespace SureCartBlocks\Blocks;

use SureCartBlocks\Util\BlockStyleAttributes;

/**
 * Checkout block
 */
abstract class BaseBlock {
	/**
	 * Optional directory to .json block data files.
	 *
	 * @var string
	 */
	protected $directory = '';

	/**
	 * Holds the block.
	 *
	 * @var object
	 */
	protected $block;

	/**
	 * Get the style for the block
	 *
	 * @param  array $attributes Style variables.
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
			$style    .= 'font-size: ' . $font_size . ';';
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
	 * Get the class name for the color.
	 *
	 * @param string $color_context_name The color context name (color, background-color).
	 * @param string $color_slug (foreground, background, etc.).
	 *
	 * @return string
	 */
	public function getColorClassName( $color_context_name, $color_slug ) {
		if ( ! $color_context_name || ! $color_slug ) {
			return false;
		}
		$color_slug = _wp_to_kebab_case( $color_slug );
		return "has-$color_slug-$color_context_name";
	}

	/**
	 * Get the classes.
	 *
	 * @param array $attributes The block attributes.
	 *
	 * @return string
	 */
	public function getClasses( $attributes ) {
		// get block classes and styles.
		[ 'classes' => $classes ] = BlockStyleAttributes::getClassesAndStylesFromAttributes( $attributes );
		// get text align class.
		['class' => $text_align_class] = BlockStyleAttributes::getTextAlignClassAndStyle( $attributes );
		// get text align class.
		[ 'class' => $align_class ] = BlockStyleAttributes::getAlignClassAndStyle( $attributes );
		return implode( ' ', array_filter( [ $classes, $text_align_class, $align_class ] ) );
	}

	/**
	 * Get the styles
	 *
	 * @param array $attributes The block attributes.
	 *
	 * @return string
	 */
	public function getStyles( $attributes ) {
		[ 'styles' => $styles ] = BlockStyleAttributes::getClassesAndStylesFromAttributes( $attributes );
		return $styles;
	}

	/**
	 * Get the spacing preset css variable.
	 *
	 * @param string $value The value.
	 *
	 * @return string|void
	 */
	public function getSpacingPresetCssVar( $value ) {
		if ( ! $value ) {
			return;
		}

		preg_match( '/var:preset\|spacing\|(.+)/', $value, $matches );

		if ( ! $matches ) {
			return $value;
		}

		return "var(--wp--preset--spacing--$matches[1])";
	}

	/**
	 * Get the font size preset css variable.
	 *
	 * @param string $value The value.
	 *
	 * @return string|void
	 */
	public function getFontSizePresetCssVar( $value ) {
		if ( ! $value ) {
			return;
		}

		return "var(--wp--preset--font-size--$value)";
	}

	/**
	 * Get the color preset css variable.
	 *
	 * @param string $value The value.
	 *
	 * @return string|void
	 */
	public function getColorPresetCssVar( $value ) {
		if ( ! $value ) {
			return;
		}

		return "var(--wp--preset--color--$value)";
	}


	/**
	 * Register the block for dynamic output
	 *
	 * @param \Pimple\Container $container Service container.
	 *
	 * @return void
	 */
	public function register() {
		register_block_type_from_metadata(
			$this->getDir(),
			apply_filters(
				'surecart/block/registration/args',
				[ 'render_callback' => [ $this, 'preRender' ] ],
			),
		);
	}

	/**
	 * Get the called class directory path
	 *
	 * @return string
	 */
	public function getDir() {
		if ( $this->directory ) {
			return $this->directory;
		}

		$reflector = new \ReflectionClass( $this );
		$fn        = $reflector->getFileName();
		return dirname( $fn );
	}


	/**
	 * Optionally run a function to modify attibuutes before rendering.
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content   Post content.
	 *
	 * @return function
	 */
	public function preRender( $attributes, $content, $block ) {
		$this->block = $block;

		// run middlware.
		$render = $this->middleware( $attributes, $content );

		if ( is_wp_error( $render ) ) {
			return $render->get_error_message();
		}

		if ( true !== $render ) {
			return $render;
		}

		$attributes = $this->getAttributes( $attributes );

		// render.
		return $this->render( $attributes, $content, $block );
	}

	/**
	 * Run any block middleware before rendering.
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content   Post content.
	 * @return boolean|\WP_Error;
	 */
	protected function middleware( $attributes, $content ) {
		return true;
	}

	/**
	 * Allows filtering of attributes before rendering.
	 *
	 * @param array $attributes Block attributes.
	 * @return array $attributes
	 */
	public function getAttributes( $attributes ) {
		return $attributes;
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
		return '';
	}
}
