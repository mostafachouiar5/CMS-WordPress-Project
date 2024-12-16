<?php

namespace SureCart\Controllers\Admin\ProductCollections;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Product Collection Scripts
 */
class ProductCollectionsScriptsController extends AdminModelEditController {
	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/product_collections';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/product-collections';

	/**
	 * Add the api url to the data.
	 */
	public function __construct() {
		$this->data['api_url'] = \SureCart::requests()->getBaseUrl();
	}

	/**
	 * Enqueue the scripts.
	 *
	 * @return void
	 */
	public function enqueue(): void {
		$available_templates              = wp_get_theme()->get_page_templates( null, 'sc_collection' );
		$available_templates              = array_merge(
			$available_templates,
			[
				apply_filters( 'default_page_template_title', __( 'Theme Layout', 'surecart' ), 'rest-api' ),
			]
		);
		$this->data['availableTemplates'] = $available_templates;
		parent::enqueue();
	}
}
