<style>
	#wpwrap {
		background: var(--sc-color-gray-50);
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
		color: var(--sc-color-gray-900);
	}
</style>

<div class="wrap">
	<div class="sc-container">
		<sc-dashboard-module>
			<sc-card>
				<sc-empty icon="shopping-bag">
					<sc-text style="--font-size: var(--sc-font-size-x-large); --line-height: var(--sc-line-height-normal); color: var(--sc-color-gray-900)">
						<?php esc_html_e( 'Coming soon...', 'surecart' ); ?>
					</sc-text>
					<?php esc_html_e( 'We are currently working on our Pro features. Please check back once we release new revenue and time saving features.', 'surecart' ); ?>
				</sc-empty>
			</sc-card>
		</sc-dashboard-module>
	</div>
</div>
