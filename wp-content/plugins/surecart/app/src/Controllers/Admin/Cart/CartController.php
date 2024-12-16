<?php

namespace SureCart\Controllers\Admin\Cart;

use SureCart\Controllers\Admin\AdminController;

/**
 * Handles product admin requests.
 */
class CartController extends AdminController {
	/**
	 * Edit a product.
	 */
	public function edit() {
		wp_enqueue_script( 'wp-edit-site' );
		wp_enqueue_script( 'wp-format-library' );
		wp_enqueue_style( 'wp-edit-site' );
		wp_enqueue_style( 'wp-format-library' );
		wp_enqueue_media();
		do_action( 'enqueue_block_editor_assets' );
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( CartScriptsController::class, 'enqueue' ) );
		// return view.
		return '<div id="app"></div>';
	}
}
