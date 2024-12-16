<?php

namespace AtlasSearch\Support\WooCommerce;

const    WOO_ORDER_BY_MAPPING = array(
	'price'      => 'price',
	'popularity' => 'total_sales',
	'rating'     => 'average_rating',
);

function get_order_by( $order_by, $query_vars ) {
	if ( 'product' !== $query_vars['post_type'] ) {
		return $order_by;
	}

	if ( empty( $query_vars['orderby'] ) ) {
		return $order_by;
	}

	if ( in_array( $query_vars['orderby'], array( 'price-desc', 'price-asc' ) ) ) {
		$price_order_by = explode( '-', $query_vars['orderby'] );

		return array(
			'field'     => $price_order_by[0],
			'direction' => $price_order_by[1],
		);
	}

	if ( ! array_key_exists( $query_vars['orderby'], WOO_ORDER_BY_MAPPING ) ) {
		return $order_by;
	}

	return array(
		'field'     => WOO_ORDER_BY_MAPPING[ $query_vars['orderby'] ],
		'direction' => get_direction( $query_vars ),
	);
}

function get_direction( $query_vars ) {
	if ( ! isset( $query_vars['order'] ) && isset( $query_vars['orderby'] ) && 'price' == $query_vars['orderby'] ) {
		return 'asc';
	}

	return $query['order'] ?? 'desc';
}

function price_filter( $query ) {
	// Ensure we only modify the main query, and avoid unintended modification of admin queries.
	if ( $query->is_main_query() && ! is_admin() ) {
		if ( ! isset( $query->query_vars['min_price'] ) && ! isset( $query->query_vars['max_price'] ) ) {
			return;
		}
		$meta_query_args = array();
		if ( isset( $query->query_vars['min_price'] ) && isset( $query->query_vars['max_price'] ) ) {
				$meta_query_args = array(
					array(
						'key'     => 'price',
						'value'   => array( $query->query_vars['min_price'], $query->query_vars['max_price'] ),
						'type'    => 'NUMERIC',
						'compare' => 'BETWEEN',
					),
				);
		} elseif ( isset( $query->query_vars['min_price'] ) ) {
				$meta_query_args = array(
					array(
						'key'     => 'price',
						'value'   => $query->query_vars['min_price'],
						'compare' => '>=',
						'type'    => 'NUMERIC',
					),
				);
		} elseif ( isset( $query->query_vars['max_price'] ) ) {
				$meta_query_args = array(
					array(
						'key'     => 'price',
						'value'   => $query->query_vars['max_price'],
						'compare' => '<=',
						'type'    => 'NUMERIC',
					),
				);
		};

		// Add the meta query to the existing query.
		$query->set( 'meta_query', $meta_query_args );
	}
}

function enable_search( $query ) {
	if ( ! $query->is_search && $query->is_main_query() && ! is_admin() ) {
		$query->is_search  = true;
		$query->query['s'] = '*';
	}
}
