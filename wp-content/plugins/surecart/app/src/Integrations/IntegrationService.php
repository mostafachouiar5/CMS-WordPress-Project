<?php

namespace SureCart\Integrations;

use SureCart\Integrations\Contracts\IntegrationInterface;
use SureCart\Integrations\Contracts\PurchaseSyncInterface;
use SureCart\Models\Integration;
use SureCart\Models\Purchase;

/**
 * Base class for integrations to extend.
 */
abstract class IntegrationService extends AbstractIntegration implements IntegrationInterface {
	/**
	 * Purchase model for the integration.
	 *
	 * @var \SureCart\Models\Purchase
	 */
	protected $purchase = null;

	/**
	 * The current user for the integration.
	 *
	 * @var \WP_User
	 */
	protected $user = null;

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getName() {
		return '';
	}

	/**
	 * Get the model for the integration.
	 *
	 * @return string
	 */
	public function getModel() {
		return '';
	}


	/**
	 * Get the logo for the integration.
	 *
	 * @return string
	 */
	public function getLogo() {
		return '';
	}

	/**
	 * Get the name for the integration.
	 *
	 * @return string
	 */
	public function getLabel() {
		return '';
	}

	/**
	 * Get the item label for the integration.
	 *
	 * @return string
	 */
	public function getItemLabel() {
		return '';
	}

	/**
	 * Get the item help label for the integration.
	 *
	 * @return string
	 */
	public function getItemHelp() {
		return '';
	}

	/**
	 * Get item listing for the integration.
	 *
	 * @param array  $items The integration items.
	 * @param string $search The search query.
	 *
	 * @return array The items for the integration.
	 */
	public function getItems( $items = [], $search = '' ) {
		return $items;
	}

	/**
	 * Get the individual item.
	 *
	 * @param string $id Id for the record.
	 *
	 * @return array The item for the integration.
	 */
	public function getItem( $id ) {
		return [];
	}

	/**
	 * Enable by default.
	 *
	 * @return boolean
	 */
	public function enabled() {
		return true;
	}

	/**
	 * Map this class methods to specific events.
	 *
	 * @var array
	 */
	protected $methods_map = [
		'surecart/purchase_created' => 'onPurchaseCreated',
		'surecart/purchase_invoked' => 'onPurchaseInvoked',
		'surecart/purchase_revoked' => 'onPurchaseRevoked',
	];

	/**
	 * Bootstrap the integration.
	 */
	public function bootstrap() {
		// index and list.
		add_filter( "surecart/integrations/providers/list/{$this->getModel()}", [ $this, 'indexProviders' ], 9 );
		add_filter( "surecart/integrations/providers/find/{$this->getName()}", [ $this, 'findProvider' ], 9 );

		// get items.
		add_filter( "surecart/integrations/providers/{$this->getName()}/{$this->getModel()}/items", [ $this, 'getItems' ], 9, 2 );
		add_filter( "surecart/integrations/providers/{$this->getName()}/item", [ $this, '_getItem' ], 9, 2 );

		// implement purchase events if purchase sync interface is implemented.
		if ( is_subclass_of( $this, PurchaseSyncInterface::class ) ) {
			add_action( 'surecart/purchase_created', [ $this, 'callMethod' ], 9 );
			add_action( 'surecart/purchase_invoked', [ $this, 'callMethod' ], 9 );
			add_action( 'surecart/purchase_revoked', [ $this, 'callMethod' ], 9 );
			add_action( 'surecart/purchase_updated', [ $this, 'onPurchaseUpdated' ], 9, 2 );
		}
	}

	/**
	 * Get the current purchase.
	 *
	 * @return \SureCart\Models\Purchase|null;
	 */
	public function getPurchase() {
		return $this->purchase;
	}

	public function getPurchaseId() {
		return $this->purchase->id ?? null;
	}

	/**
	 * Get the user.
	 *
	 * @return \WP_User|null;
	 */
	public function getUser() {
		return $this->purchase->getWPUser();
	}

	/**
	 * The purchase has been updated.
	 * This is extendable, but is also abtracted into
	 * invoke/revoke and quantity update methods.
	 *
	 * @param Purchase $purchase The purchase.
	 * @param object   $request The request.
	 *
	 * @return void
	 */
	public function onPurchaseUpdated( Purchase $purchase, $request ) {
		$this->purchase = $purchase;

		$data     = (object) $request->data->object ?? null;
		$previous = (object) $request->data->previous_attributes ?? null;

		// we need data or a previous.
		if ( empty( $data ) || empty( $previous ) ) {
			return;
		}

		// product has changed, let's revoke access to the old one
		// and provide access to the new one.
		if ( ! empty( $previous->product ) && $data->product !== $previous->product ) {
			$previous_purchase = new Purchase(
				array_merge(
					$purchase->toArray(),
					[
						'product'  => $previous->product,
						'quantity' => $previous->quantity ?? 1,
					]
				)
			);
			$this->onPurchaseProductUpdated( $purchase, $previous_purchase, $request );
			return;
		}

		// price or variant has changed. We need to revoke access to the old one
		// and provide access to the new one.
		$previous_variant = $previous->variant ?? null;
		$previous_price   = $previous->price ?? null;
		if ( $data->price !== $previous_price || $data->variant !== $previous_variant ) {
			$previous_purchase = new Purchase(
				array_merge(
					$purchase->toArray(),
					[
						'price'   => $previous_price,
						'variant' => $previous_variant,
					]
				)
			);
			$this->onPurchaseProductUpdated( $purchase, $previous_purchase, $request );
			return;
		}

		// The quantity has not changed.
		$previous_quantity = $previous->quantity ?? 1;
		if ( (int) $data->quantity === $previous_quantity ) {
			return;
		}

		// run quantity updated method.
		$integrations = (array) $this->getIntegrationData( $purchase ) ?? [];
		foreach ( $integrations as $integration ) {
			if ( ! $integration->id ) {
				continue;
			}

			if ( $this->purchaseIsNotMatchedWithPriceOrVariant( $integration, $purchase ) ) {
				continue;
			}

			$this->onPurchaseQuantityUpdated(
				$data->quantity,
				$previous->quantity,
				$integration,
				$purchase->getWPUser()
			);
		}
	}

	/**
	 * When the purchase product is updated
	 *
	 * @param \SureCart\Models\Purchase $purchase The purchase.
	 * @param \SureCart\Models\Purchase $previous_purchase The previous purchase.
	 * @param array                     $request The request.
	 *
	 * @return void
	 */
	public function onPurchaseProductUpdated( \SureCart\Models\Purchase $purchase, \SureCart\Models\Purchase $previous_purchase, $request ) {
		$this->purchase = $purchase;

		// product added.
		$integrations = (array) $this->getIntegrationData( $purchase ) ?? [];
		foreach ( $integrations as $integration ) {
			if ( ! $integration->id ) {
				continue;
			}

			if ( $this->purchaseIsNotMatchedWithPriceOrVariant( $integration, $purchase ) ) {
				continue;
			}

			$this->onPurchaseProductAdded( $integration, $purchase->getWPUser(), $purchase );
		}

		// product removed.
		$integrations = (array) $this->getIntegrationData( $previous_purchase ) ?? [];
		foreach ( $integrations as $integration ) {
			if ( ! $integration->id ) {
				continue;
			}

			if ( $this->purchaseIsNotMatchedWithPriceOrVariant( $integration, $previous_purchase ) ) {
				continue;
			}

			$this->onPurchaseProductRemoved( $integration, $previous_purchase->getWPUser(), $previous_purchase );
		}
	}

	/**
	 * Method to run when the quantity updates.
	 *
	 * @param integer  $quantity The new quantity.
	 * @param integer  $previous The previous quantity.
	 * @param Purchase $purchase The purchase.
	 * @param array    $request The request.
	 *
	 * @return void
	 */
	public function onPurchaseQuantityUpdated( $quantity, $previous, $purchase, $request ) {
		$this->purchase = $purchase;
		// Allow this to be extended to provide functionality. Do nothing by default.
	}

	/**
	 * Get the item.
	 *
	 * @param string $id Id for the record.
	 *
	 * @return object
	 */
	public function _getItem( $id ) {
		if ( ! $this->enabled() ) {
			return;
		}
		$item       = (object) $this->getItem( $id );
		$item->logo = esc_url_raw( $this->getLogo() );
		return $item;
	}

	/**
	 * Call the method for the integration.
	 *
	 * @param \SureCart\Models\Purchase $purchase The purchase model.
	 *
	 * @return void
	 */
	public function callMethod( $purchase ) {
		// store the current purchase.
		$this->purchase = $purchase;

		$method = $this->methods_map[ $this->getCurrentAction() ] ?? null;
		if ( ! $method || ! method_exists( $this, $method ) ) {
			return;
		}

		$integrations = (array) $this->getIntegrationData( $purchase ) ?? [];
		foreach ( $integrations as $integration ) {
			if ( ! $integration->id ) {
				continue;
			}

			// If the integration has a price_id or variant_id, then we need to match with specific price or variant.
			if ( $this->purchaseIsNotMatchedWithPriceOrVariant( $integration, $purchase ) ) {
				continue;
			}

			$user = $purchase->getWPUser();
			if ( ! $user ) {
				// throw new \Exception( 'No WordPress user is linked to this customer. This means any integrations will not run. Please link this customer to a WordPress user.' );
				continue;
			}

			$this->$method( $integration, $purchase->getWPUser(), $purchase );
		}
	}

	/**
	 * Get the current called action.
	 *
	 * @return string
	 */
	protected function getCurrentAction() {
		return \current_action();
	}

	/**
	 * Get the Integration data from the purchase.
	 * This normalizes the integration data and the WP user.
	 *
	 * @param \SureCart\Models\Purchase $purchase Purchase model.
	 *
	 * @return array The integration data.
	 */
	public function getIntegrationData( $purchase ) {
		if ( is_string( $purchase ) ) {
			$purchase = Purchase::find( $purchase );
		}
		if ( is_wp_error( $purchase ) ) {
			return;
		}

		// Get the integrations from the purchase.
		return $this->getIntegrationsFromPurchase( $purchase );
	}

	/**
	 * Add the provider to the list.
	 *
	 * @param array $list The list of providers.
	 * @return array
	 */
	public function indexProviders( $list = [] ) {
		$list[] = $this->findProvider();
		return $list;
	}

	/**
	 * Find the provider.
	 *
	 * @return array
	 */
	public function findProvider() {
		return [
			'name'       => $this->getName(),
			'label'      => $this->getLabel(),
			'disabled'   => ! $this->enabled(),
			'logo'       => esc_url_raw( $this->getLogo() ),
			'item_label' => $this->getItemLabel(),
			'item_help'  => $this->getItemHelp(),
		];
	}

	/**
	 * Get the integration based on the current purchase.
	 *
	 * @param \SureCart\Models\Purchase $purchase The purchase.
	 *
	 * @return array
	 */
	public function getIntegrationsFromPurchase( $purchase ) {
		// we need a product id.
		$product_id = $purchase->product_id ?? null;
		if ( ! $product_id ) {
			return [];
		}

		$query = Integration::where( 'model_id', $product_id )->andWhere( 'provider', $this->getName() );

		return (array) $query->get();
	}

	/**
	 * Check if the integration does not match with purchase price or variant.
	 *
	 * @param Integration $integration
	 * @param Purchase    $purchase
	 *
	 * @return boolean
	 */
	public function purchaseIsNotMatchedWithPriceOrVariant( $integration, $purchase ): bool {
		// Get Purchase price and variant.
		$price_id   = $purchase->price->id ?? $purchase->price ?? null;
		$variant_id = $purchase->variant->id ?? $purchase->variant ?? null;

		// If integration has price_id or variant_id,
		// then we need to match with specific price or variant.
		if (
			( ! empty( $integration->price_id ) && $integration->price_id !== $price_id )
			|| ( ! empty( $integration->variant_id ) && $integration->variant_id !== $variant_id )
		) {
			return true;
		}

		return false;
	}
}
