<?php
$product = sc_get_product();

// make sure we have the initial price.
if ( empty( $product->initial_price ) ) {
	return '';
}

return 'file:./view.php';
