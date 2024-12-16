<?php

namespace SureCart\Controllers\Admin\AffiliationPayouts;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Models\Payout;

/**
 * Handles affiliate payout admin routes.
 */
class AffiliationPayoutsController extends AdminController {

	/**
	 * Affiliate Payout index.
	 */
	public function index() {
		$table = new AffiliationPayoutsListTable();
		$table->prepare_items();

		$this->withHeader(
			array(
				'breadcrumbs' => [
					'affiliate_payouts' => [
						'title' => __( 'Affiliate Payouts', 'surecart' ),
					],
				],
				'suffix'      => '<sc-button href="' . esc_url( admin_url( 'admin.php?page=sc-affiliate-payouts&action=export' ) ) . '"  type="primary">' . __( 'Export Payouts', 'surecart' ) . '</sc-button>',
			)
		);

		$this->withNotices(
			array(
				'processing' => __( 'Affiliate payout marked processing.', 'surecart' ),
				'completed'  => __( 'Affiliate payout marked completed.', 'surecart' ),
				'deleted'    => __( 'Affiliate payout deleted.', 'surecart' ),
			)
		);

		return \SureCart::view( 'admin/affiliation-payouts/index' )->with( [ 'table' => $table ] );
	}

	/**
	 * Edit an affiliate payout.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return string
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( AffiliationPayoutsScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/affiliation_payouts/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}

	/**
	 * Export affiliate payouts.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return string
	 */
	public function export( $request ) {
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( AffiliationPayoutsScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me?context=edit',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/affiliation_payouts/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}

	/**
	 * Delete an affiliate payout.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function delete( $request ) {
		$deleted = Payout::delete( $request->query( 'id' ) );

		if ( is_wp_error( $deleted ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $deleted->get_error_messages() ) ) );
		}

		return \SureCart::redirect()->to( add_query_arg( array( 'deleted' => true ), \SureCart::getUrl()->index( 'affiliate-payouts' ) ) );
	}

	/**
	 * Complete an affiliate payout.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function complete( $request ) {
		$completed = Payout::complete( $request->query( 'id' ) );

		if ( is_wp_error( $completed ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $completed->get_error_messages() ) ) );
		}

		return \SureCart::redirect()->to( add_query_arg( array( 'completed' => true ), \SureCart::getUrl()->index( 'affiliate-payouts' ) ) );
	}

	/**
	 * Make an affiliate payout processing.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function makeProcessing( $request ) {
		$processed = Payout::make_processing( $request->query( 'id' ) );

		if ( is_wp_error( $processed ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $processed->get_error_messages() ) ) );
		}

		return \SureCart::redirect()->to( add_query_arg( array( 'processing' => true ), \SureCart::getUrl()->index( 'affiliate-payouts' ) ) );
	}
}
