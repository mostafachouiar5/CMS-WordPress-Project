<?php \SureCart::render( 'layouts/partials/admin-settings-styles' ); ?>

<div id="sc-settings-container">
	<?php \SureCart::render( 'layouts/partials/admin-settings-header' ); ?>

	<div id="sc-settings-content">
		<?php
			\SureCart::render(
				'layouts/partials/admin-settings-sidebar',
				[
					'tab' => $tab,
				]
			);
			?>

		<div class="sc-container">
			<?php
			\SureCart::render(
				'layouts/partials/admin-settings-notices',
				[
					'status' => $status,
				]
			);
			?>

			<form action="" method="post">
				<div class="sc-section-heading">
					<h3>
						<sc-icon name="sliders"></sc-icon>
						<span><?php esc_html_e( 'Advanced Settings', 'surecart' ); ?></span>
					</h3>
					<sc-button type="primary" submit>
						<?php esc_html_e( 'Save', 'surecart' ); ?>
					</sc-button>
				</div>

				<?php wp_nonce_field( 'update_plugin_settings', 'nonce' ); ?>

				<sc-flex flex-direction="column" style="--spacing: var(--sc-spacing-xx-large)">
					<sc-flex flex-direction="column">
						<sc-text style="--font-size: var(--sc-font-size-large); --font-weight: var(--sc-font-weight-bold); --line-height:1; --color: var(--sc-color-brand-heading)"><?php esc_html_e( 'Performance', 'surecart' ); ?></sc-text>
						<sc-text style="margin-bottom: 1em; --line-height:1; --color: var(--sc-color-brand-body)"><?php esc_html_e( 'Change your plugin performance settings.', 'surecart' ); ?></sc-text>
						<sc-card>
							<sc-switch name="use_esm_loader" <?php checked( $use_esm_loader, 1 ); ?> value="on">
								<?php esc_html_e( 'Use JavaScript ESM Loader', 'surecart' ); ?>
								<span slot="description" style="line-height: 1.4"><?php esc_html_e( 'This can slightly increase page load speed, but may require you to enable CORS headers for .js files on your CDN. Please check your checkout forms after you enable this option in a private browser window.', 'surecart' ); ?></span>
							</sc-switch>
						</sc-card>
					</sc-flex>

					<sc-flex flex-direction="column">
						<sc-text style="--font-size: var(--sc-font-size-large); --font-weight: var(--sc-font-weight-bold); --line-height:1;"><?php esc_html_e( 'Legacy Features', 'surecart' ); ?></sc-text>
						<sc-text style="margin-bottom: 1em; --line-height:1; --color: var(--sc-color-brand-body)"><?php esc_html_e( 'Opt-in to some legacy features of the plugin.', 'surecart' ); ?></sc-text>
						<sc-card>
							<sc-switch name="stripe-payment-element" <?php checked( $stripe_payment_element, 0 ); ?> value="off">
								<?php esc_html_e( 'Use the Stripe Card Element', 'surecart' ); ?>
								<span slot="description"><?php esc_html_e( "Use Stripe's Card Element instead of the Payment Element in all forms.", 'surecart' ); ?></span>
							</sc-switch>
						</sc-card>
					</sc-flex>

					<sc-flex flex-direction="column">
						<sc-text style="--font-size: var(--sc-font-size-large); --font-weight: var(--sc-font-weight-bold); --line-height:1;"><?php esc_html_e( 'Uninstall', 'surecart' ); ?></sc-text>
						<sc-text style="margin-bottom: 1em; --line-height:1; --color: var(--sc-color-brand-body)"><?php esc_html_e( 'Change your plugin uninstall settings.', 'surecart' ); ?></sc-text>
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
</div>

