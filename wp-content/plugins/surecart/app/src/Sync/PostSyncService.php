<?php

namespace SureCart\Sync;

use SureCart\Models\Concerns\Facade;

use SureCart\Models\VariantOptionValue;
use SureCart\Support\Currency;

/**
 * This class syncs product records to WordPress posts.
 */
class PostSyncService {
	use Facade;

	/**
	 * The product model.
	 *
	 * @var \SureCart\Models\Product
	 */
	protected $product;

	/**
	 * The post.
	 *
	 * @var \WP_Post
	 */
	protected $post;

	/**
	 * The post type.
	 *
	 * @var string
	 */
	protected $post_type = 'sc_product';

	/**
	 * Find the post from the model.
	 *
	 * @param string $model_id The model id.
	 *
	 * @return \WP_Post|\WP_Error|null
	 */
	protected function findByModelId( $model_id ) {
		// if we don't have a model id, return null.
		if ( empty( $model_id ) ) {
			return null;
		}

		// query the post.
		$query = new \WP_Query(
			array(
				'post_type'        => $this->post_type,
				'post_status'      => array( 'auto-draft', 'draft', 'publish', 'trash', 'sc_archived', 'future' ),
				'posts_per_page'   => 1,
				'no_found_rows'    => true,
				'suppress_filters' => true,
				'meta_query'       => array(
					array(
						'key'   => 'sc_id',
						'value' => $model_id, // query by model id.
					),
				),
			)
		);

		// handle error.
		if ( is_wp_error( $query ) ) {
			return $query;
		}

		// get the post.
		$post = $query->posts[0] ?? null;

		// return the post.
		return apply_filters( "surecart_get_{$this->post_type}_post", $post, $model_id, $this );
	}

	/**
	 * Sync the model with the post.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return \WP_Post|\WP_Error
	 */
	protected function sync( \SureCart\Models\Model $model ) {
		$this->post = $this->findByModelId( $model->id );

		if ( is_wp_error( $this->post ) ) {
			return $this->post;
		}

		return empty( $this->post->ID ) ? $this->create( $model ) : $this->update( $model );
	}

	/**
	 * Delete the synced post.
	 *
	 * @param string $id The model id.
	 *
	 * @return \WP_Post|\WP_Error|false|null
	 */
	protected function delete( string $id ) {
		$this->post = $this->findByModelId( $id );

		if ( is_wp_error( $this->post ) ) {
			return $this->post;
		}

		// force delete post.
		$deleted = wp_delete_post( $this->post->ID, true );
		if ( is_wp_error( $deleted ) ) {
			return $deleted;
		}

		// delete variant option values where post_id is the post id.
		$deleted_option = VariantOptionValue::where( 'product_id', $id )->delete();
		if ( is_wp_error( $deleted_option ) ) {
			return $deleted_option;
		}

		return $deleted;
	}

	/**
	 * Get the schema map.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return array
	 */
	protected function getSchemaMap( \SureCart\Models\Model $model ) {
		$base_amount = ! empty( $model->prices->data[0]->amount ) ? $model->prices->data[0]->amount : 0;
		return array(
			'post_title'        => $model->name,
			'post_type'         => $this->post_type,
			'post_name'         => $model->slug,
			'menu_order'        => $model->position ?? 0,
			'post_excerpt'      => $model->description ?? '',
			'post_date'         => ( new \DateTime() )->setTimestamp( $model->cataloged_at )->setTimezone( new \DateTimeZone( wp_timezone_string() ) )->format( 'Y-m-d H:i:s' ),
			'post_date_gmt'     => date_i18n( 'Y-m-d H:i:s', $model->cataloged_at, true ),
			'post_modified'     => ( new \DateTime() )->setTimestamp( $model->updated_at )->setTimezone( new \DateTimeZone( wp_timezone_string() ) )->format( 'Y-m-d H:i:s' ),
			'post_modified_gmt' => date_i18n( 'Y-m-d H:i:s', $model->updated_at, true ),
			'post_status'       => $this->getPostStatusFromModel( $model ),
			'meta_input'        => array(
				'sc_id'                        => $model->id,
				'product'                      => $model->toArray(),
				'min_price_amount'             => ! empty( $model->metrics->min_price_amount ) ? Currency::maybeConvertAmount( $model->metrics->min_price_amount ?? 0, $model->initial_price->currency ?? null ) : $base_amount,
				'max_price_amount'             => ! empty( $model->metrics->max_price_amount ) ? Currency::maybeConvertAmount( $model->metrics->max_price_amount ?? 0, $model->initial_price->currency ?? null ) : $base_amount,
				'available_stock'              => $model->available_stock,
				'stock_enabled'                => $model->stock_enabled,
				'allow_out_of_stock_purchases' => $model->allow_out_of_stock_purchases,
				'featured'                     => $model->featured,
				'recurring'                    => $model->recurring,
				'shipping_enabled'             => $model->shipping_enabled,
				'purchase_limit'               => $model->purchase_limit,
				'sku'                          => $model->sku,
				'weight'                       => $model->weight,
				'weight_unit'                  => $model->weight_unit,
				'display_amount'               => $model->display_amount,
				'scratch_display_amount'       => $model->scratch_display_amount,
				'range_display_amount'         => $model->range_display_amount,
				'is_on_sale'                   => $model->is_on_sale,
			),
		);
	}

	/**
	 * Convert the template id.
	 *
	 * This removes the template theme prefix since this is not needed.
	 *
	 * @param string $id The template id.
	 *
	 * @return string
	 */
	protected function convertTemplateId( $id ) {
		$parts = explode( '//', $id, 2 );

		// not a FSE template.
		if ( count( $parts ) < 2 ) {
			return $id;
		}

		return $parts[1] ?? null;
	}

	/**
	 * Create the post.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return \WP_Post|\WP_Error
	 */
	protected function create( \SureCart\Models\Model $model ) {
		// don't do these actions as they can slow down the sync.
		foreach ( array( 'do_pings', 'transition_post_status', 'save_post', 'pre_post_update', 'add_attachment', 'edit_attachment', 'edit_post', 'post_updated', 'wp_insert_post', 'save_post_' . $this->post_type ) as $action ) {
			remove_all_actions( $action );
		}

		// we are importing.
		if ( ! defined( 'WP_IMPORTING' ) ) {
			define( 'WP_IMPORTING', true );
		}

		// insert post.
		$props   = $this->getSchemaMap( $model );
		$post_id = wp_insert_post( wp_slash( $props ), true, false );

		// handle errors.
		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		// If there is a page template, use that, otherwise use the default.
		update_post_meta( $post_id, '_wp_page_template', $this->convertTemplateId( $model->template_id ?? '' ) );
		update_post_meta( $post_id, '_wp_page_template_part', $this->convertTemplateId( $model->template_part_id ?? '' ) );

		$this->syncCollections( $post_id, $model );

		// we need to do this because tax_input checks permissions for some ungodly reason.
		wp_set_post_terms( $post_id, \SureCart::account()->id, 'sc_account' );

		$values = $this->syncVariantValues( $model, $post_id );
		if ( is_wp_error( $values ) ) {
			return $values;
		}

		// set the post on the model.
		$this->post = get_post( $post_id );

		return $this->post;
	}

	/**
	 * Update the post.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return \WP_Post|\WP_Error
	 */
	protected function update( $model ) {
		// find the post.
		if ( empty( $this->post ) ) {
			$this->post = $this->findByModelId( $model->id );
		}

		$props = $this->getSchemaMap( $model );

		// if we already have a post template, don't sync. This is to prevent overwriting the template.
		if ( ! empty( $this->post->page_template ) ) {
			unset( $props['page_template'] );
		}

		// update the post by id.
		$post_id = wp_update_post(
			array_merge(
				$props,
				array(
					'ID' => $this->post->ID,
				)
			)
		);

		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		// update page template.
		update_post_meta( $post_id, '_wp_page_template', $this->convertTemplateId( $model->template_id ?? '' ) );
		update_post_meta( $post_id, '_wp_page_template_part', $this->convertTemplateId( $model->template_part_id ?? '' ) );

		// set the collection terms.
		$this->syncCollections( $post_id, $model );

		// we need to do this because tax_input checks permissions for some ungodly reason.
		wp_set_post_terms( $post_id, \SureCart::account()->id, 'sc_account' );

		$values = $this->syncVariantValues( $model, $post_id );
		if ( is_wp_error( $values ) ) {
			return $values;
		}

		$this->post = get_post( $post_id );

		return $this->post;
	}

	/**
	 * Sync the variant values.
	 *
	 * @param int $model_id The model id.
	 * @param int $post_id  The post id.
	 *
	 * @return bool|\WP_Error
	 */
	protected function syncVariantValues( $model, $post_id ) {
		// delete existing.
		VariantOptionValue::where( 'product_id', $model->id )->delete();

		// create new.
		foreach ( ( $model->variant_options->data ?? array() ) as $option ) {
			foreach ( $option->values as $value ) {
				$created = VariantOptionValue::create(
					array(
						'value'      => $value,
						'name'       => $option->name,
						'post_id'    => $post_id,
						'product_id' => $model->id,
					)
				);
				if ( is_wp_error( $created ) ) {
					return $created;
				}
			}
		}

		return true;
	}

	/**
	 * Sync the collections.
	 *
	 * @param int                    $post_id The post id.
	 * @param \SureCart\Models\Model $model   The model.
	 *
	 * @return void
	 */
	protected function syncCollections( $post_id, $model ) {
		// sanity check.
		if ( ! isset( $model->product_collections ) || ! isset( $model->product_collections->data ) || ! is_array( $model->product_collections->data ) ) {
			return;
		}

		// store the terms for the post.
		$terms = array();

		// Loop through the collections.
		foreach ( $model->product_collections->data as $collection ) {
			// sync the collection.
			$collection->sync();

			// get term by sc_id.
			$term = $collection->term;

			// error handling.
			if ( is_wp_error( $term ) ) {
				error_log( $term->get_error_message() );
				continue;
			}

			// if we don't have a term id, skip.
			if ( ! isset( $term->term_id ) || empty( $term->term_id ) ) {
				error_log( 'Could not sync term for collection: ' . $collection->name );
				error_log( print_r( $term, true ) );
				continue;
			}

			// add to terms array.
			$terms[] = (int) $term->term_id;
		}

		// set the terms.
		wp_set_post_terms( $post_id, $terms, 'sc_collection' );
	}

	/**
	 * Add archived to the post meta.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return string
	 */
	protected function getPostStatusFromModel( \SureCart\Models\Model $model ) {
		// if it's archived, use that.
		if ( $model->archived ) {
			return 'sc_archived';
		}

		// if it's draft, use that.
		if ( 'draft' === ( $model->status ?? '' ) ) {
			return 'draft';
		}

		// default to publish.
		return 'publish';
	}
}
