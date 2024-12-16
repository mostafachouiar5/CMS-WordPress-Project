<style>
	#wpwrap {
		color: var(--sc-color-brand-body);
		background: var(--sc-color-brand-main-background);
	}


	.wrap {
		display: grid;
		height: calc(100vh - 32px);
	}

	.sc-container {
		margin: auto;
		max-width: 500px;
		width: 100%;
		padding: 2rem;
	}

	.sc-section-heading {
		margin-bottom: 0.5rem;
		display: flex;
		align-items: center;
		justify-content: space-between;
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
		color: var(--sc-color-brand-heading);
	}
</style>

<div class="wrap">
	<div class="sc-container">

		<?php if ( ! empty( $status ) && 'missing' === $status ) : ?>
			<div class="notice notice-error is-dismissible">
				<p><?php esc_html_e( 'Please enter an API key.', 'surecart' ); ?></p>
			</div>
		<?php endif; ?>


		<div class="sc-section-heading">
			<h3>
				<sc-icon name="download-cloud"></sc-icon>
				<?php esc_html_e( 'Just one last step!', 'surecart' ); ?>
			</h3>
		</div>

		<form action="" method="post">
			<?php wp_nonce_field( 'update_plugin_settings', 'nonce' ); ?>

			<sc-flex flex-direction="column" style="--spacing: var(--sc-spacing-xxx-large)">
				<sc-flex flex-direction="column">
					<sc-dashboard-module>
						<sc-card>
							<sc-input size="large" label="<?php echo esc_attr_e( 'Enter your API Token', 'surecart' ); ?>" type="password" name="api_token" placeholder="<?php echo esc_attr_e( 'Api token', 'surecart' ); ?>" autofocus></sc-input>
							<sc-button type="primary" size="large" full submit>
								<?php esc_html_e( 'Complete Installation', 'surecart' ); ?>
								<sc-icon name="arrow-right" slot="suffix"></sc-icon>
							</sc-button>
						</sc-card>
					</sc-dashboard-module>
				</sc-flex>
			</sc-flex>
		</form>
	</div>
</div>
