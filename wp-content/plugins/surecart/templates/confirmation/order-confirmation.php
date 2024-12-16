<?php
/**
 * Donation form block pattern
 */
return [
	'title'      => __( 'Order Confirmation', 'surecart' ),
	'categories' => [],
	'blockTypes' => [],
	'content'    => '<!-- wp:surecart/order-confirmation -->
	<sc-order-confirmation><!-- wp:paragraph -->
	<p>Thank you for your purchase! Please check your inbox for additional information.</p>
	<!-- /wp:paragraph -->

	<!-- wp:surecart/order-confirmation-line-items -->
	<sc-dashboard-module heading="Summary" class="wp-block-surecart-order-confirmation-line-items"><sc-card><sc-order-confirmation-line-items></sc-order-confirmation-line-items><sc-divider></sc-divider><sc-order-confirmation-totals></sc-order-confirmation-totals></sc-card></sc-dashboard-module>
	<!-- /wp:surecart/order-confirmation-line-items -->

	<!-- wp:surecart/customer-dashboard-button {"label":"Manage Orders", "full": true} /--></sc-order-confirmation>
	<!-- /wp:surecart/order-confirmation -->',
];
