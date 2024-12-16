<?php

namespace SureCartBlocks\Blocks\Form;

use SureCart\Models\ManualPaymentMethod;
use SureCart\Models\Processor;
use SureCartBlocks\Blocks\BaseBlock;

/**
 * Checkout block
 */
class Block extends BaseBlock {
	/**
	 * Get the style for the block
	 *
	 * @param  array $attributes Block attributes.
	 * @return string
	 */
	public function getStyle( $attributes ) {
		$style  = 'text-align: left;';
		$style .= '--sc-form-row-spacing: ' . ( $attributes['gap'] ?? '25' ) . ';';
		if ( ! empty( $attributes['color'] ) ) {
			$style .= '--sc-color-primary-500: ' . sanitize_hex_color( $attributes['color'] ) . ';';
			$style .= '--sc-focus-ring-color-primary: ' . sanitize_hex_color( $attributes['color'] ) . ';';
			$style .= '--sc-input-border-color-focus: ' . sanitize_hex_color( $attributes['color'] ) . ';';
		}
		return $style;
	}

	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		global $sc_form_id;
		$post = get_post( $sc_form_id );
		$user = wp_get_current_user();

		$processors = Processor::get();
		if ( is_wp_error( $processors ) ) {
			$processors = [];
		}

		// set the initial state.
		sc_initial_state(
			array_filter(
				[
					'checkout'   => [
						'formId'                   => $attributes['form_id'] ?? $sc_form_id,
						'mode'                     => apply_filters( 'surecart/payments/mode', $attributes['mode'] ?? 'live' ),
						'product'                  => $attributes['product'] ?? [],
						'currencyCode'             => $attributes['currency'] ?? \SureCart::account()->currency,
						'groupId'                  => 'sc-checkout-' . ( $attributes['form_id'] ?? $sc_form_id ),
						'abandonedCheckoutEnabled' => ! is_admin(),
						'taxProtocol'              => \SureCart::account()->tax_protocol,
						'isCheckoutPage'           => true,
						'validateStock'            => ! is_admin(),
						'persist'                  => $this->getPeristance( $attributes, $attributes['form_id'] ?? $sc_form_id ),
					],
					'processors' => [
						'processors'           => array_values(
							array_filter(
								$processors ?? [],
								function( $processor ) {
									return $processor->approved && $processor->enabled;
								}
							)
						),
						'manualPaymentMethods' => (array) ManualPaymentMethod::where( [ 'archived' => false ] )->get() ?? [],
						'config'               => [
							'stripe' => [
								'paymentElement' => (bool) get_option( 'sc_stripe_payment_element', true ),
							],
						],
					],
					'user'       => [
						'loggedIn' => is_user_logged_in(),
						'email'    => $user->user_email,
						'name'     => $user->display_name,
					],
					'form'       => array_filter(
						[
							'text' => array_filter(
								[
									'loading' => array_filter( $attributes['loading_text'] ?? [] ),
									'success' => array_filter( $attributes['success_text'] ?? [] ),
								]
							),
						]
					),
				]
			)
		);

		if ( ! empty( $attributes['prices'] ) ) {
			$line_items = $this->convertPricesToLineItems( $attributes['prices'] );
			sc_initial_state(
				[
					'checkout' => [
						'initialLineItems' => sc_initial_line_items( $line_items ),
					],
				]
			);
		}

		return \SureCart::block()->render(
			'blocks/form',
			[
				'align'            => $attributes['align'] ?? '',
				'modified'         => $post->post_modified_gmt ?? '',
				'honeypot_enabled' => (bool) get_option( 'surecart_honeypot_enabled', true ),
				'classes'          => $this->getClasses( $attributes ),
				'style'            => $this->getStyle( $attributes ),
				'content'          => $content,
				'id'               => 'sc-checkout-' . ( $attributes['form_id'] ?? $sc_form_id ),
				'success_url'      => ! empty( $attributes['success_url'] ) ? $attributes['success_url'] : \SureCart::pages()->url( 'order-confirmation' ),
			]
		);
	}

	/**
	 * Get persistent mode.
	 *
	 * @param  array $attributes Block attributes.
	 * @return string|false
	 */
	public function getPeristance( $attributes, $id = null ) {
		// don't persist in the admin.
		if ( is_admin() ) {
			return false;
		}

		// if there is a checkout id in the url, use url persistence.
		if ( ! empty( $_GET['checkout_id'] ) ) {
			return 'url';
		}

		// default checkout form should persist in the browser.
		if ( \SureCart::forms()->getDefaultId() === (int) $id ) {
			return 'browser';
		}

		// otherwise, use the attributes with url as the fallback.
		return $attributes['persist_cart'] ?? 'url';
	}

	/**
	 * Convert price blocks to line items
	 *
	 * @param array $prices Array of prices.
	 *
	 * @return array    Array of line items.
	 */
	public function convertPricesToLineItems( $prices ) {
		return array_values(
			array_map(
				function( $price ) {
					return array_filter(
						[
							'price'    => $price['id'],
							'variant'  => $price['variant_id'] ?? null,
							'quantity' => $price['quantity'] ?? 1,
						]
					);
				},
				$prices
			)
		);
	}
}
