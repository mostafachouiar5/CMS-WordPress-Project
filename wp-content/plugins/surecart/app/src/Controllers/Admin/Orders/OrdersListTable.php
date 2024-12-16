<?php

namespace SureCart\Controllers\Admin\Orders;

use SureCart\Models\Order;
use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Controllers\Admin\Tables\HasModeFilter;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class OrdersListTable extends ListTable {
	use HasModeFilter;

	/**
	 * Prepare the items for the table to process
	 *
	 * @return Void
	 */
	public function prepare_items() {
		$columns  = $this->get_columns();
		$hidden   = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable );

		$query = $this->table_data();
		if ( is_wp_error( $query ) ) {
			$this->items = [];
			return;
		}

		$this->set_pagination_args(
			[
				'total_items' => $query->pagination->count,
				'per_page'    => $this->get_items_per_page( 'orders' ),
			]
		);

		$this->items = $query->data;
	}

	/**
	 * Show any integrations.
	 *
	 * @param \SureCart\Models\Order $order Order.
	 */
	public function column_integrations( $order ) {
		$output = '';

		// loop through each purchase.
		if ( ! empty( $order->checkout->purchases->data ) ) {
			foreach ( $order->checkout->purchases->data as $purchase ) {
				// TODO: eager load this to prevent n+1 queries.
				$output .= $this->productIntegrationsList(
					[
						'product_id' => $purchase->product,
						'price_id'   => $purchase->price->id ?? $purchase->price ?? null,
						'variant_id' => $purchase->variant->id ?? $purchase->variant ?? null,
					]
				);
			}
		}

		return $output ? $output : '-';
	}

	/**
	 * @global int $post_id
	 * @global string $comment_status
	 * @global string $comment_type
	 */
	protected function get_views() {
		$stati = [
			'all'            => __( 'All', 'surecart' ),
			'paid'           => __( 'Paid', 'surecart' ),
			'processing'     => __( 'Processing', 'surecart' ),
			'draft'          => __( 'Draft', 'surecart' ),
			'payment_failed' => __( 'Failed', 'surecart' ),
			'canceled'       => __( 'Canceled', 'surecart' ),
		];

		foreach ( $stati as $status => $label ) {
			$link                    = \SureCart::getUrl()->index( 'orders' );
			$current_link_attributes = '';

			if ( ! empty( $_GET['status'] ) ) {
				if ( $status === $_GET['status'] ) {
					$current_link_attributes = ' class="current" aria-current="page"';
				}
			} elseif ( 'all' === $status ) {
				$current_link_attributes = ' class="current" aria-current="page"';
			}

			$link = add_query_arg( 'status', $status, $link );

			$link = esc_url( $link );

			$status_links[ $status ] = "<a href='$link'$current_link_attributes>" . $label . '</a>';
		}

		// filter links.
		return apply_filters( 'sc_order_status_links', $status_links );
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return array
	 */
	public function get_columns() {

		$columns = [
			// 'cb'          => '<input type="checkbox" />',
			'order'              => __( 'Order', 'surecart' ),
			'status'             => __( 'Status', 'surecart' ),
			'fulfillment_status' => __( 'Fulfillment', 'surecart' ),
			'shipment_status'    => __( 'Shipping', 'surecart' ),
			'method'             => __( 'Method', 'surecart' ),
			'integrations'       => __( 'Integrations', 'surecart' ),
			'total'              => __( 'Total', 'surecart' ),
			'type'               => __( 'Type', 'surecart' ),
			'created'            => __( 'Date', 'surecart' ),
			'mode'               => '',
		];

		return $columns;
	}

	/**
	 * Displays the checkbox column.
	 *
	 * @param Product $product The product model.
	 */
	public function column_cb( $product ) {
		?>
		<label class="screen-reader-text" for="cb-select-<?php echo esc_attr( $product['id'] ); ?>"><?php _e( 'Select comment', 'surecart' ); ?></label>
		<input id="cb-select-<?php echo esc_attr( $product['id'] ); ?>" type="checkbox" name="delete_comments[]" value="<?php echo esc_attr( $product['id'] ); ?>" />
			<?php
	}

	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns() {
		return ( is_array( get_user_meta( get_current_user_id(), 'managesurecart_page_sc-orderscolumnshidden', true ) ) ) ? get_user_meta( get_current_user_id(), 'managesurecart_page_sc-orderscolumnshidden', true ) : array();
	}

	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns() {
		return array( 'title' => array( 'title', false ) );
	}

	/**
	 * Get the table data
	 *
	 * @return Array
	 */
	protected function table_data() {
		$mode = sanitize_text_field( wp_unslash( $_GET['mode'] ?? '' ) );

		$conditions = [
			'status'             => $this->getStatus(),
			'fulfillment_status' => ! empty( $_GET['fulfillment_status'] ) ? [ $_GET['fulfillment_status'] ] : [],
			'shipment_status'    => ! empty( $_GET['shipment_status'] ) ? [ $_GET['shipment_status'] ] : [],
			'query'              => $this->get_search_query(),
		];

		if ( ! empty( $mode ) ) {
			$conditions['live_mode'] = 'live' === $mode;
		}

		return Order::where( $conditions )
			->with( [ 'checkout', 'checkout.charge', 'checkout.customer', 'checkout.payment_method', 'checkout.manual_payment_method', 'checkout.purchases', 'checkout.selected_shipping_choice', 'shipping_choice.shipping_method', 'payment_method.card', 'payment_method.payment_instrument', 'payment_method.paypal_account', 'payment_method.bank_account' ] )
			->paginate(
				[
					'per_page' => $this->get_items_per_page( 'orders' ),
					'page'     => $this->get_pagenum(),
				]
			);
	}

	/**
	 * Get the archive query status.
	 *
	 * @return boolean|null
	 */
	public function getStatus() {
		$status = sanitize_text_field( wp_unslash( $_GET['status'] ?? 'all' ) );
		if ( 'paid' === $status ) {
			return [ 'paid' ];
		}
		if ( 'payment_failed' === $status ) {
			return [ 'payment_failed' ];
		}
		if ( 'processing' === $status ) {
			return [ 'processing' ];
		}
		if ( 'canceled' === $status ) {
			return [ 'void' ];
		}
		if ( 'draft' === $status ) {
			return [ 'draft' ];
		}
		if ( 'all' === $status ) {
			return [];
		}
		return $status ? [ esc_html( $status ) ] : [];
	}

	/**
	 * Handle the total column
	 *
	 * @param \SureCart\Models\Order $order The order model.
	 *
	 * @return string
	 */
	public function column_total( $order ) {
		return '<sc-format-number type="currency" currency="' . strtoupper( esc_html( $order->checkout->currency ) ) . '" value="' . (float) $order->checkout->amount_due . '"></sc-format-number>';
	}

	/**
	 * Show the payment method for the order.
	 *
	 * @param \SureCart\Models\Order $order The order model.
	 *
	 * @return string
	 */
	public function column_method( $order ) {
		if ( isset( $order->checkout->manual_payment_method->name ) ) {
			return '<sc-tag>' . $order->checkout->manual_payment_method->name . '</sc-tag>';
		}
		ob_start();
		?>
			<sc-payment-method id="sc-method-<?php echo esc_attr( $order->id ); ?>"></sc-payment-method>
			<script>
				document.getElementById('sc-method-<?php echo esc_attr( $order->id ); ?>').paymentMethod = <?php echo wp_json_encode( $order->checkout->payment_method ); ?>;
			</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * The type of order.
	 *
	 * @param \SureCart\Models\Order $order The order model.
	 *
	 * @return string
	 */
	public function column_type( $order ) {
		if ( ! empty( $order->order_type ) && 'subscription' === $order->order_type ) {
			return '<sc-tag type="success">' . esc_html__( 'Subscription', 'surecart' ) . '</sc-tag>';
		}

		return '<sc-tag type="info">' . esc_html__( 'Checkout', 'surecart' ) . '</sc-tag>';
	}

	/**
	 * Handle the status
	 *
	 * @param \SureCart\Models\Order $order Order Model.
	 *
	 * @return string
	 */
	public function column_status( $order ) {
		if ( ! empty( $order->checkout->charge->fully_refunded ) ) {
			return '<sc-tag type="danger">' . __( 'Refunded', 'surecart' ) . '</sc-tag>';
		}

		if ( ! empty( $order->checkout->payment_method->processor_type ) && 'paypal' === $order->checkout->payment_method->processor_type ) {
			if ( 'requires_approval' === $order->status ) {
				return '<sc-tooltip text="' . __( 'Paypal is taking a closer look at this payment. It’s required for some payments and normally takes up to 3 business days.', 'surecart' ) . '" type="warning"><sc-order-status-badge status="' . esc_attr( $order->status ) . '"></sc-order-status-badge></sc-tooltip>';
			}
		}

		return '<sc-order-status-badge status="' . esc_attr( $order->status ) . '"></sc-order-status-badge>';
	}

	/**
	 * Handle the status
	 *
	 * @param \SureCart\Models\Order $order Order Model.
	 *
	 * @return string
	 */
	public function column_fulfillment_status( $order ) {
		ob_start();
		?>
			<sc-order-fulfillment-badge status="<?php echo esc_attr( $order->fulfillment_status ); ?>"></sc-order-fulfillment-badge>
		<?php
		return ob_get_clean();
	}

	/**
	 * Handle the status
	 *
	 * @param \SureCart\Models\Order $order Order Model.
	 *
	 * @return string
	 */
	public function column_shipment_status( $order ) {
		$shipping_method_name = ! empty( $order->checkout->selected_shipping_choice->shipping_method->name ) ? $order->checkout->selected_shipping_choice->shipping_method->name : false;

		ob_start();
		?>
		<?php if ( 'unshippable' === $order->shipment_status ) : ?>
			-
		<?php else : ?>
			<sc-order-shipment-badge status="<?php echo esc_attr( $order->shipment_status ); ?>"></sc-order-shipment-badge>
			<?php if ( $shipping_method_name ) : ?>
				<div><small>(<?php echo esc_attr( $shipping_method_name ); ?>)</small></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
		return ob_get_clean();
	}

	/**
	 * Name of the coupon
	 *
	 * @param \SureCart\Models\Promotion $promotion Promotion model.
	 *
	 * @return string
	 */
	public function column_order( $order ) {
		ob_start();
		?>
		<a class="row-title" aria-label="<?php esc_attr_e( 'Edit Order', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'order', $order->id ) ); ?>">
			#<?php echo sanitize_text_field( $order->number ?? $order->id ); ?>
		</a>
		<br />
		<a aria-label="<?php echo esc_attr__( 'Edit Order', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'order', $order->id ) ); ?>" style="word-break: break-word">
			<?php
			// translators: Customer name.
			printf( esc_html__( 'By %s', 'surecart' ), esc_html( $order->checkout->name ?? $order->checkout->email ?? $order->checkout->customer->name ?? $order->checkout->customer->email ) );
			?>
		</a>
		<?php

		return ob_get_clean();
	}

	/**
	 * Displays a formats drop-down for filtering items.
	 *
	 * @since 5.2.0
	 * @access protected
	 *
	 * @param string $post_type Post type slug.
	 */
	protected function fulfillment_dropdown() {
		/**
		 * Filters whether to remove the 'Formats' drop-down from the post list table.
		 *
		 * @param bool   $disable   Whether to disable the drop-down. Default false.
		 */
		if ( apply_filters( 'surecart/disable_fulfillment_dropdown', false ) ) {
			return;
		}

		$displayed_order_fulfillment = isset( $_GET['fulfillment_status'] ) ? $_GET['fulfillment_status'] : '';
		?>

		<label for="filter-by-fulfillment" class="screen-reader-text">
			<?php
			/* translators: Hidden accessibility text. */
			esc_html_e( 'Filter by fulfillment', 'surecart' );
			?>
		</label>
		<select name="fulfillment_status" id="filter-by-fulfillment">
			<option<?php selected( $displayed_order_fulfillment, '' ); ?> value=""><?php esc_html_e( 'All Fulfillments', 'surecart' ); ?></option>
			<option<?php selected( $displayed_order_fulfillment, 'unfulfilled' ); ?> value="unfulfilled"><?php echo esc_html_e( 'Unfulfilled', 'surecart' ); ?></option>
			<option<?php selected( $displayed_order_fulfillment, 'fulfilled' ); ?> value="fulfilled"><?php echo esc_html_e( 'Fulfilled', 'surecart' ); ?></option>
			<option<?php selected( $displayed_order_fulfillment, '"partially_fulfilled' ); ?> value="fulfilled"><?php echo esc_html_e( 'Partially Fulfilled', 'surecart' ); ?></option>
		</select>
		<?php
	}

	/**
	 * Displays a formats drop-down for filtering items.
	 *
	 * @since 5.2.0
	 * @access protected
	 *
	 * @param string $post_type Post type slug.
	 */
	protected function shipment_dropdown() {
		/**
		 * Filters whether to remove the 'Formats' drop-down from the post list table.
		 *
		 * @param bool   $disable   Whether to disable the drop-down. Default false.
		 */
		if ( apply_filters( 'surecart/disable_shipment_dropdown', false ) ) {
			return;
		}

		$displayed_order_shipment = isset( $_GET['shipment_status'] ) ? $_GET['shipment_status'] : '';
		?>

		<label for="filter-by-shipment" class="screen-reader-text">
			<?php
			/* translators: Hidden accessibility text. */
			esc_html_e( 'Filter by shipment', 'surecart' );
			?>
		</label>
		<select name="shipment_status" id="filter-by-shipment">
			<option<?php selected( $displayed_order_shipment, '' ); ?> value=""><?php esc_html_e( 'All Shipment Statuses', 'surecart' ); ?></option>
			<option<?php selected( $displayed_order_shipment, 'unshipped' ); ?> value="unshipped"><?php echo esc_html_e( 'Not Shipped', 'surecart' ); ?></option>
			<option<?php selected( $displayed_order_shipment, 'shipped' ); ?> value="shipped"><?php echo esc_html_e( 'Shipped', 'surecart' ); ?></option>
			<option<?php selected( $displayed_order_shipment, 'partially_shipped' ); ?> value="partially_shipped"><?php echo esc_html_e( 'Partially Shipped', 'surecart' ); ?></option>
			<option<?php selected( $displayed_order_shipment, 'delivered' ); ?> value="delivered"><?php echo esc_html_e( 'Delivered', 'surecart' ); ?></option>
		</select>
		<?php
	}

	/**
	 * Displays extra table navigation.
	 *
	 * @param string $which Top or bottom placement.
	 */
	protected function extra_tablenav( $which ) {
		?>
		<input type="hidden" name="page" value="sc-orders" />

		<?php if ( ! empty( $_GET['status'] ) ) : ?>
			<input type="hidden" name="status" value="<?php echo esc_attr( $_GET['status'] ); ?>" />
		<?php endif; ?>

		<div class="alignleft actions">
		<?php
		if ( 'top' === $which ) {
			ob_start();
			$this->fulfillment_dropdown();
			$this->shipment_dropdown();
			$this->mode_dropdown();

			/**
			 * Fires before the Filter button on the Posts and Pages list tables.
			 *
			 * The Filter button allows sorting by date and/or category on the
			 * Posts list table, and sorting by date on the Pages list table.
			 *
			 * @since 2.1.0
			 * @since 4.4.0 The `$post_type` parameter was added.
			 * @since 4.6.0 The `$which` parameter was added.
			 *
			 * @param string $post_type The post type slug.
			 * @param string $which     The location of the extra table nav markup:
			 *                          'top' or 'bottom' for WP_Posts_List_Table,
			 *                          'bar' for WP_Media_List_Table.
			 */
			do_action( 'restrict_manage_orders', $this->screen->post_type, $which );

			$output = ob_get_clean();

			if ( ! empty( $output ) ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				submit_button( __( 'Filter', 'surecart' ), '', 'filter_action', false, array( 'id' => 'filter-by-fulfillment-submit' ) );
			}
		}

		?>
		</div>

		<?php
		/**
		 * Fires immediately following the closing "actions" div in the tablenav for the posts
		 * list table.
		 *
		 * @since 4.4.0
		 *
		 * @param string $which The location of the extra table nav markup: 'top' or 'bottom'.
		 */
		do_action( 'manage_orders_extra_tablenav', $which );
	}
}
