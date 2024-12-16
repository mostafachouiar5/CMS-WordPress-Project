<?php
// no price in the context.
$price = $block->context['price'] ?? '';

if ( empty( $price ) || is_wp_error( $price ) || empty( $price->short_interval_text ) || empty( $price->interval_text ) ) {
	return '';
}

// return the view.
return 'file:./view.php';
