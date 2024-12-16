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
		margin-bottom: 0.5rem;
		display: flex;
		align-items: center;
		justify-content: space-between;
		/* border-bottom: 1px solid rgba(229, 231, 235, 1); */
		/* padding-bottom: 1rem; */
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
		<div class="sc-section-heading">
			<h3>
				<sc-icon name="shopping-bag"></sc-icon>
				<?php esc_html_e( 'Welcome to SureCart!', 'surecart' ); ?>
			</h3>
		</div>
		<sc-dashboard-module>
			<sc-card>
				<sc-text style="--font-size: var(--sc-font-size-x-large); --line-height: var(--sc-line-height-normal)">
					<?php esc_html_e( 'Commerce on WordPress has never been easier, faster, or more flexible.', 'surecart' ); ?>
				</sc-text>
				<sc-button type="primary" full size="large" href="<?php echo esc_url_raw( $url ); ?>">
					<?php esc_html_e( 'Set Up My Store', 'surecart' ); ?>
					<sc-icon name="arrow-right" slot="suffix"></sc-icon>
				</sc-button>
			</sc-card>
			<!--
			<sc-text style="--font-size: var(--sc-font-sizesmall); --line-height: var(--sc-line-height-normal); --text-align: center; --color: var(--sc-color-gray-500)">
				By clicking "Set Up", you agree to our <a href="#" target="_blank">Terms of Service</a>.
			</sc-text>
			-->
		</sc-dashboard-module>
	</div>
</div>
