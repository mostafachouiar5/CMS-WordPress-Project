<?php
namespace SureCart\WordPress\Templates;

/**
 * The template service.
 */
class CollectionTemplateService {
	/**
	 * The template file/name associations.
	 *
	 * @var array
	 */
	private $templates = [];

	/**
	 * The post type for the templates.
	 *
	 * @var string
	 */
	private $type = 'sc_collection';

	/**
	 * Get things going.
	 *
	 * @param array $templates The template file/name associations.
	 */
	public function __construct( $templates ) {
		$this->templates = $templates;
	}

	/**
	 * Bootstrap actions and filters.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_filter( 'theme_' . $this->type . '_templates', [ $this, 'addTemplates' ] );
	}

	/**
	 * Add the templates to the theme.
	 *
	 * @param array $templates The templates.
	 * @return array
	 */
	public function addTemplates( $templates ) {
		return array_merge( $templates, $this->templates );
	}
}
