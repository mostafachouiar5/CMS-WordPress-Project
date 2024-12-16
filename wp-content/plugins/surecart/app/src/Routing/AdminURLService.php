<?php

namespace SureCart\Routing;

/**
 * Generates links for specific amdin urls.
 */
class AdminURLService {
	/**
	 * Stores the admin page names.
	 *
	 * @var array
	 */
	protected $page_names = [];

	/**
	 * Initialize page names
	 *
	 * @param array $page_names Array of page names and their admin query names.
	 */
	public function __construct( $page_names ) {
		$this->page_names = $page_names;
	}

	/**
	 * New page url
	 *
	 * @param string $name Model lowercase name.
	 * @return string URL for the page.
	 */
	public function new( $name ) {
		return esc_url(
			add_query_arg(
				[
					'action' => 'edit',
				],
				admin_url( 'admin.php?page=' . $this->page_names[ $name ] ?? '' )
			)
		);
	}

	/**
	 * Edit page url
	 *
	 * @param string $name Model lowercase name.
	 * @param string $id Model id.
	 *
	 * @return string URL for the page.
	 */
	public function edit( $name, $id = null ) {
		return esc_url(
			add_query_arg(
				[
					'action' => 'edit',
					'id'     => $id,
				],
				admin_url( 'admin.php?page=' . $this->page_names[ $name ] ?? '' )
			)
		);
	}

	/**
	 * Show page url
	 *
	 * @param string $name Model lowercase name.
	 * @param string $id Model id.
	 *
	 * @return string URL for the page.
	 */
	public function show( $name, $id = null ) {
		return esc_url(
			add_query_arg(
				[
					'action' => 'show',
					'id'     => $id,
				],
				admin_url( 'admin.php?page=' . $this->page_names[ $name ] ?? '' )
			)
		);
	}

	/**
	 * Admin index page url
	 *
	 * @param string $name Model lowercase name.
	 * @return string URL for the page.
	 */
	public function index( $name ) {
		return esc_url( admin_url( 'admin.php?page=' . $this->page_names[ $name ] ) );
	}

	/**
	 * Archive page url
	 *
	 * @param string $name Model lowercase name.
	 * @param string $id Model id.
	 *
	 * @return string URL for the page.
	 */
	public function toggleArchive( $name, $id ) {
		return esc_url(
			add_query_arg(
				[
					'action' => 'toggle_archive',
					'nonce'  => wp_create_nonce( "archive_$name" ),
					'id'     => $id,
				],
				$this->index( $name )
			)
		);
	}

	/**
	 * Sync a specific model
	 *
	 * @param string $name Model lowercase name.
	 *
	 * @return string URL for the page.
	 */
	public function syncAll( $name ) {
		return esc_url(
			add_query_arg(
				[
					'action' => 'sync_all',
					'nonce'  => wp_create_nonce( "sync_$name" ),
				],
				$this->index( $name )
			)
		);
	}

	/**
	 * Sync a specific model
	 *
	 * @param string $name Model lowercase name.
	 * @param string $id Model id.
	 *
	 * @return string URL for the page.
	 */
	public function sync( $name, $id ) {
		return esc_url(
			add_query_arg(
				[
					'action' => 'sync',
					'nonce'  => wp_create_nonce( "sync_$name" ),
					'id'     => $id,
				],
				$this->index( $name )
			)
		);
	}

	/**
	 * Edit model action
	 */
	public function editModel( $action, $id, $redirect_url = '' ) {
		return esc_url(
			add_query_arg(
				[
					'action' => $action,
					'nonce'  => wp_create_nonce( $action ),
					'id'     => $id,
				],
				$redirect_url
			)
		);
	}

	/**
	 * Build the checkout url.
	 *
	 * @param array $line_items Line items.
	 * @return string url
	 */
	public function checkout( $line_items = [] ) {
		$checkout = \SureCart::pages()->url( 'checkout' );
		if ( ! $checkout ) {
			return '';
		}

		return add_query_arg(
			[
				...( $line_items ? [ 'line_items' => $this->lineItems( $line_items ?? [] ) ] : [] ),
			],
			$checkout
		);
	}

	/**
	 * Build the line items array.
	 *
	 * @param array $line_items Line items.
	 * @return array Line items.
	 */
	public function lineItems( $line_items ) {
		return array_map(
			function ( $item ) {
				return [
					'price_id' => $item['id'],
					'quantity' => $item['quantity'],
				];
			},
			$line_items ?? []
		);
	}

	/**
	 * Create Url.
	 *
	 * @param string $name Model lowercase name.
	 *
	 * @return string URL for the page.
	 */
	public function create( $name ) {
		return esc_url(
			add_query_arg(
				[
					'action' => 'create',
					'nonce'  => wp_create_nonce( "create_$name" ),
				],
				admin_url( 'admin.php?page=' . $this->page_names[ $name ] ?? '' )
			)
		);
	}
}
