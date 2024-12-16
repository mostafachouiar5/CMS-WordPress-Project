<?php

$product = sc_get_product();

if ( get_query_var( 'sc_upsell_id' ) ) {
	return 'file:./upsell-quantity.php';
}

$styles = sc_get_block_styles();

// return the view.
return 'file:./view.php';
