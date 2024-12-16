<?php

declare(strict_types=1);

namespace SureCart\Controllers\Web;

/**
 * Base Page Controller Abstract class.
 */
abstract class BasePageController {
	/**
	 * Specified model.
	 *
	 * @var object
	 */
	protected $model;

	/**
	 * Set the model.
	 *
	 * @param object $model Model, eg- Product, ProductCollection.
	 *
	 * @return void
	 */
	protected function setModel( $model ): void {
		$this->model = $model;
	}

	/**
	 * Enqueue scripts.
	 * Add data for specific store by overriding this method.
	 *
	 * @return void
	 */
	public function scripts() {
		\SureCart::assets()->enqueueComponents();
		wp_localize_script(
			'surecart-components',
			'sc',
			[
				'store' => (object) [],
			]
		);
	}

	/**
	 * Handle fetching error.
	 *
	 * @param \WP_Error $wp_error WP Error.
	 *
	 * @return void
	 */
	public function handleError( \WP_Error $wp_error ): void {
		$data = (array) $wp_error->get_error_data();
		if ( 404 === ( $data['status'] ?? null ) ) {
			$this->notFound();
		}

		wp_die( esc_html( implode( ' ', $wp_error->get_error_messages() ) ) );
	}

	/**
	 * Handle not found error.
	 *
	 * @return void
	 */
	public function notFound(): void {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		get_template_part( 404 );
		exit();
	}

	/**
	 * Handle filters.
	 *
	 * @return void
	 */
	public function filters(): void {
		// set the document title.
		add_filter( 'document_title_parts', [ $this, 'documentTitle' ] );
		// disallow pre title filter.
		add_filter( 'pre_get_document_title', [ $this, 'disallowPreTitle' ], 214748364 );
		// add scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
		// preload image.
		add_action( 'wp_head', [ $this, 'preloadImage' ] );
		// add meta title and description.
		add_action( 'wp_head', [ $this, 'addSeoMetaData' ] );
	}

	/**
	 * Add meta title and description.
	 *
	 * @return void
	 */
	public function addSeoMetaData(): void {
		?>
		<!-- Primary Meta -->
		<meta name="title" content="<?php echo esc_attr( sanitize_text_field( $this->model->page_title ) ); ?>">
		<meta name="description" content="<?php echo esc_attr( sanitize_text_field( $this->model->meta_description ) ); ?>">

		<!-- Canonical -->
		<link rel="canonical" href="<?php echo esc_url( $this->model->permalink ); ?>">

		<!-- Open Graph -->
		<meta property="og:locale" content="<?php echo esc_attr( get_locale() ); ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?php echo esc_attr( $this->model->page_title ); ?>" />
		<meta property="og:description" content="<?php echo esc_attr( sanitize_text_field( $this->model->meta_description ) ); ?>" />
		<meta property="og:url" content="<?php echo esc_url( $this->model->permalink ); ?>" />
		<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
		<?php if ( ! empty( $this->model->getImageUrl( 800 ) ) ) { ?>
			<meta property="og:image" content="<?php echo esc_url( $this->model->getImageUrl( 800 ) ); ?>" />
		<?php } ?>
		<?php
	}

	/**
	 * Preload the product image.
	 *
	 * @return void
	 */
	public function preloadImage(): void {
		if ( empty( $this->model->image_url ) ) {
			return;
		}
		?>
		<link rel="preload" href="<?php echo esc_url( $this->model->image_url ); ?>" as="image">
		<?php
	}

	/**
	 * Update the document title name to match the model[eg-product] name.
	 *
	 * @param array $parts The parts of the document title.
	 */
	public function documentTitle( $parts ): array {
		$parts['title'] = esc_html( sanitize_text_field( $this->model->page_title ?? $parts['title'] ) );
		return $parts;
	}

	/**
	 * Disallow the pre title.
	 *
	 * @param string $title The title.
	 *
	 * @return string
	 */
	public function disallowPreTitle( $title ) {
		if ( ! empty( $this->model->id ) ) {
			return '';
		}
		return $title;
	}
}
