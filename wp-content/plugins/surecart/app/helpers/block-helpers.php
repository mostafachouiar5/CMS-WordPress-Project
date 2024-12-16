<?php
if ( ! function_exists( 'sc_do_early_blocks' ) ) {
	/**
	 * Run the early blocks.
	 * We need to remove the debug notice that is triggered by the `doing_it_wrong` function.
	 *
	 * We use this function in page builders that can sometimes render the blocks out of order, causing the debug notice to be displayed.
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	function sc_pre_render_blocks( $content ) {
		add_filter( 'doing_it_wrong_trigger_error', 'sc_remove_interactivity_debug_notice', 10, 2 );

		$content = do_blocks( $content );

		remove_filter( 'doing_it_wrong_trigger_error', 'sc_remove_interactivity_debug_notice', 10 );

		return $content;
	}
}

if ( ! function_exists( 'sc_remove_interactivity_debug_notice' ) ) {
	/**
	 * Remove interactivity doing it wrong.
	 *
	 * This is because we need to render blocks out of order in order to
	 * add the attributes from bricks to the block.
	 *
	 * @param string $trigger Trigger.
	 * @param string $function_name Function name.
	 *
	 * @return string|false
	 */
	function sc_remove_interactivity_debug_notice( $trigger, $function_name ) {
		if ( 'WP_Interactivity_API::evaluate' !== $function_name ) {
			return $trigger;
		}
		return false;
	}
}
