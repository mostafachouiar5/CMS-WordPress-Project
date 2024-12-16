<style>
	#wpwrap {
		color: var(--sc-color-brand-body);
		background: var(--sc-color-brand-main-background);
		--sc-color-primary-500: var(--sc-color-brand-primary);
		--sc-focus-ring-color-primary: var(--sc-color-brand-primary);
		--sc-input-border-color-focus: var(--sc-color-brand-primary);
	}

	#wpbody {
		padding-right: 20px;
	}

	.wrap {
		display: grid;
		width: 100%;
	}

	.sc-container {
		margin: auto;
		width: 100%;
	}

	.sc-banner-text {
		margin: auto;
		max-width: 600px;
		text-align: center;
	}
	.sc-banner-text,
	.sc-banner-top-img-area {
		padding: 6%;
		width: 100%;
	}

	@media screen and (min-width: 1180px) {
		.sc-banner-text,
		.sc-banner-top-img-area {
			flex:1
		}
	}

	.sc-banner-top-area {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		overflow: hidden;
		background-color: #ffffff;
		border: 1px solid var(--sc-color-gray-200);
		max-width: 1600px;
		margin: auto;
		border-radius: var(--sc-border-radius-large);
		margin-bottom: 2em;
	}

	.sc-banner-top-area img {
		max-width: 600px;
		margin: 0px;
		padding: 0px;
		padding: 5%;
	}

	.sc-get-started-top-desc {
		margin-top: 10px;
	}

	.sc-get-started-button{
		margin-top: 20px;
	}

	#sc-settings-header {
		box-sizing: border-box;
		width: 100%;
		position: sticky;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 20px;
		background: #fff;
		border-bottom: 1px solid var(--sc-color-gray-200);
		height: 66px;
	}

	.cta-video {
		aspect-ratio: 16/9;
		width: 100%;
	}
</style>

<div class="wrap">
	<div class="sc-section-top-banner">
		<div class="sc-banner-top-area">
			<div class="sc-banner-text">
				<div style="margin-bottom:1em;">
					<svg  viewBox="0 0 290 290" fill="none" xmlns="http://www.w3.org/2000/svg" width="35">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M145 290C225.081 290 290 225.081 290 145C290 64.9187 225.081 0 145 0C64.9187 0 0 64.9187 0 145C0 225.081 64.9187 290 145 290ZM145.624 72.5C133.982 72.5 117.869 79.1583 109.637 87.3718L87.2765 109.679H198.728L235.994 72.5H145.624ZM180.176 202.628C171.943 210.842 155.831 217.5 144.188 217.5H53.8177L91.0844 180.321H202.536L180.176 202.628ZM216.398 128.269H68.6835L61.7061 135.24C45.1844 150.112 50.0845 161.731 73.2223 161.731H221.337L228.317 154.76C244.678 139.975 239.536 128.269 216.398 128.269Z" fill="#01824C"/>
					</svg>
				</div>

				<sc-text style="--font-size: var(--sc-font-size-xxx-large); --line-height: 50px; --font-weight: var(--sc-font-weight-bold); --text-align: center;">
					<?php esc_html_e( 'The easiest thing you can do to increase subscription revenue.', 'surecart' ); ?>
				</sc-text>
				<sc-text class="sc-get-started-top-desc" style="--font-size: var(--sc-font-size-x-large); --line-height: var(--sc-line-height-normal); --text-align: center;">
					<?php esc_html_e( 'Automatically lower your subscription cancellation while making customers happy and saving more revenue with Subscription Saver.', 'surecart' ); ?>
				</sc-text>
				<sc-button class="sc-get-started-button" type="primary" target="_blank" size="large" href="<?php echo esc_url_raw( \SureCart::config()->links->purchase ); ?>">
					<?php esc_html_e( 'Get Subscription Saver', 'surecart' ); ?>
					<sc-icon name="arrow-right" slot="suffix"></sc-icon>
				</sc-button>
			</div>
			<!--<div class="sc-banner-top-img-area">
				<iframe class="cta-video" src="https://www.youtube.com/embed/JL1UxdwWXIM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>-->
		</div>
	</div>
</div>
