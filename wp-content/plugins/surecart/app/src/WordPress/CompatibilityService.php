<?php
/**
 * Compatibility service.
 *
 * @package   SureCartAppCore
 * @author    SureCart <support@surecart.com>
 * @copyright  SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com
 */

namespace SureCart\WordPress;

use SureCart\WordPress\Admin\Notices\AdminNoticesService;

/**
 * Provides compatibility with other plugins.
 */
class CompatibilityService {
	/**
	 * Bootstrap the service.
	 *
	 * @return void
	 */
	public function bootstrap() {
		// UAG fix.
		add_action( 'render_block_data', [ $this, 'maybeEnqueueUAGBAssets' ] );
		// SC Form Shortcode fix.
		add_filter( 'surecart/shortcode/render', [ $this, 'maybeEnqueueUAGBAssetsForShortcode' ], 5, 3 );
		// rankmath fix.
		add_action( 'rank_math/head', [ $this, 'rankMathFix' ] );

		// Yoast SEO fix.
		add_action( 'wpseo_frontend_presenters', [ $this, 'yoastSEOFix' ] );

		// Siteground JS combine exclude.
		add_filter( 'sgo_javascript_combine_exclude_ids', [ $this, 'sitegroundJsCombineExcludeScriptIds' ] );

		// Show gutenberg active notice.
		add_action( 'admin_init', [ $this, 'gutenbergActiveNotice' ] );

		// Load Divi Compatibility CSS.
		add_action( 'wp_enqueue_scripts', [ $this, 'diviCompatibility' ] );

		// Load Blocks Global Styles if enabled by Merchant in the setting.
		if ( (bool) get_option( 'surecart_load_block_assets_on_demand', false ) ) {
			add_filter( 'should_load_separate_core_block_assets', '__return_true' );
		}

		add_action( 'render_block', [ $this, 'fixKadenceAccordionPaneButtonType' ], 10, 2 );
	}

	/**
	 * Adds type="button" to the button in the Kadence Accordion Pane.
	 * This prevents the button from submitting the form.
	 *
	 * @param string $content Block content.
	 * @param array  $block Block data.
	 *
	 * @return string
	 */
	public function fixKadenceAccordionPaneButtonType( $content, $block ) {
		if ( 'kadence/pane' === $block['blockName'] ) {
			$processor = new \WP_HTML_Tag_Processor( $content );
			$has_tag   = $processor->next_tag( 'button' );
			if ( $has_tag ) {
				$processor->set_attribute( 'type', 'button' );
			}
			return $processor->get_updated_html();
		}
		return $content;
	}

	/**
	 * Load Divi Compatibility CSS.
	 *
	 * @return void
	 */
	public function diviCompatibility() {
		if ( ! is_plugin_active( 'divi-builder/divi-builder.php' ) ) {
			return;
		}
		wp_enqueue_style( 'surecart-divi-compatibility', plugins_url( 'styles/divi-compatibility.css', SURECART_PLUGIN_FILE ), '', \SureCart::plugin()->version(), 'all' );
	}

	/** Prevent Yoast SEO from outputing SEO meta tags on our custom pages.
	 *
	 * @param array $presenters Presenters.
	 * @return array Empty Array.
	 */
	public function yoastSEOFix( $presenters ) {
		if ( is_singular( 'sc_product' ) || is_singular( 'sc_collection' ) || is_singular( 'sc_upsell' ) ) {
			$title_presenters = array_filter(
				$presenters,
				function ( $item ) {
					return strpos( get_class( $item ), 'SEO\Presenters\Title_Presenter' );
				}
			);
			return apply_filters( 'sc_wpseo_frontend_presenters', $title_presenters, $presenters );
		}

		return $presenters;
	}

	/**
	 * Prevent rankmath from outputting og:tags on our custom pages.
	 *
	 * @return void
	 */
	public function rankMathFix() {
		if ( is_singular( 'sc_product' ) || is_singular( 'sc_collection' ) || is_singular( 'sc_upsell' ) ) {
			remove_all_actions( 'rank_math/opengraph/facebook' );
			remove_all_actions( 'rank_math/opengraph/twitter' );
		}
	}

	/**
	 * Render block data.
	 *
	 * @param array $parsed_block Block data.
	 *
	 * @return array
	 */
	public function maybeEnqueueUAGBAssets( $parsed_block ) {
		// UAGB must be activated.
		if ( ! class_exists( '\UAGB_Post_Assets' ) ) {
			return $parsed_block;
		}

		// must be our checkout form block.
		if ( 'surecart/checkout-form' !== $parsed_block['blockName'] && 'surecart/upsell' !== $parsed_block['blockName'] ) {
			return $parsed_block;
		}

		$post      = get_post();
		$upsell_id = isset( $post->upsell->id ) ? $post->upsell->id : null;

		$id = $parsed_block['attrs']['id'] ?? $upsell_id;

		if ( empty( $id ) ) {
			return $parsed_block;
		}

		// If Spectra Blocks are present in the form, enqueue the assets.
		$post_assets_instance = new \UAGB_Post_Assets( $id );
		$post_assets_instance->enqueue_scripts(); // This will enqueue the JS and CSS files.

		if ( ! empty( $post_assets_instance->file_generation ) && 'disabled' === $post_assets_instance->file_generation ) {
			add_action( 'wp_footer', array( $post_assets_instance, 'print_stylesheet' ) ); // As on checkout page, the wp_head action is loaded late & Spectra prints inline CSS on that action for file_generation disabled case, we need to print the CSS on footer.
		}

		return $parsed_block;
	}

	/**
	 * Filter SC Form Shortcode to load the Spectra Blocks Assets.
	 *
	 * @param string $output Content.
	 * @param array  $attributes Shortcode attributes.
	 * @param string $name Shortcode Tag.
	 *
	 * @return array
	 */
	public function maybeEnqueueUAGBAssetsForShortcode( $output, $attributes, $name ) {
		// UAGB must be activated.
		if ( ! class_exists( '\UAGB_Post_Assets' ) ) {
			return $output;
		}

		// must be our form shortcode.
		if ( 'sc_form' !== $name ) {
			return $output;
		}

		// must have an ID.
		if ( empty( $attributes['id'] ) ) {
			return $output;
		}

		// If Spectra Blocks are present in the form, enqueue the assets.
		$post_assets_instance = new \UAGB_Post_Assets( $attributes['id'] );
		$post_assets_instance->enqueue_scripts();

		return $output;
	}

	/**
	 * Show the Gutenberg active notice.
	 *
	 * @return void
	 */
	public function gutenbergActiveNotice(): void {
		if ( is_plugin_active( 'gutenberg/gutenberg.php' ) ) {
			( new AdminNoticesService() )->add(
				[
					'name'  => 'gutenberg_active_notice',
					'type'  => 'warning',
					'title' => esc_html__( 'SureCart', 'surecart' ),
					'text'  => wp_kses_post( __( '<p>The Gutenberg plugin is currently active. SureCart blocks might not perform as expected within the block editor. If you encounter any issues, consider disabling the Gutenberg plugin.<p>', 'surecart' ) ),
				]
			);
		}
	}

	/**
	 * Exclude SureCart JS modules from Siteground JS combine.
	 * This is to prevent the JS modules from being combined and minified by Siteground.
	 *
	 * @param array $exclude_ids Array of JS module IDs to exclude.
	 *
	 * @return array
	 */
	public function sitegroundJsCombineExcludeScriptIds( $exclude_ids ) {
		// WordPress scripts which depends on interactivity.
		$exclude_ids[] = '@wordpress/block-library/navigation/view-js-module';

		// SureCart scripts.
		$exclude_ids[] = '@surecart/product-page-js-module';
		$exclude_ids[] = '@surecart/image-slider-js-module';
		$exclude_ids[] = '@surecart/checkout-js-module';
		$exclude_ids[] = '@surecart/cart-js-module';
		$exclude_ids[] = '@surecart/a11y-js-module';
		$exclude_ids[] = '@surecart/checkout-service-js-module';
		$exclude_ids[] = '@surecart/checkout-events-js-module';
		$exclude_ids[] = '@surecart/dropdown-js-module';
		$exclude_ids[] = '@surecart/product-list-js-module';

		return $exclude_ids;
	}
}
