<div
	<?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'sc-dropdown' ] ) ); ?>
	<?php
	echo wp_kses_data(
		wp_interactivity_data_wp_context(
			[
				'isMenuOpen' => false,
				'index'      => 0,
			]
		)
	);
	?>
	data-wp-interactive='{ "namespace": "surecart/dropdown" }'
	data-wp-on-async-window--click="surecart/dropdown::callbacks.maybeCloseMenu"
	data-wp-on-async-window--focusin="surecart/dropdown::callbacks.maybeCloseMenu"
	data-wp-on-async-window--keydown="surecart/dropdown::callbacks.maybeCloseMenu"
	data-wp-bind--aria-activedescendant="context.activeMenuItemId"
	data-wp-on--keyup="surecart/dropdown::actions.menuKeyUp"
	data-wp-on--keydown="surecart/dropdown::actions.menuKeyDown"
	role="menu"
	tabindex="-1"
	data-wp-bind--aria-labelledby="context.activeMenuItemId"
	aria-description="<?php esc_html_e( 'Press the arrow keys then enter to make a selection.', 'surecart' ); ?>"
>
	<div
		class="sc-dropdown__trigger sc-button sc-button--standard sc-button--medium sc-button--caret sc-button--has-label sc-button--text"
		data-wp-on--click="surecart/dropdown::actions.toggleMenu"
		role="button"
		tabindex="0"
		aria-label="
		<?php
		echo esc_attr(
			sprintf(
				// translators: %s is the taxonomy label.
				__( 'Filter by: %s', 'surecart' ),
				esc_html( $taxonomy_object->label )
			)
		);
		?>
			"
	>
		<span class="sc-button__label"><?php echo esc_html( $attributes['label'] ?? __( 'Filter', 'surecart' ) ); ?></span>
		<span class="sc-button__caret"><?php echo wp_kses( SureCart::svg()->get( 'chevron-down' ), sc_allowed_svg_html() ); ?></span>
	</div>

	<div
		class="sc-dropdown__panel"
		data-wp-bind--hidden="!context.isMenuOpen"
		data-wp-bind--aria-hidden="!context.isMenuOpen"
		hidden
	>
		<?php foreach ( $options as $key => $option ) : ?>
			<a
				role="menuitem"
				tabindex="-1"
				class="sc-dropdown__menu-item"
				id="<?php echo esc_attr( wp_unique_id( 'sc-menu-item-' ) ); ?>"
				href="<?php echo esc_url_raw( $option['href'] ); ?>"
				data-wp-on--click="surecart/product-list::actions.navigate"
				data-wp-on--mouseenter="surecart/product-list::actions.prefetch"
				data-wp-class--sc-focused="surecart/dropdown::state.isMenuItemFocused"
			>
				<span class="sc-dropdown__menu-item__label">
					<?php echo esc_html( $option['label'] ?? '' ); ?>
				</span>

				<?php if ( $option['checked'] ) : ?>
					<span class="sc-menu-item__check">
						<?php echo wp_kses( SureCart::svg()->get( 'check' ), sc_allowed_svg_html() ); ?>
					</span>
				<?php endif; ?>
			</a>
		<?php endforeach; ?>
	</div>
</div>
