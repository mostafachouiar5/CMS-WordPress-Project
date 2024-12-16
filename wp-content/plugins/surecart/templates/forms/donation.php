<?php
/**
 * Donation form block pattern
 */

// get account currency.
$currency = \SureCart::account()->currency ?? 'usd';

return [
	'title'      => __( 'Donation', 'surecart' ),
	'categories' => [ 'surecart_form' ],
	'blockTypes' => [ 'surecart/form' ],
	'content'    => '
				<!-- wp:surecart/product-donation -->
				<!-- wp:surecart/product-donation-amounts -->
				<!-- /wp:surecart/product-donation-amounts -->
				<!-- wp:surecart/product-donation-prices -->
				<!-- /wp:surecart/product-donation-prices -->
				<!-- /wp:surecart/product-donation -->

					<!-- wp:surecart/columns -->
					<sc-columns class="wp-block-surecart-columns"><!-- wp:surecart/column -->
					<sc-column class="wp-block-surecart-column"><!-- wp:surecart/email -->
					<sc-customer-email label="Email" autocomplete="email" inputmode="email" required class="wp-block-surecart-email"></sc-customer-email>
					<!-- /wp:surecart/email --></sc-column>
					<!-- /wp:surecart/column -->

					<!-- wp:surecart/column -->
					<sc-column class="wp-block-surecart-column"><!-- wp:surecart/name -->
					<sc-customer-name label="Name" class="wp-block-surecart-name"></sc-customer-name>
					<!-- /wp:surecart/name --></sc-column>
					<!-- /wp:surecart/column --></sc-columns>
					<!-- /wp:surecart/columns -->

					<!-- wp:surecart/payment {"secure_notice":"This is a secure, encrypted payment"} -->
					<sc-payment label="Payment" secure-notice="This is a secure, encrypted payment" class="wp-block-surecart-payment"></sc-payment>
					<!-- /wp:surecart/payment -->

					<!-- wp:surecart/totals {"collapsible":true,"collapsed":true} -->
					<sc-order-summary collapsible="1" collapsed="1" class="wp-block-surecart-totals"><!-- wp:surecart/divider -->
					<sc-divider></sc-divider>
					<!-- /wp:surecart/divider -->

					<!-- wp:surecart/line-items -->
					<sc-line-items removable="1" editable="1" class="wp-block-surecart-line-items"></sc-line-items>
					<!-- /wp:surecart/line-items -->

					<!-- wp:surecart/divider -->
					<sc-divider></sc-divider>
					<!-- /wp:surecart/divider -->

					<!-- wp:surecart/subtotal -->
					<sc-line-item-total total="subtotal" class="wp-block-surecart-subtotal"><span slot="description">Subtotal</span></sc-line-item-total>
					<!-- /wp:surecart/subtotal -->

					<!-- wp:surecart/trial-line-item /-->

					<!-- wp:surecart/coupon {"text":"Add Coupon Code","button_text":"Apply Coupon"} -->
					<sc-order-coupon-form label="Add Coupon Code">Apply Coupon</sc-order-coupon-form>
					<!-- /wp:surecart/coupon -->

					<!-- wp:surecart/tax-line-item -->
					<sc-line-item-tax class="wp-block-surecart-tax-line-item"></sc-line-item-tax>
					<!-- /wp:surecart/tax-line-item -->

					<!-- wp:surecart/divider -->
					<sc-divider></sc-divider>
					<!-- /wp:surecart/divider -->

					<!-- wp:surecart/total -->
					<sc-line-item-total total="total" size="large" show-currency="1" class="wp-block-surecart-total"><span slot="title">Total</span><span slot="subscription-title">Total Due Today</span></sc-line-item-total>
					<!-- /wp:surecart/total --></sc-order-summary>
					<!-- /wp:surecart/totals -->

					<!-- wp:surecart/submit {"text":"Donate","show_total":true,"full":true} -->
					<sc-order-submit type="primary" full="true" size="large" icon="lock" show-total="true" class="wp-block-surecart-submit">Donate</sc-order-submit>
					<!-- /wp:surecart/submit -->',
];
