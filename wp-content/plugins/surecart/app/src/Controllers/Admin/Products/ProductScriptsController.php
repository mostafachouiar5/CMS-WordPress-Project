<?php

namespace SureCart\Controllers\Admin\Products;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Product Page
 */
class ProductScriptsController extends AdminModelEditController {
	/**
	 * What types of data to add the the page.
	 *
	 * @var array
	 */
	protected $with_data = [ 'currency', 'supported_currencies', 'tax_protocol', 'checkout_page_url' ];

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/product';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/products';

	/**
	 * Add the app url to the data.
	 */
	public function __construct() {
		$this->data['api_url'] = \SureCart::requests()->getBaseUrl();
	}

	public function enqueue() {
		$available_templates              = wp_get_theme()->get_page_templates( null, 'sc_product' );
		$available_templates['']          = apply_filters( 'default_page_template_title', __( 'Theme Layout', 'surecart' ), 'rest-api' );
		$this->data['availableTemplates'] = $available_templates;
		$this->data['metaBoxLocations']   = \SureCart::metaboxes()->perLocation();
		$this->data['wpMetaBoxUrl']       = $this->getMetaBoxUrl();
		parent::enqueue();
	}

	/**
	 * Get the meta box url.
	 *
	 * @return string
	 */
	protected function getMetaBoxUrl() {
		global $post;
		$meta_box_url = admin_url( 'post.php' );
		$meta_box_url = add_query_arg(
			array(
				'post'                  => $post->ID ?? 0,
				'action'                => 'edit',
				'meta-box-loader'       => true,
				'meta-box-loader-nonce' => wp_create_nonce( 'meta-box-loader' ),
			),
			$meta_box_url
		);
		return $meta_box_url;
	}
}
