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
		padding: 2rem;
	}

	.sc-section-heading {
		margin-bottom: 1rem;
		display: flex;
		align-items: center;
		flex-direction: column;
		gap: 1em;
		justify-content: space-between;
		/* border-bottom: 1px solid rgba(229, 231, 235, 1); */
		/* padding-bottom: 1rem; */
	}
	.sc-heading {
		margin: 0;
		margin-bottom: 0.25em;
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
		<div class="sc-section-heading">
			<div class="sc-section-logo">
				<img style="display: block" src="<?php echo esc_url( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'images/logo.svg' ); ?>" alt="SureCart" width="125">
			</div>

		</div>
		<sc-dashboard-module>
				<sc-card>
					<sc-text style="--font-size: var(--sc-font-size-x-large); --line-height: var(--sc-line-height-normal)">
					<?php esc_html_e( 'Get started by creating your first product or creating a new checkout form.', 'surecart' ); ?>
				</sc-text>
				<sc-button type="primary" full size="large" href="<?php echo esc_url_raw( $product_url ); ?>">
					<sc-icon name="shopping-bag" slot="prefix"></sc-icon>
					<?php esc_html_e( 'Create A Product', 'surecart' ); ?>
				</sc-button>
				<sc-button type="primary" outline full size="large" href="<?php echo esc_url_raw( $form_url ); ?>">
					<sc-icon name="layers" slot="prefix"></sc-icon>
					<?php esc_html_e( 'Create A Form', 'surecart' ); ?>
				</sc-button>
			</sc-card>
			<sc-button full type="text" size="large" href="mailto:hello@surecart.com" target="_blank">
				<sc-icon name="life-buoy" slot="prefix"></sc-icon>
				<?php esc_html_e( 'Get Help', 'surecart' ); ?>
				<sc-icon name="external-link" slot="suffix"></sc-icon>
			</sc-button>
		</sc-dashboard-module>
	</div>
</div>
