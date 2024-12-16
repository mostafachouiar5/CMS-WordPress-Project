<?php

namespace SureCart\BlockLibrary;

/**
 * Provide the migration service for the product variant block.
 */
class ProductVariantsMigrationService {
	/**
	 * Attributes
	 *
	 * @var array
	 */
	public $attributes = array();

	/**
	 * Block.
	 *
	 * @var object
	 */
	public ?object $block = null;

	/**
	 * Block HTML.
	 *
	 * @var string
	 */
	public string $block_html = '';

	/**
	 * Constructor
	 *
	 * @param array  $attributes Attributes.
	 * @param object $block Block.
	 */
	public function __construct( $attributes = array(), $block = null ) {
		$this->attributes = $attributes;
		$this->block      = $block;
	}

	/**
	 * Render the variant pill
	 */
	public function renderVariantPill() {
		$block_attributes = array_merge(
			$this->attributes,
			array(
				'highlight_text'       => '#ffffff',
				'highlight_background' => '#000000',
				'highlight_border'     => '#000000',
			)
		);

		// remove the margin since it is used for the parent block.
		$block_attributes['style']['spacing'] = array(
			'padding' => $block_attributes['style']['spacing']['padding'] ?? '',
		);

		$this->block_html .= '<!-- wp:surecart/product-variant-pill ' . wp_json_encode( $block_attributes ) . '  /-->';
	}

	/**
	 * Render the product variant block.
	 *
	 * @return void
	 */
	public function renderProductVariants() {
		$wrapper_attributes['style']['spacing']['margin'] = $this->attributes['style']['spacing']['margin'] ?? '';

		$this->block_html = '<!-- wp:surecart/product-variant-pills ' . wp_json_encode( $wrapper_attributes ) . ' -->';
		$this->renderVariantPill();
		$this->block_html .= '<!-- /wp:surecart/product-variant-pills -->';
	}

	/**
	 * Render the blocks.
	 *
	 * @return string
	 */
	public function doBlocks() {
		return do_blocks( $this->block_html );
	}

	/**
	 * Render the new variants block.
	 *
	 * @return string
	 */
	public function render() {
		$this->renderProductVariants();
		return $this->doBlocks();
	}
}
