<?php

namespace SureCart\Controllers\Admin\AffiliationRequests;

use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Models\AffiliationRequest;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class AffiliationRequestsListTable extends ListTable {
	public $checkbox = true;
	public $error    = '';
	public $pages    = array();

	/**
	 * Prepare the items for the table to process
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
			$this->error = $query->get_error_message();
			$this->items = array();
			return;
		}

		$this->set_pagination_args(
			array(
				'total_items' => $query->pagination->count,
				'per_page'    => $this->get_items_per_page( 'affiliate-requests' ),
			)
		);

		$this->items = $query->data;
	}

	/**
	 * Get views for the list table status links.
	 *
	 * @global int $post_id
	 * @global string $comment_status
	 * @global string $comment_type
	 */
	protected function get_views() {
		foreach ( $this->getStatuses() as $status => $label ) {
			$link = admin_url( 'admin.php?page=sc-affiliate-requests' );
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

		/**
		 * Filters the comment status links.
		 *
		 * @since 2.5.0
		 * @since 5.1.0 The 'Mine' link was added.
		 *
		 * @param string[] $status_links An associative array of fully-formed comment status links. Includes 'All', 'Mine',
		 *                              'Pending', 'Approved', 'Spam', and 'Trash'.
		 */
		return apply_filters( 'comment_status_links', $status_links );
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'name'         => __( 'Name', 'surecart' ),
			'email'        => __( 'Email', 'surecart' ),
			'payout_email' => __( 'Payout Email', 'surecart' ),
			'status'       => __( 'Status', 'surecart' ),
			'date'         => __( 'Date', 'surecart' ),
		);
	}

	/**
	 * Define which columns are hidden
	 *
	 * @return array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Get the table data
	 *
	 * @return array
	 */
	private function table_data() {
		$affiliate_request_query = AffiliationRequest::where(
			array(
				'status[]' => $this->getFilteredStatus(),
				'query'    => $this->get_search_query(),
				'used'     => false,
			)
		);

		return $affiliate_request_query->paginate(
			array(
				'per_page' => $this->get_items_per_page( 'affiliate_requests' ),
				'page'     => $this->get_pagenum(),
			)
		);
	}

	/**
	 * Nothing found.
	 *
	 * @return void
	 */
	public function no_items() {
		if ( $this->error ) {
			echo esc_html( $this->error );
			return;
		}
		echo esc_html_e( 'No affiliate requests found.', 'surecart' );
	}

	/**
	 * Published column
	 *
	 * @param \SureCart\Models\AffiliationRequest $affiliate_request AffiliationRequest model.
	 *
	 * @return string
	 */
	public function column_status( $affiliate_request ) {
		ob_start();
		?>
		<sc-tag type="<?php echo esc_attr( $affiliate_request->status_type ); ?>">
			<?php echo esc_html( $affiliate_request->status_display_text ); ?>
		</sc-tag>
		<?php
		return ob_get_clean();
	}

	/**
	 * Define what data to show on each column of the table
	 *
	 * @param \SureCart\Models\AffiliationRequest $affiliate_request AffiliationRequest model.
	 * @param string                              $column_name - Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $affiliate_request, $column_name ) {
		if ( 'name' === $column_name ) {
			return '<a href="' . \SureCart::getUrl()->edit( 'affiliate-request', $affiliate_request->id ) . '">'
				. $affiliate_request->first_name . ' ' . $affiliate_request->last_name
				. '</a>';
		}

		return $affiliate_request->$column_name ?? '';
	}

	/**
	 * Displays extra table navigation.
	 *
	 * @param string $which Top or bottom placement.
	 */
	protected function extra_tablenav( $which ) {
		?>
		<input type="hidden" name="page" value="sc-affiliate-requests" />

		<?php if ( ! empty( $_GET['status'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<input type="hidden" name="status" value="<?php echo esc_attr( $_GET['status'] ); ?>" />
		<?php endif; ?>

		<?php
		/**
		 * Fires immediately following the closing "actions" div in the tablenav
		 * for the affiliate_requests list table.
		 *
		 * @param string $which The location of the extra table nav markup: 'top' or 'bottom'.
		 */
		do_action( 'manage_affiliate_requests_extra_tablenav', $which );
	}


	/**
	 * Get filtered status / default status.
	 *
	 * @return string|null
	 */
	private function getFilteredStatus() {
		return ! empty( $_GET['status'] ) && 'all' !== $_GET['status']
			? sanitize_text_field( wp_unslash( $_GET['status'] ) )
			: null;
	}

	/**
	 * Get all statuses.
	 *
	 * @return array
	 */
	private function getStatuses(): array {
		return array(
			'all'      => __( 'All', 'surecart' ),
			'approved' => __( 'Approved', 'surecart' ),
			'denied'   => __( 'Denied', 'surecart' ),
			'pending'  => __( 'Pending', 'surecart' ),
		);
	}
}
