<?php

namespace SureCart\Controllers\Admin;

use SureCartCore\Responses\RedirectResponse;

abstract class AdminController {
	/**
	 * Preload API Request Paths
	 *
	 * @param array $preload_paths The preload paths.
	 *
	 * @return void
	 */
	public function preloadPaths( $preload_paths ) {
		wp_add_inline_script(
			'wp-api-fetch',
			sprintf(
				'wp.apiFetch.use( wp.apiFetch.createPreloadingMiddleware( %s ) );',
				wp_json_encode(
					array_reduce(
						$preload_paths,
						'rest_preload_api_request',
						array()
					)
				)
			),
			'after'
		);
	}

	/**
	 * The header.
	 *
	 * @param array $args The arguments.
	 *
	 * @return void
	 */
	public function withHeader( $args ) {
		add_action(
			'in_admin_header',
			function() use ( $args ) {
				return \SureCart::render(
					'layouts/partials/admin-header',
					[
						'breadcrumbs'      => $args['breadcrumbs'] ?? [],
						'suffix'           => $args['suffix'] ?? '',
						'claim_url'        => ! \SureCart::account()->claimed ? \SureCart::routeUrl( 'account.claim' ) : '',
						'report_url'       => $args['report_url'] ?? '',
					]
				);
			}
		);
	}

	/**
	 * Add notices.
	 *
	 * @param array $items The notices.
	 *
	 * @return void
	 */
	public function withNotices( $items ) {
		add_action(
			'admin_notices',
			function() use ( $items ) {
				foreach ( $items as $key => $item ) {
					if ( (bool) ( $_REQUEST[ $key ] ?? false ) ) {
						?>
						<div class="notice notice-success is-dismissible">
							<p><?php echo esc_html( $item ); ?></p>
						</div>
						<?php
					}
				}
			}
		);
	}

	/**
	 * Redirect back to the previous page.
	 *
	 * @param @param \SureCartCore\Requests\RequestInterface $request Request.
	 *
	 * @return \SureCartCore\Responses\RedirectResponse
	 */
	public function redirectBack( $request ) {
		return ( new RedirectResponse( $request ) )->back();
	}
}
