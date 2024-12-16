<style>
	#wpwrap {
		background: var(--sc-color-gray-50);
	}

	:root {
		--wp-admin-theme-color: #007cba;
		--sc-color-primary-500: var(--wp-admin-theme-color);
		--sc-focus-ring-color-primary: var(
			--wp-admin-theme-color
		);
		--sc-input-border-color-focus: var(
			--wp-admin-theme-color
		);
	}

	.sc-container {
		margin-left: auto;
		margin-right: auto;
		max-width: 768px;
		padding: 2rem;
	}

	.sc-section-heading {
		margin-bottom: 1.5rem;
		display: flex;
		align-items: center;
		justify-content: space-between;
		border-bottom: 1px solid rgba(229, 231, 235, 1);
		padding-bottom: 1rem;
	}

	.sc-section-heading h3 {
		margin: 0;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		font-size: 1.25rem;
		line-height: 1.75rem;
		font-weight: 600;
		color: rgba(17, 24, 39, 1);
		display: flex;
		align-items: center;
		gap: 0.5em;
		color: var(--sc-color-gray-900);
	}
</style>

<div class="wrap">
	<div class="sc-container">

		<?php if ( 'saved' === $status ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Saved.', 'surecart' ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( 'missing' === $status ) : ?>
			<div class="notice notice-error is-dismissible">
				<p><?php esc_html_e( 'Please enter an API key.', 'surecart' ); ?></p>
			</div>
		<?php endif; ?>

		<form action="" method="post">
			<div class="sc-section-heading">
				<h3>
					<sc-icon name="sliders"></sc-icon>
					<span><?php esc_html_e( 'Plugin Settings', 'surecart' ); ?></span>
				</h3>
				<sc-button type="primary" submit>
					<?php esc_html_e( 'Save Settings', 'surecart' ); ?>
				</sc-button>
			</div>

			<?php wp_nonce_field( 'update_plugin_settings', 'nonce' ); ?>

			<sc-flex flex-direction="column" style="--spacing: var(--sc-spacing-xxx-large)">
				<sc-flex flex-direction="column">
					<sc-text style="--font-size: var(--sc-font-size-large); --font-weight: var(--sc-font-weight-bold); --line-height:1;"><?php esc_html_e( 'Connection Details', 'surecart' ); ?></sc-text>
					<sc-text style="margin-bottom: 1em; --line-height:1; --color: var(--sc-color-gray-500)"><?php esc_html_e( 'Update your api token to change or update the connection to SureCart.', 'surecart' ); ?></sc-text>
					<sc-card>
						<sc-input label="<?php echo esc_attr_e( 'Api Token', 'surecart' ); ?>" type="password" value="<?php echo esc_attr( $api_token ); ?>" name="api_token" placeholder="<?php echo esc_attr_e( 'Enter your api token.', 'surecart' ); ?>"></sc-input>
					</sc-card>
					<?php if ( defined( 'SURECART_APP_URL' ) ) : ?>
						<sc-flex justify-content="center">
							<sc-button href="<?php echo esc_url( SURECART_APP_URL ) . '?switch_account_id=' . \SureCart::account()->id ?? null; ?>" type="link" target="_blank">
								<?php esc_html_e( 'Find My Api Token', 'surecart' ); ?>
								<sc-icon name="arrow-right" slot="suffix"></sc-icon>
							</sc-button>
						</sc-flex>
						<?php endif; ?>
				</sc-flex>

				<sc-flex flex-direction="column">
					<sc-text style="--font-size: var(--sc-font-size-large); --font-weight: var(--sc-font-weight-bold); --line-height:1;"><?php esc_html_e( 'Performance', 'surecart' ); ?></sc-text>
					<sc-text style="margin-bottom: 1em; --line-height:1; --color: var(--sc-color-gray-500)"><?php esc_html_e( 'Change your plugin performance settings.', 'surecart' ); ?></sc-text>
					<sc-card>
						<sc-switch name="use_esm_loader" <?php checked( $use_esm_loader, 1 ); ?> value="on">
							<?php esc_html_e( 'Use JavaScript ESM Loader', 'surecart' ); ?>
							<span slot="description" style="line-height: 1.4"><?php esc_html_e( 'This can slightly increase page load speed, but may require you to enable CORS headers for .js files on your CDN. Please check your checkout forms after you enable this option in a private browser window.', 'surecart' ); ?></span>
						</sc-switch>
					</sc-card>
				</sc-flex>

				<sc-flex flex-direction="column">
					<sc-text style="--font-size: var(--sc-font-size-large); --font-weight: var(--sc-font-weight-bold); --line-height:1;"><?php esc_html_e( 'Uninstall', 'surecart' ); ?></sc-text>
					<sc-text style="margin-bottom: 1em; --line-height:1; --color: var(--sc-color-gray-500)"><?php esc_html_e( 'Change your plugin uninstall settings.', 'surecart' ); ?></sc-text>
					<sc-card>
						<sc-switch name="uninstall" <?php checked( $uninstall, 1 ); ?> value="on">
							<?php esc_html_e( 'Remove Plugin Data', 'surecart' ); ?>
							<span slot="description"><?php esc_html_e( 'Completely remove all plugin data when deleted. This cannot be undone.', 'surecart' ); ?></span>
						</sc-switch>
					</sc-card>
				</sc-flex>
			</sc-flex>
		</form>
	</div>
</div>
