<?php

namespace SureCart\BlockLibrary;

/**
 * Provide cart migration functionality.
 */
class CartMigrationService {
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
	 * Inner Blocks.
	 *
	 * @var array
	 */
	public array $inner_blocks = array();

	/**
	 * Set the initial variables.
	 *
	 * @param array  $attributes Attributes.
	 * @param object $block Block.
	 */
	public function __construct( $attributes = array(), $block = null ) {
		$this->attributes   = $attributes;
		$this->block        = $block;
		$this->inner_blocks = $block->parsed_block['innerBlocks'] ?? [];
	}

	/**
	 * Get the Child Blocks Attributes.
	 *
	 * @param string $block_name Block Name.
	 * @return array             Child Blocks Attributes.
	 */
	public function getChildBlocksAttributes( $block_name ) {
		if ( empty( $this->inner_blocks ) ) {
			return array();
		}

		foreach ( $this->inner_blocks as $block ) {
			if ( $block['blockName'] === $block_name ) {
				return $block['attrs'];
			}
		}

		return array();
	}

	/**
	 * Render the cart header element.
	 *
	 * @return void
	 */
	public function renderCartHeader(): void {
		$cart_header_attrs = wp_json_encode( $this->getChildBlocksAttributes( 'surecart/cart-header' ), JSON_FORCE_OBJECT );
		$this->block_html .= '<!-- wp:surecart/slide-out-cart-header ' . $cart_header_attrs . ' /-->';
	}

	/**
	 * Render the cart items element.
	 *
	 * @return void
	 */
	public function renderCartItems(): void {
		$cart_items_attrs  = wp_json_encode( $this->getChildBlocksAttributes( 'surecart/cart-items' ), JSON_FORCE_OBJECT );
		$this->block_html .= '<!-- wp:surecart/slide-out-cart-items ' . $cart_items_attrs . ' /-->';
	}

	/**
	 * Render the cart coupon element.
	 *
	 * @return void
	 */
	public function renderCartCoupon(): void {
		$cart_coupon_attrs = wp_json_encode( $this->getChildBlocksAttributes( 'surecart/cart-coupon' ), JSON_FORCE_OBJECT );
		$this->block_html .= '<!-- wp:surecart/slide-out-cart-coupon ' . $cart_coupon_attrs . ' /-->';
	}

	/**
	 * Render the cart subtotal element.
	 *
	 * @return void
	 */
	public function renderCartSubtotal(): void {
		$cart_subtotal_attrs = wp_json_encode( $this->getChildBlocksAttributes( 'surecart/cart-subtotal' ), JSON_FORCE_OBJECT );
		$this->block_html   .= '<!-- wp:surecart/slide-out-cart-subtotal ' . $cart_subtotal_attrs . ' /-->';
	}

	/**
	 * Render the cart bump line item element.
	 *
	 * @return void
	 */
	public function renderCartBumpLineItem(): void {
		$cart_bump_line_item_attrs = wp_json_encode( $this->getChildBlocksAttributes( 'surecart/cart-bump-line-item' ), JSON_FORCE_OBJECT );
		$this->block_html         .= '<!-- wp:surecart/slide-out-cart-bump-line-item ' . $cart_bump_line_item_attrs . ' /-->';
	}

	/**
	 * Render the cart submit element.
	 *
	 * @return void
	 */
	public function renderCartSubmit(): void {
		$cart_submit_attrs = wp_json_encode( $this->getChildBlocksAttributes( 'surecart/cart-submit' ), JSON_FORCE_OBJECT );
		$this->block_html .= '<!-- wp:surecart/slide-out-cart-submit ' . $cart_submit_attrs . ' /-->';
	}

	/**
	 * Render the cart message element.
	 *
	 * @return void
	 */
	public function renderCartMessage(): void {
		$cart_message_attrs = $this->getChildBlocksAttributes( 'surecart/cart-message' );
		if ( empty( $cart_message_attrs['text'] ) ) {
			return;
		}

		$cart_message_attrs = wp_json_encode( $cart_message_attrs, JSON_FORCE_OBJECT );
		$this->block_html  .= '<!-- wp:surecart/slide-out-cart-message ' . $cart_message_attrs . ' /-->';
	}

	/**
	 * Render the cart template.
	 *
	 * @return void
	 */
	public function renderCartTemplate(): void {
		$cart_block_attrs  = wp_json_encode( $this->attributes, JSON_FORCE_OBJECT );
		$this->block_html .= '<!-- wp:surecart/slide-out-cart ' . $cart_block_attrs . ' -->';

		// Render according to the inner blocks order in old block.
		if ( ! empty( $this->inner_blocks ) ) {
			foreach ( $this->inner_blocks as $inner_block ) {
				switch ( $inner_block['blockName'] ) {
					case 'surecart/cart-header':
						$this->renderCartHeader();
						break;
					case 'surecart/cart-items':
						$this->renderCartItems();
						break;
					case 'surecart/cart-coupon':
						$this->renderCartCoupon();
						break;
					case 'surecart/cart-subtotal':
						$this->renderCartSubtotal();
						break;
					case 'surecart/cart-bump-line-item':
						$this->renderCartBumpLineItem();
						break;
					case 'surecart/cart-submit':
						$this->renderCartSubmit();
						break;
					case 'surecart/cart-message':
						$this->renderCartMessage();
						break;
				}
			}
		}
		$this->block_html .= '<!-- /wp:surecart/slide-out-cart -->';
	}

	/**
	 * Render the blocks.
	 *
	 * @return string
	 */
	public function doBlocks(): string {
		return do_blocks( $this->block_html );
	}

	/**
	 * Render the new cart block.
	 *
	 * @return string
	 */
	public function render(): string {
		$this->renderCartTemplate();
		return $this->doBlocks();
	}
}
