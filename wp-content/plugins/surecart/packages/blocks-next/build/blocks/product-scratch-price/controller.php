<?php
$product = sc_get_product();

// If the scratch display amount is empty, return early.
if ( empty( $product->scratch_display_amount ) ) {
	return '';
}


return 'file:./view.php';
