<?php

namespace SureCart\Controllers\Admin\Tables;

/**
 * Mode dropdown trait.
 */
trait HasModeFilter {
    /**
	 * Displays a mode drop-down for filtering items.
	 *
	 * @access protected
	 *
	 */
	protected function mode_dropdown() {
		/**
		 * Filters whether to remove the 'Formats' drop-down from the post list table.
		 *
		 * @param bool   $disable   Whether to disable the drop-down. Default false.
		 */
		if ( apply_filters( 'surecart/disable_mode_dropdown', false ) ) {
			return;
		}

		$mode = sanitize_text_field( wp_unslash( $_GET['mode'] ?? '' ) );
		?>

		<label for="filter-by-mode" class="screen-reader-text">
			<?php
			/* translators: Hidden accessibility text. */
			esc_html_e( 'Filter by mode', 'surecart' );
			?>
		</label>
		<select name="mode" id="filter-by-mode">
			<option<?php selected( $mode, '' ); ?> value=""><?php esc_html_e( 'Live & Test Mode', 'surecart' ); ?></option>
			<option<?php selected( $mode, 'live' ); ?> value="live"><?php echo esc_html_e( 'Live Mode', 'surecart' ); ?></option>
			<option<?php selected( $mode, 'test' ); ?> value="test"><?php echo esc_html_e( 'Test Mode', 'surecart' ); ?></option>
		</select>
		<?php
	}
}
