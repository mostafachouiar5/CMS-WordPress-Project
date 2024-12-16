<?php
$product = sc_get_product();
// make sure we have a product.
if ( empty( $product->id ) ) {
	return '';
}

// make sure we have selected price.
if ( empty( $product->initial_price ) ) {
	return '';
}

// return the view.
return 'file:./view.php';
