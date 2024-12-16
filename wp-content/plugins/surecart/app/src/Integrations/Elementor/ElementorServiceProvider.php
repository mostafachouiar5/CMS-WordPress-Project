<?php
namespace SureCart\Integrations\Elementor;

use SureCart\Integrations\Elementor\Conditions\Conditions;
use SureCart\Integrations\Elementor\Documents\ProductDocument;
use SureCart\Migration\ProductPageWrapperService;
use SureCart\Models\Product;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Elementor service provider.
 */
class ElementorServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		// nothing to register.
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return;
		}

		// Elementor integration.
		add_action( 'elementor/widgets/register', [ $this, 'widget' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'load_scripts' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'categories_registered' ] );

		// Register product theme condition.
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			add_action( 'elementor/documents/register', [ $this, 'register_document' ] );
			add_action( 'elementor/theme/register_conditions', [ $this, 'product_theme_conditions' ] );
			add_filter( 'elementor/query/get_autocomplete/surecart-product', [ $this, 'get_autocomplete' ], 10, 2 );
			add_filter( 'elementor/query/get_value_titles/surecart-product', [ $this, 'get_titles' ], 10, 2 );
			add_action( 'elementor/frontend/the_content', array( $this, 'handle_product_page_wrapper' ) );
		}
	}

	/**
	 * Get the titles for the query control
	 * This is important as it shows the previously selected items when the conditions load in.
	 *
	 * @param array $results The results.
	 * @param array $request The request.
	 *
	 * @return array
	 */
	public function get_titles( $results, $request ) {
		if ( 'surecart-product' !== $request['get_titles']['object'] || empty( $request['id'] ) ) {
			return $results;
		}

		$products = Product::where(
			[
				'ids' => [ $request['id'] ],
			]
		)->get();

		foreach ( $products as $product ) {
			$results[ $product->id ] = $product->name;
		}
		return $results;
	}

	/**
	 * Get autocomplete
	 *
	 * @param array $results The results.
	 * @param array $data Request data.
	 *
	 * @return array
	 */
	public function get_autocomplete( $results, $data ) {
		if ( 'surecart-product' !== $data['autocomplete']['object'] ) {
			return $results;
		}

		$products = Product::where(
			[
				'query'    => $data['q'],
				'archived' => false,
			]
		)->get();

		foreach ( $products as $product ) {
			$results[] = [
				'id'   => $product->id,
				'text' => $product->name,
			];
		}
		return $results;
	}


	/**
	 * Elementor load scripts
	 *
	 * @return void
	 */
	public function load_scripts() {
		wp_enqueue_script( 'surecart-elementor-editor', plugins_url( 'assets/editor.js', __FILE__ ), array( 'jquery' ), \SureCart::plugin()->version(), true );
		wp_enqueue_style( 'surecart-elementor-style', plugins_url( 'assets/editor.css', __FILE__ ), '', \SureCart::plugin()->version(), 'all' );
		wp_localize_script(
			'surecart-elementor-editor',
			'scElementorData',
			[
				'site_url' => site_url(),
			]
		);
	}

	/**
	 * Elementor surecart categories register
	 *
	 * @param Obj $elements_manager Elementor category manager.
	 *
	 * @return void
	 */
	public function categories_registered( $elements_manager ) {
		$elements_manager->add_category(
			'surecart-elementor',
			[
				'title' => esc_html__( 'SureCart', 'surecart' ),
				'icon'  => 'fa fa-plug',
			]
		);
	}

	/**
	 * Elementor widget register
	 *
	 * @return void
	 */
	public function widget( $widgets_manager ) {
		$widgets_manager->register( new ReusableFormWidget() );
	}

	/**
	 * Add product theme condition
	 *
	 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Documents_Manager $documents_manager The documents manager.
	 *
	 * @return void
	 */
	public function register_document( $documents_manager ) {
		$documents_manager->register_document_type( 'surecart-product', ProductDocument::get_class_full_name() );
	}

	/**
	 * Add product theme condition
	 *
	 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Manager $conditions_manager The conditions manager.
	 *
	 * @return void
	 */
	public function product_theme_conditions( $conditions_manager ) {
		$conditions_manager->register_condition_instance( new Conditions() );
	}

	/**
	 * Handle Elementor content.
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function handle_product_page_wrapper( string $content ): string {
		return ( new ProductPageWrapperService( $content ) )->wrap();
	}
}
