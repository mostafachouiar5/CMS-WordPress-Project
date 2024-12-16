<sc-subscriptions-list id="customer-subscriptions-list">
	<span slot="empty"><?php echo wp_kses_post( $empty ?? '' ); ?></span>
</sc-subscriptions-list>

<?php
\SureCart::assets()->addComponentData(
	'sc-subscriptions-list',
	'#customer-subscriptions-list',
	[
		'query' => $query ?? [],
	]
);
?>
