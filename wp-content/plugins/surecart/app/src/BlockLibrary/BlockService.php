<?php

namespace SureCart\BlockLibrary;

use SureCartCore\Application\Application;

/**
 * Provide general block-related functionality.
 */
class BlockService {
	/**
	 * View engine.
	 *
	 * @var Application
	 */
	protected $app = null;

	/**
	 * Constructor.
	 *
	 * @param Application $app Application Instance.
	 */
	public function __construct( Application $app ) {
		$this->app = $app;
	}

	/**
	 * Render a block using a template
	 *
	 * @param  string|string[]      $views A view or array of views.
	 * @param  array<string, mixed> $context Context to send.
	 * @return string View html output.
	 */
	public function render( $views, $context = array() ) {
		return apply_filters( 'surecart_block_output', $this->app->views()->make( $views )->with( $context )->toString() );
	}

	/**
	 * Find all blocks and nested blocks by name.
	 *
	 * @param  string $type Block item to filter by.
	 * @param  string $name Block name.
	 * @param   array  $blocks Array of blocks.
	 * @return array
	 */
	public function filterBy( $type, $name, $blocks ) {
		$found_blocks = array();
		$blocks       = (array) $blocks;
		foreach ( $blocks as $block ) {
			if ( $name === $block[ $type ] ) {
				$found_blocks[] = $block;
			}
			if ( ! empty( $block['innerBlocks'] ) ) {
				$found_blocks = array_merge( $found_blocks, $this->filterBy( $type, $name, $block['innerBlocks'] ) );
			}
		}
		return $found_blocks;
	}

	/**
	 * Get the block styles service.
	 *
	 * @return BlockStylesService
	 */
	public function styles() {
		return new BlockStylesService();
	}

	/**
	 * Get url params service.
	 *
	 * @param string $type Block type.
	 * @param string $instance_id Unique instance ID.
	 *
	 * @return URLParamService
	 */
	public function urlParams( $type = '' ) {
		return new URLParamService( $type );
	}

	/**
	 * Get product list migration service.
	 *
	 * @param array $attributes Attributes.
	 *
	 * @return ProductListMigrationService
	 */
	public function productListMigration( $attributes = array(), $block = null ) {
		return new ProductListMigrationService( $attributes, $block );
	}

	/**
	 * Get cart migration service.
	 *
	 * @param array $attributes Attributes.
	 *
	 * @return CartMigrationService
	 */
	public function cartMigration( $attributes = [], $block = null ) {
		return new CartMigrationService( $attributes, $block );
	}

	/**
	 * Get cart menu icon migration service.
	 *
	 * @param array $attributes Attributes.
	 *
	 * @return CartMenuIconMigrationService
	 */
	public function cartMenuIconMigration( $attributes = [], $block = null ) {
		return new CartMenuIconMigrationService( $attributes, $block );
	}

	/**
	 * Get the product list service.
	 *
	 * @return ProductListService
	 */
	public function productList( $block ) {
		return new ProductListService( $block );
	}

	/**
	 * Get the product price migration service.
	 *
	 * @param array  $attributes Attributes.
	 * @param object $block Block.
	 *
	 * @return ProductSelectedPriceMigrationService
	 */
	public function productSelectedPriceMigration( $attributes = array(), $block = null ) {
		return new ProductSelectedPriceMigrationService( $attributes, $block );
	}

	/**
	 * Get the product collection badges migration service.
	 *
	 * @param array  $attributes Attributes.
	 * @param object $block Block.
	 *
	 * @return ProductCollectionBadgesMigrationService
	 */
	public function productCollectionBadgesMigration( $attributes = array(), $block = null ) {
		return new ProductCollectionBadgesMigrationService( $attributes, $block );
	}

	/**
	 * Get the product price choices migration service.
	 *
	 * @param array  $attributes Attributes.
	 * @param object $block Block.
	 *
	 * @return ProductPriceChoicesMigrationService
	 */
	public function productPriceChoicesMigration( $attributes = array(), $block = null ) {
		return new ProductPriceChoicesMigrationService( $attributes, $block );
	}

	/**
	 * Get the product variant migration service.
	 *
	 * @param array  $attributes Attributes.
	 * @param object $block Block.
	 *
	 * @return ProductVariantsMigrationService
	 */
	public function productVariantsMigration( $attributes = array(), $block = null ) {
		return new ProductVariantsMigrationService( $attributes, $block );
	}

	/**
	 * Get the product page blocks migration service.
	 *
	 * @param object $block Block.
	 * @param string $old_block_name Old block name.
	 *
	 * @return ProductPageBlocksMigrationService
	 */
	public function productPageBlocksMigration( $block, $old_block_name ) {
		return new ProductPageBlocksMigrationService( $block, $old_block_name );
	}

	/**
	 * Block anchor support service.
	 *
	 * @return BlockAnchorSupportService
	 */
	public function anchorSupport() {
		return $this->app->resolve( 'block.support.anchor' );
	}
}
