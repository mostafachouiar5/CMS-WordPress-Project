<?php
use SureCart\Models\Blocks\ProductListBlock;

// we have already defined a search query.
if ( ! empty( $block->context['query']['search'] ) ) {
	return null;
}

// get the search query.
$controller = new ProductListBlock( $block );
$list_query = $controller->query();
$value      = $list_query->s;

// return the view.
return 'file:./view.php';
