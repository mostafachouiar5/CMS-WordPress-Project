<?php

namespace SureCart\Integrations\TutorLMS;

use SureCart\Integrations\Contracts\IntegrationInterface;
use SureCart\Integrations\Contracts\PurchaseSyncInterface;
use SureCart\Integrations\IntegrationService;
use SureCart\Models\Integration;
use SureCart\Models\Price;
use SureCart\Models\Product;
use SureCart\Support\Currency;

/**
 * Controls the LearnDash integration.
 */
class TutorLMSService extends IntegrationService implements IntegrationInterface, PurchaseSyncInterface {

	public function bootstrap() {
		parent::bootstrap();

		add_filter( 'tutor/course/single/entry-box/free', [ $this, 'purchaseButton' ], 10, 2 );
		add_filter( 'tutor/course/single/entry-box/purchasable', [ $this, 'purchaseButton' ], 10, 2 );
		add_filter( 'get_tutor_course_price', [ $this, 'coursePrice' ], 11, 2 );
		add_filter( 'tutor_course_loop_price', [ $this, 'loopPurchaseButton' ], 10, 2 );

		add_action( 'surecart/models/price/updated', [ $this, 'clearPriceCache' ], 10, 2 );
		add_action( 'surecart/models/price/created', [ $this, 'clearPriceCache' ], 10, 2 );
	}

	/**
	 * Show our purchase button if we have an integration.
	 *
	 * @param string $output The button HTML.
	 *
	 * @return string
	 */
	public function loopPurchaseButton( $output ) {
		// check first to see if we have any integrations.
		$integrations = Integration::where( 'integration_id', get_the_ID() )->andWhere( 'model_name', 'product' )->get();
		if ( empty( $integrations ) ) {
			return $output;
		}

		// Get the model ids from the integrations.
		$product_ids = array_column( $integrations, 'model_id' );
		if ( empty( $product_ids ) ) {
			return $output;
		}

		// get purchasable prices from cache.
		$prices = $this->getCachedProductsPrices( $product_ids );
		if ( empty( $prices ) ) {
			return $output;
		}

		// add our components.
		\SureCart::assets()->enqueueComponents();

		$is_logged_in             = is_user_logged_in();
		$enable_guest_course_cart = tutor_utils()->get_option( 'enable_guest_course_cart' );
		$required_loggedin_class  = '';
		if ( ! $is_logged_in && ! $enable_guest_course_cart ) {
			$required_loggedin_class = apply_filters( 'tutor_enroll_required_login_class', 'tutor-open-login-modal' );
		}

		// template.
		ob_start(); ?>

		<div class="tutor-course-list-btn"><?php echo apply_filters( 'tutor_course_restrict_new_entry', '<a href="' . get_the_permalink() . '" class="tutor-btn tutor-btn-outline-primary tutor-btn-md tutor-btn-block ' . $required_loggedin_class . '">' . __( 'Enroll Course', 'surecart' ) . '</a>' ); ?></div>

		<?php
		return ob_get_clean();
	}

	/**
	 * Clear the price cache.
	 *
	 * @param \SureCart\Models\Price $price The price model.
	 *
	 * @return void
	 */
	public function clearPriceCache( $price ) {
		if ( empty( $price->product ) ) {
			return;
		}

		// get the product id.
		$product_id = is_a( $price->product, Product::class ) ? $price->product->id : $price->product;

		delete_transient( 'surecart_tutor_lms_product_' . $product_id );
	}

	/**
	 * Get cached product prices.
	 *
	 * @param array $product_ids The product ids.
	 *
	 * @return array
	 */
	public function getCachedProductsPrices( $product_ids = [] ) {
		$prices = [];
		foreach ( $product_ids as $product_id ) {
			$prices = array_merge( $prices, $this->getCachedProductPrices( $product_id ) );
		}
		return $prices;
	}

	/**
	 * Get the cached prices.
	 *
	 * @param string $product_id The product id.
	 *
	 * @return array
	 */
	public function getCachedProductPrices( $product_id ) {
		// cache key.
		$cache_key = 'surecart_tutor_lms_product_' . $product_id;

		// get the transient.
		$prices = get_transient( $cache_key );

		// if we do not have a transient.
		if ( false === $prices ) {
			// get purchasable prices for product.
			$prices = Price::where(
				[
					'product_ids' => [ $product_id ],
					'archived'    => false,
				]
			)->get();

			// store in transient.
			set_transient( $cache_key, $prices, apply_filters( 'surecart_tutor_lms_product_cache_time', DAY_IN_SECONDS, $this ) );
		}

		return $prices;
	}

	/**
	 * The course price.
	 *
	 * @param string  $price The price string.
	 * @param integer $course_id The course id.
	 *
	 * @return string
	 */
	public function coursePrice( $price, $course_id ) {
		$integrations = Integration::where( 'integration_id', $course_id )->andWhere( 'model_name', 'product' )->get();

		// we have no integrations.
		if ( empty( $integrations ) ) {
			return $price;
		}

		if ( empty( $integrations[0]->model_id ) ) {
			return $price;
		}

		// get the first product.
		$prices = $this->getCachedProductPrices( $integrations[0]->model_id );
		if ( is_wp_error( $prices ) ) {
			return $prices;
		}

		// there is no price.
		if ( empty( $prices ) ) {
			return esc_html__( 'No price', 'surecart' );
		}

		$price_array = [];
		foreach ( $prices as $price ) {
			if ( $price->ad_hoc ) {
				$price_array[] = esc_html__( 'Custom amount', 'surecart' );
			} else {
				$price_array[] = Currency::format( $price->amount, $price->currency ?? 'usd' );
			}
		}

		// no price.
		return implode( ', ', $price_array );
	}

	/**
	 * Show our purchase button if we have an integration.
	 *
	 * @param string  $output The button HTML.
	 * @param integer $id The course id.
	 *
	 * @return string
	 */
	public function purchaseButton( $output, $id ) {
		// check first to see if we have any integrations.
		$integrations = Integration::where( 'integration_id', $id )->andWhere( 'model_name', 'product' )->get();
		if ( empty( $integrations ) ) {
			return $output;
		}

		// Get the model ids from the integrations.
		$product_ids = array_column( $integrations, 'model_id' );
		if ( empty( $product_ids ) ) {
			return $output;
		}

		// get purchasable prices from cache.
		$prices = $this->getCachedProductsPrices( $product_ids );
		if ( empty( $prices ) ) {
			return $output;
		}

		// add our components.
		\SureCart::assets()->enqueueComponents();

		// template.
		ob_start();

		include 'add-to-cart-surecart.php';

		return ob_get_clean();
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getName() {
		return 'surecart/tutor-course';
	}

	/**
	 * Get the model for the integration.
	 *
	 * @return string
	 */
	public function getModel() {
		return 'product';
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getLogo() {
		return esc_url_raw( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'images/integrations/tutor.svg' );
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getLabel() {
		return __( 'TutorLMS Course', 'surecart' );
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getItemLabel() {
		return __( 'Course Access', 'surecart' );
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getItemHelp() {
		return __( 'Enable access to a TutorLMS course.', 'surecart' );
	}

	/**
	 * Is this enabled?
	 *
	 * @return boolean
	 */
	public function enabled() {
		return defined( 'TUTOR_VERSION' );
	}

	/**
	 * Get item listing for the integration.
	 *
	 * @param array  $items The integration items.
	 * @param string $search The search term.
	 *
	 * @return array The items for the integration.
	 */
	public function getItems( $items = [], $search = '' ) {
		if ( ! function_exists( 'tutor' ) ) {
			return $items;
		}

		wp_reset_query();
		$course_query = new \WP_Query(
			[
				'post_type'   => tutor()->course_post_type,
				'post_status' => 'publish',
				's'           => $search,
				'per_page'    => 10,
			]
		);

		if ( ( isset( $course_query->posts ) ) && ( ! empty( $course_query->posts ) ) ) {
			$items = array_map(
				function( $post ) {
					return (object) [
						'id'    => $post->ID,
						'label' => $post->post_title,
					];
				},
				$course_query->posts
			);
		}

		return $items;
	}

	/**
	 * Get the individual item.
	 *
	 * @param string $id Id for the record.
	 *
	 * @return object The item for the integration.
	 */
	public function getItem( $id ) {
		$course = get_post( $id );
		if ( ! $course ) {
			return [];
		}
		return (object) [
			'id'             => $id,
			'provider_label' => __( 'TutorLMS Course', 'surecart' ),
			'label'          => $course->post_title,
		];
	}

	/**
	 * Enable Access to the course.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseCreated( $integration, $wp_user ) {
		$this->updateAccess( $integration->integration_id, $wp_user, true );
	}

	/**
	 * Enable access when purchase is invoked
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseInvoked( $integration, $wp_user ) {
		$this->onPurchaseCreated( $integration, $wp_user );
	}

	/**
	 * Remove a user role.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseRevoked( $integration, $wp_user ) {
		$this->updateAccess( $integration->integration_id, $wp_user, false );
	}

	/**
	 * Update access to a course.
	 *
	 * @param integer  $course_id The course id.
	 * @param \WP_User $wp_user The user.
	 * @param boolean  $add True to add the user to the course, false to remove.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function updateAccess( $course_id, $wp_user, $add = true ) {
		// we don't have learndash installed.
		if ( ! function_exists( 'tutor_utils' ) ) {
			return;
		}

		if ( ! $add ) {
			tutor_utils()->cancel_course_enrol( $course_id, $wp_user->ID );
			return;
		}

		tutor_utils()->do_enroll( $course_id, 0, $wp_user->ID );
		tutor_utils()->complete_course_enroll( 0 );
	}
}
