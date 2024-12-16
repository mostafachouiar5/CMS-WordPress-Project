<?php

namespace SureCart\WordPress\Assets;

/**
 * Handles the component theme.
 */
class StylesService {
	/**
	 * Holds the service container
	 *
	 * @var \Pimple\Container
	 */
	protected $container;

	/**
	 * Make sure we change the script loader tag for esm loading.
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function __construct( $container ) {
		$this->container = $container;
	}

	/**
	 * Register the default theme.
	 *
	 * @return void
	 */
	public function register() {
		wp_register_style(
			'surecart-themes-default',
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/components/surecart/surecart.css',
			array(),
			filemtime( trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/components/surecart/surecart.css' ),
		);
		$brand = \SureCart::account()->brand;

		$style = file_get_contents( plugin_dir_path( SURECART_PLUGIN_FILE ) . 'dist/blocks/cloak.css' );

		$style .= ':root {';
		$style .= '--sc-color-primary-500: #' . ( $brand->color ?? '000' ) . ';';
		$style .= '--sc-focus-ring-color-primary: #' . ( $brand->color ?? '000' ) . ';';
		$style .= '--sc-input-border-color-focus: #' . ( $brand->color ?? '000' ) . ';';
		$style .= '--sc-color-gray-900: #' . ( $brand->heading ?? '000' ) . ';';
		$style .= '--sc-color-primary-text: #' . \SureCart::utility()->color()->calculateForegroundColor( $brand->color ?? '000000' ) . ';';
		$style .= '}';

		wp_add_inline_style(
			'surecart-themes-default',
			$style
		);

		// blocks-next.
		wp_add_inline_style(
			'surecart-theme-base',
			$style
		);
	}

	/**
	 * Enqueue the front styles.
	 *
	 * @return void
	 */
	public function enqueueFront() {
		// make sure it is registered.
		$this->register();
		// enqueue it.
		wp_enqueue_style( 'surecart-themes-default' );
	}

	/**
	 * Enqueue the editor styles.
	 *
	 * @return void
	 */
	public function enqueueEditor() {
		// make sure it is registered.
		$this->register();
		// enqueue it.
		wp_enqueue_style( 'surecart-themes-default' );
	}

	/**
	 * Add inline brand styles to theme.
	 *
	 * @param string $handle The handle to add the styles to.
	 *
	 * @return void
	 */
	public function addInlineAdminColors( $handle ) {
		ob_start();
		?>
		:root:root {
			--wp-admin-theme-color: #007cba;
			--wp-admin-theme-color-darker-10: #1f63a0;
			--wp-admin-theme-color-darker-20: #1a5080;
			--sc-color-primary-500: var(--wp-admin-theme-color);
			--sc-focus-ring-color-primary: var(
				--wp-admin-theme-color
			);
			--sc-input-border-color-focus: var(
				--wp-admin-theme-color
			);
		}
		<?php

		wp_add_inline_style(
			$handle,
			ob_get_clean()
		);
	}

	/**
	 * Add inline brand styles to theme.
	 *
	 * @param string $handle The handle to add the styles to.
	 *
	 * @return void
	 */
	public function addInlineBrandColors( $handle ) {
		ob_start();
		?>
		:root:root {
			--sc-color-primary-500: var(--sc-color-brand-primary);
			--sc-focus-ring-color-primary: var(--sc-color-brand-primary);
			--sc-input-border-color-focus: var(--sc-color-brand-primary);
			--sc-color-gray-900: var(--sc-color-brand-heading);
			--sc-color-gray-800: var(--sc-color-brand-text);
			--sc-tab-active-color: var(--sc-color-brand-heading);
			--sc-tab-active-background: var(--sc-color-brand-main-background);
			--sc-tag-default-background-color: var(--sc-color-brand-main-background);
			--sc-tag-default-border-color: var(--sc-color-brand-stroke);
			--sc-tag-default-color: var(--sc-color-brand-body);
			--sc-stacked-list-row-hover-color: var(--sc-color-brand-main-background);
			--sc-color-primary-text: white;
		}
		<?php

		wp_add_inline_style(
			$handle,
			ob_get_clean()
		);
	}
}
