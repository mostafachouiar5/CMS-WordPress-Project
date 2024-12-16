<style>
	#sc-admin-header {
		background-color: #fff;
		width: calc(100% + 20px);
		margin-left: -20px;
	}

	#sc-admin-container {
		padding: 20px;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	#sc-admin-title {
		margin: 0;
		font-size: var(--sc-font-size-large);
	}

	.sc-admin-suffix {
		display: flex;
		width: 16rem;
		align-items: center;
		justify-content: flex-end;
		gap: 1em;
	}
</style>


<div id="sc-admin-header">
	<?php if ( ! empty( $claim_url ) ) : ?>
		<sc-provisional-banner claim-url="<?php echo esc_url( $claim_url ); ?>"></sc-provisional-banner>
	<?php endif; ?>
	<div id="sc-admin-container">
		<?php if ( ! empty( $breadcrumbs ) ) : ?>
			<sc-breadcrumbs style="font-size: 16px">
				<sc-breadcrumb>
					<img style="display: block" src="<?php echo esc_url( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'images/logo.svg' ); ?>" alt="SureCart" width="125">
				</sc-breadcrumb>
				<?php foreach ( $breadcrumbs as $breadcrumb ) : ?>
					<sc-breadcrumb><?php echo esc_html( $breadcrumb['title'] ?? '' ); ?></sc-breadcrumb>
				<?php endforeach; ?>
			</sc-breadcrumbs>
		<?php endif; ?>
		<?php if ( ! empty( $suffix ) || ! empty( $report_url ) ) : ?>
		<div class="sc-admin-suffix">
			<?php
			if ( ! empty( $suffix ) ) {
				echo wp_kses_post( $suffix );
			}
			?>
			<?php
			if ( ! empty( $report_url ) ) {
				$report_url = add_query_arg( 'switch_account_id', \SureCart::account()->id, $report_url );
				?>
				<sc-button type="default" size="medium" href="<?php echo esc_url( $report_url ); ?>" target="_blank">
					<sc-icon name="bar-chart-2" slot="prefix"></sc-icon>
					<?php esc_html_e( 'View Reports', 'surecart' ); ?>
					<sc-icon name="external-link" slot="suffix"></sc-icon>
				</sc-button>
				<?php
			}
			?>
		</div>
		<?php endif; ?>
	</div>
</div>
