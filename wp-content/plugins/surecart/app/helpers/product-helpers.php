<?php
if ( ! function_exists( 'sc_get_product' ) ) {
	/**
	 * Get the product.
	 *
	 * @param \WP_Post|int|string $post The product post.
	 *
	 * @return \SureCart\Models\Product|null
	 */
	function sc_get_product( $post = false ) {
		// backwards compatibility.
		if ( get_query_var( 'surecart_current_product' ) ) {
			return get_query_var( 'surecart_current_product' );
		}

		// allow getting the product by sc_id.
		if ( is_string( $post ) ) {
			$posts = get_posts(
				[
					'post_type'  => 'sc_product',
					'meta_query' => [
						'key'   => 'sc_id',
						'value' => $post,
					],
				]
			);
			$post  = count( $posts ) > 0 ? $posts[0] : get_post( $post );
		} else {
			$post = get_post( $post );
		}

		// no post.
		if ( ! $post ) {
			return null;
		}

		// get the product.
		$product = get_post_meta( $post->ID, 'product', true );
		if ( empty( $product ) ) {
			return null;
		}

		if ( is_array( $product ) ) {
			$decoded = json_decode( wp_json_encode( $product ) );
			if ( json_last_error() !== JSON_ERROR_NONE ) {
				wp_trigger_error( '', 'JSON decode error: ' . json_last_error_msg() );
			}
			$product = new \SureCart\Models\Product( $decoded );
			return $product;
		}

		// decode the product.
		if ( is_string( $product ) ) {
			$decoded = json_decode( $product );
			if ( json_last_error() !== JSON_ERROR_NONE ) {
				wp_trigger_error( '', 'JSON decode error: ' . json_last_error_msg() );
			}
			$product = new \SureCart\Models\Product( $decoded );
			return $product;
		}

		// return the product.
		return $product;
	}
}

if ( ! function_exists( 'sc_get_products' ) ) {
	/**
	 * Standard way of retrieving products based on certain parameters.
	 *
	 * This function should be used for product retrieval so that we have a data agnostic
	 * way to get a list of products.
	 *
	 * @param  array $args Array of args (above).
	 * @return array|stdClass Number of pages and an array of product objects if
	 */
	function sc_get_products( $args = [] ) {
		return get_posts(
			wp_parse_args(
				$args,
				[
					'post_type'   => 'sc_product',
					'post_status' => 'publish',
				]
			)
		);
	}
}

if ( ! function_exists( 'sc_query_products' ) ) {
	/**
	 * Standard way of retrieving products based on certain parameters.
	 *
	 * This function should be used for product retrieval so that we have a data agnostic
	 * way to query a list of products.
	 *
	 * @param  array $args Array of args (above).
	 * @return \WP_Query The query.
	 */
	function sc_query_products( $args = [] ) {
		return new \WP_Query(
			[
				$args,
				[
					'post_type'   => 'sc_product',
					'post_status' => 'publish',
				],
			]
		);
	}
}

if ( ! function_exists( 'sc_setup_product_data' ) ) {
	/**
	 * Set global $sc_product.
	 *
	 * @param mixed $post Post Object or ID.
	 *
	 * @return \SureCart\Models\Product
	 */
	function sc_setup_product_data( $post = '' ) {
		return \SureCart::productPost()->setupData( $post );
	}
}


if ( ! function_exists( 'sc_get_product_featured_image' ) ) {
	/**
	 * Set global $sc_product.
	 *
	 * @param string $size The image size.
	 * @param array  $attrs The attributes.
	 *
	 * @return string
	 */
	function sc_get_product_featured_image( $size = 'full', $attrs = [] ) {
		$sc_product = sc_get_product();
		if ( empty( $sc_product ) || empty( $sc_product->featured_image ) ) {
			return '';
		}
		return $sc_product->featured_image->html( $size, $attrs );
	}
}

if ( ! function_exists( 'sc_get_product_featured_image_attributes' ) ) {
	/**
	 * Set global $sc_product.
	 *
	 * @param string $size The image size.
	 * @param array  $attrs The attributes.
	 *
	 * @return object
	 */
	function sc_get_product_featured_image_attributes( $size = 'full', $attrs = [] ) {
		$sc_product = sc_get_product();
		if ( empty( $sc_product ) || empty( $sc_product->featured_image ) ) {
			return '';
		}
		return $sc_product->featured_image->attributes( $size, $attrs );
	}
}

if ( ! function_exists( 'sc_html_attributes' ) ) {
	/**
	 * Get the html attributes.
	 *
	 * @param array $attributes The attributes.
	 * @param bool  $show_empty_values Whether to show empty values.
	 *
	 * @return string
	 */
	function sc_html_attributes( $attributes = [], $show_empty_values = false ) {
		$html = '';
		foreach ( $attributes as $key => $value ) {
			if ( $value || $show_empty_values ) {
				$html .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
			}
		}
		return $html;
	}
}

/**
 * Get the product page id.
 *
 * @param string $prefix The prefix.
 *
 * @return string
 */
function sc_unique_product_page_id( $prefix = '' ) {
	static $id_counter = -1;
	return $prefix . (string) ++$id_counter;
}

/**
 * Get the product list id.
 *
 * @param string $prefix The prefix.
 *
 * @return string
 */
function sc_unique_product_list_id( $prefix = '' ) {
	static $id_counter = -1;
	return $prefix . (string) ++$id_counter;
}
