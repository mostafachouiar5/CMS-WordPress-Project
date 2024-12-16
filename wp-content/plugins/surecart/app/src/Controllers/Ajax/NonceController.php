<?php

namespace SureCart\Controllers\Ajax;

class NonceController {
	public function get() {
		exit( wp_create_nonce( 'wp_rest' ) );
	}
}
