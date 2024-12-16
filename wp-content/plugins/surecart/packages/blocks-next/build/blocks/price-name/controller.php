<?php
$product = sc_get_product();

if ( empty( $product ) ) {
	return '';
}

// no price in the context.
$price = $block->context['price'] ?? '';

if ( empty( $price ) || is_wp_error( $price ) ) {
	return '';
}

// return the view.
return 'file:./view.php';
