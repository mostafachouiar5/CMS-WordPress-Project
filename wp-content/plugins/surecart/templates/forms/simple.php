<?php
/**
 * Donation form block pattern
 */
return [
	'title'      => __( 'Simple', 'surecart' ),
	'categories' => [ 'surecart_form' ],
	'blockTypes' => [ 'surecart/form' ],
	'content'    => '<!-- wp:surecart/price-selector {"label":"Choose A Plan"} -->
	<sc-price-choices label="Choose A Plan" type="radio" columns="1"><div><!-- wp:surecart/price-choice -->
		<sc-price-choice type="radio" show-label="1" show-price="1" show-control="1"></sc-price-choice>
		<!-- /wp:surecart/price-choice --></div></sc-price-choices>
		<!-- /wp:surecart/price-selector -->

		<!-- wp:surecart/email -->
		<sc-customer-email label="Email" autocomplete="email" inputmode="email" required class="wp-block-surecart-email"></sc-customer-email>
		<!-- /wp:surecart/email -->

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

		<!-- wp:surecart/submit {"full":true} -->
		<sc-order-submit type="primary" full="true" size="large" icon="lock" class="wp-block-surecart-submit">Purchase</sc-order-submit>
		<!-- /wp:surecart/submit -->
	',
];
