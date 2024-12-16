<?php

namespace SureCart\Support\Blocks;

/**
 * The block templates service.
 */
class TemplateUtilityService {
	/**
	 * Holds the path for the directory where the block templates will be kept.
	 *
	 * @var string
	 */
	private $templates_directory;

	/**
	 * Holds the path for the directory where the block template parts will be kept.
	 *
	 * @var string
	 */
	private $template_parts_directory;

	/**
	 * The product template types.
	 *
	 * @var array
	 */
	private $plugin_template_types;

	/**
	 * SureCart plugin slug
	 *
	 * This is used to save templates to the DB which are stored against this value in the wp_terms table.
	 *
	 * @var string
	 */
	const PLUGIN_SLUG = 'surecart/surecart';

	/**
	 * Set the directories where the block templates will be kept.
	 *
	 * @param string $templates_directory      The path for the directory where the block templates will be kept.
	 * @param string $template_parts_directory The path for the directory where the block template parts will be kept.
	 */
	public function __construct( $templates_directory, $template_parts_directory ) {
		$this->templates_directory      = $templates_directory;
		$this->template_parts_directory = $template_parts_directory;
		$this->plugin_template_types    = array(
			'single-sc_product'       => array(
				'title'       => class_exists( 'WooCommerce' ) ? _x( 'SureCart Products', 'Template name', 'surecart' ) : _x( 'Products', 'Template name', 'surecart' ),
				'description' => __( 'Display all individual products unless a custom template has been applied.', 'surecart' ),
				'post_types'  => array( 'sc_product' ),
			),
			'product-info'            => array(
				'title'       => class_exists( 'WooCommerce' ) ? _x( 'SureCart Products', 'Template name', 'surecart' ) : _x( 'Products', 'Template name', 'surecart' ),
				'description' => __( 'Display all individual products content unless a custom template has been applied.', 'surecart' ),
				'site-editor' => false,
				'post_types'  => array( 'sc_product' ),
			),
			'single-upsell'           => array(
				'title'       => _x( 'Upsells', 'Template name', 'surecart' ),
				'description' => __( 'Display all individual upsells unless a custom template has been applied.', 'surecart' ),
				'post_types'  => array( 'sc_upsell' ),
			),
			'upsell-info'             => array(
				'title'       => _x( 'Upsells', 'Template name', 'surecart' ),
				'description' => __( 'Display all individual upsells content unless a custom template has been applied.', 'surecart' ),
				'site-editor' => false,
				'post_types'  => array( 'sc_upsell' ),
			),
			'taxonomy-sc_collection'  => array(
				'title'       => class_exists( 'WooCommerce' ) ? _x( 'SureCart Product Collections', 'Template name', 'surecart' ) : _x( 'Product Collections', 'Template name', 'surecart' ),
				'description' => __( 'Display all individual product collections unless a custom template has been applied.', 'surecart' ),
			),
			'product-collection-part' => array(
				'title'       => class_exists( 'WooCommerce' ) ? _x( 'SureCart Product Collections', 'Template name', 'surecart' ) : _x( 'Product Collections', 'Template name', 'surecart' ),
				'description' => __( 'Display all individual product collections content unless a custom template has been applied.', 'surecart' ),
				'site-editor' => false,
			),
			'cart'                    => array(
				'title'       => class_exists( 'WooCommerce' ) ? _x( 'SureCart Cart', 'Template name', 'surecart' ) : _x( 'Cart', 'Template name', 'surecart' ),
				'description' => __( 'The slide-out cart template.', 'surecart' ),
			),
			'checkout'                => array(
				'title'       => class_exists( 'WooCommerce' ) ? _x( 'SureCart Checkout', 'Template name', 'surecart' ) : _x( 'Checkout', 'Template name', 'surecart' ),
				'description' => __( 'Display the checkout content unless a custom template has been applied.', 'surecart' ),
			),
		);
	}

	/**
	 * Gets the first matching template part within themes directories
	 *
	 * Since [Gutenberg 12.1.0](https://github.com/WordPress/gutenberg/releases/tag/v12.1.0), the conventions for
	 * block templates and parts directory has changed from `block-templates` and `block-templates-parts`
	 * to `templates` and `parts` respectively.
	 *
	 * This function traverses all possible combinations of directory paths where a template or part
	 * could be located and returns the first one which is readable, prioritizing the new convention
	 * over the deprecated one, but maintaining that one for backwards compatibility.
	 *
	 * @param string $template_slug  The slug of the template (i.e. without the file extension).
	 * @param string $template_type  Either `wp_template` or `wp_template_part`.
	 *
	 * @return string|null  The matched path or `null` if no match was found.
	 */
	public function getThemeTemplatePath( $template_slug, $template_type = 'wp_template' ) {
		$template_filename = $template_slug . '.html';
		$templates_dir     = 'wp_template' === $template_type ? 'templates' : 'parts';

		$filepath = DIRECTORY_SEPARATOR . $templates_dir . DIRECTORY_SEPARATOR . $template_filename;

		$possible_paths = array(
			get_stylesheet_directory() . $filepath,
			get_template_directory() . $filepath,
		);

		// Return the first matching.
		foreach ( $possible_paths as $path ) {
			if ( is_readable( $path ) ) {
				return $path;
			}
		}

		return null;
	}

	/**
	 * Gets the directory where templates of a specific template type can be found.
	 *
	 * @param string $template_type wp_template or wp_template_part.
	 *
	 * @return string
	 */
	public function getTemplatesDirectory( $template_type = 'wp_template' ) {
		return 'wp_template_part' === $template_type ? $this->template_parts_directory : $this->templates_directory;
	}

	/**
	 * Finds all nested template part file paths in a theme's directory.
	 *
	 * @param string $base_directory The theme's file path.
	 * @return array $path_list A list of paths to all template part files.
	 */
	public function getTemplatePaths( $base_directory ) {
		$path_list = array();
		if ( file_exists( $base_directory ) ) {
			$nested_files      = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $base_directory ) );
			$nested_html_files = new \RegexIterator( $nested_files, '/^.+\.html$/i', \RecursiveRegexIterator::GET_MATCH );
			foreach ( $nested_html_files as $path => $file ) {
				$path_list[] = $path;
			}
		}
		return $path_list;
	}

	/**
	 * Converts template paths into a slug
	 *
	 * @param string $path The template's path.
	 * @return string slug
	 */
	public function generateTemplateSlugFromPath( $path ) {
		return basename( $path, '.html' );
	}

	/**
	 * Check if the theme has a template. So we know if to load our own in or not.
	 *
	 * @param string $template_name name of the template file without .html extension e.g. 'single-product'.
	 * @return boolean
	 */
	public function themeHasTemplate( $template_name ) {
		return (bool) $this->getThemeTemplatePath( $template_name, 'wp_template' );
	}

	/**
	 * Check if the theme has a template. So we know if to load our own in or not.
	 *
	 * @param string $template_name name of the template file without .html extension e.g. 'single-product'.
	 * @return boolean
	 */
	public function themeHasTemplatePart( $template_name ) {
		return (bool) $this->getThemeTemplatePath( $template_name, 'wp_template_part' );
	}

	/**
	 * Is this a FSE theme?
	 *
	 * @return boolean
	 */
	public function isFSETheme() {
		if ( function_exists( 'wp_is_block_theme' ) ) {
			return (bool) \wp_is_block_theme();
		}
		if ( function_exists( 'gutenberg_is_fse_theme' ) ) {
			return (bool) \gutenberg_is_fse_theme();
		}
		return false;
	}

	/**
	 * Does this theme support block templates?
	 *
	 * @return boolean
	 */
	public function supportsBlockTemplates() {
		return $this->isFSETheme() || ( function_exists( 'gutenberg_supports_block_templates' ) && \gutenberg_supports_block_templates() );
	}


	/**
	 * Build a unified template object based a post Object.
	 * Important: This method is an almost identical duplicate from wp-includes/block-template-utils.php as it was not intended for public use. It has been modified to build templates from plugins rather than themes.
	 *
	 * @param \WP_Post $post Template post.
	 *
	 * @return \WP_Block_Template|\WP_Error Template.
	 */
	public function buildTemplateResultsFromPost( $post ) {
		$terms = get_the_terms( $post, 'wp_theme' );

		if ( is_wp_error( $terms ) ) {
			return $terms;
		}

		if ( ! $terms ) {
			return new \WP_Error( 'template_missing_theme', __( 'No theme is defined for this template.', 'surecart' ) );
		}

		$theme          = $terms[0]->name;
		$has_theme_file = true;

		$template                 = new \WP_Block_Template();
		$template->wp_id          = $post->ID;
		$template->id             = $theme . '//' . $post->post_name;
		$template->theme          = $theme;
		$template->content        = $post->post_content;
		$template->slug           = $post->post_name;
		$template->source         = 'custom';
		$template->type           = $post->post_type;
		$template->description    = $post->post_excerpt;
		$template->title          = $post->post_title;
		$template->status         = $post->post_status;
		$template->has_theme_file = $has_theme_file;
		$template->is_custom      = true;
		$template->post_types     = array(); // don't appear in edit posts dropdown.

		// this is a customized version of the template.
		if ( ! empty( $this->plugin_template_types[ $post->post_name ]['post_types'] ) ) {
			$template->post_types = $this->plugin_template_types[ $post->post_name ]['post_types'];
		}

		if ( 'wp_template_part' === $post->post_type ) {
			$type_terms = get_the_terms( $post, 'wp_template_part_area' );
			if ( ! is_wp_error( $type_terms ) && false !== $type_terms ) {
				$template->area = $type_terms[0]->name;
			}
		}

		if ( 'surecart/surecart' === $theme ) {
			$template->origin = 'plugin';
		}

		return $template;
	}

	/**
	 * Returns an array containing the references of
	 * the passed blocks and their inner blocks.
	 *
	 * @param array $blocks array of blocks.
	 *
	 * @return array block references to the passed blocks and their inner blocks.
	 */
	public function flattenBlocks( &$blocks ) {
		$all_blocks = array();
		$queue      = array();
		foreach ( $blocks as &$block ) {
			$queue[] = &$block;
		}
		$queue_count = count( $queue );

		while ( $queue_count > 0 ) {
			$block = &$queue[0];
			array_shift( $queue );
			$all_blocks[] = &$block;

			if ( ! empty( $block['innerBlocks'] ) ) {
				foreach ( $block['innerBlocks'] as &$inner_block ) {
					$queue[] = &$inner_block;
				}
			}

			$queue_count = count( $queue );
		}

		return $all_blocks;
	}

	/**
	 * Parses wp_template content and injects the current theme's
	 * stylesheet as a theme attribute into each wp_template_part
	 *
	 * @param string $template_content serialized wp_template content.
	 *
	 * @return string Updated wp_template content.
	 */
	public function injectThemeAttributeInContent( $template_content ) {
		$has_updated_content = false;
		$new_content         = '';
		$template_blocks     = parse_blocks( $template_content );

		$blocks = $this->flattenBlocks( $template_blocks );
		foreach ( $blocks as &$block ) {
			if (
				'core/template-part' === $block['blockName'] &&
				! isset( $block['attrs']['theme'] )
			) {
				$block['attrs']['theme'] = wp_get_theme()->get_stylesheet();
				$has_updated_content     = true;
			}
		}

		if ( $has_updated_content ) {
			foreach ( $template_blocks as &$block ) {
				$new_content .= serialize_block( $block );
			}

			return $new_content;
		}

		return $template_content;
	}

	/**
	 * Build a unified template object based on a theme file.
	 * Important: This method is an almost identical duplicate from wp-includes/block-template-utils.php as it was not intended for public use. It has been modified to build templates from plugins rather than themes.
	 *
	 * @param array|object $template_file Theme file.
	 * @param string       $template_type wp_template or wp_template_part.
	 *
	 * @return \WP_Block_Template Template.
	 */
	public function buildTemplateResultFromFile( $template_file, $template_type ) {
		$default_template_types = get_default_block_template_types();
		$template_file          = (object) $template_file;

		// If the theme has an archive-products.html template but does not have product taxonomy templates
		// then we will load in the archive-product.html template from the theme to use for product taxonomies on the frontend.
		$template_is_from_theme = 'theme' === $template_file->source;
		$theme_name             = wp_get_theme()->get( 'TextDomain' );

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$template_content  = file_get_contents( $template_file->path );
		$template          = new \WP_Block_Template();
		$template->id      = $template_is_from_theme ? $theme_name . '//' . $template_file->slug : self::PLUGIN_SLUG . '//' . $template_file->slug;
		$template->theme   = $template_is_from_theme ? $theme_name : self::PLUGIN_SLUG;
		$template->content = $this->injectThemeAttributeInContent( $template_content );
		// Plugin was agreed as a valid source value despite existing inline docs at the time of creating: https://github.com/WordPress/gutenberg/issues/36597#issuecomment-976232909.
		$template->source         = $template_file->source ? $template_file->source : 'plugin';
		$template->slug           = $template_file->slug;
		$template->type           = $template_type;
		$template->title          = ! empty( $template_file->title ) ? $template_file->title : $this->getBlockTemplateTitle( $template_file->slug );
		$template->description    = ! empty( $template_file->description ) ? $template_file->description : $this->getBlockTemplateDescription( $template_file->slug );
		$template->status         = 'publish';
		$template->has_theme_file = true;
		$template->origin         = $template_file->source;
		$template->is_custom      = false; // Templates loaded from the filesystem aren't custom, ones that have been edited and loaded from the DB are.
		$template->post_types     = $template_file->post_types ?? array(); // Set the post type.
		$template->area           = 'uncategorized';

		if ( 'wp_template' === $template_type && isset( $default_template_types[ $template_file->slug ] ) ) {
			$template->is_custom = false;
		}

		return $template;
	}

	/**
	 * Returns template titles.
	 *
	 * @param string $template_slug The templates slug (e.g. single-product).
	 * @return string Human friendly title.
	 */
	public function getBlockTemplateTitle( $template_slug ) {
		if ( isset( $this->plugin_template_types[ $template_slug ] ) ) {
			return $this->plugin_template_types[ $template_slug ]['title'];
		}
		// Human friendly title converted from the slug.
		return ucwords( preg_replace( '/[\-_]/', ' ', $template_slug ) );
	}

	/**
	 * Returns template descriptions.
	 *
	 * @param string $template_slug The templates slug (e.g. single-product).
	 * @return string Template description.
	 */
	public function getBlockTemplateDescription( $template_slug ) {
		if ( isset( $this->plugin_template_types[ $template_slug ] ) ) {
			return $this->plugin_template_types[ $template_slug ]['description'];
		}
		return '';
	}

	/**
	 * Returns whether a block template is available in the site editor.
	 *
	 * @param string $template_slug The templates slug (e.g. single-product).
	 *
	 * @return boolean
	 */
	public function isBlockAvailableInSiteEditor( $template_slug ) {
		if ( isset( $this->plugin_template_types[ $template_slug ] ) ) {
			return ! isset( $this->plugin_template_types[ $template_slug ]['site-editor'] ) || $this->plugin_template_types[ $template_slug ]['site-editor'];
		}
		return true;
	}

	/**
	 * Build a new template object so that we can make SureCart Blocks default templates available in the current theme should they not have any.
	 *
	 * @param string $template_file Block template file path.
	 * @param string $template_type wp_template or wp_template_part.
	 * @param string $template_slug Block template slug e.g. single-product.
	 * @param bool   $template_is_from_theme If the block template file is being loaded from the current theme instead of SureCart Blocks.
	 *
	 * @return object Block template object.
	 */
	public function createNewBlockTemplateObject( $template_file, $template_type, $template_slug, $template_is_from_theme = false ) {
		$theme_name = wp_get_theme()->get( 'TextDomain' );

		$new_template_item = array(
			'slug'        => $template_slug,
			'id'          => $template_is_from_theme ? $theme_name . '//' . $template_slug : self::PLUGIN_SLUG . '//' . $template_slug,
			'path'        => $template_file,
			'type'        => $template_type,
			'theme'       => $template_is_from_theme ? $theme_name : self::PLUGIN_SLUG,
			// Plugin was agreed as a valid source value despite existing inline docs at the time of creating: https://github.com/WordPress/gutenberg/issues/36597#issuecomment-976232909.
			'source'      => $template_is_from_theme ? 'theme' : 'plugin',
			'title'       => $this->getBlockTemplateTitle( $template_slug ),
			'description' => $this->getBlockTemplateDescription( $template_slug ),
		);

		return (object) $new_template_item;
	}

	/**
	 * Removes templates that were added to a theme's block-templates directory, but already had a customised version saved in the database.
	 *
	 * @param \WP_Block_Template[]|\stdClass[] $templates List of templates to run the filter on.
	 *
	 * @return array List of templates with duplicates removed. The customised alternative is preferred over the theme default.
	 */
	public static function removeThemeTemplatesWithCustomAlternative( $templates ) {

		// Get the slugs of all templates that have been customised and saved in the database.
		$customised_template_slugs = array_map(
			function ( $template ) {
				return $template->slug;
			},
			array_values(
				array_filter(
					$templates,
					function ( $template ) {
						// This template has been customised and saved as a post.
						return 'custom' === $template->source;
					}
				)
			)
		);

		// Remove theme (i.e. filesystem) templates that have the same slug as a customised one. We don't need to check
		// for `woocommerce` in $template->source here because woocommerce templates won't have been added to $templates
		// if a saved version was found in the db. This only affects saved templates that were saved BEFORE a theme
		// template with the same slug was added.
		return array_values(
			array_filter(
				$templates,
				function ( $template ) use ( $customised_template_slugs ) {
					// This template has been customised and saved as a post, so return it.
					return ! ( 'theme' === $template->source && in_array( $template->slug, $customised_template_slugs, true ) );
				}
			)
		);
	}

	/**
	 * Returns whether the passed `$template` has a title, and it's different from the slug.
	 *
	 * @param object $template The template object.
	 * @return boolean
	 */
	public function templateHasTitle( $template ) {
		return ! empty( $template->title ) && $template->title !== $template->slug;
	}
}
