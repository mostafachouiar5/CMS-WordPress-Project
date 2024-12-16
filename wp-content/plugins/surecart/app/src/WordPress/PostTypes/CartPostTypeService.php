<?php

namespace SureCart\WordPress\PostTypes;

use SureCart\Models\Form;
use SureCart\WordPress\Pages\PageService;

/**
 * Form post type service class.
 */
class CartPostTypeService {
	/**
	 * Holds the page service
	 *
	 * @var PageService
	 */
	protected $page_service;

	/**
	 * The default form name.
	 *
	 * @var string
	 */
	protected $default_cart_name = 'cart';

	/**
	 * The post type slug.
	 *
	 * @var string
	 */
	protected $post_type = 'sc_cart';

	/**
	 * Get the page service from the application container.
	 *
	 * @param PageService $page_service Page serice.
	 */
	public function __construct( PageService $page_service ) {
		$this->page_service = $page_service;
	}

	/**
	 * Bootstrap the service.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'init', [ $this, 'registerPostType' ] );
		add_action( 'use_block_editor_for_post', [ $this, 'forceGutenberg' ], 999, 2 );
		add_action( 'admin_init', [ $this, 'redirectFromListPage' ] );
		add_filter( 'map_meta_cap', [ $this, 'disallowDelete' ], 10, 4 );
		add_filter( 'wp_insert_post_data', [ $this, 'forcePublish' ], 10, 4 );
		add_action( 'wp_insert_post', [ $this, 'preventMultiplePosts' ], 50, 3 );
	}

	/**
	 * Prevent multiple cart posts.
	 *
	 * @param int     $post_ID Post ID.
	 * @param WP_Post $post    Post object.
	 * @param bool    $update  Whether this is an existing post being updated.
	 */
	public function preventMultiplePosts( $post_ID, $post, $update ) {
		if ( $post_ID && $this->post_type === $post->post_type && false === $update ) {
			$cart_posts = get_posts(
				[
					'post_type' => $this->post_type,
					'per_page'  => 5,
					'status'    => 'publish',
				]
			);

			if ( is_array( $cart_posts ) && count( $cart_posts ) > 1 ) {
				$saved_cart_post = \SureCart::cartPost()->get();

				foreach ( $cart_posts as $cart_post ) {
					if ( $cart_post->ID !== $saved_cart_post->ID ) {
						wp_delete_post( $cart_post->ID );
					}
				}
			}
		}
	}

	/**
	 * Redirect to forms post type from cart list page.
	 *
	 * @return void
	 */
	public function redirectFromListPage() {
		global $pagenow, $typenow;
		if ( 'sc_cart' === $typenow && 'edit.php' === $pagenow ) {
			wp_safe_redirect( esc_url_raw( admin_url( 'edit.php?post_type=sc_form' ) ) );
			die();
		}
	}

	/**
	 * Disallow deleting cart post.
	 *
	 * @param array   $caps Array of caps.
	 * @param string  $cap Cap to check.
	 * @param integer $user_id User ID.
	 * @param array   $args Arguments passed.
	 *
	 * @return array
	 */
	public function disallowDelete( $caps, $cap, $user_id, $args ) {
		// Nothing to do.
		if ( 'delete_post' !== $cap || empty( $args[0] ) ) {
			return $caps;
		}

		// Target the payment and transaction post types.
		if ( in_array( get_post_type( $args[0] ), [ $this->post_type ], true ) ) {
			$caps[] = 'do_not_allow';
		}

		return $caps;
	}

	/**
	 * Always publish the cart post.
	 *
	 * @param \WP_Post $post The post.
	 *
	 * @return \WP_Post
	 */
	public function forcePublish( $post ) {
		if ( $post['post_type'] === $this->post_type ) {
			$post['post_status'] = 'publish';
		}
		return $post;
	}

	/**
	 * Show the header.
	 **/
	public function showHeader() {
		global $typenow, $pagenow;
		if ( 'edit.php' !== $pagenow ) {
			return;
		}
		if ( $this->post_type !== $typenow ) {
			return;
		}

		return \SureCart::render(
			'layouts/partials/admin-header',
			[
				'breadcrumbs' => [
					'forms' => [
						'title' => __( 'Forms', 'surecart' ),
					],
				],
				'claim_url'   => ! \SureCart::account()->claimed ? \SureCart::routeUrl( 'account.claim' ) : '',
			]
		);
	}

	/**
	 * Force gutenberg in case of classic editor
	 *
	 * @param boolean  $use Whether to use Gutenberg.
	 * @param \WP_Post $post Post object.
	 *
	 * @return boolean;
	 */
	public function forceGutenberg( $use, $post ) {
		if ( $this->post_type === $post->post_type ) {
			return true;
		}
		return $use;
	}

	/**
	 * Find a form by id.
	 *
	 * @return WP_Post
	 */
	public function get() {
		$posts = get_posts(
			[
				'post_type' => $this->post_type,
				'per_page'  => 1,
				'status'    => 'publish',
				'order'     => 'ASC',
			]
		);

		if ( empty( $posts ) ) {
			return;
		}

		$post = $posts[0];

		if ( 'publish' !== $post->post_status ) {
			$post_id = wp_update_post(
				[
					'id'          => $post->ID,
					'post_status' => 'publish',
				]
			);
			if ( $post_id ) {
				$post = get_post( $post_id );
			}
		}

		return $post;
	}

	/**
	 * Create the post.
	 *
	 * @return \WP_Post
	 */
	public function createPost() {
		$post_id = wp_insert_post(
			[
				'post_name'    => _x( 'cart', 'Cart slug', 'surecart' ),
				'post_title'   => _x( 'Cart', 'Cart title', 'surecart' ),
				'post_type'    => $this->post_type,
				'post_status'  => 'publish',
				'post_content' => '<!-- wp:surecart/slide-out-cart --><sc-order-summary>
				<sc-line-items></sc-line-items>
			</sc-order-summary><!-- /wp:surecart/slide-out-cart -->',
			]
		);
		return get_post( $post_id );
	}

	/**
	 * Register the post type
	 *
	 * @return void
	 */
	public function registerPostType() {
		register_post_type(
			$this->post_type,
			array(
				'labels'                => array(
					'name'                     => _x( 'Carts', 'post type general name', 'surecart' ),
					'singular_name'            => _x( 'Cart', 'post type singular name', 'surecart' ),
					'add_new'                  => _x( 'Add New', 'Cart', 'surecart' ),
					'add_new_item'             => __( 'Add new Cart', 'surecart' ),
					'new_item'                 => __( 'New Cart', 'surecart' ),
					'edit_item'                => __( 'Edit Cart', 'surecart' ),
					'view_item'                => __( 'View Cart', 'surecart' ),
					'all_items'                => __( 'All Carts', 'surecart' ),
					'search_items'             => __( 'Search Carts', 'surecart' ),
					'not_found'                => __( 'No checkout forms found.', 'surecart' ),
					'not_found_in_trash'       => __( 'No checkout forms found in Trash.', 'surecart' ),
					'filter_items_list'        => __( 'Filter checkout forms list', 'surecart' ),
					'items_list_navigation'    => __( 'Carts list navigation', 'surecart' ),
					'items_list'               => __( 'Carts list', 'surecart' ),
					'item_published'           => __( 'Cart published.', 'surecart' ),
					'item_published_privately' => __( 'Cart published privately.', 'surecart' ),
					'item_reverted_to_draft'   => __( 'Cart reverted to draft.', 'surecart' ),
					'item_scheduled'           => __( 'Cart scheduled.', 'surecart' ),
					'item_updated'             => __( 'Cart updated.', 'surecart' ),
				),
				'public'                => false,
				'show_ui'               => true,
				'show_in_menu'          => false,
				'rewrite'               => false,
				'show_in_rest'          => true,
				'rest_base'             => 'sc-cart',
				'rest_controller_class' => 'WP_REST_Blocks_Controller',
				'capability_type'       => 'block',
				'capabilities'          => array(
					// You need to be able to edit posts, in order to read blocks in their raw form.
					'read'                   => 'edit_posts',
					// You need to be able to publish posts, in order to create blocks.
					'create_posts'           => false,
					'edit_posts'             => 'edit_posts',
					'edit_published_posts'   => 'edit_published_posts',
					'delete_published_posts' => false,
					'delete_posts'           => false,
					'edit_others_posts'      => 'edit_others_posts',
					'delete_others_posts'    => false,
				),
				'template'              => [
					[
						'surecart/slide-out-cart',
						[],
						[
							[
								'surecart/slide-out-cart-header',
								[
									'lock' => [
										'remove' => true,
										'move'   => false,
									],
								],
							],
							// [
							// 	'surecart/cart-items',
							// 	[
							// 		'lock' => [
							// 			'remove' => true,
							// 			'move'   => false,
							// 		],
							// 	],
							// ],
							// [
							// 	'surecart/cart-coupon',
							// 	[
							// 		'lock' => [
							// 			'remove' => false,
							// 			'move'   => false,
							// 		],
							// 	],
							// ],
							// [
							// 	'surecart/cart-subtotal',
							// 	[
							// 		'padding' => [
							// 			'top'    => '1.25em',
							// 			'left'   => '1.25em',
							// 			'bottom' => '0',
							// 			'right'  => '1.25em',
							// 		],
							// 		'border'  => false,
							// 		[
							// 			'lock' => [
							// 				'remove' => false,
							// 				'move'   => false,
							// 			],
							// 		],
							// 	],
							// ],
							// [
							// 	'surecart/cart-submit',
							// 	[
							// 		'lock' => [
							// 			'remove' => true,
							// 			'move'   => false,
							// 		],
							// 	],
							// ],
						],
					],
				],
				'map_meta_cap'          => true,
				'supports'              => array(
					'editor',
					'revisions',
				),
			)
		);
	}
}
