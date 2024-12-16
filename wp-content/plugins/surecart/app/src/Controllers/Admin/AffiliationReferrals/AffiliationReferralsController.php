<?php

namespace SureCart\Controllers\Admin\AffiliationReferrals;

use SureCart\Controllers\Admin\AdminController;
use SureCart\Models\Referral;
use SureCartCore\Responses\RedirectResponse;

/**
 * Handles affiliate referrals admin routes.
 */
class AffiliationReferralsController extends AdminController {
	/**
	 * Affiliate Referral index.
	 */
	public function index() {
		$table = new AffiliationReferralsListTable();
		$table->prepare_items();

		$this->withHeader(
			array(
				'breadcrumbs'      => [
					'affiliate_referrals' => [
						'title' => __( 'Affiliate Referrals', 'surecart' ),
					],
				],
			)
		);

		$this->withNotices(
			array(
				'approved'  => esc_html__( 'Affiliate referral approved.', 'surecart' ),
				'denied'    => esc_html__( 'Affiliate referral denied.', 'surecart' ),
				'deleted'   => esc_html__( 'Affiliate referral deleted.', 'surecart' ),
				'reviewing' => esc_html__( 'Affiliate referral is now in review.', 'surecart' ),
			)
		);

		return \SureCart::view( 'admin/affiliation-referrals/index' )->with( [ 'table' => $table ] );
	}

	/**
	 * Edit an affiliate referral.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return string
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( AffiliationReferralsScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/affiliation_referrals/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// return view.
		return '<div id ="app"></div>';
	}

	/**
	 * Delete an affiliate referral.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function delete( $request ) {
		$deleted = Referral::delete( $request->query( 'id' ) );

		if ( is_wp_error( $deleted ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $deleted->get_error_messages() ) ) );
		}

		return \SureCart::redirect()->to( add_query_arg( array( 'deleted' => true ), \SureCart::getUrl()->index( 'affiliate-referrals' ) ) );
	}

	/**
	 * Approve an affiliate referral.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function approve( $request ) {
		$approved = Referral::approve( $request->query( 'id' ) );

		if ( is_wp_error( $approved ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $approved->get_error_messages() ) ) );
		}

		$args = array_filter(
			array(
				'approved'  => true,
				'live_mode' => $request->query( 'live_mode' ),
			)
		);

		return \SureCart::redirect()->to( add_query_arg( $args, \SureCart::getUrl()->index( 'affiliate-referrals' ) ) );
	}

	/**
	 * Deny an affiliate referral.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function deny( $request ) {
		$denied = Referral::deny( $request->query( 'id' ) );

		if ( is_wp_error( $denied ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $denied->get_error_messages() ) ) );
		}

		$args = array_filter(
			array(
				'denied'    => true,
				'live_mode' => $request->query( 'live_mode' ),
			)
		);

		return \SureCart::redirect()->to( add_query_arg( $args, \SureCart::getUrl()->index( 'affiliate-referrals' ) ) );
	}

	/**
	 * Make an affiliate referral reviewing.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function makeReviewing( $request ) {
		$reviewing = Referral::make_reviewing( $request->query( 'id' ) );

		if ( is_wp_error( $reviewing ) ) {
			wp_die( implode( ' ', array_map( 'esc_html', $reviewing->get_error_messages() ) ) );
		}

		$args = array_filter(
			array(
				'reviewing' => true,
				'live_mode' => $request->query( 'live_mode' ),
			)
		);

		return \SureCart::redirect()->to( add_query_arg( $args, \SureCart::getUrl()->index( 'affiliate-referrals' ) ) );
	}
}
