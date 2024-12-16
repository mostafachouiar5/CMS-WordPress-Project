<?php

namespace SureCart\WordPress\Assets;

/**
 * Controls when to enqueue a script based on block render.
 */
class BlockAssetsLoadService {
	/**
	 * Runs a callback when our components are detected through several means
	 *
	 * @param string        $block_name The block name, including namespace.
	 * @param callable|null $enqueue_callback A function to run when the block is rendered.
	 *
	 * @return void
	 */
	public function whenRendered( $block_name, $enqueue_callback = null ) {
		$this->whenBlockRenders( $block_name, $enqueue_callback );
		$this->whenUsingPageBuilder( $enqueue_callback );
		// global variable as a fallback.
		global $load_sc_js;
		if ( $load_sc_js ) {
			add_action( 'wp_enqueue_script', $enqueue_callback );
		}
	}

	/**
	 * Runs a callback when a block is rendered.
	 * Typical usage: scripts to be enqueued using this function will only get printed
	 * when the block gets rendered on the frontend.
	 *
	 * @param string        $block_name The block name, including namespace.
	 * @param callable|null $enqueue_callback A function to run when the block is rendered.
	 *
	 * @return void
	 */
	public function whenBlockRenders( $block_name, $enqueue_callback ) {
		/**
		 * Callback function to when a block is rendered.
		 * Typically to enqueue scripts when needed.
		 *
		 * @param string $content When the callback is used for the render_block filter,
		 *                        the content needs to be returned so the function parameter
		 *                        is to ensure the content exists.
		 * @return string Block content.
		 */
		$callback = static function ( $content, $block ) use ( $block_name, $enqueue_callback ) {
			// Sanity check.
			if ( empty( $block['blockName'] ) || $block_name !== $block['blockName'] ) {
				return $content;
			}

			// Run the callback.
			if ( ! empty( $enqueue_callback ) ) {
				call_user_func( $enqueue_callback, $content, $block );
			}

			// Return the content.
			return $content;
		};

		/*
		 * The filter's callback here is an anonymous function because
		 * using a named function in this case is not possible.
		 *
		 * The function cannot be unhooked, however, users are still able
		 * to dequeue the script registered/enqueued by the callback
		 * which is why in this case, using an anonymous function
		 * was deemed acceptable.
		 */
		add_filter( 'render_block', $callback, 10, 2 );
	}

	/**
	 * Handle when using a page builder.
	 *
	 * @param string $enqueue_callback Function Name.
	 * @return void
	 */
	public function whenUsingPageBuilder( $enqueue_callback ) {
		if ( $this->isUsingPageBuilder() ) {
			add_action( 'wp_enqueue_script', $enqueue_callback );
		}
	}

	/**
	 * Are we using a known page builder?
	 *
	 * @return boolean
	 */
	public function isUsingPageBuilder() {
		return ! empty( $this->getPageBuilder() );
	}

	/**
	 * Get the page builder.
	 *
	 * @return string
	 */
	public function getPageBuilder() {
		// enable on Elementor.
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! empty( $_GET['action'] ) && 'elementor' === sanitize_text_field( $_GET['action'] ) ) {
			return 'elementor';
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['elementor-preview'] ) ) {
			return 'elementor';
		}

		if ( class_exists( '\Elementor\Plugin' ) ) { // We are doing this because since elementor refresh editor using ajax if shortcode changes, the $_GET['action'] is not available.
			$elementor_instance = \Elementor\Plugin::instance();
			if ( isset( $elementor_instance->editor ) && method_exists( $elementor_instance->editor, 'is_edit_mode' ) && $elementor_instance->editor->is_edit_mode() ) {
				return 'elementor';
			}
		}

		// load for beaver builder.
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['fl_builder'] ) ) {
			return 'beaver';
		}
		// load for Divi builder.
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['et_fb'] ) || isset( $_GET['et_pb_preview'] ) ) {
			return 'divi';
		}

		// load for thrive architect builder.
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( isset( $_POST['tve_content'] ) ) {
			return 'thrive';
		}

		if ( ( ! empty( $_GET['bricks'] ) && 'run' === $_GET['bricks'] ) || ( \defined( 'BRICKS_IS_BUILDER' ) && \BRICKS_IS_BUILDER ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return 'bricks';
		}

		return '';
	}
}
