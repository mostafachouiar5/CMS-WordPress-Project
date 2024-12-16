<?php
namespace SureCart\Models;

/**
 * Buy link model
 */
class BuyLink {
	/**
	 * Product model
	 *
	 * @var \SureCart\Models\Product
	 */
	protected $product;

	/**
	 * Constructor
	 *
	 * @param \SureCart\Models\Product $product Product model.
	 */
	public function __construct( \SureCart\Models\Product $product ) {
		$this->product = $product;
	}

	/**
	 * The buy page url.
	 *
	 * @return void
	 */
	public function url() {
		return trailingslashit( get_home_url() ) . trailingslashit( \SureCart::settings()->permalinks()->getBase( 'buy_page' ) ) . $this->product->slug;
	}

	/**
	 * Is the buy link enabled.
	 *
	 * @return boolean
	 */
	public function isEnabled() {
		return 'true' === ( $this->product->metadata->wp_buy_link_enabled ?? '' );
	}

	/**
	 * Get the mode.
	 *
	 * @return string
	 */
	public function getMode() {
		return 'true' === ( $this->product->metadata->wp_buy_link_test_mode_enabled ?? '' ) ? 'test' : 'live';
	}

	/**
	 * Get the success url.
	 *
	 * @return string
	 */
	public function getSuccessUrl() {
		if ( 'true' !== ( $this->product->metadata->wp_buy_link_success_page_enabled ?? '' ) ) {
			return '';
		}
		return $this->product->metadata->wp_buy_link_success_page_url ?? '';
	}

	/**
	 * Should we show this item?
	 *
	 * @param string $item The name of the item.
	 *
	 * @return boolean
	 */
	public function templatePartEnabled( $item ) {
		switch ( $item ) {
			case 'image':
				return 'true' !== ( $this->product->metadata->wp_buy_link_product_image_disabled ?? '' );
			case 'description':
				return 'true' !== ( $this->product->metadata->wp_buy_link_product_description_disabled ?? '' );
			case 'coupon':
				return 'true' !== ( $this->product->metadata->wp_buy_link_coupon_field_disabled ?? '' );
			case 'logo':
				return 'true' !== ( $this->product->metadata->wp_buy_link_logo_disabled ?? '' );
			case 'terms':
				return 'true' !== ( $this->product->metadata->wp_buy_link_terms_disabled ?? '' );
		}
		return false;
	}

}
