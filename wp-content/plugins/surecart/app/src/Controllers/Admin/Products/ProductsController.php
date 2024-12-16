<?php

namespace SureCart\Controllers\Admin\Products;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Models\Product;
use SureCart\Controllers\Admin\Products\ProductsListTable;
use SureCart\Background\BulkActionService;

/**
 * Handles product admin requests.
 */
class ProductsController extends AdminController {
	/**
	 * Products index.
	 */
	public function index() {
		// instantiate the bulk actions service.
		$bulk_action_service = new BulkActionService();
		$bulk_action_service->bootstrap();

		// instantiate the products list table.
		$table = new ProductsListTable( $bulk_action_service );
		$table->prepare_items();

		// add header.
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'products' => [
						'title' => __( 'Products', 'surecart' ),
					],
				],
				'suffix'      => isset( $_GET['debug'] ) ? $this->syncDropdown() : null,
			),
		);

		// add notices.
		$this->withNotices(
			array(
				'sync_success' => __( 'Product synced successfully.', 'surecart' ),
				'archived'     => __( 'Product archived.', 'surecart' ),
				'unarchived'   => __( 'Product unarchived.', 'surecart' ),
			)
		);

		// return view.
		return \SureCart::view( 'admin/products/index' )->with( [ 'table' => $table ] );
	}

	/**
	 * Sync dropdown.
	 */
	public function syncDropdown() {
		ob_start();
		?>
		<sc-dropdown>
			<sc-button slot="trigger" type="text" circle>
				<sc-icon name="more-horizontal"  style="font-size: 20px"></sc-icon>
			</sc-button>
			<sc-menu>
				<sc-menu-item href="<?php echo esc_url( \SureCart::getUrl()->syncAll( 'products' ) ); ?>">
					<sc-icon slot="prefix" name="refresh-cw"></sc-icon>
					<?php esc_html_e( 'Sync Products', 'surecart' ); ?>
				</sc-menu-item>
			</sc-menu>
		</sc-dropdown>
		<?php
		return ob_get_clean();
	}

	/**
	 * Confirm Bulk Delete.
	 */
	public function confirmBulkDelete() {
		// find the products queued for bulk deletion.
		if ( empty( $_REQUEST['bulk_action_product_ids'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			wp_die(
				sprintf(
					'%s <a href="%s">%s</a>',
					esc_html__( 'No products selected. Please choose at least one product to delete.', 'surecart' ),
					esc_url( admin_url( 'admin.php?page=sc-products' ) ),
					esc_html__( 'Go Back', 'surecart' )
				)
			);
		}

		$products = Product::where(
			[
				'ids' => array_map( 'esc_html', $_REQUEST['bulk_action_product_ids'] ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			]
		)->get();

		// handle empty.
		if ( empty( $products ) ) {
			wp_die( esc_html( _n( 'This product has already been deleted.', 'These products have already been deleted.', count( $_REQUEST['bulk_action_product_ids'] ), 'surecart' ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		// handle error.
		if ( is_wp_error( $products ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $products->get_error_messages() ) ) );
		}

		// add header.
		$this->withHeader(
			[
				'delete' => [
					'title' => _n( 'Delete Product', 'Delete Products.', count( $products ), 'surecart' ),
				],
			],
		);

		// return view.
		return \SureCart::view( 'admin/products/confirm-bulk-delete' )->with( [ 'products' => $products ] );
	}

	/**
	 * Bulk Delete.
	 */
	public function bulkDelete() {
		$product_ids = array_map(
			'sanitize_text_field',
			$_REQUEST['bulk_action_product_ids'] // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		);

		// get all posts where the sc_id meta key is in the product_ids using wp_query.
		$query = new \WP_Query(
			[
				'post_type'      => 'sc_product',
				'posts_per_page' => -1,
				'meta_query'     => [
					[
						'key'     => 'sc_id',
						'value'   => $product_ids,
						'compare' => 'IN',
					],
				],
			]
		);

		// handle error.
		if ( is_wp_error( $query ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $query->get_error_messages() ) ) );
		}

		// delete the posts.
		foreach ( $query->posts as $post ) {
			wp_delete_post( $post->ID, true );
		}

		// create bulk action.
		$action = \SureCart::bulkAction()->createBulkAction(
			'delete_products',
			$product_ids
		);

		// handle error.
		if ( is_wp_error( $action ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $action->get_error_messages() ) ) );
		}

		// redirect.
		return \SureCart::redirect()->to( esc_url_raw( admin_url( 'admin.php?page=sc-products' ) ) );
	}

	/**
	 * Edit a product.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( ProductScriptsController::class, 'enqueue' ) );

		// define product.
		$product = null;

		// find the product.
		if ( $request->query( 'id' ) ) {
			$product = Product::find( $request->query( 'id' ) );

			if ( is_wp_error( $product ) ) {
				wp_die( implode( ' ', array_map( 'esc_html', $product->get_error_messages() ) ) );
			}
		}

		// preload paths.
		if ( ! empty( $product ) ) {
			$gallery_paths = [];
			$gallery       = $product->gallery_ids ?? [];
			foreach ( $gallery as $id ) {
				if ( is_int( $id ) ) {
					$gallery_paths[] = '/wp/v2/media/' . $id . '?context=edit';
				}
			}
			$taxonomies = array_diff( get_object_taxonomies( 'sc_product' ), array( 'sc_account', 'sc_collection' ) );

			if ( ! empty( $taxonomies ) ) {
				$taxonomy_paths = [];
				foreach ( $taxonomies as $taxonomy ) {
					$taxonomy_paths[] = '/wp/v2/taxonomies/' . $taxonomy . '?context=edit';
					$taxonomy_paths[] = '/wp/v2/' . $taxonomy;
				}
			}

			$this->preloadPaths(
				array_merge(
					[
						[ '/wp/v2/templates', 'OPTIONS' ],
						'/wp/v2/settings',
						'/wp/v2/types/wp_template?context=edit',
						'/wp/v2/types/wp_template-part?context=edit',
						'/wp/v2/templates?context=edit&per_page=-1',
						'/wp/v2/template-parts?context=edit&per_page=-1',
						'/wp/v2/users/me',
						'/wp/v2/types?context=view',
						'/wp/v2/types?context=edit',
						'/wp/v2/templates/' . $product->template_id . '?context=edit',
						'/wp/v2/template-parts/' . $product->template_part_id . '?context=edit',
						'/wp/v2/taxonomies?context=view',
						'/wp/v2/taxonomies?context=edit&per_page=100',
						'/wp/v2/sc_product?context=edit&sc_id[0]=' . $product->id . '&per_page=1&_locale=user',
						'/surecart/v1/products/' . $product->id . '?context=edit',
						'/surecart/v1/integrations?context=edit&model_ids[0]=' . $product->id . '&per_page=50',
						'/surecart/v1/integration_providers?context=edit',
						'/surecart/v1/integration_provider_items?context=edit',
					],
					$gallery_paths,
					$taxonomy_paths ?? []
				)
			);
		}

		// add product link.
		add_action(
			'admin_bar_menu',
			function ( $wp_admin_bar ) use ( $product ) {
				$wp_admin_bar->add_node(
					[
						'id'    => 'view-product-page',
						'title' => __( 'View Product', 'surecart' ),
						'href'  => esc_url( $product->permalink ?? '#' ),
						'meta'  => [
							'class' => empty( $product->permalink ) ? 'hidden' : '',
						],
					]
				);
			},
			99
		);

		return '<div id="app"></div><div id="metaboxes" class="hidden">' . $this->renderMetaBoxes( $product ) . '</div>';
	}

	/**
	 * Render meta boxes.
	 *
	 * @param \SureCart\Models\Product|null $product Product.
	 */
	public function renderMetaBoxes( $product ) {
		if ( empty( $product ) || empty( $product->post ) ) {
			return;
		}

		// fake the global post for metaboxes.
		global $post;
		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$post = $product->post;

		\SureCart::metaboxes()->register();
		ob_start();
		\SureCart::metaboxes()->render();
		return ob_get_clean();
	}

	/**
	 * Change the archived attribute in the model
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function toggleArchive( $request ) {
		$product = Product::find( $request->query( 'id' ) );

		if ( is_wp_error( $product ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $product->get_error_messages() ) ) );
		}

		$updated = $product->update(
			[
				'archived' => ! (bool) $product->archived,
			]
		);

		if ( is_wp_error( $updated ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $updated->get_error_messages() ) ) );
		}

		return \SureCart::redirect()->to(
			esc_url_raw(
				add_query_arg(
					$updated->archived ? [ 'archived' => 1 ] : [ 'unarchived' => 1 ],
					\SureCart::getUrl()->index( 'products' )
				)
			)
		);
	}

	/**
	 * Start product sync.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function syncAll() {
		// dispatch the sync job.
		\SureCart::sync()->products()->dispatch();

		// redirect to products page.
		return \SureCart::redirect()->to( esc_url_raw( \SureCart::getUrl()->index( 'products' ) ) );
	}

	/**
	 * Start product sync.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function sync( $request ) {
		$product = Product::sync( $request->query( 'id' ) );

		if ( is_wp_error( $product ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $product->get_error_messages() ) ) );
		}

		// redirect to products page.
		return \SureCart::redirect()->to(
			esc_url_raw(
				add_query_arg(
					[ 'sync_success' => true ],
					\SureCart::getUrl()->index( 'products' )
				)
			)
		);
	}
}
