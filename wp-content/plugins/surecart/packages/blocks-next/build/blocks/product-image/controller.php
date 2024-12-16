<?php
$class = $attributes['sizing'] ? 'contain' === $attributes['sizing'] ? 'sc-is-contained' : 'sc-is-covered' : 'sc-is-covered';

$style  = '';
$style .= ! empty( $attributes['aspectRatio'] )
	? esc_attr( safecss_filter_attr( 'aspect-ratio:' . $attributes['aspectRatio'] ) ) . ';'
	: '';
$style .= ! empty( $attributes['width'] )
	? esc_attr( safecss_filter_attr( 'width:' . $attributes['width'] ) ) . ';'
	: '';
$style .= ! empty( $attributes['height'] )
	? esc_attr( safecss_filter_attr( 'height:' . $attributes['height'] ) ) . ';'
	: '';

$is_link = ( isset( $attributes['isLink'] ) && $attributes['isLink'] );
$rel     = ! empty( $attributes['rel'] ) ? $attributes['rel'] : '';

$product_image_html = sc_get_product_featured_image( 'medium_large', [ 'loading' => 'lazy' ] );

if ( $product_image_html ) {
	return 'file:./view.php';
}

return 'file:./empty.php';
