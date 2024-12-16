<?php
global $sc_query_id;
$params         = \SureCart::block()->urlParams( 'products' );
$query_order_by = $params->getArg( 'orderby' ) ?? $block->context['query']['orderBy'] ?? '';
$query_order    = $params->getArg( 'order' ) ?? $block->context['query']['order'] ?? '';

$options = [
	[
		'value'   => 'date:desc',
		'href'    => $params->addArg( 'order', 'desc' )->addArg( 'orderby', 'date' )->url(),
		'label'   => esc_html__( 'Latest', 'surecart' ),
		'checked' => 'desc' === $query_order && 'date' === $query_order_by,
	],
	[
		'value'   => 'date:asc',
		'href'    => $params->addArg( 'order', 'asc' )->addArg( 'orderby', 'date' )->url(),
		'label'   => esc_html__( 'Oldest', 'surecart' ),
		'checked' => 'asc' === $query_order && 'date' === $query_order_by,
	],
	[
		'value'   => 'price:asc',
		'href'    => $params->addArg( 'order', 'asc' )->addArg( 'orderby', 'price' )->url(),
		'label'   => esc_html__( 'Price, low to high', 'surecart' ),
		'checked' => 'asc' === $query_order && 'price' === $query_order_by,
	],
	[
		'value'   => 'price:desc',
		'href'    => $params->addArg( 'order', 'desc' )->addArg( 'orderby', 'price' )->url(),
		'label'   => esc_html__( 'Price, high to low', 'surecart' ),
		'checked' => 'desc' === $query_order && 'price' === $query_order_by,
	],
];

// get the currently selected option.
$selected_options = array_filter( $options, fn( $option ) => $option['value'] === $query_order_by . ':' . $query_order );
$selected_option  = array_shift( $selected_options ) ?? $options[0];

// return the view.
return 'file:./view.php';
