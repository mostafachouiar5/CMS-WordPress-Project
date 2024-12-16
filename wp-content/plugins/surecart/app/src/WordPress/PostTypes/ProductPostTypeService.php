<?php

namespace SureCart\WordPress\PostTypes;

use SureCart\Support\Currency;

/**
 * Form post type service class.
 */
class ProductPostTypeService {
	/**
	 * The post type slug.
	 *
	 * @var string
	 */
	protected $post_type = 'sc_product';

	/**
	 * Bootstrap service.
	 *
	 * @return void
	 */
	public function bootstrap() {
		// register.
		add_action( 'init', array( $this, 'registerPostType' ) );

		// register post status.
		add_action( 'init', array( $this, 'registerPostStatus' ) );

		// register meta.
		add_action( 'init', array( $this, 'registerMeta' ) );

		// add variation option value query to posts_where.
		add_filter( 'posts_where', array( $this, 'handleVariationOptionValueQuery' ), 10, 2 );

		// ensure we always fetch with the current connected store id in case of store change.
		add_filter( 'parse_query', array( $this, 'forceAccountIdScope' ), 10, 2 );

		// redirect to 404 if we are not in the correct store.
		add_action( 'template_redirect', array( $this, 'maybeRedirectTo404' ) );

		// add global $sc_product inside loops.
		add_action( 'the_post', array( $this, 'setupData' ) );

		// add the rest api meta query.
		add_action( "rest_{$this->post_type}_query", array( $this, 'addMetaQuery' ), 10, 2 );

		// register rest fields.
		add_action( 'rest_api_init', array( $this, 'registerRestFields' ) );

		// product gallery migration.
		add_action( 'get_post_metadata', array( $this, 'defaultGalleryFallback' ), 10, 4 );

		// update edit post link to edit the product directly.
		add_filter( 'get_edit_post_link', array( $this, 'updateEditLink' ), 10, 2 );

		// we need to disable the gutenberg editor for our post type so that blocks don't load there.
		add_filter( 'use_block_editor_for_post_type', [ $this, 'disableGutenberg' ], 10, 2 );

		// Add edit product link to admin bar.
		add_action( 'admin_bar_menu', [ $this, 'addEditLink' ], 99 );

		// when a product media is deleted, remove it from the gallery.
		add_action( 'delete_attachment', array( $this, 'removeFromGallery' ), 10, 1 );
		add_action( 'delete_attachment', array( $this, 'removeFromGallery' ), 10, 1 );

		// sync via webhook events.
		add_action( 'surecart/price_created', array( $this, 'sync' ) );
		add_action( 'surecart/price_deleted', array( $this, 'sync' ) );
		add_action( 'surecart/price_updated', array( $this, 'sync' ) );
		add_action( 'surecart/product_created', array( $this, 'sync' ) );
		add_action( 'surecart/product_stock_adjusted', array( $this, 'sync' ) );
		add_action( 'surecart/product_updated', array( $this, 'sync' ) );
		add_action( 'surecart/product_deleted', array( $this, 'deleteSynced' ) );

		// attachment fields.
		add_filter( 'attachment_fields_to_edit', [ $this, 'addAttachmentFields' ], 1, 2 );
		add_filter( 'attachment_fields_to_save', [ $this, 'saveAttachmentFields' ], 10, 2 );

		// handle post thumbnails from gallery.
		add_filter( 'post_thumbnail_id', array( $this, 'postThumbnailId' ), 10, 5 );
		add_filter( 'wp_get_attachment_image', array( $this, 'getAttachmentImage' ), 10, 5 );
		add_filter( 'has_post_thumbnail', array( $this, 'hasPostThumbnail' ), 10, 2 );
		add_filter( 'post_thumbnail_html', array( $this, 'postThumbnailHTML' ), 10, 5 );
		add_filter( 'post_thumbnail_url', array( $this, 'postThumbnailURL' ), 10, 2 );

		// add schema markup.
		add_filter( 'document_title_parts', [ $this, 'documentTitle' ] );

		// disallow pre title filter.
		add_filter( 'pre_get_document_title', [ $this, 'disallowPreTitle' ], 214748364 );

		// add schema and seo meta.
		add_action( 'wp_head', array( $this, 'addProductJsonSchema' ), 10 );
		add_action( 'wp_head', array( $this, 'addProductSeoMeta' ), 10 );

		// handle classic themes template.
		if ( ! wp_is_block_theme() ) {
			// replace the content with product info part.
			add_filter( 'the_content', array( $this, 'replaceContentWithProductInfoPart' ), 10 );
		} else {
			// validate FSE template and return single if invalid.
			add_filter( 'template_include', array( $this, 'validateFSETemplate' ), 10, 1 );
		}
	}

	/**
	 * Filter the post thumbnail id.
	 * This is used to set the featured image for the product.
	 *
	 * @param integer $thumbnail_id The thumbnail ID.
	 * @param integer $post_id The post ID.
	 *
	 * @return integer
	 */
	public function postThumbnailId( $thumbnail_id, $post_id ) {
		// we already have a thumbnail id.
		if ( ! empty( $thumbnail_id ) ) {
			return $thumbnail_id;
		}

		// check post type.
		$post = get_post( $post_id );
		if ( empty( $post->post_type ) || $post->post_type !== $this->post_type ) {
			return $thumbnail_id;
		}

		// use the first gallery image (product model featured image).
		$product = sc_get_product( $post_id );
		if ( ! empty( $product->featured_image->ID ) ) {
			return $product->featured_image->ID;
		}

		// fake a thumbnail id so we can filter thumbnail html output.
		return PHP_INT_MAX;
	}

	/**
	 * Get the attachment image.
	 * We need this for backwards compatibility for ProductMedia.
	 *
	 * @param string  $html The HTML.
	 * @param integer $attachment_id The attachment ID.
	 * @param integer $post_thumbnail_id The post thumbnail ID.
	 * @param string  $size The size.
	 * @param array   $attr The attributes.
	 *
	 * @return string
	 */
	public function getAttachmentImage( $html, $attachment_id, $post_thumbnail_id, $size, $attr ) {
		// check if we have an attachment id.
		if ( ! empty( $attachment_id ) ) {
			return $html;
		}

		// check post type.
		global $post;
		if ( empty( $post->post_type ) || $post->post_type !== $this->post_type ) {
			return $html;
		}

		$product = sc_get_product();
		if ( empty( $product ) ) {
			return $html;
		}

		return $product->featured_image->html( $size, $attr );
	}

	/**
	 * Since we are using the first gallery image as the post thumbnail,
	 * we need to check if the product has a featured image.
	 *
	 * @param boolean $has_thumbnail Whether the post has a thumbnail.
	 * @param integer $post_id The post ID.
	 *
	 * @return boolean
	 */
	public function hasPostThumbnail( $has_thumbnail, $post_id ) {
		// check if we have an attachment id.
		if ( ! empty( $has_thumbnail ) ) {
			return $has_thumbnail;
		}

		// check post type.
		$post = get_post( $post_id );
		if ( empty( $post->post_type ) || $post->post_type !== $this->post_type ) {
			return $has_thumbnail;
		}

		// check if the product has a featured image.
		$product = sc_get_product( $post_id );
		return ! empty( $product->featured_image->ID );
	}

	/**
	 * Get the post thumbnail html
	 *
	 * @return string
	 */
	public function postThumbnailHTML( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		if ( ! empty( $html ) ) {
			return $html;
		}

		// check post type.
		$post = get_post( $post_id );
		if ( empty( $post->post_type ) || $post->post_type !== $this->post_type ) {
			return $html;
		}

		$product = sc_get_product( $post_id );
		if ( ! empty( $product->featured_image ) ) {
			return $product->featured_image->html( $size, $attr );
		}

		return $html;
	}

	/**
	 * Get the post thumbnail url
	 *
	 * @return string
	 */
	public function postThumbnailURL( $url, $post_id ) {
		if ( ! empty( $url ) ) {
			return $url;
		}

		// check post type.
		$post = get_post( $post_id );
		if ( empty( $post->post_type ) || $post->post_type !== $this->post_type ) {
			return $url;
		}

		$product = sc_get_product( $post_id );
		if ( ! empty( $product->featured_image ) ) {
			return $product->featured_image->attributes()->src;
		}

		return $url;
	}

	/**
	 * Save the attachment fields.
	 *
	 * @param array $post The post.
	 * @param array $attachment The attachment.
	 *
	 * @return void
	 */
	public function saveAttachmentFields( $post, $attachment ) {
		$attachid = $post['ID']; // yes this is actually an array here.
		update_post_meta( $attachid, 'sc_variant_option', $attachment['sc_variant_option'] );
	}

	/**
	 * Add a custom variant value attachment field.
	 *
	 * @param array    $form_fields The form fields.
	 * @param \WP_Post $post        The post.
	 *
	 * @return array
	 */
	public function addAttachmentFields( $form_fields, $post = null ) {
		$form_fields['sc_variant_option'] = array(
			'label'    => esc_html__( 'Variant', 'surecart' ),
			'input'    => 'text',
			'required' => false,
			'value'    => get_post_meta( $post->ID, 'sc_variant_option', true ),
			'helps'    => esc_html__( 'Enter the variant name as it appears in Option Values (e.g., Black, White, Light Green).', 'surecart' ) . ' <a href="https://surecart.com/docs/variant-swatches/" target="_blank">' . esc_html__( 'Learn More.', 'surecart' ) . '</a>',
		);
		return $form_fields;
	}

	/**
	 * Sync the product.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return void
	 */
	public function sync( \SureCart\Models\Model $model ) {
		// check if has method first.
		if ( ! method_exists( $model, 'sync' ) ) {
			return;
		}

		$model->sync();
	}

	/**
	 * Delete the synced product.
	 *
	 * @param \SureCart\Models\Product $product The model.
	 *
	 * @return void
	 */
	public function deleteSynced( \SureCart\Models\Product $product ) {
		$product->deleteSynced();
	}

	/**
	 * Validate the FSE template.
	 *
	 * @param string $template The template.
	 *
	 * @return string
	 */
	public function validateFSETemplate( $template ) {
		// not our post type.
		if ( ! is_singular( $this->post_type ) ) {
			return $template;
		}

		// we have a php file, but we are in FSE.
		if ( false !== strpos( $template, '.php' ) ) {
			return get_single_template();
		}

		return $template;
	}

	/**
	 * Add edit links
	 *
	 * @param \WP_Admin_bar $wp_admin_bar The admin bar.
	 *
	 * @return void
	 */
	public function addEditLink( $wp_admin_bar ) {
		if ( ! is_singular( 'sc_product' ) || ! current_user_can( 'edit_sc_products' ) ) {
			return;
		}

		$product = sc_get_product();

		if ( empty( $product ) ) {
			return;
		}

		$wp_admin_bar->add_node(
			[
				'id'    => 'edit',
				'title' => __( 'Edit Product', 'surecart' ),
				'href'  => get_edit_post_link( $product->ID ),
			]
		);
	}

	/**
	 * Register the meta.
	 *
	 * @return void
	 */
	public function registerMeta() {
		// register the product meta.
		register_meta(
			'post',
			'product',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => array(
					'name'   => 'product',
					'type'   => 'object',
					'schema' => array(
						'type'                 => 'object',
						'context'              => array( 'edit' ),
						'additionalProperties' => true,
					),
				),
				'single'         => true,
				'type'           => 'object',
			)
		);

		register_meta(
			'post',
			'sc_id',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'string',
			)
		);

		register_meta(
			'post',
			'min_price_amount',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'string',
			)
		);

		register_meta(
			'post',
			'max_price_amount',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'string',
			)
		);

		register_meta(
			'post',
			'available_stock',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'string',
			)
		);

		register_meta(
			'post',
			'stock_enabled',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'boolean',
			)
		);

		register_meta(
			'post',
			'allow_out_of_stock_purchases',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'boolean',
			)
		);

		register_meta(
			'post',
			'featured',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'boolean',
			)
		);

		register_meta(
			'post',
			'recurring',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'boolean',
			)
		);

		register_meta(
			'post',
			'shipping_enabled',
			array(
				'object_subtype' => $this->post_type,
				'auth_callback'  => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'read_sc_products', $object_id );
				},
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'boolean',
			)
		);

		register_meta(
			'post',
			'sc_variant_option',
			array(
				'object_subtype' => 'attachment',
				'show_in_rest'   => true,
				'single'         => true,
				'type'           => 'string',
			)
		);
	}

	/**
	 * Update the edit post link to edit the product directly.
	 *
	 * @param string  $link     The link.
	 * @param integer $post_id  The post ID.
	 *
	 * @return string
	 */
	public function updateEditLink( $link, $post_id ) {
		// only for our post type.
		if ( get_post_type( $post_id ) !== $this->post_type ) {
			return $link;
		}

		// get the product.
		$product = sc_get_product( $post_id );

		// if we have a product, return the edit link.
		if ( ! empty( $product ) ) {
			return \SureCart::getUrl()->edit( 'product', $product->id );
		}

		return $link;
	}

	/**
	 * Disables gutenburg for our post type.
	 *
	 * This prevents blocks from loading in the editor, and other scripts that may
	 * expect the editor.
	 *
	 * @param bool   $current_status The current status.
	 * @param string $post_type The post type.
	 *
	 * @return bool
	 */
	public function disableGutenberg( $current_status, $post_type ) {
		if ( $post_type === $this->post_type ) {
			return false;
		}
		return $current_status;
	}

	/**
	 * For classic themes, replace the content with the product info template.
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function replaceContentWithProductInfoPart( $content ) {
		if ( ! is_singular( 'sc_product' ) ) {
			return $content;
		}
		if ( ! empty( $content ) ) {
			return $content;
		}
		$product          = sc_get_product();
		$template_part_id = isset( $product->template_part_id ) ? $product->template_part_id : 'surecart/surecart//product-info'; // Get the template part ID.
		$template         = get_block_template( $template_part_id, 'wp_template_part' );
		if ( ! $template ) {
			$template = get_block_template( 'surecart/surecart//product-info', 'wp_template_part' );
		}

		$blocks = $template->content ?? '';
		$blocks = shortcode_unautop( $blocks );
		$blocks = do_shortcode( $blocks );
		$blocks = do_blocks( $blocks );
		$blocks = wptexturize( $blocks );
		$blocks = convert_smilies( $blocks );
		$blocks = wp_filter_content_tags( $blocks, 'template_part_uncategorized' );
		// Handle embeds for block template parts.
		global $wp_embed;
		$blocks = $wp_embed->autoembed( $blocks );
		$blocks = str_replace( ']]>', ']]&gt;', $blocks );

		return $blocks . $content;
	}

	/**
	 * Default gallery fallback.
	 *
	 * Because the gallery metadata has not yet been saved, pull in the product media
	 * as the gallery.
	 *
	 * @param array   $value  The value.
	 * @param integer $object_id The object ID.
	 * @param string  $meta_key The meta key.
	 * @param bool    $single Whether to return a single value.
	 *
	 * @return array|mixed;
	 */
	public function defaultGalleryFallback( $value, $object_id, $meta_key, $single ) {
		// only for gallery.
		if ( 'gallery' !== $meta_key ) {
			return $value;
		}

		// only for our post type.
		if ( get_post_type( $object_id ) !== $this->post_type ) {
			return $value;
		}

		// only if empty.
		remove_filter( 'get_post_metadata', array( $this, __FUNCTION__ ), 10 );
		$has_meta = get_post_meta( $object_id, $meta_key, true );
		add_filter( 'get_post_metadata', array( $this, __FUNCTION__ ), 10, 4 );
		if ( ! empty( $has_meta ) ) {
			return $value;
		}

		// get the synced product.
		$product = sc_get_product( $object_id );

		// push the existing media to the gallery.
		return array(
			array_filter(
				array_map(
					function ( $media ) {
						return (object) array(
							'id' => $media->id,
						);
					},
					$product->product_medias->data ?? array()
				)
			),
		);
	}

	/**
	 * Setup the product.
	 *
	 * @param \WP_Post $post The post.
	 *
	 * @return void
	 */
	public function setupData( $post = '' ) {
		// get post.
		$post = get_post( $post );

		// check post type.
		if ( empty( $post->post_type ) || 'sc_product' !== $post->post_type ) {
			return;
		}

		// unset existing globals.
		unset( $GLOBALS['sc_product'] );

		// set product.
		$GLOBALS['sc_product'] = sc_get_product( $post );

		// return product.
		return $GLOBALS['sc_product'];
	}

	/**
	 * Force the account id scope.
	 *
	 * @param \WP_Query $query The query.
	 *
	 * @return \WP_Query
	 */
	public function forceAccountIdScope( $query ) {
		global $pagenow;

		// not our post type.
		if ( $query->get( 'post_type' ) !== 'sc_product' ) {
			return $query;
		}

		// allow if editing direction on admin.
		if ( is_admin() && 'edit.php' === $pagenow ) {
			return $query;
		}

		if ( \SureCart::account()->id && empty( $query->query['suppress_filters'] ) ) {
			// get existing tax_query.
			$existing = is_array( $query->get( 'tax_query' ) ) && ! empty( $query->get( 'tax_query' ) ) ? $query->get( 'tax_query' ) : array();

			// set the tax query using account.
			$query->set(
				'tax_query',
				array_merge(
					array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'sc_account',
							'field'    => 'name',
							'terms'    => \SureCart::account()->id,
						),
					),
					$existing,
				),
			);
		}

		return $query;
	}

	/**
	 * Redirect to 404 if we are not in the correct store.
	 *
	 * @return void
	 */
	public function maybeRedirectTo404() {
		global $post;

		// not a post.
		if ( ! isset( $post ) ) {
			return;
		}

		// not our post type.
		if ( $this->post_type !== $post->post_type ) {
			return;
		}

		// check if the post has the taxonomy sc_acccount that matches the current account.
		// cached version fails here for some reason: https://core.trac.wordpress.org/ticket/41679.
		$account = wp_get_object_terms( $post->ID, 'sc_account' );

		if ( empty( $account ) ) {
			return;
		}

		// account id does not match.
		if ( \SureCart::account()->id !== $account[0]->name ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			get_template_part( 404 );
			exit();
		}
	}

	/**
	 * Handle the variation option value query.
	 *
	 * @param string   $where The WHERE clause of the query.
	 * @param WP_Query $query The WP_Query instance (passed by reference).
	 *
	 * @return string
	 */
	public function handleVariationOptionValueQuery( $where, $query ) {
		global $wpdb;

		// not our post type.
		if ( $query->get( 'post_type' ) !== 'sc_product' ) {
			return $where;
		}

		// not our query.
		$variant_query = $query->get( 'variant_options' );
		if ( empty( $variant_query ) ) {
			return $where;
		}

		// the relation.
		$relation = $variant_query['relation'] ?? 'AND';

		// add each query.
		foreach ( $variant_query as $query ) {
			// not a valid query.
			if ( ! is_array( $query ) ) {
				continue;
			}
			// get our table.
			$option_value_table = $wpdb->prefix . 'surecart_variant_option_values';
			// get values.
			$values = "'" . implode( "','", $query['values'] ) . "'";
			// get operator.
			$operator = $query['operator'] ?? 'IN';
			// add the where clause.
			$where .= " $relation {$wpdb->posts}.ID IN (SELECT post_id FROM {$option_value_table} WHERE value $operator ($values) AND name = '{$query['name']}')";
		}

		return $where;
	}

	/**
	 * When a product media is deleted, remove it from the gallery.
	 *
	 * @param integer $post_id The post ID.
	 *
	 * @return void
	 */
	public function removeFromGallery( $post_id ) {
		// get the post.
		$post = get_post( $post_id );

		// if the post is not a product media.
		if ( 'attachment' !== $post->post_type ) {
			return;
		}

		// get the gallery.
		$gallery = get_post_meta( $post->post_parent, 'gallery', true );

		// if the gallery is empty.
		if ( empty( $gallery ) ) {
			return;
		}

		// remove the post id from the gallery.
		$updated = array_filter(
			$gallery,
			function ( $id ) use ( $post_id ) {
				return $id !== $post_id;
			}
		);

		// update the gallery.
		update_post_meta( $post->post_parent, 'gallery', $updated );
	}

	/**
	 * Register the rest fields.
	 *
	 * @return void
	 */
	public function registerRestFields() {
		register_rest_field(
			$this->post_type,
			'gallery',
			array(
				'get_callback'    => function ( $post ) {
					$product = sc_get_product( $post['id'] );
					return $product->gallery ?? [];
				},
				'update_callback' => function ( $value, $post ) {
				},
				'schema'          => array(
					'description' => __( 'Product gallery', 'surecart' ),
					'type'        => 'array',
					'items'       => array(
						'type' => 'object',
					),
				),
			)
		);
	}

	/**
	 * Add the sc_id meta query to the REST API request.
	 *
	 * @param array            $args   The args.
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return array
	 */
	public function addMetaQuery( $args, $request ) {
		if ( ! empty( $request ) ) {
			if ( ! empty( $request['sc_id'] ) ) {
				$args['meta_query'][] = array(
					'key'     => 'sc_id',
					'value'   => $request['sc_id'],
					'compare' => 'IN',
				);
			}
			if ( ! empty( $request['featured'] ) ) {
				$args['meta_query'][] = array(
					'key'     => 'featured',
					'value'   => '1',
					'compare' => '=',
				);
			}
			if ( ! empty( $request['collection_id'] ) ) {
				$legacy_collection_ids = get_terms(
					array(
						'taxonomy'   => 'sc_collection',
						'field'      => 'term_id',
						'meta_query' => array(
							array(
								'key'     => 'sc_id',
								'value'   => $request['collection_id'],
								'compare' => '=',
							),
						),

					)
				); // platform collection ids converted to WP taxonomy ids.

				// only get the term_id.
				$legacy_collection_ids = array_map(
					function ( $term ) {
						return $term->term_id;
					},
					$legacy_collection_ids
				);

				$args['tax_query'][] = array(
					'taxonomy' => 'sc_collection',
					'field'    => 'term_id',
					'terms'    => array_map( 'intval', $legacy_collection_ids ?? array() ),
				);
			}
			// if orderBy is price then order by min_price_amount.
			if ( ! empty( $request['orderBy'] ) && 'price' === $request['orderBy'] ) {
				$args['meta_key'] = 'min_price_amount';
				$args['orderby']  = 'meta_value_num';
			}

			$args['post_status'] = $request['post_status'] ?? [ 'auto-draft', 'draft', 'publish', 'trash', 'sc_archived' ];

			$args['no_found_rows'] = true;
		}
		return $args;
	}

	/**
	 * Register the product post type.
	 *
	 * @return void
	 */
	public function registerPostType() {
		register_post_type(
			$this->post_type,
			array(
				'labels'            => array(
					'name'                     => _x( 'SureCart Product', 'post type general name', 'surecart' ),
					'singular_name'            => _x( 'SureCart Product', 'post type singular name', 'surecart' ),
					'add_new'                  => _x( 'Add New', 'Product', 'surecart' ),
					'add_new_item'             => __( 'Add new Product', 'surecart' ),
					'new_item'                 => __( 'New Product', 'surecart' ),
					'edit_item'                => __( 'Edit Product', 'surecart' ),
					'view_item'                => __( 'View Product', 'surecart' ),
					'all_items'                => __( 'All Products', 'surecart' ),
					'search_items'             => __( 'Search Products', 'surecart' ),
					'not_found'                => __( 'No checkout forms found.', 'surecart' ),
					'not_found_in_trash'       => __( 'No checkout forms found in Trash.', 'surecart' ),
					'filter_items_list'        => __( 'Filter checkout forms list', 'surecart' ),
					'items_list_navigation'    => __( 'Products list navigation', 'surecart' ),
					'items_list'               => __( 'Products list', 'surecart' ),
					'item_published'           => __( 'Product published.', 'surecart' ),
					'item_published_privately' => __( 'Product published privately.', 'surecart' ),
					'item_reverted_to_draft'   => __( 'Product reverted to draft.', 'surecart' ),
					'item_scheduled'           => __( 'Product scheduled.', 'surecart' ),
					'item_updated'             => __( 'Product updated.', 'surecart' ),
				),
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => false,
				'rewrite'           => array(
					'slug'       => \SureCart::settings()->permalinks()->getBase( 'product_page' ),
					'with_front' => false,
				),
				'show_in_rest'      => true,
				'show_in_nav_menus' => false,
				'can_export'        => false,
				'capability_type'   => 'post',
				'map_meta_cap'      => true,
				'supports'          => array(
					'title',
					'excerpt',
					'custom-fields',
					'editor',
					'thumbnail',
					'page-attributes',
				),
			)
		);
	}

	/**
	 * Register the archived post status for all post types.
	 *
	 * @return void
	 */
	public function registerPostStatus() {
		register_post_status(
			'sc_archived',
			array(
				'label'                     => _x( 'Archived', 'post', 'surecart' ),
				'public'                    => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'private'                   => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				// translators: %s: number of posts.
				'label_count'               => _n_noop( 'Archived <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>', 'surecart' ),
			)
		);
	}

	/**
	 * Update the document title name to match the model[eg-product] name.
	 *
	 * @param string $title The title.
	 */
	public function disallowPreTitle( $title ) {
		if ( is_singular( 'sc_product' ) ) {
			return '';
		}
		return $title;
	}

	/**
	 * Update the document title name to match the model[eg-product] name.
	 *
	 * @param array $parts The parts of the document title.
	 */
	public function documentTitle( $parts ): array {
		if ( ! is_singular( 'sc_product' ) ) {
			return $parts;
		}

		$product = sc_get_product();

		if ( empty( $product ) ) {
			return $parts;
		}

		$parts['title'] = esc_html( sanitize_text_field( $product->page_title ?? $parts['title'] ) );

		return $parts;
	}

	/**
	 * Add the JSON-LD schema for the product.
	 *
	 * @return void
	 */
	public function addProductJsonSchema() {
		if ( ! is_singular( 'sc_product' ) ) {
			return;
		}

		$product = sc_get_product();

		if ( empty( $product ) ) {
			return;
		}

		$display_schema = apply_filters( 'sc_display_product_json_ld_schema', true, $product );
		if ( ! $display_schema ) {
			return;
		}

		$schema = $this->getJsonSchemaArray( $product ) ?? [];
		if ( empty( $schema ) ) {
			return;
		}
		?>
		<script type="application/ld+json"><?php echo wp_json_encode( $schema ); ?></script>
		<?php
	}

	/**
	 * Get the JSON-LD schema for the product.
	 *
	 * @param \SureCart\Models\Product $product The product.
	 *
	 * @return array
	 */
	public function getJsonSchemaArray( $product ): array {
		$active_prices = (array) $product->active_prices;

		$offers = array_map(
			function ( $price ) use ( $product ) {
				return array(
					'@type'         => 'Offer',
					'price'         => Currency::maybeConvertAmount( $price->amount, $price->currency ),
					'priceCurrency' => $price->currency,
					'availability'  => $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
				);
			},
			$active_prices ?? array()
		);

		$gallery_image_urls = ! empty( $product->gallery ) ? array_map(
			function ( $media ) {
				return $media->attributes()->src;
			},
			$product->gallery
		) : '';

		return apply_filters(
			'surecart/product/json_schema',
			array(
				'@context'    => 'http://schema.org',
				'@type'       => 'Product',
				'name'        => $product->name,
				'image'       => $gallery_image_urls,
				'description' => sanitize_text_field( $product->description ),
				'offers'      => $offers,
			),
			$this
		);
	}

	/**
	 * Add SEO Meta Tags for the product.
	 *
	 * @return void
	 */
	public function addProductSeoMeta() {
		if ( ! is_singular( 'sc_product' ) ) {
			return;
		}

		$product = sc_get_product();

		if ( empty( $product ) ) {
			return;
		}

		$display_seo_meta = apply_filters( 'sc_display_product_seo_meta', true, $product );
		if ( ! $display_seo_meta ) {
			return;
		}

		$this->renderProductSeoMeta( $product );
	}

	/**
	 * Render the SEO meta tags for the product.
	 *
	 * @param \SureCart\Models\Product $product The product.
	 *
	 * @return void
	 */
	public function renderProductSeoMeta( $product ) {
		$image_attributes  = $product->featured_image ? $product->featured_image->attributes( apply_filters( 'surecart/og:image/size', 'full' ) ) : null;
		$product_image_url = $image_attributes ? $image_attributes->src : '';
		?>

		<meta name="description" content="<?php echo esc_attr( sanitize_text_field( $product->meta_description ) ); ?>">
		<meta property="og:locale" content="<?php echo esc_attr( get_locale() ); ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?php echo esc_attr( $product->page_title ); ?>" />
		<meta property="og:description" content="<?php echo esc_attr( sanitize_text_field( $product->meta_description ) ); ?>" />
		<meta property="og:url" content="<?php echo esc_url( $product->permalink ); ?>" />
		<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:title" content="<?php echo esc_attr( $product->page_title ); ?>" />
		<meta name="twitter:description" content="<?php echo esc_attr( sanitize_text_field( $product->meta_description ) ); ?>" />

		<?php if ( ! empty( $product_image_url ) ) : ?>
		<meta property="og:image" content="<?php echo esc_url( $product_image_url ); ?>" />
		<meta name="twitter:image" content="<?php echo esc_url( $product_image_url ); ?>" />
		<?php endif; ?>

		<?php
	}
}
