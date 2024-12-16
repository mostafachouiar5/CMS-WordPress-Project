<?php
namespace SureCartBlocks\Controllers;

use SureCart\Models\Component;
use SureCart\Models\Price;
use SureCart\Models\Product;
use SureCart\Models\Subscription;
use SureCart\Models\SubscriptionProtocol;
use SureCart\Models\User;
use SureCartBlocks\Controllers\Middleware\MissingPaymentMethodMiddleware;
use SureCartBlocks\Controllers\Middleware\UpdateSubscriptionMiddleware;
use SureCartBlocks\Controllers\Middleware\SubscriptionPermissionsControllerMiddleware;
use SureCartBlocks\Controllers\Middleware\SubscriptionNonceVerificationMiddleware;
/**
 * The subscription controller.
 */
class SubscriptionController extends BaseController {
	/**
	 * The middleware for this controller.
	 *
	 * @var array
	 */
	protected $middleware = [
		'confirm'               => [
			SubscriptionPermissionsControllerMiddleware::class,
			UpdateSubscriptionMiddleware::class,
			MissingPaymentMethodMiddleware::class,
		],
		'confirm_amount'        => [
			SubscriptionPermissionsControllerMiddleware::class,
			UpdateSubscriptionMiddleware::class,
			MissingPaymentMethodMiddleware::class,
		],
		'confirm_variation'     => [
			SubscriptionPermissionsControllerMiddleware::class,
			UpdateSubscriptionMiddleware::class,
			MissingPaymentMethodMiddleware::class,
		],
		'update_payment_method' => [
			SubscriptionNonceVerificationMiddleware::class,
			SubscriptionPermissionsControllerMiddleware::class,
			UpdateSubscriptionMiddleware::class,
			MissingPaymentMethodMiddleware::class,
		],
	];

	/**
	 * Render the block
	 *
	 * @param array $attributes Block attributes.
	 * @return function
	 */
	public function preview( $attributes = [] ) {
		return wp_kses_post(
			Component::tag( 'sc-subscriptions-list' )
			->id( 'customer-subscriptions-preview' )
			->with(
				[
					'heading'    => $attributes['title'] ?? null,
					'isCustomer' => User::current()->isCustomer(),
					'allLink'    => add_query_arg(
						[
							'tab'    => $this->getTab(),
							'model'  => 'subscription',
							'action' => 'index',
						],
						remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					),
					'query'      => apply_filters(
						'surecart/dashboard/subscription_list/query',
						[
							'customer_ids' => array_values( User::current()->customerIds() ),
							'status'       => [ 'active', 'trialing', 'past_due', 'canceled' ],
							'page'         => 1,
							'per_page'     => 5,
						]
					),
				]
			)->render( $attributes['title'] ? "<span slot='heading'>" . $attributes['title'] . '</span>' : '' )
		);
	}

	/**
	 * Render the block
	 *
	 * @return function
	 */
	public function index() {
		\SureCart::assets()->addComponentData(
			'sc-subscriptions-list',
			'#customer-subscriptions-index',
			[
				'heading'    => $attributes['title'] ?? __( 'Plans', 'surecart' ),
				'isCustomer' => User::current()->isCustomer(),
				'query'      => apply_filters(
					'surecart/dashboard/subscription_list/query',
					[
						'customer_ids' => array_values( User::current()->customerIds() ),
						'status'       => [ 'active', 'trialing', 'canceled' ],
						'page'         => 1,
						'per_page'     => 20,
					]
				),
			]
		);
		ob_start();
		?>
		<sc-spacing style="--spacing: var(--sc-spacing-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Plans', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>
			<sc-subscriptions-list id="customer-subscriptions-index"></sc-subscriptions-list>
		</sc-spacing>
		<?php
		return ob_get_clean();
	}

	/**
	 * Show and individual checkout session.
	 *
	 * @return function
	 */
	public function edit() {
		$id = $this->getId();

		if ( ! $id ) {
			return $this->notFound();
		}

		// fetch subscription.
		$subscription = Subscription::with(
			[
				'price',
				'price.product',
				'product.product_group',
				'current_period',
				'period.checkout',
				'purchase',
				'discount',
				'discount.coupon',
				'purchase.license',
				'license.activations',
			]
		)->find( $id );

		$should_delay_cancellation = $subscription->shouldDelayCancellation();
		ob_start();
		?>

		<sc-spacing style="--spacing: var(--sc-spacing-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="
				<?php
				echo esc_url(
					add_query_arg(
						[
							'tab'    => $this->getTab(),
							'action' => 'index',
							'model'  => 'subscription',
						],
						remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					)
				);
				?>
				">
					<?php esc_html_e( 'Plans', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Plan', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php
			echo wp_kses_post(
				Component::tag( 'sc-subscription' )
				->id( 'customer-subscription-edit' )
				->with(
					[
						'heading'                => __( 'Current Plan', 'surecart' ),
						'showCancel'             => \SureCart::account()->customer_portal_protocol->subscription_cancellations_enabled && ! $subscription->remaining_period_count && ! $should_delay_cancellation,
						'protocol'               => SubscriptionProtocol::with( [ 'preservation_coupon' ] )->find(), // \SureCart::account()->subscription_protocol,
						'subscription'           => $subscription,
						'updatePaymentMethodUrl' => esc_url_raw(
							home_url(
								add_query_arg(
									[
										'tab'    => $this->getTab(),
										'action' => 'update_payment_method',
										'nonce'  => wp_create_nonce( 'subscription-switch' ),
									]
								)
							)
						),
					]
				)->render()
			);
			?>

		<?php
		// show switch if we can change it.
		if ( $subscription->canBeSwitched() ) :
			echo wp_kses_post(
				Component::tag( 'sc-subscription-switch' )
				->id( 'customer-subscription-switch' )
				->with(
					[
						'heading'        => __( 'Update Plan', 'surecart' ),
						'productId'      => $subscription->price->product->id,
						'productGroupId' => ( $subscription->price->product->product_group
						? ( $subscription->price->product->product_group->archived
							? null
							: $subscription->price->product->product_group->id )
						: null ),
						'subscription'   => $subscription,
						'successUrl'     => home_url(
							add_query_arg(
								[
									'tab'   => $this->getTab(),
									'nonce' => wp_create_nonce( 'subscription-switch' ),
								]
							)
						),
					]
				)->render()
			);
		endif;
		?>

		</sc-spacing>

		<?php
		return ob_get_clean();
	}

	/**
	 * Update the subscription payment method
	 *
	 * @return string
	 */
	public function update_payment_method() {
		$id = $this->getId();

		if ( ! $id ) {
			return $this->notFound();
		}

		// fetch subscription.
		$subscription = Subscription::with(
			[
				'price',
				'price.product',
				'current_period',
				'period.checkout',
				'discount',
				'discount.coupon',
			]
		)->find( $id );

		ob_start();
		?>

		<sc-spacing style="--spacing: var(--sc-spacing-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="
				<?php
				echo esc_url(
					add_query_arg(
						[
							'tab'    => $this->getTab(),
							'action' => 'index',
							'model'  => 'subscription',
						],
						remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					)
				);
				?>
				">
					<?php esc_html_e( 'Plans', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="
				<?php
				echo esc_url(
					add_query_arg(
						[
							'tab'    => $this->getTab(),
							'action' => 'edit',
							'model'  => 'subscription',
							'id'     => $this->getId(),
						],
						remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					)
				);
				?>
				">
					<?php esc_html_e( 'Plan', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Update Payment Method', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

		<?php
			echo wp_kses_post(
				Component::tag( 'sc-subscription' )
				->id( 'customer-subscription-edit' )
				->with(
					[
						'heading'      => __( 'Current Plan', 'surecart' ),
						'showCancel'   => false,
						'subscription' => $subscription,
					]
				)->render()
			);
		?>

		<?php
		echo wp_kses_post(
			Component::tag( 'sc-subscription-payment-method' )
			->id( 'customer-subscription-payment-method' )
			->with(
				[
					'heading'      => __( 'Change Payment Method', 'surecart' ),
					'subscription' => $subscription,
				]
			)->render()
		);
		?>

		</sc-spacing>

		<?php
		return ob_get_clean();
	}


	/**
	 * Get the terms text.
	 */
	public function getTermsText() {
		$account     = \SureCart::account();
		$privacy_url = $account->customer_portal_protocol->privacy_url ?? \get_privacy_policy_url();
		$terms_url   = $account->customer_portal_protocol->terms_url ?? '';

		if ( ! empty( $privacy_url ) && ! empty( $terms_url ) ) {
			return sprintf( __( 'By updating or canceling your plan, you agree to the <a href="%1$1s" target="_blank">%2$2s</a> and <a href="%3$3s" target="_blank">%4$4s</a>', 'surecart' ), esc_url( $terms_url ), __( 'Terms', 'surecart' ), esc_url( $privacy_url ), __( 'Privacy Policy', 'surecart' ) );
		}

		if ( ! empty( $privacy_url ) ) {
			return sprintf( __( 'By updating or canceling your plan, you agree to the <a href="%1$1s" target="_blank">%2$2s</a>', 'surecart' ), esc_url( $privacy_url ), __( 'Privacy Policy', 'surecart' ) );
		}

		if ( ! empty( $terms_url ) ) {
			return sprintf( __( 'By updating or canceling your plan, you agree to the <a href="%1$1s" target="_blank">%2$2s</a>', 'surecart' ), esc_url( $terms_url ), __( 'Terms', 'surecart' ) );
		}

		return '';
	}

	/**
	 * Confirm the ad_hoc amount.
	 *
	 * @return void
	 */
	public function confirm_amount() {
		$price = Price::find( $this->getParam( 'price_id' ) );
		ob_start();
		?>

		<sc-spacing style="--spacing: var(--sc-spacing-xx-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="
				<?php
				echo esc_url(
					add_query_arg(
						[
							'tab'    => $this->getTab(),
							'action' => 'edit',
							'model'  => 'subscription',
							'id'     => $this->getId(),
						],
						remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					)
				);
				?>
				">
					<?php esc_html_e( 'Plan', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Enter Amount', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php

			echo wp_kses_post(
				Component::tag( 'sc-subscription-ad-hoc-confirm' )
				->id( 'subscription-ad-hoc-confirm' )
				->with(
					[
						'heading' => __( 'Enter An Amount', 'surecart' ),
						'price'   => $price,
						'variant' => $this->getParam( 'variant' ),
					]
				)->render()
			);
			?>

	</sc-spacing>

		<?php
		return ob_get_clean();
	}

	/**
	 * Confirm the product variation.
	 *
	 * @return void
	 */
	public function confirm_variation() {
		$price = Price::find( $this->getParam( 'price_id' ) );
		$id    = $this->getId();

		if ( ! $id ) {
			return $this->notFound();
		}

		// fetch subscription.
		$subscription = Subscription::with(
			[
				'price',
				'price.product',
			]
		)->find( $id );

		if ( ! $subscription ) {
			return $this->notFound();
		}

		// fetch subscription product.
		$product = Product::with(
			[
				'variants',
				'variant_options',
				'prices',
			]
		)->find( $price->product );

		ob_start();
		?>

		<sc-spacing style="--spacing: var(--sc-spacing-xx-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="
				<?php
				echo esc_url(
					add_query_arg(
						[
							'tab'    => $this->getTab(),
							'action' => 'edit',
							'model'  => 'subscription',
							'id'     => $this->getId(),
						],
						remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					)
				);
				?>
				">
					<?php esc_html_e( 'Plan', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Choose Variation', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php

			echo wp_kses_post(
				Component::tag( 'sc-subscription-variation-confirm' )
				->id( 'subscription-ad-hoc-confirm' )
				->with(
					[
						'heading'      => __( 'Choose a Variation', 'surecart' ),
						'product'      => $product,
						'subscription' => $subscription,
						'price'        => $price,
					]
				)->render()
			);
			?>

	</sc-spacing>

		<?php
		return ob_get_clean();
	}

	/**
	 * Confirm changing subscription
	 *
	 * @return function
	 */
	public function confirm() {
		$back = add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		ob_start();
		?>

		<sc-spacing style="--spacing: var(--sc-spacing-xx-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="
				<?php
				echo esc_url(
					add_query_arg(
						[
							'tab'    => $this->getTab(),
							'action' => 'edit',
							'model'  => 'subscription',
							'id'     => $this->getId(),
						],
						remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					)
				);
				?>
				">
					<?php esc_html_e( 'Plan', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Confirm', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php
			$terms            = $this->getTermsText();
			$quantity_enabled = (bool) \SureCart::account()->customer_portal_protocol->subscription_quantity_updates_enabled;
			if ( $this->getParam( 'ad_hoc_amount' ) ) {
				$quantity_enabled = false;
			}

			echo wp_kses_post(
				Component::tag( 'sc-upcoming-invoice' )
				->id( 'customer-upcoming-invoice' )
				->with(
					[
						'heading'                => __( 'New Plan', 'surecart' ),
						'subscriptionId'         => $this->getId(),
						'priceId'                => $this->getParam( 'price_id' ),
						'variantId'              => $this->getParam( 'variant' ),
						'adHocAmount'            => $this->getParam( 'ad_hoc_amount' ),
						'successUrl'             => esc_url_raw( $back ),
						'quantityUpdatesEnabled' => (bool) $quantity_enabled,
						'quantity'               => 1,
					]
				)->render( $terms ? '<span slot="terms">' . wp_kses_post( $terms ) . '</span>' : '' )
			);
			?>


	</sc-spacing>

		<?php
		return ob_get_clean();
	}

	/**
	 * Confirm cancel subscription
	 *
	 * @return function
	 */
	public function cancel() {
		$back_url              = add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$edit_subscription_url = add_query_arg(
			[
				'tab'    => $this->getTab(),
				'action' => 'edit',
				'model'  => 'subscription',
				'id'     => $this->getId(),
			],
			remove_query_arg( array_keys( $_GET ) )  // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		);
		ob_start();
		?>
		<sc-spacing style="--spacing: var(--sc-spacing-xx-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( $back_url ); ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="<?php echo esc_url( $edit_subscription_url ); ?>" >
					<?php esc_html_e( 'Plan', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Cancel', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php
			echo wp_kses_post(
				Component::tag( 'sc-subscription-cancel' )
				->id( 'customer-subscription-cancel' )
				->with(
					[
						'subscriptionId' => $this->getId(),
						'backUrl'        => esc_url_raw( $edit_subscription_url ),
						'successUrl'     => esc_url_raw( $back_url ),
					]
				)->render()
			);
			?>

		</sc-spacing>
		<?php
		return ob_get_clean();
	}

	/**
	 * Update payment
	 *
	 * @return function
	 */
	public function payment() {
		$back_url = add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		$edit_subscription_url = add_query_arg(
			[
				'tab'    => $this->getTab(),
				'action' => 'edit',
				'model'  => 'subscription',
				'id'     => $this->getId(),
			],
			remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		);

		$confirm_subscription_url = add_query_arg(
			[
				'tab'           => $this->getTab(),
				'action'        => 'confirm',
				'model'         => 'subscription',
				'ad_hoc_amount' => $this->getParam( 'ad_hoc_amount' ),
				'id'            => $this->getId(),
				'price_id'      => $this->getParam( 'price_id' ),
				'nonce'         => wp_create_nonce( 'subscription-switch' ),
			],
			remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		);

		$subscription = Subscription::find( $this->getId() );
		ob_start();
		?>

		<sc-spacing style="--spacing: var(--sc-spacing-xx-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( $back_url ); ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="<?php echo esc_url( $edit_subscription_url ); ?>">
					<?php esc_html_e( 'Plan', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="<?php echo esc_url( $confirm_subscription_url ); ?>">
					<?php esc_html_e( 'Confirm', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Payment Method', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php
			echo wp_kses_post(
				Component::tag( 'sc-subscription-payment' )
				->id( 'customer-subscription-payment' )
				->with(
					[
						'customerIds'  => $this->customerIds(),
						'subscription' => $subscription,
						'backUrl'      => esc_url_raw( $confirm_subscription_url ),
						'successUrl'   => esc_url_raw( $confirm_subscription_url ),
						'quantity'     => 1,
					]
				)->render()
			);
			?>
		</sc-spacing>

		<?php
		return ob_get_clean();
	}
}
