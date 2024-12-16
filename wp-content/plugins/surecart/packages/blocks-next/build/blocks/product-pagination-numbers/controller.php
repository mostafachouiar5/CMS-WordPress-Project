<?php

use SureCart\Models\Blocks\ProductListBlock;

$controller       = new ProductListBlock( $block );
$query            = $controller->query();
$pagination_links = $query->pagination_links;

// Render the block.
return 'file:./view.php';
