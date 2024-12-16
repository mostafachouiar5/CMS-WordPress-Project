<?php

$product = sc_get_product();


$gallery        = $product->gallery ?? [];
$featured_image = $gallery[0] ?? null;

// get the width.
if ( ! empty( $attributes['width'] ) ) {
	$width = is_numeric( $attributes['width'] ) ? $attributes['width'] . 'px' : $attributes['width'];
} else {
	$width = false;
}

// handle empty.
if ( empty( $gallery ) ) {
	return ! empty( $attributes['hide_empty'] ) ? '' : 'file:./empty.php';
}

// handle image.
if ( count( $gallery ) === 1 ) {
	return 'file:./image.php';
}

// only enqueue if we are needing a slideshow.
wp_enqueue_style( 'surecart-image-slider' );
wp_enqueue_script_module( '@surecart/image-slider' );

// handle slideshow.
$slider_options = array(
	'sliderOptions'      => array(
		'autoHeight'   => ! empty( $attributes['auto_height'] ),
		'spaceBetween' => 40,
	),
	'thumbSliderOptions' => array(
		'slidesPerView'  => $attributes['thumbnails_per_page'] ?? 5,
		'slidesPerGroup' => $attributes['thumbnails_per_page'] ?? 5,
		'breakpoints'    => array(
			320 => array(
				'slidesPerView'  => $attributes['thumbnails_per_page'] ?? 5,
				'slidesPerGroup' => $attributes['thumbnails_per_page'] ?? 5,
			),
		),
	),
);

$height = 'auto';
if ( empty( $attributes['auto_height'] ) && ! empty( $attributes['height'] ) ) {
	$height = $attributes['height'];
}

return 'file:./slideshow.php';
