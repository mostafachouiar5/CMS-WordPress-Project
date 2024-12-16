<!-- refresh this page every 15 minutes to prevent session from expiring -->
<meta http-equiv="refresh" content="1800" >

<?php \SureCart::render( 'layouts/partials/admin-settings-styles' ); ?>


<div id="sc-settings-container">
	<?php \SureCart::render( 'layouts/partials/admin-settings-header' ); ?>

	<div id="sc-settings-content">
		<div class="sc-container">
			<?php
			\SureCart::render(
				'layouts/partials/admin-settings-notices',
				[
					'status' => $status,
				]
			);
			?>

			<form action="<?php echo esc_url( add_query_arg( [ 'tab' => 'connection' ], menu_page_url( 'sc-settings', false ) ) ); ?>" method="post">
				<div class="sc-section-heading">
					<h3>
						<sc-icon name="upload-cloud"></sc-icon>
						<span><?php esc_html_e( 'Update Your Connection', 'surecart' ); ?></span>
					</h3>
					<sc-button type="primary" submit>
						<?php esc_html_e( 'Save', 'surecart' ); ?>
					</sc-button>
				</div>

				<?php wp_nonce_field( 'update_plugin_settings', 'nonce' ); ?>

				<sc-flex flex-direction="column" style="--spacing: var(--sc-spacing-xxx-large)">
					<sc-flex flex-direction="column">
						<sc-text style="--font-size: var(--sc-font-size-large); --font-weight: var(--sc-font-weight-bold); --line-height:1;"><?php esc_html_e( 'Connection Details', 'surecart' ); ?></sc-text>
						<sc-text style="margin-bottom: 1em; --line-height:1; --color: var(--sc-color-gray-500)"><?php esc_html_e( 'Add your API token to connect to SureCart.', 'surecart' ); ?></sc-text>
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
				</sc-flex>
			</form>
		</div>
	</div>
</div>

