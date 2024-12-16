<div <?php echo wp_kses_data(
	get_block_wrapper_attributes(
		array(
			'class' => 'sc-input-group sc-input-group-sm',
		)
	)
); ?>>
	<span class="sc-input-group-text">
		<?php
		echo wp_kses(
			SureCart::svg()->get(
				'search',
				[
					'width'  => 16,
					'height' => 16,
					'class'  => 'sc-icon',
				]
			),
			sc_allowed_svg_html()
		)
		?>
	</span>

	<input
		class="sc-form-control"
		type="search"
		data-wp-on--input="actions.onSearchInput"
		placeholder="<?php esc_attr_e( 'Search', 'surecart' ); ?>"
		value="<?php echo esc_attr( $value ); ?>"
	>

	<?php if ( ! empty( $value ) ) : ?>
		<span class="sc-input-group-text"
			role="button"
			tabindex="0"
			data-wp-bind--hidden="state.searching"
			data-wp-on--click="actions.clearSearch"
			data-wp-on--keydown="actions.clearSearch"
		>
			<?php
			echo wp_kses(
				SureCart::svg()->get(
					'x',
					[
						'width'       => 16,
						'height'      => 16,
						'class'       => 'sc-icon',
						'aria-hidden' => true,
					]
				),
				sc_allowed_svg_html()
			);
			?>
			<div class="sc-screen-reader-text"><?php esc_html_e( 'Clear search', 'surecart' ); ?></div>
		</span>
	<?php endif; ?>

	<span class="sc-input-group-text" data-wp-bind--hidden="!state.searching" hidden>
		<span class="sc-spinner" aria-hidden="true"></span>
	</span>
</div>
