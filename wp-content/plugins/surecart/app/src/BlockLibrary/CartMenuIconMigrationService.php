<?php

namespace SureCart\BlockLibrary;

/**
 * Provide cart menu icon migration functionality.
 */
class CartMenuIconMigrationService {
	/**
	 * Attributes.
	 *
	 * @var string
	 */
	public array $attributes = array();

	/**
	 * Block.
	 *
	 * @var string
	 */
	public ?object $block;

	/**
	 * Block HTML.
	 *
	 * @var string
	 */
	public string $block_html = '';

	/**
	 * Set the initial variables.
	 *
	 * @param array  $attributes Attributes.
	 * @param object $block      Block.
	 */
	public function __construct( $attributes = array(), $block = null ) {
		$this->attributes = $attributes;
		$this->block      = $block;
	}

	/**
	 * Render the new cart menu icon block.
	 *
	 * @return string
	 */
	public function render(): string {
		$cart_menu_icon_block_attrs = wp_json_encode( $this->attributes, JSON_FORCE_OBJECT );
		$this->block_html          .= '<!-- wp:surecart/cart-menu-icon-button ' . $cart_menu_icon_block_attrs . ' /-->';

		return do_blocks( $this->block_html );
	}
}
