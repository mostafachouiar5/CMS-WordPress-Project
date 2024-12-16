<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'surecart.kernels.http_kernel.respond' );
remove_all_filters( 'surecart.kernels.http_kernel.respond' );
