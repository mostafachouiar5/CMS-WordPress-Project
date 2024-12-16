<?php

namespace SureCart\Database;

/**
 * Run this migration when version changes or for new installations.
 */
class ProductPageMigrationService extends VersionMigration {
	/**
	 * The key for the migration.
	 *
	 * @var string
	 */
	protected $migration_key = 'surecart_product_page_migration_version';

	/**
	 * Run the migration.
	 *
	 * @return void
	 */
	public function run(): void {

		$args = array(
			'post_type'           => array( 'wp_template_part', 'wp_template' ), // specify the post types.
			'post_status'         => array( 'auto-draft', 'draft', 'publish' ), // specify the post status.
			'posts_per_page'      => -1,
			'lazy_load_term_meta' => false,
		);

		$query     = new \WP_Query( $args );
		$templates = $query->posts ?? array();

		if ( empty( $templates ) ) {
			return;
		}

		// filter out the templates that have post_name as product.
		$product_templates = array_filter(
			$templates,
			function ( $template ) {
				return in_array( $template->post_name, array( 'product-info', 'single-product' ) ) ||
				strpos( $template->post_name, 'sc-part-products-info-' ) !== false ||
				strpos( $template->post_name, 'sc-products-' ) !== false;
			}
		);

		// if we don't have any product templates, return.
		if ( empty( $product_templates ) ) {
			return;
		}

		// update each template if it doesn't have the wp:surecart/product-page block.
		foreach ( $product_templates as $product_template ) {

			if ( ! has_block( 'surecart/product-page', $product_template->post_content ) ) {
				wp_update_post(
					array(
						'ID'           => $product_template->ID,
						'post_content' => '<!-- wp:surecart/product-page {"align":"wide"} -->' . $product_template->post_content . '<!-- /wp:surecart/product-page -->',
					)
				);
			}

			if ( ! has_block( 'surecart/product-selected-price-ad-hoc-amount', $product_template->post_content ) ) {
				$insert_before_block = has_block( 'surecart/product-buy-buttons', $product_template ) ? 'surecart/product-buy-buttons' : 'surecart/product-buy-button';

				$new_content = str_replace(
					'<!-- wp:' . $insert_before_block,
					'<!-- wp:surecart/product-selected-price-ad-hoc-amount /-->' . PHP_EOL . '<!-- wp:' . $insert_before_block,
					$product_template->post_content
				);

				wp_update_post(
					array(
						'ID'           => $product_template->ID,
						'post_content' => $new_content,
					)
				);
			}
		}
	}
}
