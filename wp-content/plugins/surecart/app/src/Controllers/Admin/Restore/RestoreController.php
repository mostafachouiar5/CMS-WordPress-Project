<?php

namespace SureCart\Controllers\Admin\Restore;

use SureCart\Controllers\Admin\AdminController;

/**
 * Handles restore page admin requests.
 */
class RestoreController  extends AdminController {
	/**
	 * Index.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 */
	public function index( \SureCartCore\Requests\RequestInterface $request ) {
		$restore = sanitize_text_field( wp_unslash( $request->query( 'restore' ) ) );
		if ( empty( $restore ) ) {
			wp_die( esc_html__( 'Invalid page selected. Please choose the correct page to restore.', 'surecart' ) );
		}

		$this->withHeader(
			array(
				'breadcrumbs' => [
					'restore' => [
						'title' => __( 'Restore', 'surecart' ),
					],
				],
			)
		);

		return \SureCart::view( 'admin/restore/index' )
			->with(
				[
					'restore' => $restore,
				]
			);
	}

	/**
	 * Restore.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 *
	 * @return function
	 */
	public function restore( \SureCartCore\Requests\RequestInterface $request ) {
		$page = $request->body( 'restore' );

		if ( empty( $page ) ) {
			wp_die( esc_html__( 'Invalid page selected. Please choose the correct page to restore.', 'surecart' ) );
		}

		$page_id = \SureCart::pages()->getId( $page, 'page' );

		$post_status = get_post_status( $page_id );

		if ( ! empty( get_post_status_object( $post_status )->label ) && ! empty( $page_id ) ) {
			$restored = wp_update_post(
				[
					'ID'          => $page_id,
					'post_status' => 'publish',
				]
			);
			if ( is_wp_error( $restored ) ) {
				wp_die( esc_html__( 'Unable to restore page. Please try again.', 'surecart' ) );
			}

			return \SureCart::redirect()->to( esc_url_raw( admin_url( 'post.php?post=' . $page_id . '&action=edit' ) ) );
		}

		$restore_functions = [
			'checkout'  => 'createPages',
			'cart'      => 'createCartPost',
			'shop'      => 'createShopPage',
			'dashboard' => 'createPages',
		];

		try {
			\SureCart::page_seeder()->{$restore_functions[ $page ]}();
		} catch ( \Exception $e ) {
			wp_die( esc_html__( 'Unable to restore page. Please try again.', 'surecart' ) );
		}

		$page_id = (int) \SureCart::pages()->getId( $page, 'page' );
		return \SureCart::redirect()->to( esc_url_raw( admin_url( 'post.php?post=' . $page_id . '&action=edit' ) ) );
	}
}
