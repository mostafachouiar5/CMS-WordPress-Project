<?php
namespace SureCart\Integrations\Elementor\Documents;

use \ElementorPro\Modules\ThemeBuilder\Documents\Single_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Elementor page library document.
 *
 * Elementor page library document handler class is responsible for
 * handling a document of a page type.
 *
 * @since 2.0.0
 */
class ProductDocument extends Single_Base {

	/**
	 * Get document properties.
	 *
	 * Retrieve the document properties.
	 *
	 * @return array Document properties.
	 */
	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['location']       = 'single';
		$properties['condition_type'] = 'surecart';

		return $properties;
	}


	/**
	 * Get document name.
	 *
	 * @return string Document name.
	 */
	public static function get_type() {
		return 'surecart-product';
	}

	/**
	 * Get document title.
	 *
	 * @return string Document title.
	 */
	public static function get_title() {
		return esc_html__( 'SureCart Product', 'surecart' );
	}

	/**
	 * Get document plural title.
	 *
	 * @return string Document plural title.
	 */
	public static function get_plural_title() {
		return esc_html__( 'SureCart Products', 'surecart' );
	}

	/**
	 * Get document icon.
	 *
	 * @return string Document icon.
	 */
	protected static function get_site_editor_icon() {
		return 'eicon-single-product';
	}

	/**
	 * Get document tooltip data.
	 *
	 * Retrieve the document tooltip data.
	 *
	 * @return array Document tooltip data.
	 */
	protected static function get_site_editor_tooltip_data() {
		return [
			'title'     => esc_html__( 'What is a Single Product Template?', 'surecart' ),
			'content'   => esc_html__( 'A single product template allows you to easily design the layout and style of SureCart single product pages, and apply that template to various conditions that you assign.', 'surecart' ),
			'tip'       => esc_html__( 'You can create multiple single product templates, and assign each to different types of products, enabling a custom design for each group of similar products.', 'surecart' ),
			'docs'      => 'https://go.elementor.com/app-theme-builder-product',
			'video_url' => 'https://www.youtube.com/embed/PjhoB1RWkBM',
		];
	}
}
