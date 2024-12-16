<?php

namespace SureCart\WordPress\Admin\SSLCheck;

/**
 * Admin SSL check service
 */
class AdminSSLCheckService {
	/**
	 * Bootstrap related hooks.
	 *
	 * @return void
	 */
	public function bootstrap() {
		if ( ! is_ssl() ) {
			add_action( 'admin_notices', [ $this, 'showNotice' ] );
		}
	}

	/**
	 * Show the SSL notice.
	 *
	 * @return void
	 */
	public function showNotice() {
		echo wp_kses_post(
			\SureCart::notices()->render(
				[
					'name'  => 'ssl_notice',
					'type'  => 'warning',
					'title' => esc_html__( 'SureCart', 'surecart' ),
					'text'  => esc_html__( 'Your store does not appear to be using a secure connection. A secure connection (https) is required to use SureCart to process live transactions.', 'surecart' ),
				]
			)
		);
	}

}
