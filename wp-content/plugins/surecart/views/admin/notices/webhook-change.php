<div class="notice notice-warning surecart-webhook-change-notice">
	<div class="breadcrumbs">
		<img style="display: block" src="<?php echo esc_url( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'images/logo.svg' ); ?>" alt="SureCart" width="125">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			width="16"
			height="16"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			>
			<polyline points="9 18 15 12 9 6" />
		</svg>
		<span><?php esc_html_e( 'Connection', 'surecart' ); ?></span>
	</div>
	<h1><?php esc_html_e( 'There are two websites connected to the same SureCart store.', 'surecart' ); ?></h1>
	<p class="description">
		<?php
		esc_html_e(
			'Two sites that are telling SureCart they are the same site. Please let us know how to treat this website change.',
			'surecart'
		);
		?>
		<a href="https://surecart.com/docs/change-surecart-url/" target="_blank" class="learn-more-safe-mode">
			<?php esc_html_e( 'Learn More', 'surecart' ); ?>
		</a>
	</p>
	<div class="webhook-cards">
		<div class="webhook-card">
			<h2><?php echo esc_html( sprintf( __( 'I want to update this site connection to the store "%s".', 'surecart' ), \SureCart::account()->name ) ); ?></h2>
			<p>
			<?php echo esc_html( sprintf( __( 'We will update the SureCart connection to the your new url. This is often the case when you have changed your website url or have migrated your site to a new domain.', 'surecart' ), \SureCart::account()->name ) ); ?>
			</p>
			<div class="webhook-links">
				<span class="previous-webhook"><?php echo esc_url( $previous_web_url ); ?></span>
				<span class="previous-to-current"> ↓ </span>
				<span class="current-webhook"><?php echo esc_url( $current_web_url ); ?></span>
				<p class="webhook-action-link">
					<a href="<?php echo esc_url( $update_url ); ?>">
						<?php esc_html_e( 'I Changed My Site Address', 'surecart' ); ?>
					</a>
				</p>
			</div>
		</div>
		<div class="webhook-card">
			<h2><?php echo esc_html( sprintf( __( 'I want to have both sites connected to the store "%s".', 'surecart' ), \SureCart::account()->name ) ); ?></h2>
			<p>
			<?php esc_html_e( 'We will create a new connection for this site. This can happen if you are using a staging site or want to have more than one website connected to the same store.', 'surecart' ); ?>
			</p>
			<div class="webhook-links">
				<span class="current-webhook"><?php echo esc_url( $previous_web_url ); ?></span>
				<span> - </span>
				<span class="current-webhook"><?php echo esc_url( $current_web_url ); ?></span>
				<p class="webhook-action-link">
					<a href="<?php echo esc_url( $add_url ); ?>">
						<?php esc_html_e( 'This Is A Duplicate Or Staging Site', 'surecart' ); ?>
					</a>
				</p>
			</div>
		</div>
	</div>
</div>
