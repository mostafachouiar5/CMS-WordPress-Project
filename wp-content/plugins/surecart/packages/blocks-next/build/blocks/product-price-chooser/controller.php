<?php
// get product from initial state.
$product = sc_get_product();

// make sure we have a product.
if ( empty( $product->id ) || ! $product->has_multiple_prices ) {
	return '';
}

$prices = $product->active_prices;

return 'file:./view.php';
