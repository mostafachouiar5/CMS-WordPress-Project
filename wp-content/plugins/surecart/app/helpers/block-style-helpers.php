<?php
/**
 * Get the current block styles.
 *
 * @param bool   $combine Whether to combine the styles or not.
 * @param object $block The block object.
 * @return array
 */
function sc_get_block_styles( $combine = true, $block = null ) {
	return \SureCart::block()->styles()->get( $combine, $block );
}

/**
 * Get cart block style.
 *
 * @param  array $attributes
 *
 * @return string
 */
function sc_get_cart_block_style( $attributes ) {
	$style = '';

	// Border style.
	$style .= isset( $attributes['border'] ) && $attributes['border'] !== false ? 'border-bottom: var(--sc-drawer-border);' : '';

	// Padding style.
	$style .= ! empty( $attributes['padding']['top'] ) ? 'padding-top: ' . $attributes['padding']['top'] . ';' : '';
	$style .= ! empty( $attributes['padding']['bottom'] ) ? 'padding-bottom: ' . $attributes['padding']['bottom'] . ';' : '';
	$style .= ! empty( $attributes['padding']['left'] ) ? 'padding-left: ' . $attributes['padding']['left'] . ';' : '';
	$style .= ! empty( $attributes['padding']['right'] ) ? 'padding-right: ' . $attributes['padding']['right'] . ';' : '';

	// Background color style.
	$style .= ! empty( $attributes['backgroundColor'] ) ? 'background-color: ' . $attributes['backgroundColor'] . ';' : '';

	// Text color style.
	$text_color = $attributes['textColor'] ?? 'var(--sc-line-item-title-color, var(--sc-input-label-color))';
	$style .= 'color: ' . $text_color . ';';

	return $style;
}
