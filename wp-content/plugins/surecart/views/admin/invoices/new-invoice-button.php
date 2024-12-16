<div class="sc-button-group" style="position: relative; top: -3px;">
	<a href="<?php echo esc_attr( \SureCart::getUrl()->create( 'invoices' ) . '&live_mode=true' ); ?>" class="button button-secondary" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
		<?php esc_html_e( 'Add New', 'surecart' ); ?>
	</a>

	<sc-dropdown placement="bottom-end">
		<button slot="trigger" class="button button-secondary" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" aria-haspopup="true" aria-expanded="false" aria-label="<?php esc_attr_e( 'More Options', 'surecart' ); ?>">
			<sc-icon name="chevron-down" style="vertical-align: middle; margin-top: -2px;"></sc-icon>
		</button>
		<sc-menu>
			<sc-menu-item href="<?php echo esc_attr( \SureCart::getUrl()->create( 'invoices' ) . '&live_mode=false' ); ?>">
				<?php esc_html_e( 'New Test Invoice', 'surecart' ); ?>
			</sc-menu-item>
		</sc-menu>
	</sc-dropdown>
</div>
