<?php
/**
 * Web Routes.
 *
 * @link https://docs.wpemerge.com/#/framework/routing/methods
 *
 * @package SureCart
 */

use SureCart\Middleware\CheckoutFormModeMiddleware;
use SureCart\Middleware\CheckoutRedirectMiddleware;
use SureCart\Middleware\CustomerDashboardRedirectMiddleware;
use SureCart\Middleware\InvoiceRedirectMiddleware;
use SureCart\Middleware\LoginLinkMiddleware;
use SureCart\Middleware\OrderRedirectMiddleware;
use SureCart\Middleware\PathRedirectMiddleware;
use SureCart\Middleware\PaymentFailureRedirectMiddleware;
use SureCart\Middleware\PurchaseRedirectMiddleware;
use SureCart\Middleware\SubscriptionRedirectMiddleware;
use SureCart\Middleware\UpsellMiddleware;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
|--------------------------------------------------------------------------
| Buy Page
|--------------------------------------------------------------------------
*/
\SureCart::route()
	->get()
	->where( 'query_var', 'sc_checkout_product_id' )
	->handle( 'BuyPageController@show' );

/*
|--------------------------------------------------------------------------
|  Upsell Page
|--------------------------------------------------------------------------
*/
\SureCart::route()
	->get()
	->where( 'query_var', 'sc_upsell_id' )
	->middleware( UpsellMiddleware::class )
	->handle( 'UpsellPageController@show' );

/*
|--------------------------------------------------------------------------
| Checkout Change Mode
|--------------------------------------------------------------------------
*/
\SureCart::route()
	->get()
	->where( 'query_var', 'sc_checkout_change_mode' )
	->where( 'query_var', 'sc_checkout_post' )
	->middleware( CheckoutFormModeMiddleware::class )
	->handle( 'CheckoutFormsController@changeMode' );

/*
|--------------------------------------------------------------------------
| Receive Webhooks
|--------------------------------------------------------------------------
*/
\SureCart::route()
	->post()
	->url( '/surecart/webhooks' )
	->name( 'webhooks' )
	->middleware( 'webhooks' )
	->handle( 'WebhookController@receive' );

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/
\SureCart::route()
	->get()
	->where( 'query_var', 'sc_redirect' )
	// handle login.
	->middleware( LoginLinkMiddleware::class )
	// redirect in this order.
	->middleware( PathRedirectMiddleware::class )
	->middleware( OrderRedirectMiddleware::class )
	->middleware( InvoiceRedirectMiddleware::class )
	->middleware( PurchaseRedirectMiddleware::class )
	->middleware( CheckoutRedirectMiddleware::class )
	->middleware( PaymentFailureRedirectMiddleware::class )
	->middleware( SubscriptionRedirectMiddleware::class )
	// customer dashboard redirect is the fallback if there is a customer_id present.
	->middleware( CustomerDashboardRedirectMiddleware::class )
	->handle( 'DashboardController@show' );
