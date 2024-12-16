<?php
/**
 * Configuration. Based on WPEmerge config:
 *
 * @link https://docs.wpemerge.com/#/framework/configuration
 *
 * @package SureCart
 */

return array(
	/**
	 * Array of service providers you wish to enable.
	 */
	'providers'              => array(
		\SureCartAppCore\AppCore\AppCoreServiceProvider::class,
		\SureCartAppCore\Config\ConfigServiceProvider::class,
		\SureCart\Support\UtilityServiceProvider::class,
		\SureCart\Database\MigrationsServiceProvider::class,
		\SureCart\Database\UpdateMigrationServiceProvider::class,
		\SureCart\Account\AccountServiceProvider::class,
		\SureCart\WordPress\PluginServiceProvider::class,
		\SureCart\WordPress\TranslationsServiceProvider::class,
		\SureCart\WordPress\ThemeServiceProvider::class,
		\SureCart\WordPress\Templates\TemplatesServiceProvider::class,
		\SureCart\WordPress\Pages\PageServiceProvider::class,
		\SureCart\WordPress\Posts\PostServiceProvider::class,
		\SureCart\WordPress\Users\UsersServiceProvider::class,
		\SureCart\WordPress\Admin\Profile\UserProfileServiceProvider::class,
		\SureCart\WordPress\PostTypes\PostTypeServiceProvider::class,
		\SureCart\WordPress\Taxonomies\TaxonomyServiceProvider::class,
		\SureCart\WordPress\Assets\AssetsServiceProvider::class,
		\SureCart\WordPress\Shortcodes\ShortcodesServiceProvider::class,
		\SureCart\WordPress\Admin\Menus\AdminMenuPageServiceProvider::class,
		\SureCart\WordPress\Admin\Notices\AdminNoticesServiceProvider::class,
		\SureCart\WordPress\CLI\CLIServiceProvider::class,
		\SureCartAppCore\Assets\AssetsServiceProvider::class,
		\SureCart\Routing\PermalinkServiceProvider::class,
		\SureCart\Routing\RouteConditionsServiceProvider::class,
		\SureCart\Routing\AdminRouteServiceProvider::class,
		\SureCart\Permissions\RolesServiceProvider::class,
		\SureCart\Settings\SettingsServiceProvider::class,
		\SureCart\Request\RequestServiceProvider::class,
		\SureCart\View\ViewServiceProvider::class,
		\SureCart\Cart\CartServiceProvider::class,
		\SureCart\Webhooks\WebhooksServiceProvider::class,
		\SureCart\BlockLibrary\BlockServiceProvider::class,
		\SureCart\Support\Errors\ErrorsServiceProvider::class,
		\SureCart\Activation\ActivationServiceProvider::class,
		\SureCart\Background\BackgroundServiceProvider::class,
		\SureCart\Sync\SyncServiceProvider::class,
		\SureCart\Svg\SvgServiceProvider::class,

		// REST providers.
		\SureCart\Rest\SiteHealthRestServiceProvider::class,
		\SureCart\Rest\AbandonedCheckoutRestServiceProvider::class,
		\SureCart\Rest\AbandonedCheckoutProtocolRestServiceProvider::class,
		\SureCart\Rest\BlockPatternsRestServiceProvider::class,
		\SureCart\Rest\AccountRestServiceProvider::class,
		\SureCart\Rest\BrandRestServiceProvider::class,
		\SureCart\Rest\BumpRestServiceProvider::class,
		\SureCart\Rest\UpsellFunnelRestServiceProvider::class,
		\SureCart\Rest\UpsellRestServiceProvider::class,
		\SureCart\Rest\FulfillmentRestServiceProvider::class,
		\SureCart\Rest\LoginRestServiceProvider::class,
		\SureCart\Rest\PurchasesRestServiceProvider::class,
		\SureCart\Rest\StatisticRestServiceProvider::class,
		\SureCart\Rest\IntegrationsRestServiceProvider::class,
		\SureCart\Rest\IncomingWebhooksRestServiceProvider::class,
		\SureCart\Rest\RegisteredWebhookRestServiceProvider::class,
		\SureCart\Rest\IntegrationProvidersRestServiceProvider::class,
		\SureCart\Rest\CancellationActRestServiceProvider::class,
		\SureCart\Rest\CancellationReasonRestServiceProvider::class,
		\SureCart\Rest\CustomerRestServiceProvider::class,
		\SureCart\Rest\PaymentMethodsRestServiceProvider::class,
		\SureCart\Rest\ProcessorRestServiceProvider::class,
		\SureCart\Rest\ManualPaymentMethodsRestServiceProvider::class,
		\SureCart\Rest\PaymentIntentsRestServiceProvider::class,
		\SureCart\Rest\ProductsRestServiceProvider::class,
		\SureCart\Rest\ProductGroupsRestServiceProvider::class,
		\SureCart\Rest\ProductCollectionsRestServiceProvider::class,
		\SureCart\Rest\PriceRestServiceProvider::class,
		\SureCart\Rest\CouponRestServiceProvider::class,
		\SureCart\Rest\PromotionRestServiceProvider::class,
		\SureCart\Rest\UploadsRestServiceProvider::class,
		\SureCart\Rest\BalanceTransactionRestServiceProvider::class,
		\SureCart\Rest\ChargesRestServiceProvider::class,
		\SureCart\Rest\RefundsRestServiceProvider::class,
		\SureCart\Rest\DownloadRestServiceProvider::class,
		\SureCart\Rest\LicenseRestServiceProvider::class,
		\SureCart\Rest\LineItemsRestServiceProvider::class,
		\SureCart\Rest\ActivationRestServiceProvider::class,
		\SureCart\Rest\AffiliationProtocolRestServiceProvider::class,
		\SureCart\Rest\MediaRestServiceProvider::class,
		\SureCart\Rest\SubscriptionRestServiceProvider::class,
		\SureCart\Rest\SubscriptionProtocolRestServiceProvider::class,
		\SureCart\Rest\PeriodRestServiceProvider::class,
		\SureCart\Rest\SettingsRestServiceProvider::class,
		\SureCart\Rest\CustomerPortalProtocolRestServiceProvider::class,
		\SureCart\Rest\TaxProtocolRestServiceProvider::class,
		\SureCart\Rest\OrderProtocolRestServiceProvider::class,
		\SureCart\Rest\TaxRegistrationRestServiceProvider::class,
		\SureCart\Rest\TaxZoneRestServiceProvider::class,
		\SureCart\Rest\TaxOverrideRestServiceProvider::class,
		\SureCart\Rest\CustomerNotificationProtocolRestServiceProvider::class,
		\SureCart\Rest\OrderRestServiceProvider::class,
		\SureCart\Rest\CheckoutRestServiceProvider::class,
		\SureCart\Rest\DraftCheckoutRestServiceProvider::class,
		\SureCart\Rest\InvoicesRestServiceProvider::class,
		\SureCart\Rest\WebhooksRestServiceProvider::class,
		\SureCart\Rest\VerificationCodeRestServiceProvider::class,
		\SureCart\Rest\CheckEmailRestServiceProvider::class,
		\SureCart\Rest\ReturnItemsRestServiceProvider::class,
		\SureCart\Rest\ReturnReasonsRestServiceProvider::class,
		\SureCart\Rest\ReturnRequestsRestServiceProvider::class,
		\SureCart\Rest\ShippingProfileRestServiceProvider::class,
		\SureCart\Rest\ShippingMethodRestServiceProvider::class,
		\SureCart\Rest\ShippingRateRestServiceProvider::class,
		\SureCart\Rest\ShippingZoneRestServiceProvider::class,
		\SureCart\Rest\ShippingProtocolRestServiceProvider::class,
		\SureCart\Rest\ProvisionalAccountRestServiceProvider::class,
		\SureCart\Rest\ProductMediaRestServiceProvider::class,
		\SureCart\Rest\VariantsRestServiceProvider::class,
		\SureCart\Rest\VariantOptionsRestServiceProvider::class,
		\SureCart\Rest\VariantValuesRestServiceProvider::class,
		\SureCart\Rest\ClicksRestServiceProvider::class,
		\SureCart\Rest\ReferralItemsRestServiceProvider::class,
		\SureCart\Rest\PayoutsRestServiceProvider::class,
		\SureCart\Rest\PayoutGroupsRestServiceProvider::class,
		\SureCart\Rest\ReferralsRestServiceProvider::class,
		\SureCart\Rest\AffiliationRequestsRestServiceProvider::class,
		\SureCart\Rest\AffiliationProductsRestServiceProvider::class,
		\SureCart\Rest\AffiliationsRestServiceProvider::class,
		\SureCart\Rest\ExportsRestServiceProvider::class,

		// integrations.
		\SureCart\Integrations\DiviServiceProvider::class,
		\SureCart\Integrations\ThriveAutomator\ThriveAutomatorServiceProvider::class,
		\SureCart\Integrations\LearnDash\LearnDashServiceProvider::class,
		\SureCart\Integrations\LearnDashGroup\LearnDashGroupServiceProvider::class,
		\SureCart\Integrations\LifterLMS\LifterLMSServiceProvider::class,
		\SureCart\Integrations\BuddyBoss\BuddyBossServiceProvider::class,
		\SureCart\Integrations\AffiliateWP\AffiliateWPServiceProvider::class,
		\SureCart\Integrations\TutorLMS\TutorLMSServiceProvider::class,
		\SureCart\Integrations\User\UserServiceProvider::class,
		\SureCart\Integrations\MemberPress\MemberPressServiceProvider::class,
		\SureCart\Integrations\Bricks\BricksServiceProvider::class,
		\SureCart\Integrations\Elementor\ElementorServiceProvider::class,
		\SureCart\Integrations\Beaver\BeaverServiceProvider::class,
		\SureCart\Integrations\Bricks\BricksServiceProvider::class,
	),

	/**
	* SSR Blocks
	*/
	'blocks'                 => array(
		\SureCartBlocks\Blocks\Email\Block::class,
		\SureCartBlocks\Blocks\Address\Block::class,
		\SureCartBlocks\Blocks\BuyButton\Block::class,
		\SureCartBlocks\Blocks\Coupon\Block::class,
		\SureCartBlocks\Blocks\TrialLineItem\Block::class,
		\SureCartBlocks\Blocks\AddToCartButton\Block::class,
		\SureCartBlocks\Blocks\CustomerDashboardButton\Block::class,
		\SureCartBlocks\Blocks\CheckoutForm\Block::class,
		\SureCartBlocks\Blocks\CartCoupon\Block::class,
		\SureCartBlocks\Blocks\CartSubtotal\Block::class,
		\SureCartBlocks\Blocks\CartBumpLineItem\Block::class,
		\SureCartBlocks\Blocks\CollapsibleRow\Block::class,
		\SureCartBlocks\Blocks\Columns\Block::class,
		\SureCartBlocks\Blocks\Column\Block::class,
		\SureCartBlocks\Blocks\CollectionPage\Block::class,
		\SureCartBlocks\Blocks\OrderConfirmationLineItems\Block::class,
		\SureCartBlocks\Blocks\Form\Block::class,
		\SureCartBlocks\Blocks\Payment\Block::class,
		\SureCartBlocks\Blocks\LogoutButton\Block::class,
		\SureCartBlocks\Blocks\ProductItemList\Block::class,
		\SureCartBlocks\Blocks\ProductCollection\Block::class,
		\SureCartBlocks\Blocks\PriceSelector\Block::class,
		\SureCartBlocks\Blocks\PriceChoice\Block::class,
		\SureCartBlocks\Blocks\Dashboard\WordPressAccount\Block::class,
		\SureCartBlocks\Blocks\Dashboard\CustomerDashboard\Block::class,
		\SureCartBlocks\Blocks\Dashboard\CustomerOrders\Block::class,
		\SureCartBlocks\Blocks\Dashboard\CustomerInvoices\Block::class,
		\SureCartBlocks\Blocks\Dashboard\CustomerDownloads\Block::class,
		\SureCartBlocks\Blocks\Dashboard\CustomerBillingDetails\Block::class,
		\SureCartBlocks\Blocks\Dashboard\CustomerPaymentMethods\Block::class,
		\SureCartBlocks\Blocks\Dashboard\CustomerSubscriptions\Block::class,
		\SureCartBlocks\Blocks\Dashboard\CustomerLicenses\Block::class,
		\SureCartBlocks\Blocks\Dashboard\CustomerDashboardArea\Block::class,
		\SureCartBlocks\Blocks\Dashboard\DashboardPage\Block::class,
		\SureCartBlocks\Blocks\Dashboard\DashboardTab\Block::class,
		\SureCartBlocks\Blocks\ConditionalForm\Block::class,
		\SureCartBlocks\Blocks\StoreLogo\Block::class,
		\SureCartBlocks\Blocks\Password\Block::class,
		\SureCartBlocks\Blocks\CartMenuButton\Block::class,
		\SureCartBlocks\Blocks\CartSubmit\Block::class,
		\SureCartBlocks\Blocks\Cart\Block::class,
		\SureCartBlocks\Blocks\VariantPriceSelector\Block::class,
		\SureCartBlocks\Blocks\ProductDonation\Block::class,
		\SureCartBlocks\Blocks\ProductDonationAmounts\Block::class,
		\SureCartBlocks\Blocks\ProductDonationPrices\Block::class,
		\SureCartBlocks\Blocks\ProductDonationRecurringPrices\Block::class,
		\SureCartBlocks\Blocks\ProductDonationAmount\Block::class,
		\SureCartBlocks\Blocks\ProductDonationCustomAmount\Block::class,

		// Deprecated.
		\SureCartBlocks\Blocks\Dashboard\Deprecated\CustomerCharges\Block::class,

		\SureCartBlocks\Blocks\Product\Price\Block::class,
		\SureCartBlocks\Blocks\Product\PriceChoices\Block::class,
		\SureCartBlocks\Blocks\Product\VariantChoices\Block::class,
		\SureCartBlocks\Blocks\Product\CollectionBadges\Block::class,
		\SureCartBlocks\Blocks\Product\BuyButton\Block::class,
		\SureCartBlocks\Blocks\Product\Title\Block::class,
		\SureCartBlocks\Blocks\Product\Description\Block::class,
		\SureCartBlocks\Blocks\Product\Quantity\Block::class,
		\SureCartBlocks\Blocks\Product\Media\Block::class,

		\SureCartBlocks\Blocks\ProductCollectionTitle\Block::class,
		\SureCartBlocks\Blocks\ProductCollectionDescription\Block::class,
		\SureCartBlocks\Blocks\ProductCollectionImage\Block::class,

		\SureCartBlocks\Blocks\Upsell\Upsell\Block::class,
		\SureCartBlocks\Blocks\Upsell\Title\Block::class,
		\SureCartBlocks\Blocks\Upsell\UpsellTotals\Block::class,
		\SureCartBlocks\Blocks\Upsell\CountdownTimer\Block::class,
		\SureCartBlocks\Blocks\Upsell\SubmitButton\Block::class,
		\SureCartBlocks\Blocks\Upsell\NoThanksButton\Block::class,
	),

	/** Which components to preload for each block. */
	'preload'                => array(
		'surecart/address'                   => array( 'sc-order-shipping-address', 'sc-address', 'sc-dropdown' ),
		'surecart/add-to-cart-button'        => array( 'sc-cart-form', 'sc-price-input', 'sc-cart-form-submit' ),
		'surecart/button'                    => array( 'sc-button' ),
		'surecart/buy-button'                => array( 'sc-button' ),
		'surecart/card'                      => array( 'sc-card' ),
		'surecart/checkbox'                  => array( 'sc-checkbox' ),
		'surecart/column'                    => array( 'sc-column' ),
		'surecart/columns'                   => array( 'sc-columns' ),
		'surecart/confirmation'              => array( 'sc-order-confirmation' ),
		'surecart/coupon'                    => array( 'sc-order-coupon-form', 'sc-coupon-form', 'sc-button', 'sc-input' ),
		'surecart/customer-dashboard-button' => array( 'sc-button' ),
		'surecart/customer-dashboard'        => array( 'sc-tab-group' ),
		'surecart/customer-subscriptions'    => array( 'sc-subscriptions-list', 'sc-dialog', 'sc-card', 'sc-stacked-list', 'sc-stacked-list-row', 'sc-flex' ),
		'surecart/dashboard-page'            => array( 'sc-spacing' ),
		'surecart/dashboard-tab'             => array( 'sc-tab' ),
		'surecart/customer-billing-details'  => array( 'sc-dashboard-customer-details', 'sc-breadcrumbs', 'sc-breadcrumb', 'sc-customer-edit' ),
		'surecart/divider'                   => array( 'sc-divider' ),
		'surecart/donation'                  => array( 'sc-donation-choices', 'sc-choices', 'sc-choice' ),
		'surecart/donation-amount'           => array( 'sc-choice', 'sc-format-number' ),
		'surecart/email'                     => array( 'sc-input', 'sc-customer-email' ),
		'surecart/phone'                     => array( 'sc-input', 'sc-phone-input', 'sc-customer-phone' ),
		'surecart/express-payment'           => array( 'sc-express-payment', 'sc-divider', 'sc-stripe-payment-request' ),
		'surecart/form'                      => array( 'sc-checkout', 'sc-form', 'sc-checkout-unsaved-changes-warning', 'sc-line-items-provider', 'sc-block-ui' ),
		'surecart/heading'                   => array( 'sc-heading' ),
		'surecart/input'                     => array( 'sc-input' ),
		'surecart/line-items'                => array( 'sc-line-items', 'sc-line-item', 'sc-line-item-tax', 'sc-product-line-item', 'sc-format-number', 'sc-skeleton' ),
		'surecart/logout-button'             => array( 'sc-button' ),
		'surecart/name'                      => array( 'sc-customer-name', 'sc-input' ),
		'surecart/first-name'                => array( 'sc-customer-firstname', 'sc-input' ),
		'surecart/last-name'                 => array( 'sc-customer-lastname', 'sc-input' ),
		'surecart/name-your-price'           => array( 'sc-custom-order-price-input', 'sc-price-input', 'sc-skeleton' ),
		'surecart/password'                  => array( 'sc-order-password', 'sc-input' ),
		'surecart/payment'                   => array( 'sc-payment', 'sc-toggles', 'sc-toggle', 'sc-tag' ),
		'surecart/price-choice'              => array( 'sc-price-choice', 'sc-choice', 'sc-skeleton' ),
		'surecart/price-selector'            => array( 'sc-price-choices' ),
		'surecart/variant-price-selector'    => array( 'sc-checkout-product-price-variant-selector' ),
		'surecart/submit'                    => array( 'sc-order-submit', 'sc-button', 'sc-total', 'sc-paypal-buttons', 'sc-format-number', 'sc-spinner' ),
		'surecart/subtotal'                  => array( 'sc-line-item-total', 'sc-format-number' ),
		'surecart/total'                     => array( 'sc-line-item-total', 'sc-format-number' ),
		'surecart/totals'                    => array( 'sc-order-summary' ),
		'surecart/conditional-from'          => array( 'sc-conditional-form' ),
		'surecart/product-price'             => array( 'sc-product-price', 'sc-tag', 'sc-format-number' ),
		'surecart/product-media'             => array(),
		'surecart/product-buy-buttons'       => array( 'sc-product-buy-button', 'sc-button' ),
		'surecart/product-price-choices'     => array( 'sc-product-price-choices', 'sc-choices', 'sc-price-choice-container', 'sc-choice-container', 'sc-format-number', 'sc-skeleton' ),
		'surecart/product-variant-choices'   => array( 'sc-product-variation-choices' ),
		'surecart/product-quantity'          => array( 'sc-product-quantity', 'sc-form-control', 'sc-icon', 'sc-quantity-select' ),
		'surecart/product-collection-badges' => array(),
	),

	/**
	 * Links used.
	 */
	'links'                  => array(
		'purchase' => 'https://app.surecart.com/plans',
	),

	/**
	* Permission Controllers
	*/
	'permission_controllers' => array(
		\SureCart\Permissions\Models\ActivationPermissionsController::class,
		\SureCart\Permissions\Models\BalanceTransactionPermissionsController::class,
		\SureCart\Permissions\Models\ChargePermissionsController::class,
		\SureCart\Permissions\Models\LicensePermissionsController::class,
		\SureCart\Permissions\Models\CustomerPermissionsController::class,
		\SureCart\Permissions\Models\OrderPermissionsController::class,
		\SureCart\Permissions\Models\CheckoutPermissionsController::class,
		\SureCart\Permissions\Models\InvoicePermissionsController::class,
		\SureCart\Permissions\Models\PaymentMethodPermissionsController::class,
		\SureCart\Permissions\Models\PurchasePermissionsController::class,
		\SureCart\Permissions\Models\RefundPermissionsController::class,
		\SureCart\Permissions\Models\SubscriptionPermissionsController::class,
	),

	/**
	 * Array of route group definitions and default attributes.
	 * All of these are optional so if we are not using
	 * a certain group of routes we can skip it.
	 * If we are not using routing at all we can skip
	 * the entire 'routes' option.
	 */
	'routes'                 => array(
		'web'   => array(
			'definitions' => __DIR__ . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'web.php',
			'attributes'  => array(
				'namespace' => 'SureCart\\Controllers\\Web\\',
			),
		),
		'admin' => array(
			'definitions' => __DIR__ . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'admin.php',
			'attributes'  => array(
				'namespace' => 'SureCart\\Controllers\\Admin\\',
			),
		),
		'ajax'  => array(
			'definitions' => __DIR__ . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'ajax.php',
			'attributes'  => array(
				'namespace' => 'SureCart\\Controllers\\Ajax\\',
			),
		),
	),

	/**
	 * View Composers settings.
	 */
	'view_composers'         => array(
		'namespace' => 'SureCart\\ViewComposers\\',
	),

	/**
	 * Register middleware class aliases.
	 * Use fully qualified middleware class names.
	 *
	 * Internal aliases that you should avoid overriding:
	 * - 'flash'
	 * - 'old_input'
	 * - 'csrf'
	 * - 'user.logged_in'
	 * - 'user.logged_out'
	 * - 'user.can'
	 */
	'middleware'             => array(
		'archive_model'       => \SureCart\Middleware\ArchiveModelMiddleware::class,
		'edit_model'          => \SureCart\Middleware\EditModelMiddleware::class,
		'nonce'               => \SureCart\Middleware\NonceMiddleware::class,
		'webhooks'            => \SureCart\Middleware\WebhooksMiddleware::class,
		'assets.components'   => \SureCart\Middleware\ComponentAssetsMiddleware::class,
		'assets.brand_colors' => \SureCart\Middleware\BrandColorMiddleware::class,
		'assets.admin_colors' => \SureCart\Middleware\AdminColorMiddleware::class,
	),

	/**
	 * Map model names to their corresponding classes.
	 * This lets you reference a model based on a simple string.
	 */
	'models'                 => array(
		'abandoned_checkout'  => \SureCart\Models\AbandonedCheckout::class,
		'account'             => \SureCart\Models\Account::class,
		'cancellation_reason' => \SureCart\Models\CancellationReason::class,
		'charge'              => \SureCart\Models\Charge::class,
		'coupon'              => \SureCart\Models\Coupon::class,
		'customer'            => \SureCart\Models\Customer::class,
		'customer_link'       => \SureCart\Models\CustomerLink::class,
		'form'                => \SureCart\Models\Form::class,
		'line_item'           => \SureCart\Models\LineItem::class,
		'order'               => \SureCart\Models\Order::class,
		'price'               => \SureCart\Models\Price::class,
		'processor'           => \SureCart\Models\Processor::class,
		'product'             => \SureCart\Models\Product::class,
		'promotion'           => \SureCart\Models\Promotion::class,
		'subscription'        => \SureCart\Models\Subscription::class,
		'upload'              => \SureCart\Models\Upload::class,
		'user'                => \SureCart\Models\User::class,
		'webhook'             => \SureCart\Models\Webhook::class,
	),

	/**
	 * Register middleware groups.
	 * Use fully qualified middleware class names or registered aliases.
	 * There are a couple built-in groups that you may override:
	 * - 'web'      - Automatically applied to web routes.
	 * - 'admin'    - Automatically applied to admin routes.
	 * - 'ajax'     - Automatically applied to ajax routes.
	 * - 'global'   - Automatically applied to all of the above.
	 * - 'surecart' - Internal group applied the same way 'global' is.
	 *
	 * Warning: The 'surecart' group contains some internal SureCart core
	 * middleware which you should avoid overriding.
	 */
	'middleware_groups'      => array(
		'global' => array(),
		'web'    => array(),
		'ajax'   => array(),
		'admin'  => array(),
	),

	/**
	 * Optionally specify middleware execution order.
	 * Use fully qualified middleware class names.
	 */
	'middleware_priority'    => array(
		// phpcs:ignore
		// \SureCart\Middleware\MyMiddlewareThatShouldRunFirst::class,
		// \SureCart\Middleware\MyMiddlewareThatShouldRunSecond::class,
	),

	/**
	 * Webhook events we gonna proceed.
	 */
	'webhook_events'         => array(
		'customer.updated',
		'purchase.created',
		'purchase.invoked',
		'purchase.updated',
		'purchase.revoked',
		'price.created',
		'price.deleted',
		'price.updated',
		'product.created',
		'product.deleted',
		'product.stock_adjusted',
		'product.updated',
		'subscription.renewed', // needed for AffiliateWP recurring referrals.
		'account.updated',
	),

	/**
	 * Custom directories to search for views.
	 * Use absolute paths or leave blank to disable.
	 * Applies only to the default PhpViewEngine.
	 */
	'views'                  => array( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'views' ),

	/**
	 * App Core configuration.
	 */
	'app_core'               => array(
		'path' => dirname( __DIR__ ),
		'url'  => plugin_dir_url( SURECART_PLUGIN_FILE ),
	),
);
