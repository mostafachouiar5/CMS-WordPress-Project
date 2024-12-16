<?php
// get product from initial state.
$product = sc_get_product();

// make sure we have a product and variant options.
if ( empty( $product->id ) || empty( $product->variant_options->data ) ) {
	return;
}

// return the view.
return 'file:./view.php';
