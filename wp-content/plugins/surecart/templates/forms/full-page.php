<?php
/**
 * Donation form block pattern
 */
return [
	'title'      => __( 'Full Page', 'surecart' ),
	'categories' => [ 'surecart_form' ],
	'blockTypes' => [ 'surecart/form' ],
	'content'    => '<!-- wp:surecart/columns {"isFullHeight":true,"isReversedOnMobile":true,"style":{"spacing":{"blockGap":{"top":"0px","left":"0px"}},"color":{"background":"#f3f4f6"}}} -->
	<sc-columns is-stacked-on-mobile="1" is-full-height="1" is-reversed-on-mobile="1" class="wp-block-surecart-columns has-background" style="background-color:#f3f4f6;gap:0px 0px"><!-- wp:surecart/column {"layout":{"type":"constrained","contentSize":"450px","justifyContent":"right"},"backgroundColor":"white","style":{"spacing":{"padding":{"top":"60px","right":"60px","bottom":"60px","left":"60px"},"blockGap":"30px"}}} -->
	<sc-column class="wp-block-surecart-column is-layout-constrained is-horizontally-aligned-right has-white-background-color has-background" style="padding-top:60px;padding-right:60px;padding-bottom:60px;padding-left:60px;--sc-column-content-width:450px;--sc-form-row-spacing:30px"><!-- wp:surecart/store-logo {"width":120,"maxHeight":100,"isLinkToHome":false} /-->

	<!-- wp:surecart/checkout-errors -->
<sc-checkout-form-errors></sc-checkout-form-errors>
<!-- /wp:surecart/checkout-errors -->

	<!-- wp:surecart/price-selector {"label":"Choose A Product"} -->
	<sc-price-choices label="Choose A Product" type="radio" columns="1"><div><!-- wp:surecart/price-choice -->
		<sc-price-choice type="radio" show-label="1" show-price="1" show-control="1"></sc-price-choice>
	<!-- /wp:surecart/price-choice --></div></sc-price-choices>
	<!-- /wp:surecart/price-selector -->

	<!-- wp:surecart/email {"placeholder":"your@email.com"} /-->

	<!-- wp:surecart/name {"required":true,"placeholder":"Your Full Name"} -->
	<sc-customer-name label="Name" placeholder="Your Full Name" required class="wp-block-surecart-name"></sc-customer-name>
	<!-- /wp:surecart/name -->

	<!-- wp:surecart/address /-->

	<!-- wp:surecart/payment {"secure_notice":"This is a secure, encrypted payment"} -->
	<sc-payment label="Payment" default-processor="stripe" secure-notice="This is a secure, encrypted payment" class="wp-block-surecart-payment"></sc-payment>
	<!-- /wp:surecart/payment -->

	<!-- wp:surecart/submit {"show_total":true,"full":true} -->
	<sc-order-submit type="primary" full="true" size="large" icon="lock" show-total="true" class="wp-block-surecart-submit">Purchase</sc-order-submit>
	<!-- /wp:surecart/submit --></sc-column>
	<!-- /wp:surecart/column -->

	<!-- wp:surecart/column {"layout":{"type":"constrained","justifyContent":"left","contentSize":"450px"},"width":"","sticky":true,"style":{"spacing":{"padding":{"top":"60px","right":"60px","bottom":"60px","left":"60px"},"blockGap":"30px"}}} -->
	<sc-column class="wp-block-surecart-column is-sticky is-layout-constrained is-horizontally-aligned-left" style="padding-top:60px;padding-right:60px;padding-bottom:60px;padding-left:60px;--sc-column-content-width:450px;--sc-form-row-spacing:30px"><!-- wp:surecart/totals {"collapsible":true,"closed_text":"","open_text":"","collapsedOnMobile":true} -->
	<sc-order-summary collapsible="1" closed-text="" open-text="" collapsed-on-mobile="1" class="wp-block-surecart-totals"><!-- wp:surecart/divider -->
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

	<!-- wp:surecart/coupon {"text":"","button_text":""} -->
	<sc-order-coupon-form></sc-order-coupon-form>
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
	<!-- /wp:surecart/totals --></sc-column>
	<!-- /wp:surecart/column --></sc-columns>
	<!-- /wp:surecart/columns -->',
];
