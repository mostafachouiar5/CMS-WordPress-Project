<?php
// Get the arrows and label show/hide from context.

use SureCart\Models\Blocks\ProductListBlock;

$pagination_arrow = $block->context['paginationArrow'] ?? '';
$show_label       = $block->context['showLabel'] ?? true;

// Map the arrow name to the icon name.
$arrow_name = [
	'none'    => '',
	'arrow'   => is_rtl() ? 'arrow-left' : 'arrow-right',
	'chevron' => is_rtl() ? 'chevron-left' : 'chevron-right',
][ $pagination_arrow ] ?? $pagination_arrow;

$controller = new ProductListBlock( $block );
$query      = $controller->query();
$page_link  = $query->next_page_link;

// Render the block.
return 'file:./view.php';
