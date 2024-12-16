<?php

namespace SureCart\Controllers\Admin\Abandoned;

use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Models\AbandonedCheckout;
use SureCart\Controllers\Admin\Tables\HasModeFilter;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class AbandonedCheckoutListTable extends ListTable {
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
				'per_page'    => $this->get_items_per_page( 'abandoned_checkout' ),
			]
		);

		$this->items = $query->data;
	}

	protected function get_views() {
		$stati = [
			'all'           => __( 'All', 'surecart' ),
			'scheduled'     => __( 'Scheduled', 'surecart' ),
			'sent'          => __( 'Sent', 'surecart' ),
			'not_scheduled' => __( 'Not Scheduled', 'surecart' ),
		];

		foreach ( $stati as $status => $label ) {
			$link = \SureCart::getUrl()->index( 'abandoned-checkout' );

			$current_link_attributes = '';

			if ( ! empty( $_GET['status'] ) ) {
				if ( sanitize_text_field( wp_unslash( $_GET['status'] ) ) === $status ) {
					$current_link_attributes = ' class="current" aria-current="page"';
				}
			} elseif ( 'all' === $status ) {
				$current_link_attributes = ' class="current" aria-current="page"';
			}

			$link = add_query_arg( 'status', $status, $link );

			$link = esc_url( $link );

			$status_links[ $status ] = "<a href='$link'$current_link_attributes>" . $label . '</a>';
		}

		/**
		 * Filters the comment status links.
		 *
		 * @since 2.5.0
		 * @since 5.1.0 The 'Mine' link was added.
		 *
		 * @param string[] $status_links An associative array of fully-formed comment status links. Includes 'All', 'Mine',
		 *                              'Pending', 'Approved', 'Spam', and 'Trash'.
		 */
		return apply_filters( 'abandoned_order_status_links', $status_links );
	}

	public function search() {
		?>
		<form class="search-form"
			method="get">
			<?php $this->search_box( __( 'Search Abanonded Orders', 'surecart' ), 'abandoned_order' ); ?>
			<input type="hidden"
				name="id"
				value="1" />
		</form>
		<?php
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return Array
	 */
	public function get_columns() {
		return [
			'placed_by'           => __( 'Placed By', 'surecart' ),
			'date'                => __( 'Date', 'surecart' ),
			'notification_status' => __( 'Email Status', 'surecart' ),
			'recovery_status'     => __( 'Recovery Status', 'surecart' ),
			'total'               => __( 'Total', 'surecart' ),
			'mode'                => '',
		];
	}

	/**
	 * Get the table data
	 *
	 * @return Array
	 */
	protected function table_data() {
		$mode = sanitize_text_field( wp_unslash( $_GET['mode'] ?? '' ) );
		$status = $this->getStatus();
		$where  = array();

		if ( ! empty( $mode ) ) {
			$where['live_mode'] = 'live' === $mode;
		}

		if ( $status ) {
			$where['notification_status'] = [ $status ];
		}

		return AbandonedCheckout::where( $where )
		->with( [ 'recovered_checkout', 'checkout', 'customer' ] )
		->paginate(
			[
				'per_page' => $this->get_items_per_page( 'abandoned-checkouts' ),
				'page'     => $this->get_pagenum(),
				'expand'   => [ 'checkout' ],
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
		if ( 'all' === $status ) {
			return null;
		}
		return $status ? [ esc_html( $status ) ] : [];
	}

	/**
	 * Handle the total column
	 *
	 * @param \SureCart\Models\AbandonedCheckout $checkout Checkout Session Model.
	 *
	 * @return string
	 */
	public function column_total( $abandoned ) {
		return '<sc-format-number type="currency" currency="' . strtoupper( esc_html( $abandoned->checkout->currency ?? 'usd' ) ) . '" value="' . (float) $abandoned->checkout->total_amount . '"></sc-format-number>';
	}

	/**
	 * Handle the total column
	 *
	 * @param \SureCart\Models\AbandonedCheckout $abandoned Abandoned checkout model.
	 *
	 * @return string
	 */
	public function column_date( $abandoned ) {
		return isset( $abandoned->created_at ) ? '<sc-format-date date="' . (int) $abandoned->created_at . '" type="timestamp" month="short" day="numeric" year="numeric" hour="numeric" minute="numeric"></sc-format-date>' : '--';
	}

	/**
	 * Handle the notification status
	 *
	 * @param \SureCart\Models\AbandonedCheckout $abandoned Abandoned checkout session.
	 *
	 * @return string
	 */
	public function column_notification_status( $abandoned ) {
		if ( $abandoned->recovered_checkout ) {
			return '--';
		}

		switch ( $abandoned->notification_status ?? '' ) {
			case 'scheduled':
				return '<sc-tag type="info">' . __( 'Scheduled', 'surecart' ) . '</sc-tag>';
			case 'not_scheduled':
				return '<sc-tag type="warning">' . __( 'Not Scheduled', 'surecart' ) . '</sc-tag>';
			case 'sent':
				return '<sc-tag type="success">' . __( 'Email Sent', 'surecart' ) . '</sc-tag>';
		}
		 return '<sc-tag>' . esc_html( $abandoned->notification_status ?? 'Unknown' ) . '</sc-tag>';
	}

	/**
	 * Handle the recovery status
	 *
	 * @param \SureCart\Models\AbandonedCheckout $abandoned Abandoned checkout session.
	 *
	 * @return string
	 */
	public function column_recovery_status( $abandoned ) {
		switch ( $abandoned->recovery_status ) {
			case 'abandoned':
				return '<sc-tag type="warning">' . __( 'Abandoned', 'surecart' ) . '</sc-tag>';
			case 'assisted_recovered':
				return '<sc-tag type="success">' . __( 'Recovered', 'surecart' ) . '</sc-tag>';
			case 'unassisted_recovered':
				return '<sc-tag type="info">' . __( 'Recovered Before Email Was Sent', 'surecart' ) . '</sc-tag>';
		}
		return '<sc-tag type="success">' . $abandoned->recovery_status . '</sc-tag>';
	}

	/**
	 * Handle the mode column
	 *
	 * @param \SureCart\Models\AbandonedCheckout $abandoned Abandoned checkout model.
	 *
	 * @return string
	 */
	public function column_mode( $abandoned ) {
		return empty( $abandoned->checkout->live_mode ) ? '<sc-tag type="warning">' . __( 'Test', 'surecart' ) . '</sc-tag>' : '';
	}

	/**
	 * Email of customer
	 *
	 * @param \SureCart\Models\AbandonedCheckout $abandoned Abandoned checkout model.
	 *
	 * @return string
	 */
	public function column_placed_by( $abandoned ) {
		ob_start();
		?>
		<a  class="row-title" aria-label="<?php esc_attr_e( 'Edit Order', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'abandoned-checkout', $abandoned->id ) ); ?>">
			<?php
			// translators: Customer name.
			echo sprintf( esc_html__( 'By %s', 'surecart' ), esc_html( $abandoned->customer->name ?? $abandoned->customer->email ) );
			?>
		</a>
		<br />
		<a aria-label="<?php esc_attr_e( 'View Checkout', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'abandoned-checkout', $abandoned->id ) ); ?>">
			<?php esc_attr_e( 'View Checkout', 'surecart' ); ?>
		</a>
		<?php

		return ob_get_clean();
	}

	/**
	 * Displays extra table navigation.
	 *
	 * @param string $which Top or bottom placement.
	 */
	protected function extra_tablenav( $which ) {
		?>
		<input type="hidden" name="page" value="sc-abandoned-checkouts" />

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
			do_action( 'restrict_manage_abandoned_checkouts', $this->screen->post_type, $which );

			$output = ob_get_clean();

			if ( ! empty( $output ) ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				submit_button( __( 'Filter' ), '', 'filter_action', false, array( 'id' => 'filter-by-mode-submit' ) );
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
		do_action( 'manage_abandoned_checkouts_extra_tablenav', $which );
	}
}
