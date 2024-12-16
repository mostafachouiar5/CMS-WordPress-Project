<?php
/**
 * Donation form block pattern
 */
return [
	'title'      => __( 'Sections', 'surecart' ),
	'categories' => [ 'surecart_form' ],
	'blockTypes' => [ 'surecart/form' ],
	'content'    => '<!-- wp:surecart/price-selector {"label":"Choose A Plan"} -->
	<sc-price-choices label="Choose A Plan" type="radio" columns="1"><div><!-- wp:surecart/price-choice {"price_id":"9182e0aa-95b4-41ff-adeb-477fae3400f7","label":"","quantity":1,"checked":true} -->
	<sc-price-choice price-id="9182e0aa-95b4-41ff-adeb-477fae3400f7" type="radio" label="" checked show-label="1" show-price="1" show-control="1" quantity="1"></sc-price-choice>
	<!-- /wp:surecart/price-choice --></div></sc-price-choices>
	<!-- /wp:surecart/price-selector -->

	<!-- wp:surecart/heading {"title":"Contact Information"} -->
	<sc-heading>Contact Information<span slot="description"></span><span slot="end"></span></sc-heading>
	<!-- /wp:surecart/heading -->

	<!-- wp:surecart/columns -->
	<sc-columns class="wp-block-surecart-columns"><!-- wp:surecart/column -->
	<sc-column class="wp-block-surecart-column"><!-- wp:surecart/name -->
	<sc-customer-name label="Name" class="wp-block-surecart-name"></sc-customer-name>
	<!-- /wp:surecart/name --></sc-column>
	<!-- /wp:surecart/column -->

	<!-- wp:surecart/column -->
	<sc-column class="wp-block-surecart-column"><!-- wp:surecart/email -->
	<sc-customer-email label="Email" autocomplete="email" inputmode="email" required class="wp-block-surecart-email"></sc-customer-email>
	<!-- /wp:surecart/email --></sc-column>
	<!-- /wp:surecart/column --></sc-columns>
	<!-- /wp:surecart/columns -->

	<!-- wp:spacer {"height":1} -->
	<div style="height:1px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:surecart/heading {"title":"Address"} -->
	<sc-heading>Address<span slot="description"></span><span slot="end"></span></sc-heading>
	<!-- /wp:surecart/heading -->

	<!-- wp:surecart/address {"label":""} -->
	<sc-order-shipping-address label=""></sc-order-shipping-address>
	<!-- /wp:surecart/address -->

	<!-- wp:spacer {"height":1} -->
	<div style="height:1px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:surecart/heading {"title":"Payment"} -->
	<sc-heading>Payment<span slot="description"></span><span slot="end"></span></sc-heading>
	<!-- /wp:surecart/heading -->

	<!-- wp:surecart/payment {"secure_notice":"This is a secure, encrypted payment","label":""} -->
	<sc-payment label="" secure-notice="This is a secure, encrypted payment" class="wp-block-surecart-payment"></sc-payment>
	<!-- /wp:surecart/payment -->

	<!-- wp:spacer {"height":1} -->
	<div style="height:1px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:surecart/heading {"title":"Totals"} -->
	<sc-heading>Totals<span slot="description"></span><span slot="end"></span></sc-heading>
	<!-- /wp:surecart/heading -->

	<!-- wp:surecart/totals -->
	<sc-order-summary class="wp-block-surecart-totals"><!-- wp:surecart/divider -->
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

	<!-- wp:surecart/submit {"show_total":true,"full":true} -->
	<sc-order-submit type="primary" full="true" size="large" icon="lock" show-total="true" class="wp-block-surecart-submit">Purchase</sc-order-submit>
	<!-- /wp:surecart/submit -->',
];
