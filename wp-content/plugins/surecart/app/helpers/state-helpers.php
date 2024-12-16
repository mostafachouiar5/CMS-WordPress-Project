<?php
if ( ! function_exists( 'sc_initial_state' ) ) {
	/**
	 * Merge data with the existing store.
	 *
	 * @param array $data Data that will be merged with the existing store.
	 *
	 * @return $data The current store data.
	 */
	function sc_initial_state( $data = null ) {
		if ( $data ) {
			\SureCart::state()->mergeData( $data );
		}
		return \SureCart::state()->getData();
	}
}

if ( ! function_exists( 'sc_initial_line_items' ) ) {
	/**
	 * Get the current store state.
	 *
	 * @param array $data Data that will be merged with the existing store.
	 *
	 * @return array The current store state.
	 */
	function sc_initial_line_items( $data = [] ) {
		if ( $data ) {
			return \SureCart::state()->lineItems()->merge( $data );
		}
		return \SureCart::state()->lineItems()->get();
	}
}
