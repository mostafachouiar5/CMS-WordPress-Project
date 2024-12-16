<?php

namespace SureCart\Controllers\Admin\Invoices;

use SureCart\Controllers\Admin\Tables\HasModeFilter;
use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Models\Invoice;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class InvoicesListTable extends ListTable {
	use HasModeFilter;

	/**
	 * Prepare the items for the table to process.
	 *
	 * @return void
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
				'per_page'    => $this->get_items_per_page( 'invoices' ),
			]
		);

		$this->items = $query->data;
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table.
	 *
	 * @return array
	 */
	public function get_columns() {
		return [
			'invoice'    => __( 'Invoice', 'surecart' ),
			'issue_date' => __( 'Issued', 'surecart' ),
			'due_date'   => __( 'Due', 'surecart' ),
			'status'     => __( 'Status', 'surecart' ),
			'customer'   => __( 'Customer', 'surecart' ),
			'method'     => __( 'Method', 'surecart' ),
			'total'      => __( 'Total', 'surecart' ),
			'date'       => __( 'Created', 'surecart' ),
			'mode'       => '',
		];
	}

	/**
	 * Show the payment method for the invoice.
	 *
	 * @param Invoice $invoice Invoice model.
	 *
	 * @return string
	 */
	public function column_method( $invoice ) {
		if ( isset( $invoice->checkout->manual_payment_method->name ) ) {
			return '<sc-tag>' . $invoice->checkout->manual_payment_method->name . '</sc-tag>';
		}
		ob_start();
		?>
			<sc-payment-method id="sc-method-<?php echo esc_attr( $invoice->id ); ?>"></sc-payment-method>
			<script>
				document.getElementById('sc-method-<?php echo esc_attr( $invoice->id ); ?>').paymentMethod = <?php echo wp_json_encode( $invoice->checkout->payment_method ); ?>;
			</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * Define which columns are hidden.
	 *
	 * @return array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Get the table data.
	 *
	 * @return object
	 */
	protected function table_data() {
		$status = $this->getStatus();
		$mode   = sanitize_text_field( wp_unslash( $_GET['mode'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$where  = array(
			'query' => $this->get_search_query(),
		);

		if ( ! empty( $mode ) ) {
			$where['live_mode'] = 'live' === $mode;
		}

		if ( $status ) {
			$where['status'] = [ $status ];
		}

		// Check if there is any sc_collection in the query, then filter it.
		if ( ! empty( $_GET['sc_customer'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$where['customer_ids'] = array( sanitize_text_field( wp_unslash( $_GET['sc_customer'] ) ) );  // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		return Invoice::where( $where )
		->with( [ 'charge', 'checkout', 'checkout.order', 'checkout.charge', 'checkout.payment_method', 'checkout.manual_payment_method', 'checkout.customer', 'payment_method.card', 'payment_method.payment_instrument', 'payment_method.paypal_account', 'payment_method.bank_account' ] )
		->paginate(
			[
				'per_page' => $this->get_items_per_page( 'invoices' ),
				'page'     => $this->get_pagenum(),
			]
		);
	}

	/**
	 * Generates views links.
	 *
	 * @return array
	 */
	protected function get_views() {
		$statuses = [
			'all'   => __( 'All', 'surecart' ),
			'paid'  => __( 'Paid', 'surecart' ),
			'draft' => __( 'Draft', 'surecart' ),
			'open'  => __( 'Open', 'surecart' ),
		];

		$link         = \SureCart::getUrl()->index( 'invoices' );
		$status_links = [];

		foreach ( $statuses as $status => $label ) {
			$current_link_attributes = '';

			if ( ! empty( $_GET['status'] ) ) {
				if ( $status === $_GET['status'] ) {
					$current_link_attributes = ' class="current" aria-current="page"';
				}
			} elseif ( 'all' === $status ) {
				$current_link_attributes = ' class="current" aria-current="page"';
			}

			$link = add_query_arg( 'status', $status, $link );

			if ( isset( $_GET['live_mode'] ) ) {
				$link = add_query_arg( 'live_mode', sanitize_text_field( wp_unslash( $_GET['live_mode'] ) ), $link );
			}

			$status_links[ $status ] = "<a href='$link'$current_link_attributes>" . $label . '</a>';
		}

		// filter links.
		return apply_filters( 'sc_invoice_status_links', $status_links );
	}

	/**
	 * Get the query status.
	 *
	 * @return array
	 */
	public function getStatus() {
		$status = sanitize_text_field( wp_unslash( $_GET['status'] ?? 'all' ) );
		if ( 'all' === $status ) {
			return [];
		}
		return $status ? [ esc_html( $status ) ] : [];
	}

	/**
	 * Handle the total column.
	 *
	 * @param Invoice $invoice Invoice Model.
	 *
	 * @return string
	 */
	public function column_total( $invoice ) {
		return '<sc-format-number type="currency" currency="' . strtoupper( esc_html( $invoice->checkout->currency ?? 'u' ) ) . '" value="' . (float) $invoice->checkout->total_amount . '"></sc-format-number>';
	}

	/**
	 * Handle the total column.
	 *
	 * @param Invoice $invoice Invoice model.
	 *
	 * @return string
	 */
	public function column_date( $invoice ) {
		return '<sc-format-date date="' . (int) $invoice->created_at . '" type="timestamp" month="short" day="numeric" year="numeric" hour="numeric" minute="numeric"></sc-format-date>';
	}

	/**
	 * Handle invoice due date.
	 *
	 * @param Invoice $invoice Invoice model.
	 *
	 * @return string
	 */
	public function column_due_date( $invoice ) {
		return $invoice->due_date ? '<sc-format-date date="' . (int) $invoice->due_date . '" type="timestamp" month="short" day="numeric" year="numeric"></sc-format-date>' : '-';
	}

	/**
	 * Handle invoice issue date.
	 *
	 * @param Invoice $invoice Invoice model.
	 *
	 * @return string
	 */
	public function column_issue_date( $invoice ) {
		return $invoice->issue_date ? '<sc-format-date date="' . (int) $invoice->issue_date . '" type="timestamp" month="short" day="numeric" year="numeric"></sc-format-date>' : '-';
	}

	/**
	 * Show customer as tag.
	 *
	 * @param Invoice $invoice The invoice model.
	 */
	public function column_customer( $invoice ) {
		$customer = $invoice->checkout->customer ?? null;

		if ( empty( $customer ) ) {
			return '-';
		}

		$url = \SureCart::getUrl()->edit( 'customer', $customer->id );
		return '<a href="' . esc_url( $url ) . '">' . ( ! empty( $customer->name ) ? $customer->name : $customer->email ) . '</a>';
	}

	/**
	 * Handle the status.
	 *
	 * @param Invoice $invoice Invoice Model.
	 *
	 * @return string
	 */
	public function column_status( $invoice ) {
		if ( ! empty( $invoice->checkout->charge->fully_refunded ) ) {
			return '<sc-tag type="danger">' . __( 'Refunded', 'surecart' ) . '</sc-tag>';
		}
		return '<sc-invoice-status-badge status="' . esc_attr( $invoice->status ) . '"></sc-invoice-status-badge>';
	}

	/**
	 * Handle Invoice column.
	 *
	 * @param Invoice $invoice Invoice model.
	 *
	 * @return string
	 */
	public function column_invoice( $invoice ) {
		ob_start();
		?>
		<a class="row-title" aria-label="<?php echo esc_attr__( 'Edit Invoice', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'invoice', $invoice->id ) ); ?>">
			<?php echo ! empty( $invoice->checkout->order->number ) ? '#' . esc_html( $invoice->checkout->order->number ) : esc_html_e( '(draft)', 'surecart' ); ?>
		</a>

		<?php
		echo wp_kses_post(
			$this->row_actions(
				array_filter(
					[
						'edit' => '<a href="' . esc_url( \SureCart::getUrl()->edit( 'invoice', $invoice->id ) ) . '" aria-label="' . esc_attr__( 'Edit Invoice', 'surecart' ) . '">' . __( 'Edit', 'surecart' ) . '</a>',
						'view' => 'open' === $invoice->status && ! empty( $invoice->checkout_url ) ? '<a href="' . esc_url( $invoice->checkout_url ) . '" aria-label="' . esc_attr__( 'View Payment Page', 'surecart' ) . '">' . __( 'View Payment Page', 'surecart' ) . '</a>' : null,
					]
				),
			)
		);

		return ob_get_clean();
	}

	/**
	 * Handle the mode column.
	 *
	 * @param Invoice $invoice Invoice model.
	 *
	 * @return string
	 */
	public function column_mode( $invoice ) {
		return empty( $invoice->checkout->live_mode ) ? '<sc-tag type="warning">' . __( 'Test', 'surecart' ) . '</sc-tag>' : '';
	}

	/**
	 * Displays extra table navigation.
	 *
	 * @param string $which Top or bottom placement.
	 */
	protected function extra_tablenav( $which ) {
		?>
		<input type="hidden" name="page" value="sc-invoices" />

		<?php if ( ! empty( $_GET['status'] ) ) : ?>
			<input type="hidden" name="status" value="<?php echo esc_attr( $_GET['status'] ); ?>" />
		<?php endif; ?>

		<?php if ( ! empty( $_GET['live_mode'] ) ) : ?>
			<input type="hidden" name="live_mode" value="<?php echo esc_attr( $_GET['live_mode'] ); ?>" />
		<?php endif; ?>

		<div class="alignleft actions">
		<?php
		if ( 'top' === $which ) {
			ob_start();
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
			do_action( 'restrict_manage_invoices', $this->screen->post_type, $which );

			$output = ob_get_clean();

			if ( ! empty( $output ) ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				submit_button( __( 'Filter' ), '', 'filter_action', false, array( 'id' => 'filter-by-fulfillment-submit' ) );
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
		do_action( 'manage_invoices_extra_tablenav', $which );
	}
}
