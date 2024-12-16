<?php

namespace AtlasSearch\Support\WooCommerce;

use WP_Post;
use function AtlasSearch\Index\get_term_fields;

/**
 * Adds extra fields to WooCommerce product data.
 *
 * @param array   $fields Existing fields.
 * @param WP_Post $post WordPress post object.
 * @return array Modified fields.
 */
function add_extra_fields_to_product( array $fields, WP_Post $post ): array {

	$wc_product = wc_get_product( $post->ID );
	if ( $wc_product ) {
		$data = $wc_product->get_data();

		$fields['name']              = $data['name'];
		$fields['post_date_gmt']     = $data['date_created']->__toString();
		$fields['post_modified_gmt'] = $data['date_modified']->__toString();
		$fields['post_content']      = $data['description'];
		$fields['post_excerpt']      = $data['short_description'];
		$fields['price']             = (float) $data['price'];
		$fields['regular_price']     = (float) $data['regular_price'];
		$fields['sale_price']        = (float) $data['sale_price'];
		$fields['stock_status']      = $data['stock_status'];
		$fields['sku']               = $data['sku'];
		$fields['weight']            = $data['weight'];
		$fields['total_sales']       = (int) $data['total_sales'];
		$fields['average_rating']    = (float) $data['average_rating'];

		// Fetch product options (variations).
		if ( $wc_product->is_type( 'variable' ) ) {
			$variations = array();
			foreach ( $wc_product->get_children() as $child_id ) {
				$variation = wc_get_product( $child_id );

				if ( $variation ) {
					$variations[] = array(
						'sku'               => $variation->sku,
						'price'             => $variation->price,
						'regular_price'     => $variation->regular_price,
						'sale_price'        => $variation->sale_price,
						'stock_status'      => $variation->stock_status,
						'description'       => $variation->description,
						'short_description' => $variation->short_description,
						'weight'            => $variation->weight,
						'attributes'        => $variation->attributes,
					);
				}
			}
			$fields['variations'] = $variations;
		}

		// Fetch product attributes.
		$attributes = array();
		foreach ( $data['attributes'] as $attribute ) {
			if ( isset( $attribute['name'] ) && taxonomy_exists( $attribute['name'] ) ) {
				// Fetch terms for the attribute.
				// We need to treat these as taxonomies.
				// So they must exist at the root level of the index.
				$fields[ $attribute['name'] ] = array_map(
					function( $term ) {
						return get_term_fields( $term );
					},
					wp_get_post_terms( $wc_product->get_id(), $attribute['name'] )
				);
			} elseif ( isset( $attribute['name'], $attribute['options'] ) ) {
				$attributes[ $attribute['name'] ] = $attribute['options'];
			}
		}
		$fields['attributes'] = $attributes;

		// Fetch product downloads.
		$downloads = array();
		foreach ( $wc_product->downloads as $download ) {
			$downloads[] = array(
				'name' => $download['name'],
				'file' => $download['file'],
			);
		}
		$fields['downloads'] = $downloads;

		// Fetch all product meta data.
		$fields['meta_data'] = $data['meta_data'];

		// Fetch product purchase note.
		$fields['purchase_note'] = $data['purchase_note'];

		// Fetch product dimensions.
		$fields['dimensions'] = array(
			'length' => $data['length'],
			'width'  => $data['width'],
			'height' => $data['height'],
		);

	}

	return $fields;
}

/**
 * Adds extra search config fields for WooCommerce products.
 *
 * @param array  $fields Existing fields.
 * @param string $post_type Post type.
 * @return array Modified fields.
 */
function add_extra_search_config_fields( array $fields, string $post_type ): array {
	if ( 'product' === $post_type ) {

		$fields[] = 'name';
		$fields[] = 'price';
		$fields[] = 'regular_price';
		$fields[] = 'sale_price';
		$fields[] = 'stock_status';
		$fields[] = 'sku';
		$fields[] = 'weight';
		$fields[] = 'variations.*';
		$fields[] = 'attributes.*';
		$fields[] = 'downloads.*';
		$fields[] = 'meta_data.*';
		$fields[] = 'purchase_note';
		$fields[] = 'dimensions.*';
	}

	return $fields;
}
