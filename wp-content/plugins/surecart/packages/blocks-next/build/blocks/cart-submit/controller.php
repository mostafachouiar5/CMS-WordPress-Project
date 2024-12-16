<?php
$wrapper_style  = '';
$wrapper_style .= ! empty( $attributes['border'] )
	? esc_attr( safecss_filter_attr( 'border-bottom:var(--sc-drawer-border)' ) ) . ';'
	: '';
$wrapper_style .= ! empty( $attributes['padding'] )
	? esc_attr( safecss_filter_attr( 'padding:' . $attributes['padding']['top'] . ' ' . $attributes['padding']['right'] . ' ' . $attributes['padding']['bottom'] . ' ' . $attributes['padding']['left'] ) ) . ';'
	: '';
$wrapper_style .= ! empty( $attributes['sectionBackgroundColor'] )
	? esc_attr( safecss_filter_attr( 'background-color:' . $attributes['sectionBackgroundColor'] ) ) . ';'
	: '';
$wrapper_style .= ! empty( $attributes['textColor'] )
	? esc_attr( safecss_filter_attr( 'color:' . $attributes['textColor'] ) ) . ';'
	: '';

$styles = sc_get_block_styles();

// Return the view.
return 'file:./view.php';
