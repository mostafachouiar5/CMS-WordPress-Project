<?php


namespace SureCart\WordPress\Templates;

/**
 * The template service.
 */
class TemplatesService {
	/**
	 * The service container.
	 *
	 * @var array
	 */
	private $container;

	/**
	 * The template file/name associations.
	 *
	 * @var array
	 */
	private $templates = [];

	/**
	 * The post type for the templates.
	 *
	 * @var string
	 */
	private $post_type = '';

	/**
	 * SureCart plugin slug
	 *
	 * This is used to save templates to the DB which are stored against this value in the wp_terms table.
	 *
	 * @var string
	 */
	const PLUGIN_SLUG = 'surecart/surecart';

	/**
	 * Get things going.
	 *
	 * @param array  $container The service container.
	 * @param array  $templates The template file/name associations.
	 * @param string $post_type The post type for the templates.
	 */
	public function __construct( $container, $templates, $post_type ) {
		$this->container = $container;
		$this->templates = $templates;
		$this->post_type = $post_type;
	}

	/**
	 * Bootstrap actions and filters.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_filter( 'theme_' . $this->post_type . '_templates', [ $this, 'addTemplates' ] );
		add_filter( 'template_include', [ $this, 'includeTemplate' ], 9 );
		add_filter( 'template_include', [ $this, 'fixFSEDashboardTemplate' ] );
		add_filter( 'body_class', [ $this, 'bodyClass' ] );
		add_action( 'init', [ $this, 'registerMeta' ] );
	}

	/**
	 * Fix the dashboard template.
	 *
	 * @param string $template The template.
	 * @return string
	 */
	public function fixFSEDashboardTemplate( $template ) {
		if ( ! empty( get_the_ID() ) ) {
			$saved_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
			if ( strpos( $saved_template, 'template-surecart-dashboard' ) !== false ) {
				return plugin_dir_path( SURECART_PLUGIN_FILE ) . 'templates/pages/template-surecart-dashboard.php';
			}
		}
		return $template;
	}

	/**
	 * Add surecart_current_product to list of query vars.
	 *
	 * @param array $vars The query vars.
	 * @return array
	 */
	public function addCurrentProductQueryVar( $vars ) {
		$vars[] = 'surecart_current_product';
		return $vars;
	}

	/**
	 * Register any template meta we need.
	 */
	public function registerMeta() {
		register_meta(
			'post',
			'_surecart_dashboard_logo_width',
			[
				'auth_callback' => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
					return current_user_can( 'edit_post', $object_id );
				},
				'default'       => '180px',
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'string',
			]
		);

		foreach ( [
			'show_logo',
			'navigation_orders',
			'navigation_invoices',
			'navigation_subscriptions',
			'navigation_downloads',
			'navigation_billing',
			'navigation_account',
		] as $toggle ) {
			register_meta(
				'post',
				'_surecart_dashboard_' . $toggle,
				[
					'auth_callback' => function ( $allowed, $meta_key, $object_id, $user_id, $cap, $caps ) {
						return current_user_can( 'edit_post', $object_id );
					},
					'default'       => true,
					'show_in_rest'  => true,
					'single'        => true,
					'type'          => 'boolean',
				]
			);
		}
	}

	/**
	 * Is one of our templates active?
	 *
	 * @return boolean
	 */
	public function isTemplateActive() {
		$template = get_page_template_slug();
		return false !== $template && array_key_exists( $template, $this->templates );
	}

	/**
	 * Add the templates. to the existing templates.
	 *
	 * @param array $posts_templates Existing templates.
	 *
	 * @return array
	 */
	public function addTemplates( $posts_templates ) {
		return array_merge( $posts_templates, $this->templates );
	}

	/**
	 * Include the template if it is set.
	 *
	 * @param string $template Template url.
	 *
	 * @return string
	 */
	public function includeTemplate( $template ) {
		global $post;
		$id = $post->ID ?? null;

		if ( ! is_singular( $this->post_type ) ) {
			return $template;
		}

		if ( wp_is_block_theme() ) {
			return $template;
		}

		// check for product and use the template id.
		$product = get_query_var( 'surecart_current_product' );

		if ( ! empty( $product->metadata->wp_template_id ) ) {
			$page_template = $product->metadata->wp_template_id;
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

	/**
	 * Add to the body class if it's our template.
	 *
	 * @param array $body_class Array of body class names.
	 *
	 * @return array
	 */
	public function bodyClass( $body_class ) {
		$template = get_page_template_slug();

		if ( false !== $template && $this->isTemplateActive() ) {
			$body_class[] = 'surecart-template';
			$body_class[] = 'surecart-template-' . get_template();
		}

		return $body_class;
	}
}
