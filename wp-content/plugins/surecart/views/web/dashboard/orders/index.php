<sc-orders-list id="customer-orders-index"></sc-orders-list>
<?php
\SureCart::assets()->addComponentData(
	'sc-orders-list',
	'#customer-orders-index',
	[
		'query' => $query ?? [],
	]
);
?>
