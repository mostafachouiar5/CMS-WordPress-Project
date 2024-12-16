<?php
// no price in the context.
$price = $block->context['price'] ?? '';

if ( empty( $price ) || is_wp_error( $price ) ) {
	return '';
}

if ( empty( $price->scratch_display_amount ) ) {
	return '';
}

$scratch_amount = $price->scratch_display_amount;

// translators: %1$s: scratch amount.
$screen_reader_text = sprintf( esc_attr__( 'Scratch Price: %1$s', 'surecart' ), $scratch_amount );

// return the view.
return 'file:./view.php';
