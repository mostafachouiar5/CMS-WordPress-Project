<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasImageSizes;
use SureCart\Models\Traits\HasPurchases;
use SureCart\Models\Traits\HasCommissionStructure;
use SureCart\Support\Contracts\GalleryItem;
use SureCart\Support\Contracts\PageModel;
use SureCart\Support\Currency;

/**
 * Product model
 */
class Product extends Model implements PageModel {
	use HasImageSizes;
	use HasPurchases;
	use HasCommissionStructure;

	/**
	 * These always need to be fetched during create/update in order to sync with post model.
	 *
	 * @var array
	 */
	protected $sync_expands = array( 'prices', 'product_medias', 'product_media.media', 'variants', 'variant_options', 'product_collections', 'featured_product_media' );

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'products';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'product';

	/**
	 * Is this cachable?
	 *
	 * @var boolean
	 */
	protected $cachable = true;

	/**
	 * Clear cache when products are updated.
	 *
	 * @var string
	 */
	protected $cache_key = 'products';

	/**
	 * Create a new model
	 *
	 * @param array $attributes Attributes to create.
	 *
	 * @return $this|false
	 */
	protected function create( $attributes = array() ) {
		// create the model.
		$created = parent::create( $attributes );
		if ( is_wp_error( $created ) ) {
			return $created;
		}

		// sync with the post.
		$this->sync();

		// return.
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
	 * Immediately sync with a post.
	 *
	 * @param string $id The id of the product to sync.
	 *
	 * @return \WP_Post|\WP_Error|self
	 */
	protected function sync( $id = '' ) {
		// set the id.
		if ( ! empty( $id ) ) {
			$this->id = $id;
		}

		// we need an id.
		if ( empty( $this->id ) ) {
			return new \WP_Error( 'missing_id', __( 'Missing ID', 'surecart' ) );
		}

		// if there are no syncable expands, let's fetch them.
		$this->with( $this->sync_expands )->where( array( 'cached' => false ) )->find( $this->id );

		// sync the product.
		$synced = \SureCart::sync()->product()->sync( $this );

		// on success, cancel any queued syncs.
		if ( is_wp_error( $synced ) ) {
			return $synced;
		}

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
			->product()
			->delete( $id );

		return $this;
	}

	/**
	 * Queue a sync process with a post.
	 *
	 * @param boolean $show_notice Whether to show a notice.
	 *
	 * @return \SureCart\Background\QueueService
	 */
	protected function queueSync( $show_notice = false ) {
		\SureCart::sync()
			->product()
			->withNotice( $show_notice )
			->queue( $this );

		return $this;
	}

	/**
	 * Maybe queue a sync job if updated_at is different
	 * than the product post updated_at.
	 *
	 * @return \SureCart\Background\QueueService|false Whether the sync was queued.
	 */
	protected function maybeQueueSync() {
		// already in sync.
		if ( $this->synced ) {
			return false;
		}

		return $this->queueSync();
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
	 * Get the attached post.
	 *
	 * @return int|false
	 */
	public function getPostAttribute() {
		return \SureCart::sync()->product()->post()->findByModelId( $this->id );
	}

	/**
	 * Get the is synced attribute.
	 *
	 * @return bool
	 */
	protected function getSyncedAttribute() {
		// we don't have a post.
		if ( empty( $this->post ) ) {
			return false;
		}

		// the post is trashed.
		if ( 'trash' === $this->post->post_status ) {
			return false;
		}

		// this doesn't have updated at.
		if ( empty( $this->updated_at ) ) {
			return false;
		}

		// get the product and decode it.
		$product = get_post_meta( $this->post->ID, 'product', true );
		$product = is_string( $product ) ? json_decode( get_post_meta( $this->post->ID, 'product', true ) ) : $product;
		$product = (object) $product;
		if ( empty( $product ) || ! isset( $product->updated_at ) ) {
			return false;
		}

		// sync if updated at is different.
		return $this->updated_at === $product->updated_at;
	}

	/**
	 * Check if model has syncable expands as properties
	 *
	 * @return bool
	 */
	protected function getHasSyncableExpandsAttribute() {
		foreach ( $this->sync_expands as $expand ) {
			// if expand contains a ., let's ignore it for now.
			if ( false !== strpos( $expand, '.' ) ) {
				return true;
			}
			if ( ! isset( $this->$expand ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Get the sync expands.
	 *
	 * @return array
	 */
	protected function getSyncExpands() {
		return $this->sync_expands;
	}

	/**
	 * Maybe queue a sync job if updated_at is different
	 * than the product post updated_at.
	 *
	 * @param string $value The updated_at value.
	 *
	 * @return void
	 */
	public function setUpdatedAtAttribute( $value ) {
		$this->attributes['updated_at'] = apply_filters( "surecart/$this->object_name/attributes/updated_at", $value, $this );
		$this->maybeQueueSync();
	}

	/**
	 * Image srcset.
	 *
	 * @return string
	 */
	public function getImageSrcsetAttribute() {
		if ( empty( $this->attributes['image_url'] ) ) {
			return '';
		}
		return $this->imageSrcSet( $this->attributes['image_url'] );
	}

	/**
	 * Get the image url for a specific size.
	 *
	 * @param integer $size The size.
	 *
	 * @return string
	 */
	public function getImageUrl( $size = 0 ) {
		if ( empty( $this->attributes['image_url'] ) ) {
			return '';
		}
		return $size ? $this->imageUrl( $this->attributes['image_url'], $size ) : $this->attributes['image_url'];
	}

	/**
	 * Set the prices attribute.
	 *
	 * @param  object $value Array of price objects.
	 * @return void
	 */
	public function setPricesAttribute( $value ) {
		$this->setCollection( 'prices', $value, Price::class );
	}

	/**
	 * Set the product collections attribute
	 *
	 * @param object $value Product collections.
	 * @return void
	 */
	public function setProductCollectionsAttribute( $value ) {
		$this->setCollection( 'product_collections', $value, ProductCollection::class );
	}

	/**
	 * Set the variants attribute.
	 *
	 * @param  object $value Array of price objects.
	 * @return void
	 */
	public function setVariantsAttribute( $value ) {
		$this->setCollection( 'variants', $value, Variant::class );
	}

	/**
	 * Set the variants attribute.
	 *
	 * @param  object $value Array of price objects.
	 * @return void
	 */
	public function setVariantOptionsAttribute( $value ) {
		$this->setCollection( 'variant_options', $value, VariantOption::class );
	}

	/**
	 * Set the featured product media attribute.
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setFeaturedProductMediaAttribute( $value ) {
		$this->setRelation( 'featured_product_media', $value, ProductMedia::class );
	}

	/**
	 * Set the product media attribute
	 *
	 * @param  string $value ProductMedia properties.
	 * @return void
	 */
	public function setProductMediasAttribute( $value ) {
		$this->setCollection( 'product_medias', $value, ProductMedia::class );
	}

	/**
	 * Buy link model
	 *
	 * @return \SureCart\Models\BuyLink
	 */
	public function buyLink() {
		return new BuyLink( $this );
	}

	/**
	 * Checkout Permalink.
	 *
	 * @return string
	 */
	public function getCheckoutPermalinkAttribute() {
		return $this->buyLink()->url();
	}

	/**
	 * Get the product permalink.
	 *
	 * @return string
	 */
	public function getPermalinkAttribute(): string {
		return ! empty( $this->post ) ? get_the_permalink( $this->post->ID ) : '';
	}

	/**
	 * Is the post published?
	 *
	 * @return string
	 */
	public function getIsPublishedAttribute(): bool {
		return ! empty( $this->post ) && 'publish' === $this->post->post_status;
	}

	/**
	 * Get the page title.
	 *
	 * @return string
	 */
	public function getPageTitleAttribute(): string {
		return $this->metadata->page_title ?? $this->name ?? '';
	}

	/**
	 * Get the meta description.
	 *
	 * @return string
	 */
	public function getMetaDescriptionAttribute(): string {
		return $this->metadata->meta_description ?? $this->description ?? '';
	}

	/**
	 * Get the product in stock attribute.
	 *
	 * @param Product $product The product.
	 *
	 * @return bool
	 */
	public function getInStockAttribute(): bool {
		if ( ! $this->stock_enabled ) {
			return true;
		}

		if ( $this->allow_out_of_stock_purchases ) {
			return true;
		}

		return $this->available_stock > 0;
	}

	/**
	 * Return attached active prices.
	 *
	 * @return array
	 */
	public function getActivePricesAttribute() {
		$active_prices = array_values(
			array_filter(
				$this->prices->data ?? array(),
				function ( $price ) {
					return ! $price->archived;
				}
			)
		);

		usort(
			$active_prices,
			function ( $a, $b ) {
				if ( $a->position == $b->position ) {
					return 0;
				}
				return ( $a->position < $b->position ) ? -1 : 1;
			}
		);

		return $active_prices;
	}

	/**
	 * Get the has multiple prices attribute.
	 *
	 * @return boolean
	 */
	public function getHasMultiplePricesAttribute() {
		return count( $this->active_prices ) > 1;
	}

	/**
	 * Return attached active prices.
	 */
	public function activeAdHocPrices() {
		return array_filter(
			$this->active_prices ?? array(),
			function ( $price ) {
				return $price->ad_hoc;
			}
		);
	}

	/**
	 * Get the featured image attribute.
	 *
	 * @return SureCart\Support\Contracts\GalleryItem|null;
	 */
	public function getFeaturedImageAttribute() {
		$gallery = array_values( $this->gallery ?? array() );

		if ( ! empty( $gallery ) ) {
			return $gallery[0] ?? null;
		}
		if ( empty( $this->featured_product_media ) ) {
			return null;
		}
		if ( ! is_a( $this->featured_product_media, \SureCart\Models\ProductMedia::class ) ) {
			return null;
		}
		return new GalleryItemProductMedia( $this->featured_product_media );
	}

	/**
	 * Returns the product media image attributes.
	 *
	 * @return SureCart\Support\Contracts\GalleryItem|null;
	 */
	public function getFeaturedMediaAttribute() {
		return $this->featured_product_image;
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
				return 'single-sc_product';
			}

			// this is acceptable.
			return $this->metadata->wp_template_id;
		}

		return '';
	}

	/**
	 * Get with sorted prices.
	 *
	 * @return this
	 */
	public function withSortedPrices() {
		if ( empty( $this->prices->data ) ) {
			return $this;
		}

		$filtered = clone $this;

		// Sort prices by position.
		usort(
			$filtered->prices->data,
			function ( $a, $b ) {
				return $a->position - $b->position;
			}
		);

		return $filtered;
	}

	/**
	 * Get product with acgive and sorted prices.
	 *
	 * @return this
	 */
	public function withActivePrices() {
		if ( empty( $this->prices->data ) ) {
			return $this;
		}

		$filtered = clone $this;

		// Filter out archived prices.
		$filtered->prices->data = array_values(
			array_filter(
				$filtered->prices->data ?? array(),
				function ( $price ) {
					return ! $price->archived;
				}
			)
		);

		return $filtered;
	}

	/**
	 * Get the trial text attribute.
	 *
	 * @return string
	 */
	public function getTrialTextAttribute() {
		return $this->initial_price ? $this->initial_price->trial_text ?? '' : '';
	}

	/**
	 * Get the billing interval attribute.
	 *
	 * @return string
	 */
	public function getBillingIntervalTextAttribute() {
		return $this->initial_price ? $this->initial_price->interval_text ?? '' : '';
	}

	/**
	 * Get the setup fee attribute
	 *
	 * @return string
	 */
	public function getSetupFeeTextAttribute() {
		return $this->initial_price ? $this->initial_price->setup_fee_text ?? '' : '';
	}

	/**
	 * Is the product or any variants in stock.
	 *
	 * @return int
	 */
	public function getHasUnlimitedStockAttribute() {
		if ( empty( $this->stock_enabled ) ) {
			return true;
		}
		return $this->allow_out_of_stock_purchases;
	}

	/**
	 * Get the first variant with stock.
	 *
	 * @return \SureCart\Models\Variant;
	 */
	public function getFirstVariantWithStockAttribute() {
		return $this->in_stock_variants[0] ?? null;
	}

	/**
	 * Get the in stock variants.
	 *
	 * @return array
	 */
	public function getInStockVariantsAttribute() {
		if ( ! $this->has_unlimited_stock && ! empty( $this->variants->data ) ) {
			return array_map(
				function ( $variant ) {
					return $variant->available_stock > 0;
				},
				$this->variants->data,
			);
		}
		return $this->variants->data ?? null;
	}

	/**
	 * Get the initial price.
	 *
	 * @return string
	 */
	public function getInitialPriceAttribute() {
		$prices        = $this->active_prices ?? array();
		$initial_price = $prices[0] ?? null;
		return $initial_price;
	}

	/**
	 * Get the initial variant.
	 *
	 * @return string
	 */
	public function getInitialVariantAttribute() {
		$initial_variant = $this->first_variant_with_stock;
		if ( ! empty( $initial_variant ) ) {
			return $initial_variant;
		}
		return $this->variants->data[0] ?? null;
	}

	/**
	 * Get the initial amount.
	 *
	 * @return string
	 */
	public function getInitialAmountAttribute() {
		$initial_price = $this->initial_price;
		if ( count( $this->active_prices ) > 1 ) {
			return $this->initial_price->amount;
		}

		$initial_variant = $this->initial_variant;
		if ( ! empty( $initial_variant->amount ) ) {
			return $initial_variant->amount;
		}

		return $initial_price->amount ?? null;
	}

	/**
	 * Get the scratch amount.
	 *
	 * @return string
	 */
	public function getScratchAmountAttribute() {
		$prices        = $this->active_prices ?? array();
		$initial_price = $prices[0] ?? null;
		return $initial_price->scratch_amount ?? null;
	}

	/**
	 * Get the scratch display amount.
	 *
	 * @return string
	 */
	public function getScratchDisplayAmountAttribute() {
		if ( empty( $this->initial_price->scratch_amount ) ) {
			return '';
		}
		return Currency::format( $this->initial_price->scratch_amount, $this->initial_price->currency );
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
	 * Get the product template id.
	 *
	 * @return string
	 */
	public function getTemplatePartIdAttribute(): string {
		if ( ! empty( $this->metadata->wp_template_part_id ) ) {
			return $this->metadata->wp_template_part_id;
		}
		return 'surecart/surecart//product-info';
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
	 * Get Template Content.
	 *
	 * @return string
	 */
	public function getTemplateContent(): string {
		return wp_is_block_theme() ?
		$this->template->content ?? '' :
		$this->template_part->content ?? '';
	}

	/**
	 * Get the gallery ids attribute.
	 *
	 * @return array
	 */
	public function getGalleryIdsAttribute() {
		// fallback.
		if ( empty( $this->metadata->gallery_ids ) ) {
			return array_values(
				array_filter(
					array_map(
						function ( $media ) {
							return $media->id;
						},
						$this->product_medias->data ?? array()
					)
				),
			);
		}

		// gallery.
		return json_decode( $this->metadata->gallery_ids ?? '' );
	}

	/**
	 * Set the gallery ids attribute.
	 * This needs to be converted to JSON for the platform.
	 *
	 * @param array $value The gallery array.
	 * @return void
	 */
	public function setGalleryIdsAttribute( $value ) {
		$this->attributes['metadata']              = (object) ( $this->attributes['metadata'] ?? [] );
		$this->attributes['metadata']->gallery_ids = is_string( $value ) ? $value : wp_json_encode( $value );
	}

	/**
	 * Get the gallery attribute.
	 *
	 * Map the post gallery array to GalleryItem objects.
	 *
	 * @return GalleryItem[]
	 */
	public function getGalleryAttribute() {
		$cached = $this->getCachedAttribute( 'gallery' );
		if ( null !== $cached ) {
			return $cached;
		}

		$gallery = array_values(
			array_filter(
				array_map(
					function ( $id ) {
						// this is an attachment id.
						if ( is_int( $id ) ) {
							return new GalleryItemAttachment( $id );
						}

						// get the product media item that matches the id.
						$item = array_filter(
							$this->getAttribute( 'product_medias' )->data ?? array(),
							function ( $item ) use ( $id ) {
								return $item->id === $id;
							}
						);

						// get the first item.
						$item = array_shift( $item );
						if ( ! empty( $item ) ) {
							return new GalleryItemProductMedia( $item );
						}

						return null;
					},
					$this->gallery_ids
				),
				function ( $item ) {
					// it must have a src at least.
					return ! empty( $item ) && ! empty( $item->attributes()->src );
				}
			)
		);

		$this->setAttributeCache( 'gallery', $gallery );

		return $gallery;
	}

	/**
	 * Get the price display amount.
	 *
	 * @return array
	 */
	public function getDisplayAmountAttribute() {
		$prices = $this->active_prices ?? array();

		// only if we have one price.
		if ( count( $prices ) === 1 ) {
			$initial_variant = $this->first_variant_with_stock;
			if ( ! empty( $initial_variant->amount ) ) {
				return Currency::format( $initial_variant->amount, $initial_variant->currency );
			}
		}

		// we don't have an initial price.
		if ( empty( $this->initial_price ) ) {
			return '';
		}

		// return the formatted amount.
		return Currency::format( $this->initial_price->amount, $this->initial_price->currency );
	}

	/**
	 * Get Price Range Display Amount.
	 *
	 * @return string
	 */
	public function getRangeDisplayAmountAttribute() {
		// there are no metrics.
		if ( ! $this->metrics || empty( $this->metrics->min_price_amount ) || empty( $this->metrics->max_price_amount ) ) {
			return '';
		}

		// the min and max are the same.
		if ( $this->metrics->min_price_amount === $this->metrics->max_price_amount ) {
			return Currency::format( $this->metrics->min_price_amount, $this->metrics->currency );
		}

		// return the range.
		return sprintf(
		// translators: %1$1s is the min price, %2$2s is the max price.
			__(
				'%1$1s - %2$2s',
				'surecart',
			),
			Currency::format( $this->metrics->min_price_amount, $this->metrics->currency ),
			Currency::format( $this->metrics->max_price_amount, $this->metrics->currency )
		);
	}

	/**
	 * Is the product on sale?
	 *
	 * @return array
	 */
	public function getIsOnSaleAttribute() {
		return $this->initial_price->is_on_sale ?? false;
	}

	/**
	 * Get the image used in line items.
	 *
	 * @return object
	 */
	public function getLineItemImageAttribute() {
		return is_a( $this->featured_image, GalleryItem::class ) ? $this->featured_image->attributes( 'thumbnail' ) : (object) array();
	}

	/**
	 * Get the image used in line items.
	 *
	 * @return object
	 */
	public function getPreviewImageAttribute() {
		return is_a( $this->featured_image, GalleryItem::class ) ? $this->featured_image->attributes( 'medium_large' ) : (object) [];
	}

	/**
	 * Get the product page initial state
	 *
	 * @param array $args Array of arguments.
	 *
	 * @return array
	 */
	public function getInitialPageState( $args = [] ) {
		$form = \SureCart::forms()->getDefault();

		return wp_parse_args(
			$args,
			[
				'formId'          => $form->ID,
				'mode'            => \SureCart\Models\Form::getMode( $form->ID ),
				'product'         => $this,
				'prices'          => $this->active_prices,
				'selectedPrice'   => ( $this->active_prices ?? [] )[0] ?? null,
				'checkoutUrl'     => \SureCart::pages()->url( 'checkout' ),
				'variant_options' => $this->variant_options->data ?? [],
				'variants'        => $this->variants->data ?? [],
				'selectedVariant' => $this->first_variant_with_stock ?? null,
				'isProductPage'   => ! empty( get_query_var( 'surecart_current_product' )->id ),
			]
		);
	}
}
