<div id="sc-nav" style="--sc-tabs-min-width: 0;">
	<?php if ( (bool) \SureCart\Models\ApiToken::get() ) : ?>
		<sc-tab href="<?php echo esc_url( remove_query_arg( 'tab' ) ); ?>" <?php echo ! $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="sliders"></sc-icon>
			<?php esc_html_e( 'Store Settings', 'surecart' ); ?>
		</sc-tab>

		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'brand' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'brand' === $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="pen-tool"></sc-icon>
			<?php esc_html_e( 'Design & Branding', 'surecart' ); ?>
		</sc-tab>

		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'order' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'order' === $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="shopping-bag"></sc-icon>
			<?php esc_html_e( 'Orders & Invoices', 'surecart' ); ?>
		</sc-tab>

		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'abandoned_checkout' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'abandoned_checkout' === $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="shopping-cart"></sc-icon>
			<?php esc_html_e( 'Abandoned Checkout', 'surecart' ); ?>
		</sc-tab>

		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'customer_notification_protocol' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'customer_notification_protocol' === $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="bell"></sc-icon>
			<?php esc_html_e( 'Notifications', 'surecart' ); ?>
		</sc-tab>

		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'subscription_protocol' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'subscription_protocol' === $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="refresh-ccw"></sc-icon>
			<?php esc_html_e( 'Subscriptions', 'surecart' ); ?>
		</sc-tab>

		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'subscription_preservation' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'subscription_preservation' === $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="bar-chart-2"></sc-icon>
			<?php esc_html_e( 'Subscription Saver', 'surecart' ); ?>
		</sc-tab>

		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'affiliation_protocol' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'affiliation_protocol' === $tab ? 'active' : ''; ?> >
			<sc-icon style="font-size: 18px; width: 18px; stroke-width: 4; opacity: 0.7" name="mouse-pointer" slot="prefix"></sc-icon>
			<?php esc_html_e( 'Affiliates', 'surecart' ); ?>
		</sc-tab>
		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'tax_protocol' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'tax_protocol' === $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="tag"></sc-icon>
			<?php esc_html_e( 'Taxes', 'surecart' ); ?>
		</sc-tab>
		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'shipping_protocol' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'shipping_protocol' === $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="truck"></sc-icon>
			<?php esc_html_e( 'Shipping', 'surecart' ); ?>
		</sc-tab>
		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'processors' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'processors' === $tab ? 'active' : ''; ?>>
			<sc-icon slot="prefix" style="width: 18px; height: 18px; opacity: 0.7;" name="credit-card"></sc-icon>
			<?php esc_html_e( 'Payment Processors', 'surecart' ); ?>
		</sc-tab>
		<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'export' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'export' === $tab ? 'active' : ''; ?> >
			<sc-icon style="font-size: 18px; width: 18px; stroke-width: 4; opacity: 0.7" name="layers" slot="prefix"></sc-icon>
			<?php esc_html_e( 'Data Export', 'surecart' ); ?>
		</sc-tab>
	<?php endif; ?>

	<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'connection' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'connection' === $tab ? 'active' : ''; ?> >
		<sc-icon style="font-size: 18px; width: 18px; stroke-width: 4; opacity: 0.7" name="upload-cloud" slot="prefix"></sc-icon>
		<?php esc_html_e( 'Connection', 'surecart' ); ?>
	</sc-tab>

	<sc-tab href="<?php echo esc_url( add_query_arg( [ 'tab' => 'advanced' ], menu_page_url( 'sc-settings', false ) ) ); ?>" <?php echo 'advanced' === $tab ? 'active' : ''; ?> >
		<sc-icon style="font-size: 18px; width: 18px; stroke-width: 4; opacity: 0.7" name="sliders" slot="prefix"></sc-icon>
		<?php esc_html_e( 'Advanced', 'surecart' ); ?>
	</sc-tab>

	<a href="https://surecart.com/support/" target="_blank" class="surecart-help">
		<sc-icon style="font-size: 18px; width: 22px; stroke-width: 4;" name="life-buoy"></sc-icon>
		<?php esc_html_e( 'Help', 'surecart' ); ?>
	</a>

</div>
