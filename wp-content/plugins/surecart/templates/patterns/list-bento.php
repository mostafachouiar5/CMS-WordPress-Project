<?php
/**
 * Classic Product Carousel block pattern.
 */
return [
	'title'      => __( 'Product Bento', 'surecart' ),
	'categories' => [ 'surecart_shop' ],
	'blockTypes' => [ 'surecart/product-list' ],
	'priority'   => 3,
	'content'    => '<!-- wp:group {"metadata":{"categories":["surecart_shop"],"patternName":"surecart-list-bento","name":"Product Bento"},"style":{"spacing":{"blockGap":"20px","padding":{"right":"0px","left":"0px","top":"0px","bottom":"0px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"style":{"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"bottom","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="padding-right:0;padding-left:0"><!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"28px"}}} -->
<h3 class="wp-block-heading" style="font-size:28px">Featured</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#000"}}},"typography":{"textDecoration":"none"}},"textColor":"black"} -->
<p class="has-black-color has-text-color has-link-color" style="text-decoration:none"><a href="#">Shop All →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"15px","left":"15px"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:surecart/product-list {"query":{"perPage":1,"pages":0,"offset":0,"postType":"sc_product","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"include":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"style":{"spacing":{"blockGap":"24px"},"layout":{"columnSpan":"1","rowSpan":"2"}}} -->
<!-- wp:surecart/product-template {"style":{"spacing":{"blockGap":"30px"}},"layout":{"type":"default","columnCount":"3"}} -->
<!-- wp:group {"style":{"dimensions":{"minHeight":"100%"}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="min-height:100%"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":40,"isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.5},"minHeight":29,"minHeightUnit":"rem","customGradient":"linear-gradient(180deg,rgba(0,0,0,0.28) 0%,rgb(0,0,0) 100%)","contentPosition":"bottom left","style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"25px","bottom":"25px","left":"25px","right":"25px"}},"border":{"radius":"10px"}},"layout":{"type":"default"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-radius:10px;margin-top:0;margin-bottom:0;padding-top:25px;padding-right:25px;padding-bottom:25px;padding-left:25px;min-height:29rem"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-40 has-background-dim has-background-gradient" style="background:linear-gradient(180deg,rgba(0,0,0,0.28) 0%,rgb(0,0,0) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"padding":{"right":"0","left":"0"},"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group" style="padding-right:0;padding-left:0"><!-- wp:surecart/product-title {"level":2,"style":{"typography":{"fontSize":"17px","fontStyle":"normal","fontWeight":"400","lineHeight":"1"},"spacing":{"margin":{"bottom":"5px","top":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.5em","margin":{"top":"0px","bottom":"0px"},"padding":{"right":"0","left":"0"}},"margin":{"top":"0px","bottom":"0px"},"typography":{"lineHeight":"1"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px;padding-right:0;padding-left:0;line-height:1"><!-- wp:surecart/product-list-price {"style":{"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"5px","bottom":"5px"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} /-->

<!-- wp:surecart/product-scratch-price {"style":{"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"5px","bottom":"5px"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} /-->

<!-- wp:surecart/product-sale-badge {"style":{"typography":{"fontSize":"12px","lineHeight":"1"},"border":{"radius":"100px"}}} /--></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->
<!-- /wp:surecart/product-template -->
<!-- /wp:surecart/product-list --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:surecart/product-list {"query":{"perPage":2,"pages":0,"offset":0,"postType":"sc_product","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"include":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"style":{"spacing":{"blockGap":"24px"},"layout":{"columnSpan":"1","rowSpan":"1"}}} -->
<!-- wp:surecart/product-template {"style":{"spacing":{"blockGap":"15px"}},"layout":{"type":"default","columnCount":"3"}} -->
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":40,"isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.5},"minHeight":14,"minHeightUnit":"rem","customGradient":"linear-gradient(180deg,rgba(0,0,0,0.28) 0%,rgb(0,0,0) 100%)","contentPosition":"bottom left","style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"25px","bottom":"25px","left":"25px","right":"25px"}},"border":{"radius":"10px"}},"layout":{"type":"default"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-radius:10px;margin-top:0;margin-bottom:0;padding-top:25px;padding-right:25px;padding-bottom:25px;padding-left:25px;min-height:14rem"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-40 has-background-dim has-background-gradient" style="background:linear-gradient(180deg,rgba(0,0,0,0.28) 0%,rgb(0,0,0) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"bottom"}} -->
<div class="wp-block-group" style="padding-right:0;padding-left:0"><!-- wp:surecart/product-title {"level":2,"style":{"typography":{"fontSize":"17px","fontStyle":"normal","fontWeight":"400"},"spacing":{"margin":{"bottom":"5px","top":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} /-->

<!-- wp:surecart/product-sale-badge {"style":{"typography":{"fontSize":"12px"},"border":{"radius":"100px"}}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.5em","margin":{"top":"0px","bottom":"0px"},"padding":{"right":"0","left":"0"}},"margin":{"top":"0px","bottom":"0px"},"typography":{"lineHeight":"1"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px;padding-right:0;padding-left:0;line-height:1"><!-- wp:surecart/product-list-price {"style":{"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"5px","bottom":"5px"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} /-->

<!-- wp:surecart/product-scratch-price {"style":{"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"5px","bottom":"5px"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} /--></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->
<!-- /wp:surecart/product-template -->
<!-- /wp:surecart/product-list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
];
