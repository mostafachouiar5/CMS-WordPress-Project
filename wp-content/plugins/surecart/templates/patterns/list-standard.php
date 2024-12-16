<?php
/**
 * Classic Product Carousel block pattern.
 */
return [
	'title'      => __( 'Classic Product List', 'surecart' ),
	'categories' => [ 'surecart_shop' ],
	'blockTypes' => [ 'surecart/product-list' ],
	'priority'   => 0,
	'content'    => '<!-- wp:surecart/product-list {"metadata":{"categories":["surecart_shop"],"patternName":"surecart-list-standard","name":"Standard"},"align":"wide","style":{"spacing":{"blockGap":"10px","margin":{"left":"0px","right":"0px"}}}} -->
<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"10px"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="margin-bottom:10px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:surecart/product-list-sort /-->

<!-- wp:surecart/product-list-filter /--></div>
<!-- /wp:group -->

<!-- wp:surecart/product-list-search {"style":{"layout":{"selfStretch":"fixed","flexSize":"250px"}}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"10px"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-bottom:10px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:surecart/product-list-filter-tags -->
<!-- wp:surecart/product-list-filter-tag /-->
<!-- /wp:surecart/product-list-filter-tags --></div>
<!-- /wp:group -->

<!-- wp:surecart/product-template {"style":{"spacing":{"blockGap":"36px"}},"layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"224px"}} -->
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"color":{"background":"#0000000d"},"border":{"radius":"10px"},"spacing":{"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"},"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background" style="border-radius:10px;background-color:#0000000d;margin-top:0px;margin-bottom:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.5},"contentPosition":"top right","isDark":false,"style":{"dimensions":{"aspectRatio":"3/4"},"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"bottom":"15px"}},"border":{"radius":"10px"}},"layout":{"type":"default"}} -->
<div class="wp-block-cover is-light has-custom-content-position is-position-top-right" style="border-radius:10px;margin-bottom:15px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:surecart/product-sale-badge {"style":{"typography":{"fontSize":"12px"},"border":{"radius":"100px"}}} /--></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->

<!-- wp:surecart/product-title {"level":2,"style":{"typography":{"fontSize":"15px","fontStyle":"normal","fontWeight":"400"},"spacing":{"margin":{"bottom":"5px","top":"0px"}}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.5em","margin":{"top":"0px","bottom":"0px"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}},"margin":{"top":"0px","bottom":"0px"},"typography":{"lineHeight":"1"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;line-height:1"><!-- wp:surecart/product-list-price {"style":{"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"5px","bottom":"5px"}}}} /-->

<!-- wp:surecart/product-scratch-price {"style":{"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"5px","bottom":"5px"}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:surecart/product-template -->

<!-- wp:surecart/product-pagination {"style":{"elements":{"link":{"color":{"text":"#000000"}}},"spacing":{"padding":{"top":"15px","bottom":"15px"}}},"textColor":"black"} -->
<!-- wp:surecart/product-pagination-previous /-->

<!-- wp:surecart/product-pagination-numbers /-->

<!-- wp:surecart/product-pagination-next /-->
<!-- /wp:surecart/product-pagination -->
<!-- /wp:surecart/product-list -->',
];
