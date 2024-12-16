<a
	<?php echo wp_kses_data(
		get_block_wrapper_attributes(
			[
				'class' => 'sc-tag sc-tag--default sc-tag--medium',
				'style' => 'cursor: pointer; text-decoration: none;',
			]
		)
	); ?>
	id="sc-product-list-filter-tag-<?php echo (int) $filter_tag->id; ?>"
	href="<?php echo esc_url( $filter_tag->href ); ?>"
	data-wp-on--click="surecart/product-list::actions.navigate"
	data-wp-on--mouseenter="surecart/product-list::actions.prefetch"
	role="listitem"
	aria-description="<?php esc_html_e( 'Press enter to remove this filter.', 'surecart' ); ?>"
>
	<span class="tag__content"><?php echo esc_html( $filter_tag->name ); ?></span>
	<?php
	echo wp_kses(
		SureCart::svg()->get(
			'x',
			[
				'class'      => 'sc-tag__clear',
				'aria-label' => __(
					'Remove tag',
					'surecart'
				),
			],
		),
		sc_allowed_svg_html()
	);
	?>
</a>
