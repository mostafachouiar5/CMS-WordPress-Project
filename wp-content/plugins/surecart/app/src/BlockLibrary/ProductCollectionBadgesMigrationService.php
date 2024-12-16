<?php

namespace SureCart\BlockLibrary;

/**
 * Provide the migration service for the product collection badges block.
 */
class ProductCollectionBadgesMigrationService {
	/**
	 * Attributes
	 *
	 * @var array
	 */
	public array $attributes = array();

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
	 * Render the collection badges.
	 *
	 * @return void
	 */
	public function renderProductCollectionBadges() {
		$layout_attributes = array(
			'count' => $this->attributes['count'] ?? 1,
			'style' => array(
				'spacing' => array(
					'blockGap' => $this->attributes['style']['spacing']['blockGap'] ?? '3px',
				),
			),
		);

		$this->block_html  = '<!-- wp:surecart/product-collection-tags ' . wp_json_encode( $layout_attributes ) . ' -->';
		$this->block_html .= '<!-- wp:surecart/product-collection-tag ' . wp_json_encode( $this->attributes ) . ' /-->';
		$this->block_html .= '<!-- /wp:surecart/product-collection-tags -->';
	}

	/**
	 * Render blocks.
	 *
	 * @return string
	 */
	public function doBlocks() {
		return do_blocks( $this->block_html );
	}

	/**
	 * Render the new product collection badges.
	 *
	 * @return string
	 */
	public function render() {
		$this->renderProductCollectionBadges();
		return $this->doBlocks();
	}
}
