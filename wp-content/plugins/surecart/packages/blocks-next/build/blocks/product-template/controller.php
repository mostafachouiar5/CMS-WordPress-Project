<?php

use SureCart\Models\Blocks\ProductListBlock;

$controller = new ProductListBlock( $block );
$query      = $controller->query();

// If we have a button or a link, we need to wrap the content in a form element.
$has_button         = ( new \WP_HTML_Tag_Processor( $content ?? '' ) )->next_tag( 'button' );
$has_link           = ( new \WP_HTML_Tag_Processor( $content ?? '' ) )->next_tag( 'a' );
$html_tag           = $has_link || $has_button ? 'form' : 'a';
$wrapper_attributes = ( ! empty( $attributes['layout'] ) && ! empty( $attributes['layout']['columnCount'] ) ) ? array( 'class' => 'sc-product-template-columns-' . $attributes['layout']['columnCount'] ) : array();

return 'file:./view.php';
