<?php
namespace SureCartBlocks\Controllers;

use SureCart\Models\Component;
use SureCart\Models\User;

/**
 * The subscription controller.
 */
class OrderController extends BaseController {
	/**
	 * Preview.
	 */
	public function preview( $attributes = [] ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		return wp_kses_post(
			Component::tag( 'sc-orders-list' )
			->id( 'customer-orders-preview' )
			->with(
				[
					'allLink'    => add_query_arg(
						[
							'tab'    => $this->getTab(),
							'model'  => 'order',
							'action' => 'index',
						]
					),
					'isCustomer' => User::current()->isCustomer(),
					'query'      => apply_filters(
						'surecart/dashboard/order_list/query',
						[
							'customer_ids' => array_values( User::current()->customerIds() ),
							'status'       => [ 'paid', 'processing', 'payment_failed', 'canceled', 'void' ],
							'page'         => 1,
							'per_page'     => 5,
						]
					),
				]
			)->render( $attributes['title'] ? "<span slot='heading'>" . $attributes['title'] . '</span>' : '' )
		);
	}

	/**
	 * Index.
	 */
	public function index() {
		if ( ! is_user_logged_in() ) {
			return;
		}
		ob_start();
		?>

		<sc-spacing style="--spacing: var(--sc-spacing-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Orders', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

		<?php
		echo wp_kses_post(
			Component::tag( 'sc-orders-list' )
			->id( 'customer-orders-index' )
			->with(
				[
					'heading'    => __( 'Order History', 'surecart' ),
					'isCustomer' => User::current()->isCustomer(),
					'query'      => apply_filters(
						'surecart/dashboard/order_list/query',
						[
							'customer_ids' => array_values( User::current()->customerIds() ),
							'status'       => [ 'paid', 'processing', 'payment_failed', 'canceled', 'void' ],
							'page'         => 1,
							'per_page'     => 10,
						]
					),
				]
			)->render()
		);
		?>
		</sc-spacing>

		<?php
		return ob_get_clean();
	}

	/**
	 * Index.
	 */
	public function show() {
		if ( ! is_user_logged_in() ) {
			return;
		}
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
								'model'  => 'order',
								'action' => 'index',
							],
							remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						)
					);
					?>
				 ">
					<?php esc_html_e( 'Orders', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Order', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<div>
			<?php
			echo wp_kses_post(
				Component::tag( 'sc-order' )
				->id( 'sc-customer-order' )
				->with(
					[
						'orderId'     => $this->getId(),
						'customerIds' => array_values( (array) User::current()->customerIds() ),
					]
				)->render()
			);
			?>
			</div>

			<div>
			<?php
			echo wp_kses_post(
				Component::tag( 'sc-fulfillments' )
				->id( 'sc-customer-fulfillments' )
				->with(
					[
						'orderId' => $this->getId(),
					]
				)->render()
			);
			?>
			</div>
		</sc-spacing>

		<?php
		return ob_get_clean();
	}
}
