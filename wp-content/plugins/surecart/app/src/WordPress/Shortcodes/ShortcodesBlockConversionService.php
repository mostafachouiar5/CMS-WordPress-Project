<?php

namespace SureCart\WordPress\Shortcodes;

class ShortcodesBlockConversionService {
	/**
	 * Holds the attributes.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Holds the content.
	 *
	 * @var string
	 */
	protected $content = '';

	/**
	 * Get things going
	 *
	 * @param array  $attributes Attributes.
	 * @param string $content Content.
	 */
	public function __construct( $attributes, $content ) {
		$this->attributes = $attributes;
		$this->content    = $content;
	}

	/**
	 * Convert the block
	 *
	 * @param string $name Block name.
	 * @param string $block Block class.
	 * @param array  $defaults Default attributes.
	 *
	 * @return string
	 */
	public function convert( $name, $block, $defaults = [] ) {

		$attributes = shortcode_atts(
			$defaults,
			$this->attributes,
			$name
		);

		return apply_filters(
			'surecart/shortcode/render',
			( new $block() )->render(
				$attributes,
				do_shortcode( $this->content )
			),
			$attributes,
			$name
		);
	}
}
