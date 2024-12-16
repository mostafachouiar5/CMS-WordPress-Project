<?php
use SureCartBlocks\Blocks\Product\Quantity\Block;
echo ( new Block() )->render( $attributes, $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
