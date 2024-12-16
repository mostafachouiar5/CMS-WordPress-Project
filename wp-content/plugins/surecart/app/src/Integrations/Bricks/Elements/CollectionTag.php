<?php

namespace SureCart\Integrations\Bricks\Elements;

use SureCart\Integrations\Bricks\Concerns\ConvertsBlocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Collection Tag element.
 */
class CollectionTag extends \Bricks\Element {
	use ConvertsBlocks; // we have to use a trait since we can't extend the surecart class.

	/**
	 * Element name.
	 *
	 * @var string
	 */
	public $name = 'surecart-product-collection-tag';

	/**
	 * Element block name.
	 *
	 * @var string
	 */
	public $block_name = 'surecart/product-collection-tag';

	/**
	 * Element icon
	 *
	 * @var string
	 */
	public $icon = 'ion-md-pricetag';

	/**
	 * The constructor.
	 *
	 * @param array $element Element data.
	 *
	 * @return void
	 */
	public function __construct( $element = null ) {
		$element['settings']['_width'] = 'max-content';
		parent::__construct( $element );
	}

	/**
	 * Get element label
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Collection Tag', 'surecart' );
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render() {
		if ( $this->is_admin_editor() ) {
			$product     = sc_get_product();
			$collections = $product->product_collections->data ?? [];
			$collection  = $collections[0] ?? (object) [ 'name' => 'Collection Name' ];

			echo $this->preview( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$collection->name,
				'sc-tag sc-tag--default sc-tag--medium wp-block-surecart-product-collection-tag',
				'span'
			);

			return;
		}

		echo $this->raw(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
