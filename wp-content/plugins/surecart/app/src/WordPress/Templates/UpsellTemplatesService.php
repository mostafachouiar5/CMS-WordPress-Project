<?php

declare(strict_types=1);

namespace SureCart\WordPress\Templates;

use SureCartVendors\Pimple\Container;

/**
 * The Upsell template service.
 */
class UpsellTemplatesService {
	/**
	 * The service container.
	 *
	 * @var Container $container
	 */
	private Container $container;

	/**
	 * The template file/name associations.
	 *
	 * @var array
	 */
	private array $templates = [];

	/**
	 * The post type for the templates.
	 *
	 * @var string
	 */
	private string $post_type = 'sc_upsell';

	/**
	 * SureCart plugin slug.
	 *
	 * This is used to save templates to the DB which are stored against this value in the wp_terms table.
	 *
	 * @var string
	 */
	const PLUGIN_SLUG = 'surecart/surecart';

	/**
	 * Get things going.
	 *
	 * @param array $container The service container.
	 * @param array $templates The template file/name associations.
	 */
	public function __construct( $container, $templates ) {
		$this->container = $container;
		$this->templates = $templates;
	}

	/**
	 * Bootstrap actions and filters.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_filter( 'theme_' . $this->post_type . '_templates', [ $this, 'addTemplates' ] );
		add_filter( 'template_include', [ $this, 'includeTemplate' ], 9 );

		// Upsell page query overrides.
		add_filter( 'posts_pre_query', [ $this, 'overrideUpsellPostQuery' ], 10, 2 );
		add_filter( 'query_vars', [ $this, 'addCurrentUpsellQueryVar' ] );
	}

	/**
	 * Add surecart_current_upsell to list of query vars.
	 *
	 * @param array $vars The query vars.
	 * @return array
	 */
	public function addCurrentUpsellQueryVar( array $vars ): array {
		$vars[] = 'surecart_current_upsell';
		return $vars;
	}

	/**
	 * Filters the posts array before the query takes place to return a product post.
	 * Return a non-null value to bypass WordPress' default post queries.
	 *
	 * Filtering functions that require pagination information are encouraged to set
	 * the `found_posts` and `max_num_pages` properties of the WP_Query object,
	 * passed to the filter by reference. If WP_Query does not perform a database
	 * query, it will not have enough information to generate these values itself.
	 *
	 * @param WP_Post[]|int[]|null $posts Return an array of post data to short-circuit WP's query,
	 *                                    or null to allow WP to run its normal queries.
	 * @param \WP_Query            $wp_query The WP_Query instance (passed by reference).
	 *
	 * @return WP_Post[]|null Array of post data, or null to allow WP to run its normal queries.
	 */
	public function overrideUpsellPostQuery( $posts, \WP_Query $wp_query ) {
		$upsell_id = isset( $wp_query->query['sc_upsell_id'] ) ? $wp_query->query['sc_upsell_id'] : null;
		if ( ! $upsell_id ) {
			return $posts;
		}

		$upsell = \SureCart\Models\Upsell::with( [ 'price' ] )->find( $upsell_id );
		if ( is_wp_error( $upsell ) ) {
			$wp_query->is_404 = true;
			return $posts;
		}

		set_query_var( 'surecart_current_upsell', $upsell );

		$product = \SureCart\Models\Product::with( [ 'prices', 'image', 'variants', 'variant_options' ] )->find( $upsell->price->product ?? '' );
		set_query_var( 'surecart_current_product', $product );
		$content = wp_is_block_theme() ? $upsell->template->content : $upsell->template_part->content;

		// create a fake post for the upsell.
		$post                    = new \stdClass();
		$post->post_title        = $product->name;
		$post->post_name         = $upsell->id;
		$post->post_content      = '<div>' . ( $content ?? '' ) . '</div>';
		$post->post_status       = 'publish';
		$post->post_type         = $this->post_type;
		$post->sc_id             = $upsell->id;
		$post->upsell            = $upsell;
		$post->product           = $product;
		$post->post_author       = 1;
		$post->post_parent       = 0;
		$post->comment_count     = 0;
		$post->comment_status    = 'closed';
		$post->ping_status       = 'closed';
		$post->post_password     = '';
		$post->post_excerpt      = '';
		$post->post_date         = ( new \DateTime( "@$upsell->created_at" ) )->setTimezone( new \DateTimeZone( wp_timezone_string() ) )->format( 'Y-m-d H:i:s' );
		$post->post_date_gmt     = date_i18n( 'Y-m-d H:i:s', $upsell->created_at, true );
		$post->post_modified     = ( new \DateTime( "@$upsell->updated_at" ) )->setTimezone( new \DateTimeZone( wp_timezone_string() ) )->format( 'Y-m-d H:i:s' );
		$post->post_modified_gmt = date_i18n( 'Y-m-d H:i:s', $upsell->updated_at, true );
		$post->ID                = 999999999;
		$posts                   = array( $post );

		$wp_query->found_posts       = 1;
		$wp_query->max_num_pages     = 1;
		$wp_query->is_singular       = true;
		$wp_query->is_single         = true;
		$wp_query->is_archive        = false;
		$wp_query->is_tax            = false;
		$wp_query->is_home           = false;
		$wp_query->is_search         = false;
		$wp_query->is_404            = false;
		$wp_query->queried_object    = $post;
		$wp_query->queried_object_id = $post->ID;

		return $posts;
	}

	/**
	 * Add the templates. to the existing templates.
	 *
	 * @param array $posts_templates Existing templates.
	 *
	 * @return array
	 */
	public function addTemplates( array $posts_templates ): array {
		return array_merge( $posts_templates, $this->templates );
	}

	/**
	 * Include the template if it is set.
	 *
	 * @param string $template Template url.
	 *
	 * @return string
	 */
	public function includeTemplate( string $template ): string {
		global $post;
		$id = $post->ID ?? null;

		// if block theme, short circuit and return template-canvas probably.
		if ( wp_is_block_theme() ) {
			return $template;
		}

		// check for upsell and use the template id.
		$upsell = get_query_var( 'surecart_current_upsell' );

		if ( empty( $upsell ) ) {
			return $template;
		}

		if ( ! empty( $upsell->metadata->wp_template_id ) ) {
			$page_template = $upsell->metadata->wp_template_id;
		} else {
			$page_template = get_post_meta( $id, '_wp_page_template', true );
		}

		// if the set template does not match one of these templates.
		if ( empty( $page_template ) || false === strpos( $page_template, '.php' ) ) {
			return $template;
		}

		$file = trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . '/templates/' . $page_template;

		// Return file if it exists.
		if ( file_exists( $file ) ) {
			return $file;
		}

		return $template;
	}
}
