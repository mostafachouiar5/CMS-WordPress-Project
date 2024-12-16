<?php
$product = sc_get_product();
if ( empty( $product ) ) {
	return '';
}


$collections = get_the_terms( get_the_ID(), 'sc_collection' );
if ( empty( $collections ) ) {
	return '';
}

// Limit the number of items displayed based on the $attributes['count'] value.
if ( ! empty( $attributes['count'] ) ) {
	$collections = array_slice( $collections, 0, $attributes['count'] );
}

// return the view.
return 'file:./view.php';
