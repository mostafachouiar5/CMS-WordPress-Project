<?php
// no price in the context.
$price = $block->context['price'] ?? '';

if ( empty( $price ) || is_wp_error( $price ) ) {
	return '';
}

// get the display amount.
// translators: %1$s: amount.
$display_amount = $price->display_amount;

// translators: %1$s: amount.
$screen_reader_text = sprintf( esc_attr__( 'Price: %1$s', 'surecart' ), $display_amount );
if ( ! empty( $price->payments_text ) ) {
	$screen_reader_text .= ' ' . $price->payments_text;
}

// return the view.
return 'file:./view.php';
