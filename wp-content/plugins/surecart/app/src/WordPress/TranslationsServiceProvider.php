<?php

namespace SureCart\WordPress;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register translations.
 */
class TranslationsServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		// Nothing to register.
	}

	/**
	 * Bootstrap the service.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		add_filter( 'loco_compile_single_json', [ $this, 'compileSingleJSON' ], 999, 2 );
		add_filter( 'load_script_translation_file', [ $this, 'loadSingleTranslationFile' ], 999, 3 );
		add_action( 'init', [ $this, 'loadPluginTextDomain' ], 0 );
	}

	/**
	 * Compile javascript translations as a single file.
	 * We need to do this since we lazy load a lot of our scripts.
	 *
	 * @param string $path Path for the json file.
	 * @param string $po_path Path of the po.
	 *
	 * @return string
	 */
	public function compileSingleJSON( $path, $po_path ) {
		$info = pathinfo( $po_path );
		if ( 'surecart' === substr( $info['filename'], 0, 8 ) ) {
			$path = $info['dirname'] . '/' . $info['filename'] . '.json';
		}
		return $path;
	}

	/**
	 * Load the single translation file when the domain loads.
	 *
	 * @param string $file The file.
	 * @param string $handle The script handle.
	 * @param string $domain The domain.
	 *
	 * @return string
	 */
	public function loadSingleTranslationFile( $file, $handle, $domain ) {
		if ( 'surecart' === $domain ) {
			if ( ! file_exists( $file ) && file_exists( WP_LANG_DIR . '/loco/plugins/surecart-' . get_locale() . '.json' ) ) {
				return WP_LANG_DIR . '/loco/plugins/surecart-' . get_locale() . '.json';
			}
			if ( file_exists( WP_LANG_DIR . '/plugins/surecart-' . get_locale() . '.json' ) ) {
				return WP_LANG_DIR . '/plugins/surecart-' . get_locale() . '.json';
			}
			if ( is_string( $file ) ) {
				if ( false !== strpos( $file, SURECART_PLUGIN_DIR_NAME . '/languages/' ) ) {
					$first_part = substr( $file, 0, strpos( $file, SURECART_PLUGIN_DIR_NAME . '/languages/' ) );
					$file       = $first_part . SURECART_PLUGIN_DIR_NAME . '/languages/surecart-' . get_locale() . '.json';
				} else {
					$first_part = substr( $file, 0, strpos( $file, 'plugins/surecart-' ) );
					$file       = $first_part . 'plugins/surecart-' . get_locale() . '.json';
				}
			}

			if ( false === $file ) {
				$file = SURECART_LANGUAGE_DIR . '/surecart-' . get_locale() . '.json';
			}
		}
		return $file;
	}

	/**
	 * This is needed for Loco translate to work properly.
	 */
	public function loadPluginTextDomain() {
		// Default languages directory for CartFlows Pro.
		$lang_dir = trailingslashit( SURECART_LANGUAGE_DIR );

		/**
		 * Filters the languages directory path to use for CartFlows Pro.
		 *
		 * @param string $lang_dir The languages directory path.
		 */
		$lang_dir = apply_filters( 'surecart_languages_directory', $lang_dir );

		// Traditional WordPress plugin locale filter.
		global $wp_version;

		$get_locale = get_locale();

		if ( $wp_version >= 4.7 ) {
			$get_locale = get_user_locale();
		}

		/**
		 * Language Locale for CartFlows Pro
		 *
		 * @var $get_locale The locale to use.
		 * Uses get_user_locale()` in WordPress 4.7 or greater,
		 * otherwise uses `get_locale()`.
		 */
		$locale = apply_filters( 'plugin_locale', $get_locale, 'surecart' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'surecart', $locale );

		// Setup paths to current locale file.
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/plugins/ folder.
			load_textdomain( 'surecart', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/surecart/languages/ folder.
			load_textdomain( 'surecart', $mofile_local );
		} else {
			// Load the default language files.
			load_plugin_textdomain( 'surecart', false, $lang_dir );
		}
	}
}
