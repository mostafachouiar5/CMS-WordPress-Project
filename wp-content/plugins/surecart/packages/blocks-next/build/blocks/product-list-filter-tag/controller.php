<?php
// no collection id context.
if ( empty( $block->context['surecart/filter_tag'] ) ) {
	return;
}

$filter_tag = (object) $block->context['surecart/filter_tag'];

// return the view.
return 'file:./view.php';
