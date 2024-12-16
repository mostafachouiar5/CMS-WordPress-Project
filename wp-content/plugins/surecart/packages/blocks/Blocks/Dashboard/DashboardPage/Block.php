<?php

namespace SureCartBlocks\Blocks\Dashboard\DashboardPage;

use SureCartBlocks\Blocks\Dashboard\DashboardPage;

/**
 * Checkout block
 */
class Block extends DashboardPage {
	/**
	 * Individual block controllers.
	 *
	 * @var array
	 */
	protected $blocks = [
		'subscription'   => \SureCartBlocks\Controllers\SubscriptionController::class,
		'payment_method' => \SureCartBlocks\Controllers\PaymentMethodController::class,
		'charge'         => \SureCartBlocks\Controllers\ChargeController::class,
		'order'          => \SureCartBlocks\Controllers\OrderController::class,
		'user'           => \SureCartBlocks\Controllers\UserController::class,
		'customer'       => \SureCartBlocks\Controllers\CustomerController::class,
		'download'       => \SureCartBlocks\Controllers\DownloadController::class,
		'invoice'        => \SureCartBlocks\Controllers\InvoiceController::class,
		'license'		 => \SureCartBlocks\Controllers\LicenseController::class,
	];

	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		if ( ! is_user_logged_in() ) {
			return \SureCart::block()->render( 'web/login' );
		}

		// get the current page tab and possible id.
		$tab = $this->getTab();

		// make sure we are on the correct tab.
		if ( ! empty( $tab ) && ! empty( $attributes['name'] ) ) {
			if ( $tab !== $attributes['name'] ) {
				return '';
			}
		}

		$model = isset( $_GET['model'] ) ? sanitize_text_field( wp_unslash( $_GET['model'] ) ) : false;

		/**
		 * Filters content to display before the block.
		 *
		 * @since 1.1.12
		 *
		 * @param string $content Content to display. Default empty.
		 * @param array  $args    Array of login form arguments.
		 */
		$before = apply_filters( 'surecart/dashboard/block/before', '', $attributes, $content );

		/**
		 * Filters content to display after the block.
		 *
		 * @since 1.1.12
		 *
		 * @param string $content Content to display. Default empty.
		 * @param array  $args    Array of login form arguments.
		 */
		$after = apply_filters( 'surecart/dashboard/block/after', '', $attributes, $content );

		// call the correct block controller.
		if ( ! empty( $this->blocks[ $model ] ) ) {
			$action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : false;

			if ( method_exists( $this->blocks[ $model ], $action ) ) {
				$block = new $this->blocks[ $model ]();
				return $this->passwordNag() . '<sc-spacing class="sc-customer-dashboard" style="--spacing: var(--sc-spacing-xx-large); font-size: 15px;">' . $before . $block->handle( $action ) . $after . '</sc-spacing>';
			}
		}

		return $this->passwordNag() . '<sc-spacing class="sc-customer-dashboard" style="--spacing: var(--sc-spacing-xx-large); font-size: 15px;">' . $before . filter_block_content( $content ) . $after . '</sc-spacing>';
	}

	/**
	 * Render the passowrd nag if needed.
	 *
	 * @return string
	 */
	public function passwordNag() {
		if ( empty( get_user_meta( get_current_user_id(), 'default_password_nag', true ) ) ) {
			return;
		}
		$back = add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		ob_start();
		?>

		<sc-password-nag success-url="<?php echo esc_url( $back ); ?>"></sc-password-nag>

		<?php
		return ob_get_clean();
	}
}
