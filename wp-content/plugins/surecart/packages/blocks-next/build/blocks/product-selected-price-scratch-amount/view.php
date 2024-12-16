<span <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>
	data-wp-bind--hidden="!state.isOnSale"
	hidden>
	<span class="sc-screen-reader-text" data-wp-bind--aria-hidden="!context.selectedPrice.scratch_display_amount"><?php esc_html_e( 'Was', 'surecart' ); ?> </span>
	<span <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?> data-wp-text="context.selectedPrice.scratch_display_amount">
	</span>
</span>
