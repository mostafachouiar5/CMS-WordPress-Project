<?php

namespace SureCartBlocks\Blocks\ProductCollection;

use SureCartBlocks\Blocks\ProductItemList\Block as ProductItemListBlock;

/**
 * Product Collection block.
 */
class Block extends ProductItemListBlock {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		$term                        = get_queried_object();
		$collection                  = sc_get_collection( $term->term_id );
		$attributes['collection_id'] = $collection->id;

		return \SureCart::block()->productListMigration( $attributes, $this->block )->render();

		self::$instance = wp_unique_id( 'sc-product-item-list-' );

		// check for inner blocks.
		$product_inner_blocks = $this->block->parsed_block['innerBlocks'] ?? [];

		$product_item_inner_blocks = $product_inner_blocks[0]['innerBlocks'] ?? $this->default_block_template;
		$product_item_attributes   = $product_inner_blocks[0]['attrs'] ?? $attributes;

		$layout_config = array_map(
			function ( $inner_block ) {
				return (object) [
					'blockName'  => $inner_block['blockName'],
					'attributes' => $inner_block['attrs'],
				];
			},
			$product_item_inner_blocks
		);

		$style  = '';
		$style .= $this->getStyle( $attributes, $product_item_attributes );

		foreach ( $product_item_inner_blocks as $inner_blocks ) {
			switch ( $inner_blocks['blockName'] ) {
				case 'surecart/product-item-image':
					$style .= $this->getVars( $inner_blocks['attrs'], 'image' );
					break;
				case 'surecart/product-item-title':
					$style .= $this->getVars( $inner_blocks['attrs'], 'title' );
					break;
				case 'surecart/product-item-price':
					$style .= $this->getVars( $inner_blocks['attrs'], 'price' );
					break;
				default:
					break;
			}
		}

		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'id'    => self::$instance,
				'style' => $style,
			)
		);

		// query posts.
		$product_query = new \WP_Query(
			array(
				'post_type'      => 'sc_product',
				'posts_per_page' => 10,
			)
		);

		// get the product for each post.
		$products = array_map(
			function ( $post ) {
				return sc_get_product( $post );
			},
			$product_query->posts ?? []
		);

		\SureCart::assets()->addComponentData(
			'sc-product-item-list',
			'#' . self::$instance,
			[
				'layoutConfig'         => $layout_config,
				'paginationAlignment'  => $attributes['pagination_alignment'],
				'limit'                => (int) $attributes['limit'],
				'pagination'           => [
					'total'       => $product_query->found_posts,
					'total_pages' => $product_query->max_num_pages,
				],
				'page'                 => (int) ( $_GET['product-page'] ?? 1 ),
				'paginationEnabled'    => wp_validate_boolean( $attributes['pagination_enabled'] ),
				'ajaxPagination'       => wp_validate_boolean( $attributes['ajax_pagination'] ),
				'paginationAutoScroll' => wp_validate_boolean( $attributes['pagination_auto_scroll'] ),
				'searchEnabled'        => wp_validate_boolean( $attributes['search_enabled'] ),
				'sortEnabled'          => wp_validate_boolean( $attributes['sort_enabled'] ),
				'products'             => ! \SureCart::account()->isConnected() ? $this->getDummyProducts( $attributes['limit'] ) : $products->data,
				'collectionEnabled'    => false,
				'collectionId'         => $this->getCollectionId( $attributes ),
				'pageTitle'            => get_the_title(),
			]
		);

		return '<sc-product-item-list ' . $wrapper_attributes . '></sc-product-item-list>';
	}

	/**
	 * Get query for the block.
	 *
	 * @param array $attributes Block attributes.
	 */
	public function getQuery( $attributes ) {
		$query                           = parent::getQuery( $attributes );
		$query['product_collection_ids'] = [ $this->getCollectionId( $attributes ) ];
		return $query;
	}

	/**
	 * Get collection id for the block.
	 *
	 * @param array $attributes Block attributes.
	 */
	public function getCollectionId( $attributes ) {
		$query_collection_id = get_query_var( 'sc_collection_page_id' );
		return $query_collection_id ? $query_collection_id : $attributes['collection_id'] ?? '';
	}
}
