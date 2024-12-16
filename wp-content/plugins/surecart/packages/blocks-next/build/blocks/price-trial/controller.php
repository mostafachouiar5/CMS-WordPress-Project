<?php
// no price in the context.
$price = $block->context['price'] ?? '';

if ( empty( $price ) || is_wp_error( $price ) ) {
	return '';
}

if ( empty( $price->trial_text ) ) {
	return '';
}

// return the view.
return 'file:./view.php';
