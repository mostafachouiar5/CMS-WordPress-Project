<?php

namespace SureCartBlocks\Blocks\Dashboard\CustomerSubscriptions;

use SureCart\Models\Subscription;
use SureCart\Models\User;
use SureCartBlocks\Blocks\Dashboard\DashboardPage;
use SureCartBlocks\Controllers\SubscriptionController;

/**
 * Checkout block
 */
class Block extends DashboardPage {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return function
	 */
	public function render( $attributes, $content ) {
		if ( ! is_user_logged_in() ) {
			return false;
		}
		return ( new SubscriptionController() )->preview( $attributes );
	}

	/**
	 * Show and individual checkout session.
	 *
	 * @param string $id Session ID.
	 *
	 * @return function
	 */
	public function show( $id ) {
		return \SureCart::block()->render(
			'web/dashboard/subscriptions/show',
			[
				'id' => $id,
			]
		);
	}

	/**
	 * Show and individual checkout session.
	 *
	 * @return function
	 */
	public function edit() {
		$id           = isset( $_GET['id'] ) ? sanitize_text_field( wp_unslash( $_GET['id'] ) ) : false;
		$tab          = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : false;
		$subscription = Subscription::with( [ 'price', 'price.product', 'current_period', 'product.product_group', 'variant_options' ] )->find( $id );

		\SureCart::assets()->addComponentData(
			'sc-subscription',
			'#customer-subscription',
			[
				'heading'      => $attributes['title'] ?? __( 'Update Plan', 'surecart' ),
				'subscription' => $subscription,
			]
		);
		\SureCart::assets()->addComponentData(
			'sc-subscription-switch',
			'#customer-subscription-switch',
			[
				'heading'       => $attributes['title'] ?? __( 'Update Plan', 'surecart' ),
				'product-group' => $subscription->price->product->product_group ?? null,
				'subscription'  => $subscription,
			]
		);
		ob_start(); ?>
		<sc-spacing style="--spacing: var(--sc-spacing-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $tab ], \SureCart::pages()->url( 'dashboard' ) ) ); ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Plan', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<sc-subscription id="customer-subscription"></sc-subscription>
			<sc-subscription-switch id="customer-subscription-switch"></sc-subscription-switch>
		</sc-spacing>

		<?php
		return ob_get_clean();
	}

	/**
	 * Show and individual checkout session.
	 *
	 * @param array $attributes Block attributes.
	 *
	 * @return function
	 */
	public function index( $attributes ) {
		if ( ! is_user_logged_in() ) {
			return false;
		}
		\SureCart::assets()->addComponentData(
			'sc-subscriptions-list',
			'#customer-subscriptions-index',
			[
				'heading'    => $attributes['title'] ?? __( 'Plans', 'surecart' ),
				'isCustomer' => User::current()->isCustomer(),
				'query'      => [
					'customer_ids' => array_values( User::current()->customerIds() ),
					'status'       => [ 'active', 'trialing' ],
					'page'         => 1,
					'per_page'     => 10,
				],
			]
		);
		return '<sc-subscriptions-list id="customer-subscriptions-index"></sc-subscriptions-list>';
	}
}
