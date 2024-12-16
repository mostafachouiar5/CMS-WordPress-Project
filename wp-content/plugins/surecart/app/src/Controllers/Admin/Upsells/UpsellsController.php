<?php

namespace SureCart\Controllers\Admin\Upsells;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Models\UpsellFunnel;
use SureCartCore\Responses\RedirectResponse;

/**
 * Handles upsell admin requests.
 */
class UpsellsController extends AdminController {

	/**
	 * Bumps index.
	 */
	public function index() {
		$table = new UpsellsListTable();
		$table->prepare_items();
		$this->withHeader(
			array(
				'breadcrumbs' => [
					'upsells' => [
						'title' => __( 'Upsell Funnels', 'surecart' ),
					],
				],
				'report_url' => SURECART_REPORTS_URL . 'upsells',
			)
		);
		return \SureCart::view( 'admin/upsell-funnels/index' )->with( [ 'table' => $table ] );
	}

	/**
	 * Edit
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( UpsellScriptsController::class, 'enqueue' ) );

		$upsell = null;

		if ( $request->query( 'id' ) ) {
			$upsell = UpsellFunnel::with()->find( $request->query( 'id' ) );

			if ( is_wp_error( $upsell ) ) {
				wp_die( implode( ' ', array_map( 'esc_html', $upsell->get_error_messages() ) ) );
			}
		}

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				// '/surecart/v1/upsell_funnels/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// Add View Upsell link.
		add_action(
			'admin_bar_menu',
			function( $wp_admin_bar ) use ( $upsell ) {
				$wp_admin_bar->add_node(
					[
						'id'    => 'view-upsell-page',
						'title' => __( 'View Upsell', 'surecart' ),
						'href'  => esc_url( $upsell->permalink ?? '#' ),
						'meta'  => [
							'class' => empty( $upsell->permalink ) ? 'hidden' : '',
						],
					]
				);
			},
			99
		);

		// return view.
		return '<div id="app"></div>';
	}

	/**
	 * Change the archived attribute in the model
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function toggleEnabled( $request ) {
		$funnel = UpsellFunnel::find( $request->query( 'id' ) );
		$status = $request->query( 'status' ) ?? 'active';

		if ( is_wp_error( $funnel ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $funnel->get_error_messages() ) ) );
		}

		$updated = $funnel->update(
			[
				'enabled' => ! (bool) $funnel->enabled,
			]
		);

		if ( is_wp_error( $updated ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $updated->get_error_messages() ) ) );
		}

		\SureCart::flash()->add(
			'success',
			$updated->enabled ? __( 'Funnel enabled.', 'surecart' ) : __( 'Funnel disabled.', 'surecart' )
		);

		return \SureCart::redirect()->to(
			esc_url_raw( add_query_arg( 'status', $status, admin_url( 'admin.php?page=sc-upsell-funnels' ) ) )
		);
	}
}
