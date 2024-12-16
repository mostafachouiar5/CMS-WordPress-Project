<?php

namespace AtlasSearch\Query\Meta;

/**
 * This function returns a string filter that represents the meta_query.
 *
 * $meta_query_args = array(
 *   'relation' => 'OR', // Optional, defaults to "AND"
 *   array(
 *       'key'     => '_my_custom_key',
 *       'value'   => 'Value I am looking for',
 *       'compare' => '='
 *   ),
 *   array(
 *       'relation' => 'AND',
 *       array(
 *           'key'     => '_my_custom_key_2',
 *           'value'   => 'Value I am looking for 2',
 *           'compare' => '='
 *       ),
 *       array(
 *           'key'     => '_my_custom_key_3',
 *           'value'   => 'Value I am looking for 3',
 *           'compare' => '='
 *       )
 *   )
 * );
 * $meta_query = new WP_Meta_Query( $meta_query_args );
 *
 * The above meta_query should return the following string:
 * _my_custom_key:"Value I am looking for" OR (_my_custom_key_2:"Value I am looking for 2" AND _my_custom_key_3:"Value I am looking for 3")
 *
 * @param \WP_Query $wp_query WP Query.
 *
 * @return string|null
 */
function get_meta_query_filter( \WP_Query $wp_query = null ) {
	if ( ! isset( $wp_query ) ) {
		return null;
	}

	if ( ! isset( $wp_query->meta_query ) ) {
		return null;
	}

	if ( empty( $wp_query->meta_query->queries ) ) {
		return null;
	}

	return meta_query_filter_recursive( $wp_query->meta_query->queries );
}

function meta_query_filter_recursive( array $wp_meta_queries ) {
	$queries  = array();
	$relation = $wp_meta_queries['relation'] ?? 'AND';

	foreach ( $wp_meta_queries as $key => $query ) {
		if ( 'relation' === $key ) {
			continue;
		}
		$compare = $query['compare'] ?? null;
		$key     = $query['key'] ?? null;

		if ( isset( $key ) && ! isset( $query['value'] ) && ! in_array( $compare, array( 'EXISTS', 'NOT EXISTS', 'IN', 'NOT IN' ) ) ) {
			continue;
		}

		if ( isset( $key ) ) {
			$queries[] = generate_simple_query( $query );
		} else {
			$queries[] = meta_query_filter_recursive( $query );
		}
	}

	return implode(
		' ' . $relation . ' ',
		array_map(
			function ( $v ) {
				return '(' . $v . ')';
			},
			$queries
		)
	);
}


function generate_simple_query( $query ) {
	$compare = $query['compare'] ?? null;
	$type    = $query['type'] ?? 'CHAR';
	switch ( $compare ) {
		case 'EXISTS':
		case 'NOT EXISTS':
			$inner_query = '_exists_' . inner_operator( $compare, $type ) . $query['key'];
			break;
		default:
			$inner_query = $query['key'] . inner_operator( $compare, $type ) . wrap_value( $query );
	}

	return outer_operator( $inner_query, $compare );
}

function outer_operator( string $query_string, ?string $operator = '=' ) {
	switch ( $operator ) {
		case '!=':
		case 'NOT LIKE':
		case 'NOT EXISTS':
		case 'NOT IN':
		case 'NOT BETWEEN':
			return ' NOT (' . $query_string . ')';
		case '=':
		default:
			return $query_string;
	}
}

function inner_operator( ?string $operator = '=', ?string $type = 'CHAR' ) {
	if ( 'DATETIME' === $type ) {
		return ':';
	}

	switch ( $operator ) {
		case '>':
			return ':>';
		case '>=':
			return ':>=';
		case '<':
			return ':<';
		case '<=':
			return ':<=';
		case '=':
		default:
			return ':';
	}
}

function wrap_value( $query ) {
	$value   = $query['value'] ?? '';
	$type    = $query['type'] ?? 'CHAR';
	$compare = $query['compare'] ?? null;

	if ( 'LIKE' === $compare || 'NOT LIKE' === $compare ) {
		switch ( str_word_count( $value ) ) {
			case 1:
				return '*' . $value . '*';
			default:
				return '"*' . $value . '*"';
		}
	}

	if ( 'IN' === $compare || 'NOT IN' === $compare ) {

		if ( ! is_array( $value ) ) {
			return '""';
		}

		if ( count( $value ) <= 1 ) {
			return '"' . ( $value[0] ?? '' ) . '"';
		}

		return '(' . implode(
			' OR ',
			array_map(
				function ( $v ) {
					return '"' . $v . '"';
				},
				$value
			)
		) . ')';

	}
	if ( 'BETWEEN' === $compare || 'NOT BETWEEN' === $compare ) {
		switch ( $type ) {
			case 'DATETIME':
				return '[' . es_datetime( $value[0] ) . ' TO ' . es_datetime( $value[1] ) . ']';
			default:
				return '[' . $value[0] . ' TO ' . $value[1] . ']';
		}
	}

	if ( in_array( $type, array( 'NUMERIC', 'DATE' ) ) ) {
		return $value;
	}

	if ( 'DATETIME' === $type ) {
		$formatted_value = es_datetime( $value );
		switch ( $compare ) {
			case '>':
				return '{' . $formatted_value . ' TO *]';
			case '>=':
				return '[' . $formatted_value . ' TO *]';
			case '<':
				return '[* TO ' . $formatted_value . '}';
			case '<=':
				return '[* TO ' . $formatted_value . ']';
			case '=':
			case '!=':
			default:
				return '"' . $formatted_value . '"';
		}
	}

	return '"' . $value . '"';
}

function es_datetime( $datetime ) {
	$time_obj     = new \DateTime( $datetime );
	$has_timezone = $time_obj->getOffset() !== 0 || $time_obj->getTimezone()->getName() !== 'UTC';
	if ( $has_timezone ) {
		return $time_obj->format( 'c' );
	}

	return $time_obj->format( 'Y-m-d\TH:i:s' );

}
