<?php

namespace SureCart\BlockLibrary;

/**
 * Provide product list migration functionality.
 */
class ProductListMigrationService {
	/**
	 * Attributes.
	 *
	 * @var array
	 */
	public array $attributes = array();

	/**
	 * Block.
	 *
	 * @var \WP_Block_Type;
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
		$this->attributes     = $attributes;
		$this->block          = $block;
		$default_inner_blocks = array(
			array(
				'blockName'   => 'surecart/product-item',
				'attrs'       => array(),
				'innerBlocks' => array(
					array(
						'blockName' => 'surecart/product-item-image',
						'attrs'     => array(),
					),
					array(
						'blockName' => 'surecart/product-item-price',
						'attrs'     => array(),
					),
					array(
						'blockName' => 'surecart/product-item-title',
						'attrs'     => array(),
					),
				),
			),
		); // For Shortcodes.
		$this->inner_blocks   = $block->parsed_block['innerBlocks'] ?? $default_inner_blocks;
	}

	/**
	 * Get the Child Blocks Attributes.
	 *
	 * @param string $block_name Block Name.
	 * @return array Child Blocks Attributes.
	 */
	public function getChildBlocksAttributes( $block_name ) {
		if ( empty( $this->inner_blocks ) || empty( $this->inner_blocks[0]['innerBlocks'] ) ) {
			return array();
		}

		foreach ( $this->inner_blocks[0]['innerBlocks'] as $block ) {
			if ( $block['blockName'] === $block_name ) {
				if ( 'surecart/product-item-title' === $block_name ) {
					$block['attrs']['level'] = 0;
				}
				if ( 'surecart/product-item-price' === $block_name && isset( $block['attrs']['range'] ) ) {
					$block['attrs']['show_range'] = $block['attrs']['range'];
				}
				return $block['attrs'];
			}
		}
		return array();
	}

	/**
	 * Render the product list.
	 *
	 * @return void
	 */
	public function renderProductList(): void {
		if ( ! isset( $this->attributes['query'] ) ) {
			$this->attributes['query'] = [];
		}
		$this->attributes['query']['perPage'] = $this->attributes['limit'] ?? 8;

		$this->block_html .= '<!-- wp:surecart/product-list' . ( ! empty( $this->attributes ) ? ' ' . wp_json_encode( $this->attributes ) : '' ) . ' -->';

		$this->renderSortFilterAndSearch();

		$this->renderFilterTags();

		$this->renderProductTemplate();

		$this->renderPagination();

		$this->block_html .= '<!-- /wp:surecart/product-list -->';
	}

	/**
	 * Render the sort, filter and search.
	 *
	 * @return void
	 */
	public function renderSortFilterAndSearch(): void {
		// we don't have any of these items enabled, so we don't need to render anything.
		$sort_enabled       = wp_validate_boolean( $this->attributes['sort_enabled'] ?? true );
		$collection_enabled = wp_validate_boolean( $this->attributes['collection_enabled'] ?? true );
		$search_enabled     = wp_validate_boolean( $this->attributes['search_enabled'] ?? true );
		if ( ! $sort_enabled && ! $collection_enabled && ! $search_enabled ) {
			return;
		}

		$this->block_html .= '<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"10px"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->';
		$this->block_html .= '<div class="wp-block-group" style="margin-bottom:10px">';

		$this->renderSortAndFilter();

		$this->renderSearch();

		$this->block_html .= '</div><!-- /wp:group -->';
	}

	/**
	 * Render the sort and filter.
	 *
	 * @return void
	 */
	public function renderSortAndFilter(): void {
		$sort_enabled       = wp_validate_boolean( $this->attributes['sort_enabled'] ?? true );
		$collection_enabled = wp_validate_boolean( $this->attributes['collection_enabled'] ?? true );

		if ( ! $sort_enabled && ! $collection_enabled ) {
			return;
		}

		$this->block_html .= '<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->';
		$this->block_html .= '<div class="wp-block-group">';

		if ( $sort_enabled ) {
			$this->block_html .= '<!-- wp:surecart/product-list-sort /-->';
		}

		if ( $collection_enabled ) {
			$this->block_html .= '<!-- wp:surecart/product-list-filter /-->';
		}

		$this->block_html .= '</div><!-- /wp:group -->';
	}

	/**
	 * Render the search.
	 *
	 * @return void
	 */
	public function renderSearch(): void {
		$search_enabled = wp_validate_boolean( $this->attributes['search_enabled'] ?? true );

		if ( ! $search_enabled ) {
			return;
		}

		$this->block_html .= '<!-- wp:surecart/product-list-search {"style":{"layout":{"selfStretch":"fixed","flexSize":"250px"}}} /-->';
	}

	/**
	 * Render the filter tags.
	 *
	 * @return void
	 */
	public function renderFilterTags(): void {
		$collection_enabled = wp_validate_boolean( $this->attributes['collection_enabled'] ?? true );

		if ( ! $collection_enabled ) {
			return;
		}

		$this->block_html .= '<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"10px"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->';
		$this->block_html .= '<div class="wp-block-group" style="margin-bottom:10px">';
		$this->block_html .= '<!-- wp:surecart/product-list-filter-tags -->';
		$this->block_html .= '<!-- wp:surecart/product-list-filter-tag /-->';
		$this->block_html .= '</div><!-- /wp:group -->';
		$this->block_html .= '</div><!-- /wp:group -->';
	}

	/**
	 * Render the product title.
	 *
	 * @return void
	 */
	public function renderTitle(): void {
		$product_title_attrs = $this->getChildBlocksAttributes( 'surecart/product-item-title' );
		if ( ! isset( $product_title_attrs['style'] ) ) {
			$product_title_attrs['style'] = array();
		}
		if ( ! isset( $product_title_attrs['style']['spacing'] ) ) {
			$product_title_attrs['style']['spacing'] = array();
		}

		// this is the default.
		if ( isset( $product_title_attrs['style']['spacing']['padding']['top'] ) && $product_title_attrs['style']['spacing']['padding']['top'] === '10px' ) {
			$product_title_attrs['style']['spacing']['margin'] = array_merge(
				$product_title_attrs['style']['spacing']['margin'] ?? array(),
				array(
					'bottom' => $product_title_attrs['style']['spacing']['margin']['bottom'] ?? '0px',
					'top'    => '0px',
				),
			);
		}

		$this->block_html .= '<!-- wp:surecart/product-title ' . wp_json_encode( $product_title_attrs, JSON_FORCE_OBJECT ) . ' /-->';
	}

	/**
	 * Render the product image.
	 *
	 * @return void
	 */
	public function renderImage(): void {
		$attributes          = $this->getChildBlocksAttributes( 'surecart/product-item-image' );
		$product_image_attrs = array(
			'useFeaturedImage'   => true,
			'minHeight'          => 0,
			'dimRatio'           => 0,
			'isUserOverlayColor' => true,
			'focalPoint'         => array(
				'x' => 0.5,
				'y' => 0.5,
			),
			'contentPosition'    => 'top right',
			'isDark'             => false,
			'style'              => array(
				'dimensions' => array( 'aspectRatio' => ! empty( $attributes['ratio'] ) ? $attributes['ratio'] : '3/4' ),
				'layout'     => array(
					'selfStretch' => 'fit',
					'flexSize'    => null,
				),
				'spacing'    => array( 'margin' => array( 'bottom' => '15px' ) ),
				'border'     => array( 'radius' => '10px' ),
			),
		);

		$image  = '<!-- wp:group {"style":{"color":{"background":"#0000000d"},"border":{"radius":"10px"},"spacing":{"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"},"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"constrained"}} -->';
		$image .= '<div class="wp-block-group has-background" style="border-radius:10px;background-color:#0000000d;margin-top:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px">';
		$image .= '<!-- wp:cover ' . wp_json_encode( array_replace_recursive( $product_image_attrs, [] ) ) . ' -->';
		$image .= '<div class="wp-block-cover is-light has-custom-content-position is-position-top-right" style="border-radius:10px;">';
		$image .= '<span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>';
		$image .= '<div class="wp-block-cover__inner-container">';
		$image .= '<!-- wp:surecart/product-sale-badge {"style":{"typography":{"fontSize":"12px"},"border":{"radius":"100px"}}} /-->';
		$image .= '</div>';
		$image .= '</div>';
		$image .= '<!-- /wp:cover -->';
		$image .= '</div>';
		$image .= '<!-- /wp:group -->';

		$this->block_html .= $image;
	}

	/**
	 * Render the product price.
	 *
	 * @return void
	 */
	public function renderPrice(): void {
		$product_price_attrs = wp_json_encode( $this->getChildBlocksAttributes( 'surecart/product-item-price' ), JSON_FORCE_OBJECT );
		$this->block_html   .= '<!-- wp:group {"style":{"spacing":{"blockGap":"0.5em","margin":{"top":"0px","bottom":"0px"}},"margin":{"top":"0px","bottom":"0px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->';
		$this->block_html   .= '<div class="wp-block-group" style="margin-top:0;">';
		$this->block_html   .= '<!-- wp:surecart/product-list-price ' . $product_price_attrs . ' /-->';
		$this->block_html   .= '<!-- wp:surecart/product-scratch-price ' . $product_price_attrs . ' /-->';
		$this->block_html   .= '</div>';
		$this->block_html   .= '<!-- /wp:group -->';
	}

	/**
	 * Render the product template.
	 *
	 * @return void
	 */
	public function renderProductTemplate(): void {
		$product_template_attrs = array_merge(
			array(
				'style'  => array(
					'spacing' => array(
						'blockGap' => '30px',
					),
				),
				'layout' => array(
					'type'        => 'grid',
					'columnCount' => $this->attributes['columns'] ?? 3,
				),
			),
			$this->attributes ?? array(),
		);

		$this->block_html .= '<!-- wp:surecart/product-template ' . wp_json_encode( $product_template_attrs ) . ' -->';
		$group_attrs       = ! empty( $this->inner_blocks[0]['attrs'] ) ? wp_json_encode( $this->inner_blocks[0]['attrs'] ) : '{}';
		$group_block       = parse_blocks( '<!-- wp:group ' . $group_attrs . ' -->' )[0];
		$group_styles      = sc_get_block_styles( true, $group_block );
		$group_classnames  = ! empty( $group_styles['classnames'] ) ? $group_styles['classnames'] : '';
		$group_css         = ! empty( $group_styles['css'] ) ? $group_styles['css'] : '';
		$this->block_html .= '<!-- wp:group {"style":{"spacing":{"blockGap":"5px"}} -->';
		$this->block_html .= '<div class="wp-block-group ' . $group_classnames . '" style="' . $group_css . '">';
		// Render according to the inner blocks order in old block.
		if ( ! empty( $this->inner_blocks[0]['innerBlocks'] ) ) {
			foreach ( $this->inner_blocks[0]['innerBlocks'] as $inner_block ) {
				switch ( $inner_block['blockName'] ) {
					case 'surecart/product-item-image':
						$this->renderImage();
						break;
					case 'surecart/product-item-title':
						$this->renderTitle();
						break;
					case 'surecart/product-item-price':
						$this->renderPrice();
						break;
				}
			}
		}
		$this->block_html .= '</div><!-- /wp:group -->';
		$this->block_html .= '<!-- /wp:surecart/product-template -->';
	}

	/**
	 * Render the pagination.
	 *
	 * @return void
	 */
	public function renderPagination(): void {
		$pagination_enabled = wp_validate_boolean( $this->attributes['pagination_enabled'] ?? true );

		if ( ! $pagination_enabled ) {
			return;
		}

		$attributes = ! empty( $this->attributes['pagination_size'] ) ? [
			'style' => [
				'typography' => [
					'fontSize' => $this->attributes['pagination_size'],
				],
			],
		] : null;

		$this->block_html .= '<!-- wp:surecart/product-pagination ' . ( ! empty( $attributes ) ? wp_json_encode( $attributes ) : '' ) . ' -->';
		$this->block_html .= '<!-- wp:surecart/product-pagination-previous /-->';
		$this->block_html .= '<!-- wp:surecart/product-pagination-numbers /-->';
		$this->block_html .= '<!-- wp:surecart/product-pagination-next /-->';
		$this->block_html .= '<!-- /wp:surecart/product-pagination -->';
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
	 * Render the new product list.
	 *
	 * @return string
	 */
	public function render(): string {
		$this->renderProductList();
		return $this->doBlocks();
	}
}
