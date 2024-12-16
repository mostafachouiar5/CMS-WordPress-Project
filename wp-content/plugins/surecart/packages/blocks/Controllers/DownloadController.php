<?php
namespace SureCartBlocks\Controllers;

use SureCart\Models\Component;
use SureCart\Models\Purchase;
use SureCart\Models\User;

/**
 * The subscription controller.
 */
class DownloadController extends BaseController {
	/**
	 * Preview.
	 *
	 * @param array $attributes Block attributes.
	 */
	public function preview( $attributes = [] ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		return wp_kses_post(
			Component::tag( 'sc-dashboard-downloads-list' )
			->id( 'customer-downloads-preview' )
			->with(
				[
					'allLink'      => add_query_arg(
						[
							'tab'    => $this->getTab(),
							'model'  => 'download',
							'action' => 'index',
						],
						remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					),
					'requestNonce' => wp_create_nonce( 'customer-download' ),
					'isCustomer'   => User::current()->isCustomer(),
					'query'        => [
						'customer_ids' => array_values( User::current()->customerIds() ),
						'page'         => 1,
						'per_page'     => 10,
					],
				]
			)->render( "<span slot='heading'>" . ( $attributes['title'] ?? __( 'Downloads', 'surecart' ) ) . '</span>' )
		);
	}

	/**
	 * Index.
	 */
	public function index( $attributes = [] ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		ob_start(); ?>
		<sc-spacing style="--spacing: var(--sc-spacing-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Downloads', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php
			echo wp_kses_post(
				Component::tag( 'sc-dashboard-downloads-list' )
				->id( 'customer-downloads-preview' )
				->with(
					[
						'requestNonce' => wp_create_nonce( 'customer-download' ),
						'isCustomer'   => User::current()->isCustomer(),
						'query'        => [
							'customer_ids' => array_values( User::current()->customerIds() ),
							'page'         => 1,
							'per_page'     => 10,
						],
					]
				)->render( "<span slot='heading'>" . ( $attributes['title'] ?? __( 'Downloads', 'surecart' ) ) . '</span>' )
			);
			?>
		</sc-spacing>

		<?php
		return ob_get_clean();
	}

	public function show() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		$purchase = Purchase::with( [ 'customer', 'checkout', 'license', 'product', 'product.downloads', 'download.media', 'license.activations' ] )->find( $this->getId() );

		if ( empty( $purchase->customer->id ) || ! User::current()->hasCustomerId( $purchase->customer->id ) ) {
			return null;
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
								'model'  => 'download',
								'action' => 'index',
							],
							remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						)
					);
					?>
				 ">
					<?php esc_html_e( 'Downloads', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Download', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

				<?php
				echo wp_kses_post(
					Component::tag( 'sc-downloads-list' )
					->id( 'customer-purchase' )
					->with(
						[
							'heading'    => __( 'Downloads', 'surecart' ),
							'customerId' => $purchase->customer->id ?? '',
							'downloads'  => array_values(
								array_filter(
									$purchase->product->downloads->data ?? [],
									function( $download ) {
										return ! $download->archived;
									}
								)
							),
						]
					)->render()
				);
				?>

			<?php
			if ( $purchase->license ) :
				echo wp_kses_post(
					Component::tag( 'sc-licenses-list' )
					->id( 'customer-licenses' )
					->with(
						[
							'heading'  => __( 'License Keys', 'surecart' ),
							'licenses' => [ $purchase->license ],
						]
					)->render()
				);
			endif;
			?>

		</sc-spacing>

			<?php
			return ob_get_clean();
	}
}
