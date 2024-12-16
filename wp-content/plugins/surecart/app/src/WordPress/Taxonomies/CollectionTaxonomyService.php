<?php

namespace SureCart\WordPress\Taxonomies;

/**
 * Form post type service class.
 */
class CollectionTaxonomyService {
	/**
	 * The post type slug.
	 *
	 * @var string
	 */
	protected $slug = 'sc_collection';

	/**
	 * Bootstrap service.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'init', array( $this, 'register' ) );
		add_filter( 'taxonomy_template', array( $this, 'template' ) );
		add_filter( 'get_edit_term_link', array( $this, 'updateEditLink' ), 10, 3 );
		add_filter( 'get_terms_args', array( $this, 'getTermsArgs' ), 10, 2 );
	}

	/**
	 * Always fetch taxonomy terms with sc_id metadata.
	 *
	 * @param array $args     The arguments.
	 * @param array $taxonomies The taxonomies.
	 *
	 * @return array
	 */
	public function getTermsArgs( $args, $taxonomies ) {
		global $pagenow;
		// allow if editing direction on admin.
		if ( is_admin() && 'edit-tags.php' === $pagenow ) {
			return $args;
		}

		if ( ! empty( \SureCart::account()->id ) && in_array( $this->slug, $taxonomies, true ) && empty( $args['suppress_filters'] ) ) {
			$args['meta_query'] = array(
				array(
					'key'   => 'sc_account',
					'value' => \SureCart::account()->id,
				),
			);
		}

		return $args;
	}

	/**
	 * Update the edit collection link to edit the collection directly.
	 *
	 * @param string  $link     The link.
	 * @param integer $term_id  The term ID.
	 * @param string  $taxonomy The taxonomy.
	 *
	 * @return string
	 */
	public function updateEditLink( $link, $term_id, $taxonomy ) {
		// only for our post type.
		if ( $taxonomy !== $this->slug ) {
			return $link;
		}

		$collection = sc_get_collection( $term_id );

		// if we have a collection, return the edit link.
		if ( ! empty( $collection ) ) {
			return \SureCart::getUrl()->edit( 'product_collection', $collection->id );
		}

		return $link;
	}

	/**
	 * Get the template for the taxonomy.
	 *
	 * @param string $template The template.
	 *
	 * @return string
	 */
	public function template( $template ) {
		// not our taxonomy.
		if ( ! is_tax( $this->slug ) ) {
			return $template;
		}

		$term       = get_queried_object();
		$collection = sc_get_collection( $term->term_id );

		if ( wp_is_block_theme() && ! empty( $collection->metadata->wp_template_id ) ) {
			global $_wp_current_template_id, $_wp_current_template_content;
			$_wp_current_template_id = $collection->metadata->wp_template_id;
			$block_template          = get_block_template( $collection->metadata->wp_template_id );
			if ( ! empty( $block_template ) ) {
				$_wp_current_template_content = $block_template->content ?? '';
			}
		}

		// the theme has provided a taxonomy template, or we are not on the collection taxonomy.
		if ( ! empty( $template ) || empty( $collection->metadata->wp_template_id ) || strpos( $collection->metadata->wp_template_id, '.php' ) === false ) {
			return $template;
		}

		// check if we are on the collection taxonomy.
		return untrailingslashit( plugin_dir_path( SURECART_PLUGIN_FILE ) ) . '/templates/pages/template-surecart-collection.php';
	}

	/**
	 * Register the taxonomy
	 *
	 * @return void
	 */
	public function register() {
		register_taxonomy(
			$this->slug,
			array( 'sc_product' ),
			array(
				'label'             => __( 'Collections', 'surecart' ),
				'labels'            => array(
					'name'              => _x( 'Collections', 'taxonomy general name', 'surecart' ),
					'singular_name'     => _x( 'Collection', 'taxonomy singular name', 'surecart' ),
					'search_items'      => __( 'Search Collections', 'surecart' ),
					'all_items'         => __( 'All Collections', 'surecart' ),
					'parent_item'       => __( 'parent Collection', 'surecart' ),
					'parent_item_colon' => __( 'parent Collection:', 'surecart' ),
					'edit_item'         => __( 'Edit Collection', 'surecart' ),
					'update_item'       => __( 'Update Collection', 'surecart' ),
					'add_new_item'      => __( 'Add New Collection', 'surecart' ),
					'new_item_name'     => __( 'New Collection Name', 'surecart' ),
					'menu_name'         => __( 'Collection', 'surecart' ),
				),
				'public'            => true,
				'show_in_rest'      => true,
				'hierarchical'      => false,
				'show_in_ui'        => true,
				'show_admin_column' => true,
				'rewrite'           => array(
					'slug'       => \SureCart::settings()->permalinks()->getBase( 'collection_page' ),
					'with_front' => false,
				),
			)
		);
	}
}
