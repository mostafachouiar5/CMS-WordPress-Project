<?php
/**
 * @package   SureCartAppCore
 * @author    SureCart <support@surecart.com>
 * @copyright  SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com
 */

/**
 * Absolute path to app core's directory
 */
if ( ! defined( 'SURECART_APP_CORE_DIR' ) ) {
	define( 'SURECART_APP_CORE_DIR', __DIR__ );
}

/**
 * Absolute path to app core's src directory
 */
if ( ! defined( 'SURECART_APP_CORE_SRC_DIR' ) ) {
	define( 'SURECART_APP_CORE_SRC_DIR', SURECART_APP_CORE_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR );
}
