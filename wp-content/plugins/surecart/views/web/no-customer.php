<sc-card style="font-size: 16px;">
	<sc-text tag="h2" style="--font-size: var(--sc-font-size-x-large);">
	<?php esc_html_e( 'It looks like you are not yet a customer.', 'surecart' ); ?></sc-text>
	<sc-text tag="p" style="--color: var(--sc-font-color-gray-500)">
		<?php esc_html_e( 'You must first purchase something to access your dashboard.', 'surecart' ); ?>
	</sc-text>
	<sc-button type="primary" href="<?php echo esc_url( get_home_url() ); ?>">
		<?php esc_html_e( 'Home', 'surecart' ); ?>
	</sc-button>
	<sc-button type="text" href="<?php echo esc_url( wp_logout_url( get_home_url() ) ); ?>">
		<?php esc_html_e( 'Logout', 'surecart' ); ?>
	</sc-button>
</sc-card>
