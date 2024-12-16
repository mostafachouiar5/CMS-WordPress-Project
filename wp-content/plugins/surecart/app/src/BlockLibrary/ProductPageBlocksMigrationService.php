<?php

namespace SureCart\BlockLibrary;

/**
 * Provide the migration service for the product page blocks
 */
class ProductPageBlocksMigrationService {
	/**
	 * Attributes
	 *
	 * @var array
	 */
	public array $attributes = array();

	/**
	 * Block name.
	 *
	 * @var string
	 */
	public string $old_block_name = '';

	/**
	 * Block.
	 *
	 * @var object
	 */
	public ?object $block = null;

	/**
	 * Constructor.
	 *
	 * @param object $block Block.
	 * @param string $old_block_name Old block name.
	 *
	 * @return void
	 */
	public function __construct( $block, $old_block_name ) {
		$this->block          = $block;
		$this->old_block_name = $old_block_name;
		$this->attributes     = $block->parsed_block['attrs'] ?? [];
	}

	/**
	 * Maybe render old block.
	 *
	 * @param string $shortcode_name Short code name.
	 *
	 * @return string
	 */
	public function maybeRenderOldBlockFromShortCode( $shortcode_name ) {
		if ( empty( $this->attributes['id'] ) ) {
			return;
		}

		// translators: %s: block name.
		wp_trigger_error( '', sprintf( esc_html__( 'Passing an id to the [%s] shortcode is deprecated. Please use these shortcodes on product pages directly.', 'surecart' ), $shortcode_name ) );
		$block_content = '<!-- wp:' . $this->old_block_name . ' ' . wp_json_encode( $this->attributes ) . ' /-->';

		return do_blocks( $block_content );
	}
}
