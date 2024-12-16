<?php

namespace SureCart\WordPress\Taxonomies;

/**
 * Form post type service class.
 */
class StoreTaxonomyService {
	/**
	 * The post type slug.
	 *
	 * @var string
	 */
	protected $slug = 'sc_account';

	/**
	 * Bootstrap service.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'init', [ $this, 'register' ] );
	}

	/**
	 * Register the taxonomy
	 *
	 * @return void
	 */
	public function register() {
		register_taxonomy(
			$this->slug,
			[ 'sc_product' ],
			[
				'public'            => false,
				'hierarchical'      => false,
				'labels'            => array(
					'name'          => __( 'Store', 'surecart' ),
					'singular_name' => __( 'Store', 'surecart' ),
				),
				'query_var'         => false,
				'rewrite'           => false,
				'show_ui'           => false,
				'show_in_nav_menus' => false,
				'show_in_rest'      => false,
				'show_admin_column' => true,
			]
		);
	}
}
