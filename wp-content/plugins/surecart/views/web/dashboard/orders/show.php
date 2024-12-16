<sc-breadcrumbs>
	<sc-breadcrumb href="<?php echo esc_url( $back_url ); ?>">Dashboard</sc-breadcrumb>
	<sc-breadcrumb>Order</sc-breadcrumb>
</sc-breadcrumbs>

<sc-card
	style="--spacing: var(--sc-spacing-medium)"
	no-divider
>
	<sc-order-detail
		order-id="<?php echo esc_attr( $id ); ?>"
		style="margin-bottom: 2em;"
	>
		<span slot="title">
			<?php echo __( 'Order Details', 'surecart' ); ?>
			<sc-divider></sc-divider>
		</span>
	</sc-order-detail>
	<?php
		\SureCart::assets()->addComponentData(
			'sc-order-detail',
			'',
			[
				'query' => $order['query'] ?? [],
			]
		);
		?>

	<sc-charges-list
		id="customer-order-charges-list"
		style="margin-bottom: 2em;"
	>
		<span slot="title">
			<?php echo __( 'Payment', 'surecart' ); ?>
			<sc-divider></sc-divider>
		</span>
		<span slot="empty">
			<sc-alert
				type="info"
				open
			>
			<?php esc_html_e( 'You have not been charged for this order.', 'surecart' ); ?>
			</sc-alert>
		</span>
	</sc-charges-list>
	<?php
		\SureCart::assets()->addComponentData(
			'sc-charges-list',
			'#customer-order-charges-list',
			[
				'query' => $charges['query'] ?? [],
			]
		);
		?>

	<sc-subscriptions-list id="<?php echo esc_attr( 'list' . $id ); ?>">
		<span slot="title">
			<?php echo __( 'Subscriptions', 'surecart' ); ?>
			<sc-divider></sc-divider>
		</span>
		<span slot="empty"></span>
	</sc-subscriptions-list>
	<?php
		\SureCart::assets()->addComponentData(
			'sc-subscriptions-list',
			'#list' . $id,
			[
				'query' => $subscriptions['query'] ?? [],
			]
		);
		?>
</sc-card>
