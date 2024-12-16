<?php
global $sc_query_id;
$params         = \SureCart::block()->urlParams( 'products' );
$all_taxonomies = $params->getAllTaxonomyArgs();

// no filters, don't render this block.
if ( empty( $all_taxonomies ) ) {
	return;
}

$product_terms = array();
foreach ( $all_taxonomies as $taxonomy_name => $term_slugs ) {
	$terms = get_terms(
		[
			'taxonomy'   => $taxonomy_name,
			'hide_empty' => false,
			'slug'       => $term_slugs,
		]
	);

	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		$product_terms = array_merge( $product_terms, $terms );
	}
}

// map the collections to the view.
$product_terms = array_map(
	function ( $term ) use ( $params ) {
		return [
			'href' => $params->removeFilterArg( $term->taxonomy, $term->slug ),
			'name' => $term->name,
			'id'   => $term->slug,
		];
	},
	$product_terms ?? []
);

// no collections, don't render this block.
if ( empty( $product_terms ) ) {
	return;
}

?>
<div
	<?php echo wp_kses_data( get_block_wrapper_attributes( [ 'role' => 'list' ] ) ); ?>
	<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'collections' => $product_terms ] ) ); ?>
>
<?php
foreach ( $product_terms as $filter_tag ) :
	// Get an instance of the current Post Template block.
		$block_instance = $block->parsed_block;

		// Set the block name to one that does not correspond to an existing registered block.
		// This ensures that for the inner instances of the Post Template block, we do not render any block supports.
		$block_instance['blockName'] = 'core/null';

		$filter_block_context = static function ( $context ) use ( $filter_tag ) {
			$context['surecart/filter_tag'] = $filter_tag;
			return $context;
		};

		add_filter( 'render_block_context', $filter_block_context, 1 );

		$block_content = ( new WP_Block( $block_instance ) )->render( array( 'dynamic' => false ) );

		remove_filter( 'render_block_context', $filter_block_context, 1 );
	?>
	<?php echo $block_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php endforeach; ?>
</div>
