<?php

namespace SureCart\WordPress\Admin\Profile;

use SureCart\Models\User;

/**
 * Admin user profile service
 */
class UserProfileService {
	/**
	 * Bootstrap related hooks.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'edit_user_profile', [ $this, 'showCustomerInfo' ] );
		add_action( 'show_user_profile', [ $this, 'showCustomerInfo' ] );
	}

	/**
	 * Show customer info on user profile.
	 *
	 * @param \WP_User $user The user.
	 * @return void
	 */
	public function showCustomerInfo( $user ) {
		$user          = User::find( $user->ID );
		$test_customer = $user->customer( 'test' );
		$live_customer = $user->customer( 'live' );

		$this->render(
			'admin/user-profile',
			[
				'test_customer'  => $test_customer,
				'live_customer'  => $live_customer,
				'edit_test_link' => is_a( $test_customer, \SureCart\Models\Customer::class ) ? \SureCart::getUrl()->edit( 'customer', $test_customer->id ) : '',
				'edit_live_link' => is_a( $live_customer, \SureCart\Models\Customer::class ) ? \SureCart::getUrl()->edit( 'customer', $live_customer->id ) : '',
			]
		);
	}

	/**
	 * Render a block using a template
	 *
	 * @param  string|string[]      $views A view or array of views.
	 * @param  array<string, mixed> $context Context to send.
	 * @return void
	 */
	public function render( $views, $context = [] ) {
		echo wp_kses_post( \SureCart::views()->make( $views )->with( $context )->toString() );
	}
}
