<?php

if ( ! function_exists( 'sc_get_collection' ) ) {
	/**
	 * Get the collection.
	 *
	 * @param \WP_Term|int $term The collection term.
	 *
	 * @return \SureCart\Models\Collection|null
	 */
	function sc_get_collection( $term = false ) {
		// backwards compatibility.
		if ( get_query_var( 'surecart_current_collection' ) ) {
			return get_query_var( 'surecart_current_collection' );
		}

		// make sure to get the term.
		$term = get_term( $term );

		// no post.
		if ( ! $term ) {
			return null;
		}

		// get the product.
		$collection = get_term_meta( $term->term_id, 'collection', true );
		if ( empty( $collection ) ) {
			return null;
		}

		if ( is_array( $collection ) ) {
			$decoded = json_decode( wp_json_encode( $collection ) );
			if ( json_last_error() !== JSON_ERROR_NONE ) {
				wp_trigger_error( '', 'JSON decode error: ' . json_last_error_msg() );
			}
			$collection = new \SureCart\Models\Collection( $decoded );
			return $collection;
		}

		// decode the product.
		if ( is_string( $collection ) ) {
			$decoded = json_decode( $collection );
			if ( json_last_error() !== JSON_ERROR_NONE ) {
				wp_trigger_error( '', 'JSON decode error: ' . json_last_error_msg() );
			}
			$collection = new \SureCart\Models\Collection( $decoded );
			return $collection;
		}

		// return the collection.
		return $collection;
	}
}
