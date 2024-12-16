<?php

namespace SureCartBlocks\Blocks\ProductItemList;

use SureCart\Models\Collection;
use SureCart\Models\Product;
use SureCartBlocks\Blocks\BaseBlock;
/**
 * ProductItemList block
 */
class Block extends BaseBlock {
	/**
	 * Keeps track of instances of this block.
	 *
	 * @var integer
	 */
	public static $instance;

	/**
	 * Default block template.
	 *
	 * @var array
	 */
	protected $default_block_template = [
		[
			'blockName' => 'surecart/product-item-image',
			'attrs'     => [
				'sizing' => 'cover',
				'ratio'  => '1/1.33',
				'style'  => [
					'border'  => [
						'radius' => '6px',
					],
					'spacing' => [
						'margin' => [
							'bottom' => '16px',
						],
					],
				],
			],
		],
		[
			'blockName' => 'surecart/product-item-title',
			'attrs'     => [
				'level' => 3,
				'style' => [
					'typography' => [
						'fontSize' => '18px',
					],
					'color'      => [
						'text' => '#000000',
					],
					'spacing'    => [
						'margin' => [
							'bottom' => '8px',
						],
					],
				],
			],
		],
		[
			'blockName' => 'surecart/product-item-price',
			'attrs'     => [
				'style' => [
					'typography' => [
						'fontSize' => '16px',
					],
					'color'      => [
						'text' => '#000000',
					],
					'spacing'    => [
						'margin' => [
							'bottom' => '8px',
						],
					],
				],
			],
		],
	];

	/**
	 * Get the style for the block.
	 *
	 * @param  array $attr Product List attributes.
	 * @return string
	 */
	public function getProductListStyle( $attr ) {
		$style  = '--sc-product-item-list-column: ' . ( $attr['columns'] ?? 3 ) . ';';
		$style .= '--sc-product-item-list-gap: ' . $this->getSpacingPresetCssVar( $attr['style']['spacing']['blockGap'] ?? '40px' ) . ';';
		$style .= '--sc-pagination-font-size: ' . ( $attr['paginationSize'] ?? '14px' ) . ';';
		return $style;
	}

	/**
	 * Get the style for the block
	 *
	 * @param  array  $attr Style variables.
	 * @param  string $prefix Prefix for the css variable.
	 * @return string
	 */
	public function getVars( $attr, $prefix ) {
		$style = '';
		// padding.
		if ( ! empty( $attr['style']['spacing']['padding'] ) ) {
			$padding = $attr['style']['spacing']['padding'];
			$style  .= '--sc-product-' . $prefix . '-padding-top: ' . $this->getSpacingPresetCssVar( array_key_exists( 'top', $padding ) ? $padding['top'] : '0' ) . ';';
			$style  .= '--sc-product-' . $prefix . '-padding-bottom: ' . $this->getSpacingPresetCssVar( array_key_exists( 'bottom', $padding ) ? $padding['bottom'] : '0' ) . ';';
			$style  .= '--sc-product-' . $prefix . '-padding-left: ' . $this->getSpacingPresetCssVar( array_key_exists( 'left', $padding ) ? $padding['left'] : '0' ) . ';';
			$style  .= '--sc-product-' . $prefix . '-padding-right: ' . $this->getSpacingPresetCssVar( array_key_exists( 'right', $padding ) ? $padding['right'] : '0' ) . ';';
		}
		// margin.
		if ( ! empty( $attr['style']['spacing']['margin'] ) ) {
			$margin = $attr['style']['spacing']['margin'];
			$style .= '--sc-product-' . $prefix . '-margin-top: ' . $this->getSpacingPresetCssVar( array_key_exists( 'top', $margin ) ? $margin['top'] : '0' ) . ';';
			$style .= '--sc-product-' . $prefix . '-margin-bottom: ' . $this->getSpacingPresetCssVar( array_key_exists( 'bottom', $margin ) ? $margin['bottom'] : '0' ) . ';';
			$style .= '--sc-product-' . $prefix . '-margin-left: ' . $this->getSpacingPresetCssVar( array_key_exists( 'left', $margin ) ? $margin['left'] : '0' ) . ';';
			$style .= '--sc-product-' . $prefix . '-margin-right: ' . $this->getSpacingPresetCssVar( array_key_exists( 'right', $margin ) ? $margin['right'] : '0' ) . ';';
		}
		// aspect ratio.
		if ( ! empty( $attr['ratio'] ) ) {
			$style .= '--sc-product-' . $prefix . '-aspect-ratio: ' . $attr['ratio'] . ';';
		}
		// border width.
		if ( ! empty( $attr['style']['border']['width'] ) ) {
			$style .= '--sc-product-' . $prefix . '-border-width: ' . $attr['style']['border']['width'] . ';';
		}
		// border radius.
		if ( ! empty( $attr['style']['border']['radius'] ) ) {
			$style .= '--sc-product-' . $prefix . '-border-radius: ' . $attr['style']['border']['radius'] . ';';
		}
		// font weight.
		if ( ! empty( $attr['style']['typography']['fontWeight'] ) ) {
			$style .= '--sc-product-' . $prefix . '-font-weight: ' . $attr['style']['typography']['fontWeight'] . ';';
		}
		// font size.
		if ( ! empty( $attr['fontSize'] ) || ! empty( $attr['style']['typography']['fontSize'] ) ) {
			$font_size = ! empty( $attr['fontSize'] ) ? $this->getFontSizePresetCssVar( $attr['fontSize'] ) : $attr['style']['typography']['fontSize'];
			$style    .= '--sc-product-' . $prefix . '-font-size: ' . $font_size . ';';
		}
		// border color.
		if ( ! empty( $attr['borderColor'] ) || ! empty( $attr['style']['border']['color'] ) ) {
			$border_color = ! empty( $attr['borderColor'] ) ? $this->getColorPresetCssVar( $attr['borderColor'] ) : $attr['style']['border']['color'];
			$style       .= '--sc-product-' . $prefix . '-border-color: ' . $border_color . ';';
		}
		// text color.
		if ( ! empty( $attr['textColor'] ) || ! empty( $attr['style']['color']['text'] ) ) {
			$text_color = ! empty( $attr['textColor'] ) ? $this->getColorPresetCssVar( $attr['textColor'] ) : $attr['style']['color']['text'];
			$style     .= '--sc-product-' . $prefix . '-text-color: ' . $text_color . ';';
		}
		if ( ! empty( $attr['backgroundColor'] ) || ! empty( $attr['style']['color']['background'] ) ) {
			$background_color = ! empty( $attr['backgroundColor'] ) ? $this->getColorPresetCssVar( $attr['backgroundColor'] ) : $attr['style']['color']['background'];
			$style           .= '--sc-product-' . $prefix . '-background-color: ' . $background_color . ';';
		}
		// text align.
		if ( ! empty( $attr['align'] ) ) {
			$style .= '--sc-product-' . $prefix . '-align: ' . $attr['align'] . ';';
		}

		return $style;
	}

	/**
	 * Get the style for the block
	 *
	 * @param  array $attr Product List attributes.
	 * @param  array $item_attributes Product item attributes.
	 * @return string
	 */
	public function getStyle( $attr, $item_attributes ) {
		$style  = 'border-style: none !important;';
		$style .= $this->getProductListStyle( $attr );
		$style .= $this->getVars( $item_attributes, 'item' );
		return $style;
	}

	/**
	 * Get the dummy products array.
	 *
	 * @param  int $limit Limit per page.
	 * @return array Dummy Products.
	 */
	public function getDummyProducts( $limit = 15 ) {
		$dummy_products = array();

		for ( $i = 1; $i <= $limit; $i++ ) {
			$product = array(
				'permalink'  => '#',
				'name'       => __( 'Example Product Title', 'surecart' ),
				'created_at' => wp_rand( 1, 40 ),
				'prices'     => array(
					'data' => array(
						array(
							'amount'   => 1900,
							'currency' => 'USD',
						),
					),
				),
			);

			$dummy_products[] = $product;
		}

		return $dummy_products;
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
		if ( isset( $attributes['sort_enabled'] ) ) { // This way we know it's the old block.
			return \SureCart::block()->productListMigration( $attributes, $this->block )->render();
		}

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

		// backwards compat.
		if ( empty( $attributes['type'] ) && ! empty( $attributes['ids'] ) ) {
			$attributes['type'] = 'custom';
		}
		if ( empty( $attributes['type'] ) ) {
			$attributes['type'] = '';
		}

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
				'limit'                => $attributes['limit'],
				'style'                => $style,
				'pagination'           => [
					'total'       => $product_query->found_posts,
					'total_pages' => $product_query->max_num_pages,
				],
				'page'                 => (int) ( $_GET['product-page'] ?? 1 ),
				'ids'                  => 'custom' === $attributes['type'] ? array_values( array_filter( $attributes['ids'] ) ) : [],
				'paginationEnabled'    => \SureCart::account()->isConnected() ? wp_validate_boolean( $attributes['pagination_enabled'] ) : false,
				'ajaxPagination'       => wp_validate_boolean( $attributes['ajax_pagination'] ),
				'paginationAutoScroll' => $attributes['pagination_auto_scroll'],
				'searchEnabled'        => \SureCart::account()->isConnected() ? wp_validate_boolean( $attributes['search_enabled'] ) : false,
				'sortEnabled'          => \SureCart::account()->isConnected() ? wp_validate_boolean( $attributes['sort_enabled'] ) : false,
				'featured'             => 'featured' === $attributes['type'],
				'products'             => ! \SureCart::account()->isConnected() ? $this->getDummyProducts( $attributes['limit'] ) : $products,
				'collectionEnabled'    => \SureCart::account()->isConnected() ? wp_validate_boolean( $attributes['collection_enabled'] ) : false,
				'pageTitle'            => get_the_title(),
			]
		);

		return '<sc-product-item-list id="' . esc_attr( self::$instance ) . '"></sc-product-item-list>';
	}

	/**
	 * Get the query for the products.
	 *
	 * @param  array $attributes Block attributes.
	 *
	 * @return array
	 */
	public function getQuery( $attributes ) {
		$query = [
			'expand'   => [ 'prices', 'featured_product_media', 'product_medias', 'product_media.media', 'variants' ],
			'archived' => false,
			'status'   => [ 'published' ],
			'sort'     => 'cataloged_at:desc',
		];

		if ( 'featured' === ( $attributes['type'] ?? '' ) ) {
			$query['featured'] = true;
		}

		if ( 'custom' === ( $attributes['type'] ?? '' ) ) {
			$query['ids'] = array_values( array_filter( $attributes['ids'] ?? [] ) );
		}

		return $query;
	}
}
