<?php
/**
 * Donation form block pattern
 */
return [
	'title'      => __( 'Two Column', 'surecart' ),
	'categories' => [ 'surecart_form' ],
	'blockTypes' => [],
	'content'    => '<!-- wp:surecart/columns {"backgroundColor":"background"} -->
	<sc-columns class="wp-block-surecart-columns has-background-background-color has-background"><!-- wp:surecart/column {"verticalAlignment":"top","sticky":true,"stickyOffset":"50px"} -->
		<sc-column class="wp-block-surecart-column is-vertically-aligned-top is-sticky" style="top:50px" stickyoffset="50px"><!-- wp:surecart/heading {"title":"Order Summary"} -->
		<sc-heading>Order Summary<span slot="description"></span><span slot="end"></span></sc-heading>
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
		<!-- /wp:surecart/totals --></sc-column>
		<!-- /wp:surecart/column -->

		<!-- wp:surecart/column {"style":{"spacing":{"padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}}} -->
		<sc-column class="wp-block-surecart-column" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px">

			<!-- wp:surecart/price-selector {"label":"Choose A Plan"} -->
	<sc-price-choices label="Choose A Plan" type="radio" columns="1"><div><!-- wp:surecart/price-choice -->
		<sc-price-choice type="radio" show-label="1" show-price="1" show-control="1"></sc-price-choice>
		<!-- /wp:surecart/price-choice --></div></sc-price-choices>
		<!-- /wp:surecart/price-selector -->

		<!-- wp:surecart/heading {"title":"Contact Information"} -->
		<sc-heading>Contact Information<span slot="description"></span><span slot="end"></span></sc-heading>
		<!-- /wp:surecart/heading -->

		<!-- wp:surecart/email {"label":"Email Address"} -->
		<sc-customer-email label="Email Address" autocomplete="email" inputmode="email" required class="wp-block-surecart-email"></sc-customer-email>
		<!-- /wp:surecart/email -->

		<!-- wp:surecart/password -->
		<sc-order-password label="Password" placeholder="" size="medium" type="password" name="password" value="" class="wp-block-surecart-password"></sc-order-password>
		<!-- /wp:surecart/password -->

		<!-- wp:surecart/address -->
		<sc-order-shipping-address label="Address"></sc-order-shipping-address>
		<!-- /wp:surecart/address -->

		<!-- wp:surecart/payment {"secure_notice":"This is a secure, encrypted payment"} -->
		<sc-payment label="Payment" secure-notice="This is a secure, encrypted payment" class="wp-block-surecart-payment"></sc-payment>
		<!-- /wp:surecart/payment -->

		<!-- wp:surecart/switch {"required":true,"label":"I agree to the purchase terms.","description":"You can find these on our terms page."} -->
		<sc-switch name="switch" required class="wp-block-surecart-switch">I agree to the purchase terms.<span slot="description">You can find these on our terms page.</span></sc-switch>
		<!-- /wp:surecart/switch -->

		<!-- wp:surecart/submit {"show_total":true,"full":true} -->
	<sc-order-submit type="primary" full="true" size="large" icon="lock" show-total="true" class="wp-block-surecart-submit">Purchase</sc-order-submit>
	<!-- /wp:surecart/submit --></sc-column>
		<!-- /wp:surecart/column --></sc-columns>
		<!-- /wp:surecart/columns -->
	',
];
