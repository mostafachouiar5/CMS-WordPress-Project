<?php

namespace SureCartBlocks\Controllers;

use SureCart\Models\Component;
use SureCart\Models\User;

/**
 * The invoice controller.
 */
class InvoiceController extends BaseController {
	/**
	 * Preview.
	 */
	public function preview( $attributes = [] ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		return wp_kses_post(
			Component::tag( 'sc-invoices-list' )
			->id( 'customer-invoices-preview' )
			->with(
				[
					'allLink'    => add_query_arg(
						[
							'tab'    => $this->getTab(),
							'model'  => 'invoice',
							'action' => 'index',
						]
					),
					'isCustomer' => User::current()->isCustomer(),
					'query'      => apply_filters(
						'surecart/dashboard/invoice_list/query',
						[
							'customer_ids' => array_values( User::current()->customerIds() ),
							'status'       => [ 'paid', 'open' ],
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
					<?php esc_html_e( 'Invoices', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

		<?php
		echo wp_kses_post(
			Component::tag( 'sc-invoices-list' )
			->id( 'customer-invoices-index' )
			->with(
				[
					'heading'    => __( 'Invoices', 'surecart' ),
					'isCustomer' => User::current()->isCustomer(),
					'query'      => apply_filters(
						'surecart/dashboard/invoice_list/query',
						[
							'customer_ids' => array_values( User::current()->customerIds() ),
							'status'       => [ 'paid', 'open' ],
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
}
