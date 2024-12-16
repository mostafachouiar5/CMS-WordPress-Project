<?php

declare(strict_types=1);

namespace SureCart\BlockLibrary;

/**
 * The product list service.
 */
class ProductListService {
	/**
	 * The block.
	 *
	 * @var \WP_Block
	 */
	protected $block;

	/**
	 * The block id.
	 *
	 * @var int
	 */
	protected $block_id = null;

	/**
	 * The URL.
	 *
	 * @var object
	 */
	protected $url;

	/**
	 * The query vars.
	 *
	 * @var array
	 */
	protected $query_vars = [];

	/**
	 * The query.
	 *
	 * @var \WP_Query
	 */
	protected $query;

	/**
	 * Constructor.
	 *
	 * @param \WP_Block $block The block.
	 */
	public function __construct( $block ) {
		$this->block    = $block;
		$this->block_id = $block->context['surecart/product-list/blockId'] ?? '';
		$this->url      = \SureCart::block()->urlParams( 'products' );
	}

	/**
	 * Build the query
	 *
	 * @return $this
	 */
	public function parse_query() {
		// build up the query.
		$this->query_vars = [
			'post_type'           => 'sc_product',
			'status'              => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $this->block->attributes['limit'] ?? 15,
			'paged'               => $this->url->getCurrentPage(),
			'order'               => $this->url->getArg( 'order' ) ?? 'desc',
			'orderby'             => $this->url->getArg( 'orderby' ) ?? 'date',
			's'                   => $this->url->getArg( 'search' ),
		];

		// put together price query.
		if ( 'price' === $this->url->getArg( 'orderby' ) ) {
			$this->query_vars['meta_key'] = 'max_price_amount';
			$this->query_vars['orderby']  = 'meta_value_num';
		}

		// handle collections query.
		if ( ! empty( $this->url->getArg( 'sc_collection' ) ) ) {
			$this->query_vars['tax_query'] = [
				[
					'taxonomy' => 'sc_collection',
					'field'    => 'term_id',
					'terms'    => $this->url->getArg( 'sc_collection' ),
				],
			];
		}

		// handle featured.
		if ( 'featured' === ( $this->block->attributes['type'] ?? 'all' ) ) {
			$this->query_vars['meta_query'] = [
				[
					'key'     => 'featured',
					'value'   => '1',
					'compare' => '=',
				],
			];
		}

		if ( 'custom' === ( $this->block->attributes['type'] ?? 'all' ) ) {
			// fallback for older strings - get the ids of legacy products.
			$legacy_ids           = [];
			$ids_that_are_strings = array_filter( $attributes['ids'] ?? [], 'is_string' );
			if ( ! empty( $ids_that_are_strings ) ) {
				$legacy_ids = get_posts(
					[
						'post_type'      => 'sc_product',
						'status'         => 'publish',
						'fields'         => 'ids',
						'posts_per_page' => -1,
						'meta_query'     => [
							[
								'key'     => 'sc_id',
								'value'   => $ids_that_are_strings,
								'compare' => 'IN',
							],
						],
					]
				);
			}

			$ids_that_are_integers        = array_filter( $attributes['ids'] ?? [], 'is_int' );
			$this->query_vars['post__in'] = array_merge( $legacy_ids, $ids_that_are_integers );
		}

		return $this;
	}

	/**
	 * Run the query
	 *
	 * @return $this|\WP_Error
	 */
	public function query() {
		$this->parse_query();
		$this->query = new \WP_Query( $this->query_vars );
		if ( is_wp_error( $this->query ) ) {
			return $this->query;
		}
		return $this;
	}

	/**
	 * Get the query attribute.
	 *
	 * @return \WP_Query
	 */
	public function __get( $key ) {
		// handle pagination.
		if ( 'next_page_link' === $key ) {
			return $this->query->max_num_pages && $this->query->max_num_pages !== $this->query->paged ? $this->url->addPageArg( $this->query->paged + 1 )->url() : '';
		}

		if ( 'previous_page_link' === $key ) {
			return $this->query->paged > 1 ? $this->url->addPageArg( $this->query->paged - 1 )->url() : '';
		}

		if ( 'pagination_links' === $key ) {
			return array_map(
				function ( $i ) {
					return [
						'href'    => $this->url->addPageArg( $i )->url(),
						'name'    => $i,
						'current' => (int) $i === (int) $this->query->paged,
					];
				},
				range( 1, $this->query->max_num_pages )
			);
		}

		if ( 'products' === $key ) {
			return array_map(
				function ( $post ) {
					return sc_get_product( $post );
				},
				$this->query->posts
			);
		}

		return $this->query->$key;
	}
}
