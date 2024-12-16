<?php
use SureCart\Models\Blocks\ProductListBlock;

global $sc_query_id;

// Set the intitial state used in SSR.
wp_interactivity_state(
	'surecart/product-list',
	[
		'loading'   => false,
		'searching' => false,
	]
);

// For Analytics.
$controller = new ProductListBlock( $block );
$query      = $controller->query();
$products   = $query->products;

// return the view.
return 'file:./view.php';
