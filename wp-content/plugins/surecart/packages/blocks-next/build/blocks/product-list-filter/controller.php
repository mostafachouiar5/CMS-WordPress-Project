<?php
global $sc_query_id;

$taxonomy_slug   = $attributes['taxonomy'] ?? 'sc_collection';
$taxonomy_object = get_taxonomy( $taxonomy_slug );

// get non-empty terms.
$terms = get_terms(
	array(
		'taxonomy'   => $taxonomy_slug,
		'hide_empty' => true,
	)
);

// we are on a collection page.
$current_term = get_queried_object();
if ( is_a( $current_term, \WP_Term::class ) ) {
	return '';
}

$url        = \SureCart::block()->urlParams( 'products' );
$filter_key = $url->getKey( 'filter' );

$options = array_map(
	function ( $term ) use ( $url, $taxonomy_slug ) {
		return [
			'value'   => $term->slug,
			'label'   => $term->name,
			'href'    => $url->hasFilterArg( $taxonomy_slug, $term->slug ) ? $url->removeFilterArg( $taxonomy_slug, $term->slug ) : $url->addFilterArg( $taxonomy_slug, $term->slug ),
			'checked' => $url->hasFilterArg( $taxonomy_slug, $term->slug ),
		];
	},
	$terms ?? []
);

// no filter options.
if ( empty( $options ) ) {
	return '';
}

// return the view.
return 'file:./view.php';
