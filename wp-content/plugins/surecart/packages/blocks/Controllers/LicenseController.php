<?php

namespace SureCartBlocks\Controllers;

use SureCart\Models\Component;
use SureCart\Models\User;

/**
 * The subscription controller.
 */
class LicenseController extends BaseController {

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
			Component::tag( 'sc-licenses-list' )
				->id( 'customer-licenses-preview' )
				->with(
					[
						'isCustomer' => User::current()->isCustomer(),
						'heading'    => $attributes['title'],
						'query'      => [
							'customer_ids' => array_values( User::current()->customerIds() ),
							'page'         => 1,
							'per_page'     => 5,
						],
						'allLink'    => add_query_arg(
							[
								'tab'    => $this->getTab(),
								'model'  => 'license',
								'action' => 'index',
							]
						),
					]
				)
				->render()
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
				<sc-breadcrumb href="
				<?php
				echo esc_url( add_query_arg( [ 'tab' => $this->getTab() ], remove_query_arg( array_keys( $_GET ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				?>
										">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'Licenses', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php
			echo wp_kses_post(
				Component::tag( 'sc-licenses-list' )
					->id( 'customer-licenses-index' )
					->with(
						[
							'heading'    => __( 'Licenses', 'surecart' ),
							'isCustomer' => User::current()->isCustomer(),
							'query'      => [
								'customer_ids' => array_values( User::current()->customerIds() ),
								'page'         => 1,
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

	public function show() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		ob_start();
		?>
		<sc-spacing style="--spacing: var(--sc-spacing-large)">
			<sc-breadcrumbs>
				<sc-breadcrumb href="
				<?php
				echo esc_url(
					add_query_arg(
						[ 'tab' => $this->getTab() ],
						remove_query_arg( array_keys( $_GET ) )
					)
				); // phpcs:ignore WordPress.Security.NonceVerification.Recommended 
				?>
				">
					<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb href="
					<?php
					echo esc_url(
						add_query_arg(
							[
								'tab'    => $this->getTab(),
								'model'  => 'license',
								'action' => 'index',
							],
							remove_query_arg( array_keys( $_GET ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						)
					);
					?>
				 ">
					<?php esc_html_e( 'Licenses', 'surecart' ); ?>
				</sc-breadcrumb>
				<sc-breadcrumb>
					<?php esc_html_e( 'License', 'surecart' ); ?>
				</sc-breadcrumb>
			</sc-breadcrumbs>

			<?php
			echo wp_kses_post(
				Component::tag( 'sc-license' )
					->id( 'sc-customer-license' )
					->with(
						[
							'licenseId'   => $this->getId(),
							'customerIds' => array_values( (array) User::current()->customerIds() ),
						]
					)
					->render()
			);
			?>
		</sc-spacing>
		<?php
		return ob_get_clean();
	}
}
