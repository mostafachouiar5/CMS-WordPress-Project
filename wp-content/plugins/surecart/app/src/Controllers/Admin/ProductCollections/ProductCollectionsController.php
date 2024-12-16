<?php

namespace SureCart\Controllers\Admin\ProductCollections;

use SureCart\Models\ProductCollection;

/**
 * Handles product collections admin requests.
 */
class ProductCollectionsController {
	/**
	 * Index.
	 */
	public function index() {
		$table = new ProductCollectionsListTable();
		$table->prepare_items();
		return \SureCart::view( 'admin/product-collections/index' )->with(
			[
				'table' => $table,
			]
		);
	}

	/**
	 * Edit a product.
	 *
	 * @param \WP_REST_Request $request Request.
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( ProductCollectionsScriptsController::class, 'enqueue' ) );

		$product_collection = null;

		if ( $request->query( 'id' ) ) {
			$product_collection = ProductCollection::find( $request->query( 'id' ) );

			if ( is_wp_error( $product_collection ) ) {
				wp_die( implode( ' ', array_map( 'esc_html', $product_collection->get_error_messages() ) ) );
			}

			if ( ! empty( $product_collection ) ) {
				$this->preloadAPIRequests( $product_collection );
			}

			// add product collection link.
			add_action(
				'admin_bar_menu',
				function( $wp_admin_bar ) use ( $product_collection ) {
					$wp_admin_bar->add_node(
						[
							'id'    => 'view-product-collection-page',
							'title' => __( 'View Collection', 'surecart' ),
							'href'  => esc_url( $product_collection->permalink ?? '#' ),
							'meta'  => [
								'class' => empty( $product_collection->permalink ) ? 'hidden' : '',
							],
						]
					);
				},
				99
			);
		}

		// return view.
		return '<div id="app"></div>';
	}

	/**
	 * Preload API Requests.
	 *
	 * @param \SureCart\Models\ProductCollection $product_collection The product collection.
	 *
	 * @return void
	 */
	public function preloadAPIRequests( ProductCollection $product_collection ): void {
		$preload_paths = array(
			array( '/wp/v2/templates', 'OPTIONS' ),
			'/wp/v2/settings',
			'/wp/v2/types/wp_template?context=edit',
			'/wp/v2/types/wp_template-part?context=edit',
			'/wp/v2/templates?context=edit&per_page=-1',
			'/wp/v2/template-parts?context=edit&per_page=-1',
			'/wp/v2/users/me',
			'/wp/v2/types?context=view',
			'/wp/v2/types?context=edit',
			'/wp/v2/templates/' . $product_collection->template_id . '?context=edit',
			'/wp/v2/template-parts/' . $product_collection->template_part_id . '?context=edit',
			'/surecart/v1/product_collections/' . $product_collection->id . '?context=edit&expand[0]=media',
		);

		wp_add_inline_script(
			'wp-api-fetch',
			sprintf(
				'wp.apiFetch.use( wp.apiFetch.createPreloadingMiddleware( %s ) );',
				wp_json_encode(
					array_reduce(
						$preload_paths,
						'rest_preload_api_request',
						array()
					)
				)
			),
			'after'
		);
	}
}
