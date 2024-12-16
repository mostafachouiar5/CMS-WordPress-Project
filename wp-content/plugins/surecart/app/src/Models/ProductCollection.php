<?php

namespace SureCart\Models;

use SureCart\Support\Contracts\PageModel;

/**
 * Holds Product Collection data.
 */
class ProductCollection extends Model implements PageModel {
	use Traits\HasImageSizes;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'product_collections';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'product_collection';

	/**
	 * Is this cachable.
	 *
	 * @var boolean
	 */
	protected $cachable = true;

	/**
	 * Clear cache when products are updated.
	 *
	 * @var string
	 */
	protected $cache_key = 'product_collections';

	/**
	 * Create a new model
	 *
	 * @param array $attributes Attributes to create.
	 *
	 * @return $this|false
	 */
	protected function create( $attributes = [] ) {
		$created = parent::create( $attributes );

		if ( is_wp_error( $created ) ) {
			return $created;
		}

		// sync with the post.
		$this->sync();

		return $this;
	}

	/**
	 * Update a model
	 *
	 * @param array $attributes Attributes to update.
	 *
	 * @return $this|false
	 */
	protected function update( $attributes = array() ) {
		// update the model.
		$updated = parent::update( $attributes );
		if ( is_wp_error( $updated ) ) {
			return $updated;
		}

		// sync with the post.
		$this->sync();

		// return.
		return $this;
	}

		/**
		 * Update a model
		 *
		 * @param string $id The id of the model to delete.
		 * @return $this|false
		 */
	protected function delete( $id = '' ) {
		// delete the model.
		$deleted = parent::delete( $id );

		// check for errors.
		if ( is_wp_error( $deleted ) ) {
			return $deleted;
		}

		// delete the post.
		$this->deleteSynced( $id );

		// return.
		return $this;
	}

	/**
	 * Delete the synced post.
	 *
	 * @param string $id The id of the model to delete.
	 * @return \SureCart\Models\Product
	 */
	protected function deleteSynced( $id = '' ) {
		$id = ! empty( $id ) ? $id : $this->id;
		\SureCart::sync()
			->collection()
			->delete( $id );

		return $this;
	}

	/**
	 * Sync the collection
	 */
	public function sync() {
		\SureCart::sync()
			->collection()
			->sync( $this );

		return $this;
	}

	/**
	 * Get the attached term.
	 *
	 * @return int|false
	 */
	public function getTermAttribute() {
		if ( empty( $this->id ) ) {
			return false;
		}
		return \SureCart::sync()->collection()->findByModelId( $this->id );
	}

	/**
	 * Get the product template
	 *
	 * @return \WP_Template
	 */
	public function getTemplateAttribute() {
		return get_block_template( $this->getTemplateIdAttribute() );
	}

	/**
	 * Get the product template part template.
	 *
	 * @return \WP_Template
	 */
	public function getTemplatePartAttribute() {
		return get_block_template( $this->getTemplatePartIdAttribute(), 'wp_template_part' );
	}

	/**
	 * Get the product template id.
	 *
	 * @return string|false
	 */
	public function getTemplatePartIdAttribute(): string {
		if ( ! empty( $this->metadata->wp_template_part_id ) ) {
			return $this->metadata->wp_template_part_id;
		}
		return 'surecart/surecart//product-collection-part';
	}

	/**
	 * Get the product template id.
	 *
	 * @return string
	 */
	public function getTemplateIdAttribute(): string {
		if ( ! empty( $this->metadata->wp_template_id ) ) {
			// we have a php file, switch to default.
			if ( wp_is_block_theme() && false !== strpos( $this->metadata->wp_template_id, '.php' ) ) {
				return 'surecart/surecart//product-collection';
			}

			// this is acceptable.
			return $this->metadata->wp_template_id;
		}
		return 'surecart/surecart//product-collection';
	}

	/**
	 * Get the product permalink.
	 *
	 * @return string
	 */
	public function getPermalinkAttribute(): string {
		if ( empty( $this->attributes['id'] ) ) {
			return false;
		}

		$term = $this->term;

		if ( isset( $term->term_id ) ) {
			return get_term_link( $term );
		}

		return '';
	}

	/**
	 * Get the page title for SEO.
	 *
	 * @return string
	 */
	public function getPageTitleAttribute(): string {
		return $this->attributes['name'] ?? '';
	}

	/**
	 * Get the page description for SEO.
	 *
	 * @return string
	 */
	public function getMetaDescriptionAttribute(): string {
		return $this->attributes['description'] ?? '';
	}

	/**
	 * Get the image url for a specific size.
	 *
	 * @param integer $size The size.
	 *
	 * @return string
	 */
	public function getImageUrl( $size = 0, $additional_options = '' ) {
		if ( empty( $this->attributes['image']->url ) ) {
			return '';
		}

		return $size ? $this->imageUrl( $this->attributes['image']->url, $size, false, $additional_options ) : $this->attributes['image']->url;
	}

	/**
	 * Get the srcset for the product media.
	 *
	 * @param array $sizes The sizes.
	 *
	 * @return string
	 */
	public function getSrcSet( $sizes = [] ) {
		if ( empty( $this->attributes['image']->url ) ) {
			return '';
		}
		return $this->imageSrcSet( $this->attributes['image']->url, $sizes );
	}

	/**
	 * Get Template Content.
	 *
	 * @return string
	 */
	public function getTemplateContent(): string {
		return wp_is_block_theme() ?
			$this->template->content ?? '' :
			$this->template_part->content ?? '';
	}
}
