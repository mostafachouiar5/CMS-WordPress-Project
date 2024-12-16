<?php
namespace SureCartBlocks\Controllers;

use SureCart\Models\Component;
use SureCart\Models\Customer;
use SureCart\Models\User;

/**
 * Payment method block controller class.
 */
class UserController extends BaseController {
	/**
	 * List all payment methods.
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Block content.
	 *
	 * @return function
	 */
	public function show( $attributes, $content ) {
		$user = wp_get_current_user();
		if ( ! $user ) {
			return '';
		}
		$data = get_userdata( $user->ID );

		return wp_kses_post(
			Component::tag( 'sc-wordpress-user' )
			->id( 'wordpress-user-edit' )
			->with(
				[
					'heading' => $attributes['title'] ?? __( 'Account Details', 'surecart' ),
					'user'    => [
						'display_name' => $user->display_name,
						'email'        => $user->user_email,
						'first_name'   => $data->user_firstname ?? '',
						'last_name'    => $data->user_lastname ?? '',
					],
				]
			)->render()
		);
	}

	/**
	 * Show a view to add a payment method.
	 *
	 * @return function
	 */
	public function edit() {
		$user = wp_get_current_user();
		if ( ! $user ) {
			return '';
		}
		$data = get_userdata( $user->ID );
		$back = add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		ob_start(); ?>

		<sc-spacing style="--spacing: var(--sc-spacing-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="<?php echo esc_url( $back ); ?>">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Account Details', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php
				echo wp_kses_post(
					Component::tag( 'sc-wordpress-user-edit' )
					->id( 'wordpress-user-edit' )
					->with(
						[
							'heading'    => $attributes['title'] ?? __( 'Update Account Details', 'surecart' ),
							'user'       => [
								'id'           => $user->ID,
								'display_name' => $user->display_name,
								'email'        => $user->user_email,
								'first_name'   => $data->user_firstname,
								'last_name'    => $data->user_lastname,
							],
							'successUrl' => esc_url_raw( $back ),
						]
					)->render()
				);

			?>

		<?php
				echo wp_kses_post(
					Component::tag( 'sc-wordpress-password-edit' )
					->id( 'wordpress-password-edit' )
					->with(
						[
							'heading'    => $attributes['title'] ?? __( 'Update Password', 'surecart' ),
							'user'       => [
								'id'           => $user->ID,
								'display_name' => $user->display_name,
								'email'        => $user->user_email,
								'first_name'   => $data->user_firstname,
								'last_name'    => $data->user_lastname,
							],
							'successUrl' => esc_url_raw( $back ),
						]
					)->render()
				);

		?>
		</sc-spacing>

			<?php
			return ob_get_clean();
	}
}
