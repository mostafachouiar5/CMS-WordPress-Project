<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<label class="sc-form-label">
		<?php echo wp_kses_post( $attributes['label'] ?? __( 'Pricing', 'surecart' ) ); ?>
	</label>

	<div class="sc-choices" style="--columns:<?php echo esc_attr( $attributes['columns'] ); ?>">
	<?php
	foreach ( $prices as $price ) :
		// Get an instance of the current Post Template block.
		$block_instance = $block->parsed_block;

		// Set the block name to one that does not correspond to an existing registered block.
		// This ensures that for the inner instances of the Post Template block, we do not render any block supports.
		$block_instance['blockName'] = 'core/null';

		$filter_block_context = static function ( $context ) use ( $price ) {
			$context['price'] = $price;
			return $context;
		};

		// Use an early priority to so that other 'render_block_context' filters have access to the values.
		add_filter( 'render_block_context', $filter_block_context, 1 );
		// Render the inner blocks of the Post Template block with `dynamic` set to `false` to prevent calling
		// `render_callback` and ensure that no wrapper markup is included.
		$block_content = ( new WP_Block( $block_instance ) )->render( array( 'dynamic' => false ) );
		remove_filter( 'render_block_context', $filter_block_context, 1 );
		?>

		<?php echo $block_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

	<?php endforeach; ?>
	</div>
</div>
