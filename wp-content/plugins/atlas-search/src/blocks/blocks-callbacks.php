<?php

/**
 * This file registers facets blocks.
 *
 * @package    Wpe_Content_Engine
 */
class WPE_Atlas_Search_Facets_Callbacks {

	private $loader;
	public const SMART_SEARCH_BLOCKS_SUPPORT_ENABLED_OPTION = 'smart_search_blocks_support_enabled';

	public function __construct( \Wpe_Content_Engine_Loader $loader ) {
		$this->loader = $loader;
	}

	public function init() {
		$this->loader->add_action( 'init', $this, 'register_facet_blocks' );
		$this->loader->add_filter( 'block_categories_all', $this, 'register_block_categories', 10, 2 );
	}

	public function register_facet_blocks() {
		if ( ! get_option( self::SMART_SEARCH_BLOCKS_SUPPORT_ENABLED_OPTION, false ) ) {
			return;
		}

		$blocks = array(
			'search-facet',
			'dropdown-facet',
		);

		foreach ( $blocks as $block ) {
			// Go up two levels to the plugin root.
			$plugin_dir = plugin_dir_path( dirname( __FILE__, 2 ) );
			register_block_type( $plugin_dir . "build/{$block}" );
		}
	}
	/**
	 * Register block categories
	 *
	 * Used in combination with the `block_categories_all` filter, to append
	 * Smart Search Blocks related categories to the Gutenberg editor.
	 *
	 * @param array $categories The array of already registered categories.
	 */
	public function register_block_categories( $categories ) {
		$smart_search_block_categories = array(
			array(
				'slug'  => 'wpengine-smart-search',
				'title' => __( 'WP Engine Smart Search', 'wpengine-smart-search' ),
			),
		);
		return array_merge( $categories, $smart_search_block_categories );
	}
}
