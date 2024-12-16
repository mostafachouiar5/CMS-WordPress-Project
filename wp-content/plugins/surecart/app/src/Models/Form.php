<?php

namespace SureCart\Models;

use SureCart\Models\Product;

/**
 * Checkout form class
 */
class Form {
	/**
	 * Holds the form post.
	 *
	 * @var \WP_Post;
	 */
	protected $post;

	/**
	 * Get the post
	 *
	 * @param [type] $id
	 */
	final public function __construct( $id = 0 ) {
		$this->post = get_post( $id );
	}

	/**
	 * The form's post type
	 *
	 * @return string The post type.
	 */
	protected function getPostType() {
		// TODO: get this from registration.
		return 'sc_form';
	}

	/**
	 * Get the stored product choices
	 *
	 * @param int|WP_Post $id Post object or id.
	 * @return array
	 */
	protected function getPriceIds( $id ) {
		$this->post = get_post( $id );
		$blocks     = parse_blocks( $this->post->post_content );
		return $this->getNested( $blocks, 'price_id' );
	}

	/**
	 * Get a form's attribute
	 *
	 * @param string $attribute Attribute name.
	 * @return mixed
	 */
	public function getAttribute( $attribute ) {
		$blocks     = parse_blocks( $this->post->post_content );
		$form_block = $blocks[0] ?? false;
		if ( ! $form_block || 'surecart/form' !== $form_block['blockName'] ) {
			return '';
		}
		return $form_block['attrs'][ $attribute ] ?? null;
	}

	/**
	 * Get the form's mode
	 *
	 * @param int|WP_Post $id Post object or id.
	 * @return string
	 */
	protected function getMode( $id ) {
		$this->post = get_post( $id );
		if ( empty( $this->post ) ) {
			return null;
		}
		$blocks     = parse_blocks( $this->post->post_content );
		$form_block = $blocks[0] ?? false;
		if ( ! $form_block || 'surecart/form' !== $form_block['blockName'] ) {
			return '';
		}
		return apply_filters( 'surecart/payments/mode', $form_block['attrs']['mode'] ?? 'live' );
	}

	/**
	 * Get nested values from an array
	 *
	 * @param array  $array Array to search.
	 * @param string $nested_key Nested key to search for.
	 * @return array
	 */
	protected function getNested( array $array, $nested_key ) {
		$return = array();
		array_walk_recursive(
			$array,
			function( $a, $key ) use ( &$return, $nested_key ) {
				if ( $nested_key === $key ) {
					$return[] = $a;
				}
			}
		);
		return $return;
	}

	/**
	 * Get the form's products.
	 *
	 * @param int|WP_Post Block post id.
	 */
	protected function getProducts( $id ) {
		$ids = $this->getPriceIds( $id );
		// no products.
		if ( empty( $ids ) ) {
			return [];
		}

		// get prices with their product
		$prices = Price::where(
			[
				'ids' => $ids,
			]
		)->with( [ 'product' ] )->get();

		$products = [];
		foreach ( $prices as $price ) {
			$products[] = $price->product;
		}
		return $products;
	}

	protected function getPosts( $id ) {
		$blocks     = $this->searchBlocks( $id );
		$shortcodes = $this->searchShortcodes( $id );
		return array_merge( $blocks, $shortcodes );
	}

	public function searchBlocks( $id ) {
		return get_posts(
			[
				's'         => '<!-- wp:surecart/checkout-form {"id":' . (int) $id,
				'sentence'  => 1,
				'post_type' => 'any',
				'per_page'  => -1,
			]
		);
	}

	public function searchShortcodes( $id ) {
		return get_posts(
			[
				's'         => '[sc_form id=' . (int) $id,
				'sentence'  => 1,
				'post_type' => 'any',
				'per_page'  => -1,
			]
		);
	}

	/**
	 * Get blocks from the posts.
	 *
	 * @param array $posts Array of posts.
	 * @return array Array of blocks.
	 */
	public function getBlocksFromPosts( $posts ) {
		$blocks = [];
		foreach ( $posts as $post ) {
			$parsed_blocks = parse_blocks( $post->post_content );
			$blocks        = array_merge( $blocks, $this->findCheckoutBlocks( $parsed_blocks, $post ) );
		}
		return array_filter( $blocks );
	}

	/**
	 * Find our checkout block.
	 *
	 * @param array    $post_blocks Blocks array.
	 * @param \WP_Post $post_object Post object.
	 * @return array
	 */
	public function findCheckoutBlocks( $post_blocks, \WP_Post $post_object ) {
		$blocks = [];
		foreach ( $post_blocks as $block ) {
			if ( 'surecart/checkout-form' === $block['blockName'] ) {
				$block['post'] = $post_object;
				$blocks[]      = $block;
			} elseif ( ! empty( $block['innerBlocks'] ) ) {
				$blocks = array_merge( $blocks, $this->findCheckoutBlocks( $block['innerBlocks'], $post_object ) );
			}
		}

		return array_filter( $blocks );
	}

	/**
	 * Static Facade Accessor
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 *
	 * @return mixed
	 */
	public static function __callStatic( $method, $params ) {
		return call_user_func_array( [ new static(), $method ], $params );
	}
}
