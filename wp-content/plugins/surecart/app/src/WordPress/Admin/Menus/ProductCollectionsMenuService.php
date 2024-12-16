<?php

namespace SureCart\WordPress\Admin\Menus;

use SureCart\Models\ProductCollection;

/**
 * Service for product collection pages in WordPress menu related functions.
 */
class ProductCollectionsMenuService {
	/**
	 * Bootstrap any actions.
	 *
	 * @return void
	 */
	public function bootstrap(): void {
		add_action( 'admin_init', [ $this, 'registerNavMetaBox' ], 9 );
		add_filter( 'render_block', [ $this, 'filterMenuBlockLinkHref' ], 10, 2 );
	}

	/**
	 * Adds the meta box container.
	 *
	 * @return void
	 */
	public function registerNavMetaBox(): void {
		global $pagenow;

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		if ( 'nav-menus.php' === $pagenow ) {
			add_meta_box(
				'sc_collections_meta_box',
				__( 'Product Collections', 'surecart' ),
				[ $this, 'metaBoxContents' ],
				'nav-menus',
				'side',
				'high'
			);
		}
	}

	/**
	 * Show the Meta Menu settings.
	 *
	 * @return void
	 */
	public function metaBoxContents(): void {
		$this->renderCollectionPagesMenuOptions();
	}

	/**
	 * Render the collection pages menu options.
	 *
	 * @return void
	 */
	public function renderCollectionPagesMenuOptions(): void {
		$collections = ProductCollection::get();

		if ( empty( $collections ) || ! is_array( $collections ) ) {
			esc_html_e( 'No product collections added.', 'surecart' );
			return;
		}

		?>
		<div id="posttype-sc-collections" class="posttypediv">
			<div id="tabs-panel-sc-collections" class="tabs-panel tabs-panel-active">
				<ul id="sc-collections-checklist" class="categorychecklist form-no-clear">
					<?php
					$i = -1;
					foreach ( $collections as $collection ) :
						$name = $collection->name;
						?>
						<li>
							<label class="menu-item-title">
								<input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-object-id]" value="<?php echo esc_attr( $i ); ?>" /> <?php echo esc_html( $name ); ?>
							</label>
							<input type="hidden" class="menu-item-type" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-type]" value="custom" />
							<input type="hidden" class="menu-item-title" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-title]" value="<?php echo esc_attr( $name ); ?>" />
							<input type="hidden" class="menu-item-url" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-url]" value="<?php echo esc_url( $collection->permalink ); ?>" />
							<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-classes]" />
						</li>
						<?php
						$i--;
					endforeach;
					?>
				</ul>
			</div>
			<p class="button-controls" data-items-type="posttype-sc-collections">
				<span class="list-controls">
					<label>
						<input type="checkbox" class="select-all" />
						<?php esc_html_e( 'Select all', 'surecart' ); ?>
					</label>
				</span>
				<span class="add-to-menu">
					<button type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to menu', 'surecart' ); ?>" name="add-post-type-menu-item" id="submit-posttype-sc-collections"><?php esc_html_e( 'Add to menu', 'surecart' ); ?></button>
					<span class="spinner"></span>
				</span>
			</p>
		</div>
		<?php
	}

	/**
	 * If the menu item is a collection page, add the collection slug to the menu item..
	 *
	 * @param string $content Block content.
	 * @param array  $block_data Block data.
	 *
	 * @return array
	 */
	public function filterMenuBlockLinkHref( $content, $block_data ) {
		// not a navigation link.
		if ( empty( $block_data['blockName'] ) || 'core/navigation-link' !== $block_data['blockName'] ) {
			return $content;
		}
		// don't have kind.
		if ( empty( $block_data['attrs']['kind'] ) || 'sc-collection' !== $block_data['attrs']['kind'] ) {
			return $content;
		}
		// don't have an id.
		if ( empty( $block_data['attrs']['id'] ) ) {
			return $content;
		}

		$collection = ProductCollection::find( $block_data['attrs']['id'] );

		if ( ! $collection || empty( $collection ) || empty( $collection->slug ) ) {
			return $content;
		}

		$collection_slug = $collection->slug;

		$new_link = esc_url_raw( trailingslashit( get_home_url() ) . trailingslashit( \SureCart::settings()->permalinks()->getBase( 'collection_page' ) ) . $collection_slug );

		return preg_replace( '/href="([^"]*)"/', 'href="' . $new_link . '"', $content );
	}
}
