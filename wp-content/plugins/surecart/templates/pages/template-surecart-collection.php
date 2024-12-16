<?php
get_header();
global $content_width;
echo '<style>
.sc-template-wrapper,
.sc-template-container {
	width: 100%;
}
.sc-template-wrapper .sc-template-container {
	max-width: var(--wp--style--global--wide-size, ' . (int) ( $content_width ?? 1170 ) . 'px) !important;
	margin-left: auto;
	margin-right: auto;
}
</style>';
$collection    = sc_get_collection( get_queried_object_id() );
$template_part = $collection->template_part_id;
$template_part = $template_part ? $template_part : 'surecart/surecart//product-collection-part';
?>
<div class="wp-block-group is-layout-constrained sc-template-wrapper" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<div class="wp-block-group alignwide sc-template-container">
		<?php sc_block_template_part( $template_part ); ?>
	</div>
</div>
<?php
get_footer();
