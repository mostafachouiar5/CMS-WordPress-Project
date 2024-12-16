<?php

namespace SureCart\Concerns;

use SureCartCore\Helpers\MixedType;

trait HasBlockTheme {

	/**
	 * Register theme
	 *
	 * @param string $block_name Name of the block.
	 * @param string $slug Lowercase slug for style.
	 * @param string $name Display name of style.
	 * @param string $path Relative path in dist directory.
	 *
	 * @return void
	 */
	public function registerBlockTheme( $block_name, $slug, $name, $path ) {
		$url = trailingslashit( \SureCart::core()->assets()->getUrl() ) . $path;

		wp_register_style(
			"surecart/themes/$slug",
			$url,
			false,
			$this->generateFileVersion( $url )
		);

		register_block_style(
			"surecart/$block_name",
			[
				'name'         => $slug,
				'label'        => $name,
				'style_handle' => "surecart/themes/$slug",
			]
		);
	}

	/**
	 * Remove the protocol from an http/https url.
	 *
	 * @param  string $url Url for the source.
	 * @return string
	 */
	protected function removeProtocol( $url ) {
		return preg_replace( '~^https?:~i', '', $url );
	}

	/**
	 * Generate a version for a given asset src.
	 *
	 * @param  string $src Source for the asset.
	 * @return integer|boolean
	 */
	protected function generateFileVersion( $src ) {
		// Normalize both URLs in order to avoid problems with http, https
		// and protocol-less cases.
		$src      = $this->removeProtocol( $src );
		$home_url = $this->removeProtocol( WP_CONTENT_URL );
		$version  = false;

			// Generate the absolute path to the file.
			$file_path = MixedType::normalizePath(
				str_replace(
					[ $home_url, '/' ],
					[ WP_CONTENT_DIR, DIRECTORY_SEPARATOR ],
					$src
				)
			);

		if ( file_exists( $file_path ) ) {
			// Use the last modified time of the file as a version.
			$version = filemtime( $file_path );
		}

		return $version;
	}
}
