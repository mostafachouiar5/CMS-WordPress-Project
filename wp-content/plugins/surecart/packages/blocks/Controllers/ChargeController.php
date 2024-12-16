<?php
namespace SureCartBlocks\Controllers;

use SureCart\Models\Component;
use SureCart\Models\User;

class ChargeController extends BaseController {
	/**
	 * List all charges and paginate.
	 *
	 * @return function
	 */
	public function index() {
		ob_start(); ?>

		<sc-spacing style="--spacing: var(--sc-spacing-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Payment History', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php
			echo wp_kses_post(
				Component::tag( 'sc-charges-list' )
					->id( 'sc-customer-charges' )
					->with(
						[
							'heading' => __( 'Payment History', 'surecart' ),
							'query'   => [
								'customer_ids' => array_values( User::current()->customerIds() ),
								'page'         => $this->getPage(),
								'per_page'     => 10,
							],
						]
					)->render()
			);
			?>

		</sc-spacing>

		<?php
		return ob_get_clean();
	}
}
