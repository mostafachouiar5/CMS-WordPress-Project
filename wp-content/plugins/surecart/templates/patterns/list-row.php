<?php
/**
 * Classic Product Carousel block pattern.
 */
return [
	'title'      => __( 'Simple Product Row', 'surecart' ),
	'categories' => [ 'surecart_shop' ],
	'blockTypes' => [ 'surecart/product-list' ],
	'priority'   => 3,
	'content'    => '<!-- wp:surecart/product-list {"limit":null,"query":{"perPage":4,"pages":0,"offset":0,"postType":"sc_product","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"include":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"metadata":{"categories":["surecart_shop"],"patternName":"surecart-list-row","name":"Simple Product Row"},"align":"wide","style":{"spacing":{"blockGap":"24px"}}} -->
<!-- wp:surecart/product-template {"style":{"spacing":{"blockGap":"30px"}},"layout":{"type":"grid","columnCount":"4"}} -->
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"color":{"background":"#0000000d"},"spacing":{"padding":{"right":"0px","left":"0px","top":"0px","bottom":"0px"}},"border":{"radius":"10px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background" style="border-radius:10px;background-color:#0000000d;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.5},"contentPosition":"top right","isDark":false,"style":{"dimensions":{"aspectRatio":"3/4"},"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"bottom":"15px"}},"border":{"radius":"10px"}},"layout":{"type":"default"}} -->
<div class="wp-block-cover is-light has-custom-content-position is-position-top-right" style="border-radius:10px;margin-bottom:15px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:surecart/product-sale-badge {"style":{"typography":{"fontSize":"12px"},"border":{"radius":"100px"}}} /--></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->

<!-- wp:surecart/product-title {"level":2,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"500","textAlign":"center"},"spacing":{"margin":{"bottom":"5px","top":"0px"}}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.5em","margin":{"top":"0px","bottom":"0px"},"padding":{"right":"0","left":"0"}},"margin":{"top":"0px","bottom":"0px"},"typography":{"lineHeight":"1"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px;padding-right:0;padding-left:0;line-height:1"><!-- wp:surecart/product-scratch-price {"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"},"spacing":{"margin":{"top":"5px","bottom":"5px"}}}} /-->

<!-- wp:surecart/product-list-price {"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"},"spacing":{"margin":{"top":"5px","bottom":"5px"}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:surecart/product-template -->
<!-- /wp:surecart/product-list -->',
];
