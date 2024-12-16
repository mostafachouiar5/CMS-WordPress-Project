<?php
/**
 * WordPress AJAX Routes.
 * WARNING: Do not use \SureCart::route()->all() here, otherwise you will override
 * ALL AJAX requests which you most likely do not want to do.
 *
 * @link https://docs.wpemerge.com/#/framework/routing/methods
 *
 * @package SureCart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
|--------------------------------------------------------------------------
| Nonce Refresh
|--------------------------------------------------------------------------
*/
\SureCart::route()->get()->where( 'ajax', 'sc-rest-nonce', true, true )->handle( 'NonceController@get' );
