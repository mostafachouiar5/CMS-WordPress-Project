<?php

namespace SureCart\WordPress;

/**
 * InitialState class
 *
 * Manages the initial state of the store in the server and
 * its serialization so it can be restored in the browser upon hydration.
 */
class StateService {
	/**
	 * Store data.
	 *
	 * @var array
	 */
	private $store = array();

	/**
	 * Set the store.
	 *
	 * @param array $store The store data.
	 */
	public function __construct( $store ) {
		$this->store = $store;
	}

	/**
	 * Render the store in the footer.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'wp_footer', [ $this, 'render' ], 8 );
	}

	/**
	 * Get store data.
	 *
	 * @return array
	 */
	public function getData() {
		return $this->store;
	}

	/**
	 * Get the line items service.
	 *
	 * @return LineItemStateService
	 */
	public function lineItems() {
		return new LineItemStateService();
	}

	/**
	 * Merge data.
	 *
	 * @param array $data The data that will be merged with the existing store.
	 */
	public function mergeData( $data ) {
		$this->store = array_replace_recursive( $this->store, $data );
	}

	/**
	 * Reset the store data.
	 */
	public function reset() {
		$this->store = array();
	}

	/**
	 * Render the store data.
	 */
	public function render() {
		if ( empty( $this->store ) ) {
			return;
		}
		echo sprintf(
			'<script id="sc-store-data" type="application/json">%s</script>',
			wp_json_encode( $this->store, JSON_HEX_TAG | JSON_HEX_AMP )
		);
	}
}
