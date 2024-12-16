<?php
// get product.

use SureCart\Models\Blocks\ProductPageBlock;

$product = sc_get_product();

$controller = new ProductPageBlock();
$state      = $controller->state();
$context    = $controller->context();

wp_interactivity_state( 'surecart/product-page', $state );

return 'file:./view.php';
