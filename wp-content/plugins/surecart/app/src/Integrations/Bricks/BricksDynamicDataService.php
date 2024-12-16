<?php

namespace SureCart\Integrations\Bricks;

use SureCart\Support\Currency;

/**
 * This class handles bricks dynamic data functionality.
 */
class BricksDynamicDataService {
	/**
	 * Provider name.
	 *
	 * @var string
	 */
	protected $name = 'surecart';

	/**
	 * Bootstrap the service.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'bricks/dynamic_tags_list', [ $this, 'dynamicTags' ] );
		add_filter( 'bricks/dynamic_data/render_tag', [ $this, 'getTheTagValue' ], 10, 2 );
		add_filter( 'bricks/frontend/render_data', [ $this, 'render' ], 10, 3 );
		add_filter( 'bricks/dynamic_data/render_content', [ $this, 'render' ], 10, 3 );

		// make sure scripts load in footer.
		if ( ! defined( 'ACSS_FLAG_LOAD_DASHBOARD_SCRIPTS_IN_FOOTER' ) ) {
			define( 'ACSS_FLAG_LOAD_DASHBOARD_SCRIPTS_IN_FOOTER', true );
		}
	}

	/**
	 * Check if we are in the admin editor.
	 *
	 * @return bool
	 */
	public function is_admin_editor() {
		return ! bricks_is_frontend() || bricks_is_builder_call();
	}

	/**
	 * Register Tags.
	 *
	 * @param array $tags Existing tags.
	 *
	 * @return array
	 */
	public function dynamicTags( $tags = [] ) {
		return array_merge(
			$tags,
			[
				[
					'slug'  => 'sc_product_price',
					'name'  => '{sc_product_price}',
					'label' => esc_html__( 'Product price', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_selected_price',
					'name'  => '{sc_product_selected_price}',
					'label' => esc_html__( 'Product selected price', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_scratch_price',
					'name'  => '{sc_product_scratch_price}',
					'label' => esc_html__( 'Product scratch price', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_selected_scratch_price',
					'name'  => '{sc_product_selected_scratch_price}',
					'label' => esc_html__( 'Product selected scratch price', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_price_range',
					'name'  => '{sc_product_price_range}',
					'label' => esc_html__( 'Product price range', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_description',
					'name'  => '{sc_product_description}',
					'label' => esc_html__( 'Product description', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_stock',
					'name'  => '{sc_product_stock}',
					'label' => esc_html__( 'Product stock', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_sku',
					'name'  => '{sc_product_sku}',
					'label' => esc_html__( 'Product SKU', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_on_sale',
					'name'  => '{sc_product_on_sale}',
					'label' => esc_html__( 'Product on sale', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_trial',
					'name'  => '{sc_product_trial}',
					'label' => esc_html__( 'Product trial', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_selected_trial',
					'name'  => '{sc_product_selected_trial}',
					'label' => esc_html__( 'Product selected price trial', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_billing_interval',
					'name'  => '{sc_product_billing_interval}',
					'label' => esc_html__( 'Product billing interval', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_selected_billing_interval',
					'name'  => '{sc_product_selected_billing_interval}',
					'label' => esc_html__( 'Product selected price billing interval', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_setup_fee',
					'name'  => '{sc_product_setup_fee}',
					'label' => esc_html__( 'Product setup fee', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_product_selected_setup_fee',
					'name'  => '{sc_product_selected_setup_fee}',
					'label' => esc_html__( 'Product selected price setup fee', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_price_name',
					'name'  => '{sc_price_name}',
					'label' => esc_html__( 'Price name', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_price_amount',
					'name'  => '{sc_price_amount}',
					'label' => esc_html__( 'Price amount', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_price_trial',
					'name'  => '{sc_price_trial}',
					'label' => esc_html__( 'Price trial', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
				[
					'slug'  => 'sc_price_setup_fee',
					'name'  => '{sc_price_setup_fee}',
					'label' => esc_html__( 'Price setup fee', 'surecart' ),
					'group' => esc_html__( 'SureCart Product', 'surecart' ),
				],
			]
		);
	}

	/**
	 * Parse tag
	 *
	 * @param string $name    Tag name.
	 * @param object $post    Post object.
	 * @param array  $filters Filters.
	 */
	public function parseTag( $name, $post, $filters ) {
		$post_id = isset( $post->ID ) ? $post->ID : '';
		$product = $post_id ? sc_get_product( $post_id ) : false;

		switch ( $name ) {
			// static product price.
			case 'product_price':
				// Support ':value' filter to get the price value as a simple string (e.g.: 65.3, 2.5, 5 ).
				if ( isset( $filters['value'] ) ) {
					return esc_html( $product ? Currency::maybeConvertAmount( $product->initial_amount ) : '' );
				}

				// Support ':raw' filter to get the price value as a simple string (e.g.: 1250, 250, 5 ).
				if ( isset( $filters['raw'] ) ) {
					return esc_html( $product ? $product->initial_amount : '' );
				}

				// preview in the admin editor.
				if ( $this->is_admin_editor() ) {
					return ( $product->display_amount ?? Currency::format( 1200 ) );
				}

				return $product->display_amount;

			// the dymamically selected price for the product.
			case 'product_selected_price':
				// preview in the admin editor.
				if ( $this->is_admin_editor() ) {
					return "<span class='wp-block-surecart-product-selected-price-amount'>" . ( $product->display_amount ?? Currency::format( 1200 ) ) . '</span>';
				}

				// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return '<!-- wp:surecart/product-selected-price-amount --><!-- /wp:surecart/product-selected-price-amount --> ';

			// the static price range.
			case 'product_price_range':
				return esc_html( $product ? $product->range_display_amount : '' );

			// static product scratch price.
			case 'product_scratch_price':
				// Support ':value' filter to get the price value as a simple string (e.g.: 65.3, 2.5, 5 ).
				if ( isset( $filters['value'] ) ) {
					return esc_html( $product ? Currency::maybeConvertAmount( $product->scratch_amount ) : '' );
				}

				// Support ':raw' filter to get the price value as a simple string (e.g.: 1450, 250, 5 ).
				if ( isset( $filters['raw'] ) ) {
					return esc_html( $product ? $product->scratch_amount : '' );
				}

				// preview in the admin editor.
				if ( $this->is_admin_editor() ) {
					return ( $product->scratch_display_amount ?? Currency::format( 1400 ) );
				}

				return $product->scratch_display_amount;

			// the dymamically selected scratch price for the product.
			case 'product_selected_scratch_price':
				// preview in the admin editor.
				if ( $this->is_admin_editor() ) {
					return "<span class='wp-block-surecart-product-selected-price-scratch-amount sc-price__amount'>" . ( $product->scratch_display_amount ?? '$14' ) . '</span>';
				}

				// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return '<!-- wp:surecart/product-selected-price-scratch-amount --><!-- /wp:surecart/product-selected-price-scratch-amount --> ';

			case 'product_description':
				$clean_excerpt = trim( wp_strip_all_tags( $post->post_excerpt ) );
				if ( empty( $clean_excerpt ) ) {
					return '';
				}
				return '<span class="sc-prose">' . wp_kses_post( ! empty( $filters['num_words'] ) ? \Bricks\Helpers::get_the_excerpt( $post, $filters['num_words'], null, true ) : $post->post_excerpt ?? '' ) . '</span>';

			case 'product_stock':
				// unlimited stock, don't display stock.
				if ( $product ? $product->has_unlimited_stock : '' ) {
					return '';
				}
				if ( isset( $filters['meta_key'] ) && 'on_hand' === $filters['meta_key'] ) {
					return esc_html( $product ? $product->stock : '' );
				}
				if ( isset( $filters['meta_key'] ) && 'held' === $filters['meta_key'] ) {
					return esc_html( $product ? $product->held_stock : '' );
				}
				return esc_html( $product ? $product->available_stock : '' );

			case 'product_sku':
				return esc_html( $product ? $product->sku : '' );

			case 'product_on_sale':
				return esc_html( $product ? $product->is_on_sale : '' );

			case 'product_trial':
				if ( $this->is_admin_editor() ) {
					return $product->trial_text ?? esc_html__( 'Starting in 15 days.', 'surecart' );
				}
				return $product->trial_text;

			case 'product_selected_trial':
				if ( $this->is_admin_editor() ) {
					return "<span class='wp-block-surecart-product-selected-price-trial'>" . esc_html__( 'Starting in 15 days.', 'surecart' ) . '</span>';
				}
				// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return '<!-- wp:surecart/product-selected-price-trial --><!-- /wp:surecart/product-selected-price-trial --> ';

			case 'product_billing_interval':
				if ( $this->is_admin_editor() ) {
					return $product->billing_interval_text ?? esc_html__( '/ day (3 payments)', 'surecart' );
				}
				return $product->billing_interval_text ?? '';

			case 'product_selected_billing_interval':
				if ( $this->is_admin_editor() ) {
					return "<span class='wp-block-surecart-product-selected-price-interval sc-price__amount'>" . esc_html__( '/ day (3 payments)', 'surecart' ) . '</span>';
				}
				// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return '<!-- wp:surecart/product-selected-price-interval --><!-- /wp:surecart/product-selected-price-interval --> ';

			case 'product_setup_fee':
				if ( $this->is_admin_editor() ) {
					// translators: %s: Setup Fee amount.
					return $product->setup_fee_text ?? esc_html( sprintf( __( '%s setup fee.', 'surecart' ), Currency::format( 100 ) ) );
				}
					// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return $product->setup_fee_text ?? '';

			case 'product_selected_setup_fee':
				if ( $this->is_admin_editor() ) {
					// translators: %s: Setup Fee amount.
					return "<span class='wp-block-surecart-product-selected-price-fees'>" . esc_html( sprintf( __( '%s setup fee.', 'surecart' ), Currency::format( 100 ) ) ) . '</span>';
				}
				// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return '<!-- wp:surecart/product-selected-price-fees --><!-- /wp:surecart/product-selected-price-fees --> ';

			case 'price_name':
				if ( $this->is_admin_editor() ) {
					// translators: %s: Setup Fee amount.
					return "<span class='wp-block-surecart-price-name'>" . esc_html__( 'Price name', 'surecart' ) . '</span>';
				}
				// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return '<!-- wp:surecart/price-name --><!-- /wp:surecart/price-name --> ';

			case 'price_amount':
				if ( $this->is_admin_editor() ) {
					// translators: %s: Setup Fee amount.
					return "<span class='wp-block-surecart-price-amount'>" . sprintf( esc_attr__( '%1$s %2$s', 'surecart' ), Currency::format( 200 ), '/mo' ) . '</span>';
				}
				// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return '<!-- wp:surecart/price-amount --><!-- /wp:surecart/price-amount --> ';

			case 'price_trial':
				if ( $this->is_admin_editor() ) {
					// translators: %s: Setup Fee amount.
					return "<span class='wp-block-surecart-product-price-trial'>" . esc_html__( 'Starting in 15 days', 'surecart' ) . '</span>';
				}
				// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return '<!-- wp:surecart/price-trial --><!-- /wp:surecart/price-trial --> ';

			case 'price_setup_fee':
				if ( $this->is_admin_editor() ) {
					// translators: %s: Setup Fee amount.
					return "<span class='wp-block-surecart-product-price-setup-fee'>" . esc_html__( '$12 Signup Fee', 'surecart' ) . '</span>';
				}
				// IMPORTANT: Don't remove the trailing space or the block may break in some contexts.
				return '<!-- wp:surecart/price-setup-fee --><!-- /wp:surecart/price-setup-fee --> ';
		}

		return $name;
	}

	/**
	 * Dynamic tag exists in $content: Replaces dynamic tag with requested data.
	 *
	 * @param string  $content Content.
	 * @param WP_Post $post   Post object.
	 * @param string  $context Context.
	 *
	 * @return string
	 */
	public function render( $content, $post, $context = 'text' ) {
		/**
		 * \w: Matches any word character (alphanumeric & underscore).
		 * Equivalent to [A-Za-z0-9_]
		 * "À-ÖØ-öø-ÿ" Add the accented characters
		 * "-" Needed because some post types handles are like "my-post-type"
		 * ":" Needed for extra arguments to dynamic data tags (e.g. post_excerpt:20 or wp_user_meta:my_meta_key)
		 * "|" and "," needed for the post terms like {post_terms_post_tag:sep} where sep could be a pipe or comma
		 * "(", ")" and "'" for the function arguments of the dynamic tag {echo}
		 * "@" to support email addresses as arguments of the dynamic tag {echo} #3kazphp
		 *
		 * @since 1.9.4: "u" modifier: Pattern strings are treated as UTF-8 to support Cyrillic, Arabic, etc.
		 * @since 1.10: "$", "+", "%", "#", "!", "=", "<", ">", "&", "~", "[", "]", ";" as arguments of the dynamic tag {echo}
		 *
		 * @see https://regexr.com/
		 */
		$pattern = '/{([\wÀ-ÖØ-öø-ÿ\-\s\.\/:\(\)\'@|,$%#!+=<>&~\[\];]+)}/u';

		/**
		 * Matches the echo tag pattern (#86bwebj6m)
		 *
		 * @since 1.9.8
		 */
		$echo_pattern = '/echo:([a-zA-Z0-9_]+)/';

		// Get a list of tags to exclude from the Dynamic Data logic.
		$exclude_tags = apply_filters( 'bricks/dynamic_data/exclude_tags', [] );

		/**
		 * STEP: Determine how many times we need to run the DD parser
		 *
		 * Previously we ran the parser by counting the number of open curly braces in the content. (@since 1.8)
		 * But this is not reliable because the content could contain curly braces in the code elements or any shortcodes.
		 * Causing the website to load extremely slow.
		 *
		 * @since 1.8.2 (#862jyyryg)
		 */
		// Get all registered tags except the excluded ones.
		// Example: [0 => "post_title", 1 => "woo_product_price", 2 => "echo"].
		$registered_tags = array_filter(
			array_column( $this->dynamicTags(), 'slug' ),
			function ( $tag ) use ( $exclude_tags ) {
				return ! in_array( $tag, $exclude_tags, true );
			}
		);

		$dd_tags_in_content = [];
		$dd_tags_found      = [];
		$echo_tags_found    = [];

		// Find all dynamic data tags in the content.
		preg_match_all( $pattern, $content, $dd_tags_in_content );

		$dd_tags_in_content = ! empty( $dd_tags_in_content[1] ) ? $dd_tags_in_content[1] : [];

		// Find all echo tags in the content.
		preg_match_all( $echo_pattern, $content, $echo_tags_found );

		// Combine the dynamic data tags from the content and the echo tags.
		if ( ! empty( $echo_tags_found[0] ) ) {
			$dd_tags_in_content = array_merge( $dd_tags_in_content, $echo_tags_found[0] );
		}

		if ( ! empty( $dd_tags_in_content ) ) {
			/**
			 * $dd_tags_in_content only matches the pattern, but some codes from Code element could match the pattern too.
			 * Example: function test() { return 'Hello World'; } will match the pattern, but it's not a dynamic data tag.
			 *
			 * Find all dynamic data tags in the content which starts with dynamic data tag from $registered_tags
			 * Cannot use array_in or array_intersect because $registered_tags only contains the tag name, somemore tags could have filters like {echo:my_function( 'Hello World' )
			 *
			 * Example: $registered_tags    = [0 => "post_title", 1 => "woo_product_price", 2 => "echo"]
			 * Example: $dd_tags_in_content = [0 => "post_title", 1 => "woo_product_price:value", 2 => "echo:my_function('Hello World')"]
			 */
			$dd_tags_found = array_filter(
				$dd_tags_in_content,
				function ( $tag ) use ( $registered_tags ) {
					foreach ( $registered_tags as $all_tag ) {
						/**
						 * Skip not our tags.
						 */
						if ( strpos( $tag, 'sc_' ) === 0 ) {
							return true;
						}

						if ( strpos( $tag, $all_tag ) === 0 ) {
							return true;
						}
					}
					return false;
				}
			);
		}

		// Get the count of found dynamic data tags.
		$dd_tag_count = count( $dd_tags_found );

		// STEP: Run the parser based on the count of found dynamic data tags.
		for ( $i = 0; $i < $dd_tag_count; $i++ ) {
			preg_match_all( $pattern, $content, $matches );

			if ( empty( $matches[0] ) ) {
				return $content;
			}

			$run_again = false;

			foreach ( $matches[1] as $key => $match ) {
				$tag = $matches[0][ $key ];

				if ( in_array( $match, $exclude_tags, true ) ) {
					continue;
				}

				$value = $this->getTheTagValue( $match, $post, $context );

				// Value is a WP_Error: Set value to false to avoid error in builder.
				if ( is_a( $value, 'WP_Error' ) ) {
					$value = false;
				}

				$content = str_replace( $tag, $value, $content );
			}

			if ( $run_again ) {
				++$dd_tag_count;
			}
		}

		return $content;
	}

	/**
	 * Main function to render the tag value for WooCommerce provider
	 *
	 * @param string $tag    Tag name.
	 * @param object $post   Post object.
	 *
	 * @return string
	 */
	public function getTheTagValue( $tag, $post ) {
		$tags = $this->dynamicTags();

		// Check if the tag exists in the registered tags.
		$tag_exists = array_search( strtok( $tag, ':' ), array_column( $tags, 'slug' ), true );
		if ( false === $tag_exists ) {
			return $tag;
		}

		// parse tag and args.
		$parsed = is_string( $tag ) ? $this->parse_tag_and_args( $tag ) : [
			'tag'  => $tag,
			'args' => [],
		];
		$tag    = $parsed['tag'];
		$args   = $parsed['args'];

		// Check for filter args.
		$filters = $this->get_filters_from_args( $args );

		// Get the tag name.
		$name = isset( $tags[ $tag ]['render'] ) ? $tags[ $tag ]['render'] : str_replace( 'sc_', '', $tag );

		return $this->parseTag( $name, $post, $filters );
	}

	/**
	 * Parse the tag and extract arguments
	 *
	 * @param string $tag The original tag string.
	 * @return array An array containing the parsed tag and arguments.
	 */
	private function parse_tag_and_args( $tag ) {
		$original_tag = $tag;
		$args         = [];

		// Special case to allow using "@" as "echo:" tag parameter.
		// TODO NEXT: More rebust DD argument parser (@see #86bzunbgf)
		if ( strpos( $tag, 'echo:' ) === 0 ) {
			return [
				'tag'          => 'echo',
				'args'         => [ substr( $tag, 5 ) ], // Everything after 'echo:'
				'original_tag' => $original_tag,
			];
		}

		// Check if tag has ':' or '@' indicating it has arguments
		if ( strpos( $tag, ':' ) !== false || strpos( $tag, '@' ) !== false ) {
			// If there's a ':' before the first '@', split at the first ':'
			if ( strpos( $tag, ':' ) !== false && ( strpos( $tag, '@' ) === false || strpos( $tag, ':' ) < strpos( $tag, '@' ) ) ) {
				list($tag, $args_string) = explode( ':', $tag, 2 );
			} else {
				// If there's no ':' before the first '@', the tag is before the '@'
				$args_string = $tag;
				$tag         = strtok( $tag, ' @' );
			}

			// Check if the args_string contains key-value pairs marked with '@'
			if ( strpos( $args_string, '@' ) !== false ) {
				list($standard_args, $kv_args_string) = explode( '@', $args_string, 2 );

				// Add standard arguments to the args array
				if ( ! empty( $standard_args ) ) {
					$standard_args_array = explode( ':', $standard_args );
					foreach ( $standard_args_array as $arg ) {
						$args[] = trim( $arg );
					}
				}

				// Split the key-value pairs
				$kv_pairs = explode( '@', $kv_args_string );
				foreach ( $kv_pairs as $pair ) {
					list($key, $value)    = explode( ':', $pair, 2 );
					$args[ trim( $key ) ] = trim( $value );
				}
			} else {
				// No key-value pairs, just standard arguments
				$standard_args_array = explode( ':', $args_string );
				foreach ( $standard_args_array as $arg ) {
					$args[] = trim( $arg );
				}
			}
		}

		return [
			'tag'          => $tag,
			'args'         => $args,
			'original_tag' => $original_tag,
		];
	}

		/**
		 * Calculate dynamic data filters according to the args received
		 *
		 * @param array $args
		 * @return array
		 */
	public function get_filters_from_args( $args ) {
		$filters = [
			'object_type' => '',
		];

		if ( empty( $args ) || ! is_array( $args ) ) {
			return $filters;
		}

		foreach ( $args as $arg ) {
			// Trim number of words or avatar size (in px)
			if ( is_numeric( $arg ) ) {
				$filters['num_words'] = $arg;
			}

			// Add context to the archive title
			elseif ( $arg == 'context' || $arg == 'prefix' ) {
				$filters['add_context'] = true;
			}

			// Output as image tag
			elseif ( $arg == 'image' ) {
				$filters['image'] = true;
			}

			// Wrap value in a link
			elseif ( $arg == 'link' ) {
				$filters['link'] = true;
			}

			// Open link in newTab
			elseif ( $arg == 'newTab' ) {
				$filters['newTab'] = true;
			}

			// Create a callable link
			elseif ( $arg == 'tel' ) {
				$filters['tel'] = true;
			}

			/**
			 * Return value instead of label
			 *
			 * Useful for dynamic data element conditions like MB checkbox_list, ACF true_false, etc. where the user can specify the value & label.
			 *
			 * @since 1.5.7
			 */
			elseif ( $arg == 'value' ) {
				$filters['value'] = true;
			}

			/**
			 * Return raw value (skip parsing DD tag)
			 *
			 * Useful to skip rendering one specific DD tag
			 *
			 * @since 1.6
			 */
			elseif ( $arg == 'raw' ) {
				$filters['raw'] = true;
			}

			/**
			 * Return URL
			 *
			 * Useful for field type 'file'
			 *
			 * NOTE: Undocumented
			 *
			 * @since 1.6
			 */
			elseif ( $arg == 'url' ) {
				$filters['url'] = true;
			}

			/**
			 * Keep formatting
			 *
			 * Useful for dynamic data with HTML
			 *
			 * Example: {post_excerpt:format}
			 *
			 * @since 1.6.2
			 */
			elseif ( $arg == 'format' ) {
				$filters['format'] = true;
			}

			/**
			 * Return plain text
			 *
			 * Strip HTML tags
			 *
			 * Example: {post_terms_category:plain}
			 *
			 * @since 1.7.2
			 */
			elseif ( $arg == 'plain' ) {
				$filters['plain'] = true;
			}

			/**
			 * Return array value
			 *
			 * Useful for dynamic data with array
			 *
			 * Example : {acf_link_field:array_value|title}
			 *
			 * @since 1.8
			 */
			elseif ( strpos( $arg, 'array_value|' ) === 0 ) {
				$filters['array_value'] = str_replace( 'array_value|', '', $arg );
			}

			// Default key: used for 1) user meta_key, 2) post terms separator or 3) image size, 4) date format
			else {
				$filters['meta_key'][] = $arg;
			}
		}

		// Note: Use case where the date format contains a colon. E.g. "{post_date:jS F Y h:ia}"
		if ( isset( $filters['meta_key'] ) ) {
			$filters['meta_key'] = implode( ':', $filters['meta_key'] );
		}

		return $filters;
	}
}
