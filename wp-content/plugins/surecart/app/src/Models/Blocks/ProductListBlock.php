<?php

namespace SureCart\Models\Blocks;

/**
 * The product list block.
 */
class ProductListBlock {
	/**
	 * The block.
	 *
	 * @var \WP_Block
	 */
	protected $block;

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
	public function __construct( \WP_Block $block = null ) {
		$this->block = $block ? $block : \WP_Block_Supports::$block_to_render;
		$this->url   = \SureCart::block()->urlParams( 'products' );
	}

	/**
	 * Get the URL.
	 *
	 * @return object|null
	 */
	public function urlParams() {
		return $this->url;
	}

	/**
	 * Get the query context.
	 *
	 * @return array
	 */
	public function getQueryContext() {
		return $this->block->context['query'] ?? [];
	}

	/**
	 * Build the query
	 *
	 * @return $this
	 */
	public function parse_query() {
		$query = $this->getQueryContext();

		$offset   = absint( $query['offset'] ?? 0 );
		$per_page = $this->block->parsed_block['attrs']['query']['perPage'] ?? $this->block->parsed_block['attrs']['limit'] ?? $query['perPage'] ?? 15;
		$order    = ! empty( $this->url->getArg( 'order' ) )
			? sanitize_text_field( $this->url->getArg( 'order' ) )
			: ( ! empty( $query['order'] ) ? $query['order'] : 'desc' );
		$orderby  = ! empty( $this->url->getArg( 'orderby' ) )
			? sanitize_text_field( $this->url->getArg( 'orderby' ) )
			: ( ! empty( $query['orderBy'] ) ? $query['orderBy'] : 'date' );
		$page     = $this->url->getCurrentPage();

		// build up the query.
		$this->query_vars = array_filter(
			array(
				'post_type'           => 'sc_product',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => $per_page,
				'offset'              => ( $per_page * ( $page - 1 ) ) + $offset,
				'paged'               => (int) $this->url->getCurrentPage(),
				'order'               => $order,
				'orderby'             => $orderby,
				's'                   => sanitize_text_field( $this->url->getArg( 'search' ) ),
			)
		);

		// handle search.
		if ( ! empty( $query['search'] ) && empty( $this->query_vars['s'] ) ) {
			$this->query_vars['s'] = sanitize_text_field( $query['search'] );
		}

		// put together price query.
		if ( 'price' === $this->url->getArg( 'orderby' ) ) {
			$this->query_vars['meta_key'] = 'min_price_amount';
			$this->query_vars['orderby']  = 'meta_value_num';
		}

		$tax_query = array(
			'relation' => 'OR',
		);

		// handle tax query.
		if ( ! empty( $query['taxQuery'] ) ) {
			foreach ( $query['taxQuery'] as $taxonomy => $terms ) {
				if ( is_taxonomy_viewable( $taxonomy ) && ! empty( $terms ) ) {
					$tax_query[] = array(
						'taxonomy'         => sanitize_key( $taxonomy ),
						'terms'            => array_filter( array_map( 'absint', $terms ) ),
						'include_children' => false,
					);
				}
			}
		}

		// put together price query.
		if ( 'price' === $orderby ) {
			$this->query_vars['meta_key'] = 'min_price_amount';
			$this->query_vars['orderby']  = 'meta_value_num';
		}

		$collection_id = sanitize_text_field( $this->block->context['surecart/product-list/collection_id'] ?? $this->block->parsed_block['attrs']['collection_id'] ?? '' );

		// handle collection id send from "sc_product_collection" shortcode.
		if ( ! empty( $collection_id ) ) {
			$collection_ids = array_unique( array_map( 'sanitize_text_field', explode( ',', $collection_id ) ) );

			$legacy_collection_ids = get_terms(
				array(
					'taxonomy'   => 'sc_collection',
					'field'      => 'term_id',
					'meta_query' => array(
						array(
							'key'     => 'sc_id',
							'value'   => $collection_ids,
							'compare' => 'IN',
						),
					),
				)
			); // platform collection ids converted to WP taxonomy ids.

			// only get the term_id.
			$legacy_collection_ids = array_map(
				function ( $term ) {
					return $term->term_id;
				},
				$legacy_collection_ids
			);

			$tax_query[] =
				array(
					'taxonomy' => 'sc_collection',
					'field'    => 'term_id',
					'terms'    => array_unique( array_map( 'absint', $legacy_collection_ids ?? array() ) ),
				);
		} elseif ( is_tax() ) {
				$term        = get_queried_object();
				$tax_query[] =
				array(
					'taxonomy' => 'sc_collection',
					'field'    => 'term_id',
					'terms'    => array_unique( array_map( 'absint', [ (int) $term->term_id ] ) ),
				);
		}

		$all_taxonomies = $this->url->getAllTaxonomyArgs();

		// handle taxonomies query.
		foreach ( $all_taxonomies as $taxonomy => $terms ) {
			$tax_query[] =
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => array_unique( array_map( 'strval', $terms ?? array() ) ),
					'operator' => 'IN',
				);
		}

		$this->query_vars['tax_query'][] = $tax_query;

		// handle featured.
		if ( 'featured' === ( $this->block->context['surecart/product-list/type'] ?? 'all' ) ) {
			$this->query_vars['meta_query'] = [
				[
					'key'     => 'featured',
					'value'   => '1',
					'compare' => '=',
				],
			];
		}

		if ( 'custom' === ( $this->block->context['surecart/product-list/type'] ?? $this->block->parsed_block['attrs']['type'] ?? 'all' ) ) {
			$query = $this->getQueryContext();
			// backward compatibility.

			$ids = ! empty( $query['include'] ) ? $query['include'] : ( ! empty( $this->block->context['surecart/product-list/ids'] ) ? $this->block->context['surecart/product-list/ids'] : ( ! empty( $this->block->parsed_block['attrs']['ids'] ) ? $this->block->parsed_block['attrs']['ids'] : [] ) );

			// fallback for older strings - get the ids of legacy products.
			$legacy_ids           = [];
			$ids_that_are_strings = array_map( 'sanitize_text_field', array_filter( $ids, 'is_string' ) );
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

			// get only ids that are integers.
			$ids_that_are_integers = array_filter( $ids, 'is_int' );

			// post in.
			$this->query_vars['post__in'] = array_merge( $legacy_ids, $ids_that_are_integers );

			// order by posts if there is not an order by.
			if ( empty( $this->query_vars['orderby'] ) ) {
				$this->query_vars['orderby'] = 'post__in';
			}
		}

		return $this;
	}

	/**
	 * Offset the found posts.
	 * See: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
	 *
	 * @param int $found_posts The found posts.
	 *
	 * @return int The found posts with offset.
	 */
	public function offsetFoundPosts( $found_posts ) {
		$query  = $this->getQueryContext();
		$offset = absint( $query['offset'] ?? 0 );

		return $found_posts - $offset;
	}

	/**
	 * Run the query
	 *
	 * @return $this|\WP_Error
	 */
	public function query() {
		$this->parse_query();
		wp_reset_postdata();

		add_filter( 'found_posts', [ $this, 'offsetFoundPosts' ], 1 );
		$this->query = new \WP_Query( $this->query_vars );
		remove_filter( 'found_posts', [ $this, 'offsetFoundPosts' ], 1 );

		return $this;
	}

	/**
	 * Get the query attribute.
	 *
	 * @param string $key The key.
	 * @return \WP_Query
	 */
	public function __get( $key ) {
		// handle pagination.
		if ( 'next_page_link' === $key ) {
			return $this->max_num_pages && $this->max_num_pages !== $this->paged ? $this->url->addPageArg( $this->paged + 1 )->url() : '';
		}

		if ( 'previous_page_link' === $key ) {
			return $this->paged > 1 ? $this->url->addPageArg( $this->paged - 1 )->url() : '';
		}

		if ( 'pagination_links' === $key ) {
			return array_map(
				function ( $i ) {
					return array(
						'href'    => $this->url->addPageArg( $i )->url(),
						'name'    => $i,
						'current' => (int) $i === (int) $this->paged,
					);
				},
				range( 1, $this->max_num_pages )
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

		return $this->query->$key ?? $this->query->query[ $key ] ?? $this->query->query_vars[ $key ] ?? null;
	}

	/**
	 * Call the query method.
	 *
	 * @param string $method The method.
	 * @param array  $args   The arguments.
	 *
	 * @return mixed
	 */
	public function __call( $method, $args ) {
		return $this->query->$method( ...$args );
	}
}
