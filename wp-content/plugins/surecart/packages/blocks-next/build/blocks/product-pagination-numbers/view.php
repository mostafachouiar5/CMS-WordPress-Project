<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<?php foreach ( $pagination_links as $pagination_link ) : ?>
		<a
		<?php
		echo wp_kses_data(
			sc_html_attributes(
				[
					'class'                  => 'sc-page-link',
					'role'                   => 'link',
					'href'                   => esc_url( $pagination_link['href'] ),
					'disabled'               => $pagination_link['current'] ? 'disabled' : null,
					'aria-disabled'          => $pagination_link['current'] ? 'true' : null,
					// translators: %s: page number.
					'aria-label'             => sprintf( __( 'Page %s', 'surecart' ), $pagination_link['name'] ) ,
					'data-wp-on--click'      => 'surecart/product-list::actions.navigate',
					'data-wp-on--mouseenter' => 'surecart/product-list::actions.prefetch',
				]
			)
		);
		?>
		>
			<?php echo esc_html( $pagination_link['name'] ); ?>
		</a>
	<?php endforeach; ?>
</div>
