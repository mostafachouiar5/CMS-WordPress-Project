<a
	<?php
	echo wp_kses_data(
		get_block_wrapper_attributes(
			array_filter(
				[
					'class'                  => 'has-arrow-type-' . $pagination_arrow,
					'href'                   => esc_url( $page_link ),
					'role'                   => 'link',
					'aria-disabled'          => empty( $page_link ) ? 'true' : null,
					'aria-label'             => $attributes['label'] ?? __( 'Previous Page', 'surecart' ),
					'data-wp-on--click'      => 'surecart/product-list::actions.navigate',
					'data-wp-on--mouseenter' => 'surecart/product-list::actions.prefetch',
				]
			)
		)
	);
	?>
	>
	<?php if ( ! empty( $arrow_name ) ) : ?>
		<?php
		echo wp_kses(
			\SureCart::svg()->get(
				$arrow_name,
				[
					'class'       => 'wp-block-surecart-product-pagination-previous__icon',
					'aria-hidden' => true,
				]
			),
			sc_allowed_svg_html()
		)
		?>
	<?php endif; ?>

	<span class="<?php echo empty( $show_label ) ? 'sc-screen-reader-text' : 'sc-page-link-label'; ?>">
		<?php echo wp_kses_post( $attributes['label'] ?? __( 'Previous', 'surecart' ) ); ?>
	</span>
</a>
