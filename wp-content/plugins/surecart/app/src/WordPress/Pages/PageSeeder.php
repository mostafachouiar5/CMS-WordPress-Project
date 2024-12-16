<?php

namespace SureCart\WordPress\Pages;

/**
 * Service for installation related functions.
 */
class PageSeeder {
	/**
	 * SureCart instance.
	 *
	 * @var \SureCart\WordPress\PostTypes\FormPostTypeService
	 */
	protected $forms = null;

	/**
	 * SureCart instance.
	 *
	 * @var \SureCart\WordPress\Pages\PageService
	 */
	protected $pages = null;

	/**
	 * Constructor.
	 *
	 * @param \SureCart\WordPress\PostTypes\FormPostTypeService $forms Forms service.
	 * @param \SureCart\WordPress\Pages\PageService             $pages Pages service.
	 */
	public function __construct( $forms, $pages ) {
		$this->forms = $forms;
		$this->pages = $pages;
	}

	/**
	 * Seed pages and forms.
	 *
	 * @return void
	 */
	public function seed() {
		$this->createCheckoutForm();
		$this->createPages();
		$this->createCartPost();
		$this->createShopPage();
	}

	/**
	 * Delete checkout pages.
	 *
	 * @return void
	 */
	public function delete() {
		$this->deletePages();
	}

	/**
	 * Create the cart post.
	 *
	 * @return void
	 */
	public function createCartPost() {
		$pattern = require plugin_dir_path( SURECART_PLUGIN_FILE ) . 'templates/cart.php';

		$cart = apply_filters(
			'surecart/create_cart',
			[
				'cart' => [
					'name'      => _x( 'cart', 'Cart slug', 'surecart' ),
					'title'     => _x( 'Cart', 'Cart title', 'surecart' ),
					'content'   => $pattern['content'],
					'post_type' => 'sc_cart',
				],
			]
		);

		$this->createPosts( $cart );
	}

	/**
	 * Create shop page.
	 *
	 * @return void
	 */
	public function createShopPage() {
		$pattern = require plugin_dir_path( SURECART_PLUGIN_FILE ) . 'templates/patterns/list-standard.php';

		$shop = apply_filters(
			'surecart/create_shop',
			[
				'shop' => [
					'name'      => _x( 'shop', 'Shop page slug', 'surecart' ),
					'title'     => _x( 'Shop', 'Shop page title', 'surecart' ),
					'content'   => $pattern['content'],
					'post_type' => 'page',
				],
			]
		);

		$this->createPosts( $shop );
	}

	/**
	 * Create the main checkout form.
	 *
	 * @return void
	 */
	public function createCheckoutForm() {
		$pattern = require plugin_dir_path( SURECART_PLUGIN_FILE ) . 'templates/forms/checkout.php';

		$forms = apply_filters(
			'surecart/create_forms',
			[
				'checkout' => [
					'name'      => _x( 'checkout', 'Form slug', 'surecart' ),
					'title'     => _x( 'Checkout', 'Form title', 'surecart' ),
					'content'   => '<!-- wp:surecart/form {"mode":"test"} -->' . $pattern['content'] . '<!-- /wp:surecart/form -->',
					'post_type' => 'sc_form',
				],
			]
		);

		$this->createPosts( $forms );
	}

	/**
	 * Get pages for seeding.
	 *
	 * @param \WP_Post $form Form post.
	 *
	 * @return array
	 */
	public function getPages( $form = null ) {
		$customer_dashboard = require plugin_dir_path( SURECART_PLUGIN_FILE ) . 'templates/dashboard/customer-dashboard.php';

		return apply_filters(
			'surecart/create_pages',
			array(
				'checkout'  => [
					'name'          => _x( 'checkout', 'Page slug', 'surecart' ),
					'title'         => _x( 'Checkout', 'Page title', 'surecart' ),
					'content'       => '<!-- wp:surecart/checkout-form {"id":' . (int) ( $form->ID ?? 0 ) . '} --><!-- /wp:surecart/checkout-form -->',
					'page_template' => wp_is_block_theme() ? 'checkout' : 'pages/template-surecart-blank.php',
				],
				'dashboard' => [
					'name'          => _x( 'customer-dashboard', 'Page slug', 'surecart' ),
					'title'         => _x( 'Dashboard', 'Page title', 'surecart' ),
					'content'       => $customer_dashboard['content'],
					'page_template' => 'pages/template-surecart-dashboard.php',
				],
			)
		);
	}

	/**
	 * Create pages that the plugin relies on, storing page IDs in variables.
	 *
	 * @return void
	 */
	public function createPages() {
		// get default form page.
		$form = $this->forms->getDefault();
		// get pages for seeding.
		$pages = $this->getPages( $form );
		// seed posts.
		$this->createPosts( $pages );
	}

	/**
	 * Delete pages that were created by the plugin.
	 *
	 * @return void
	 */
	public function deletePages() {
		$pages = $this->getPages();
		$this->deletePosts( $pages );
	}

	/**
	 * Create posts from an array of post data.
	 *
	 * @param array $posts Array of post data.
	 * @return void
	 */
	public function createPosts( $posts ) {
		// ability to turn off page seeding.
		if ( ! apply_filters( 'surecart/seed/all', true ) ) {
			return;
		}

		foreach ( $posts as $key => $post ) {
			$this->pages->findOrCreate(
				esc_sql( $post['name'] ),
				$key,
				$post['title'],
				$post['content'],
				! empty( $post['parent'] ) ? \SureCart::pages()->findOrCreate( $post['parent'] ) : '',
				! empty( $post['post_status'] ) ? $post['post_status'] : 'publish',
				! empty( $post['post_type'] ) ? $post['post_type'] : 'page',
				! empty( $post['page_template'] ) ? $post['page_template'] : null
			);
		}
	}

	/**
	 * Delete posts from an array of post data.
	 *
	 * @param array $posts Array of post data.
	 * @return void
	 */
	public function deletePosts( $posts ) {
		foreach ( $posts as $key => $post ) {
			$page = $this->pages->get(
				$key,
				! empty( $post['post_type'] ) ? $post['post_type'] : 'page'
			);
			if ( $page ) {
				wp_delete_post( $page->ID, true );
			}
		}
	}
}
