<?php

namespace SureCart\Controllers\Admin\AffiliationPayouts;

use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Models\Payout;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class AffiliationPayoutsListTable extends ListTable {

	/**
	 * Checkbox column.
	 *
	 * @var boolean
	 */
	public $checkbox = true;

	/**
	 * Error message.
	 *
	 * @var string
	 */
	public $error = '';

	/**
	 * Pages.
	 *
	 * @var array
	 */
	public $pages = array();

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
				'per_page'    => $this->get_items_per_page( 'affiliate_payouts' ),
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
			$current_link_attributes = '';
			$link = admin_url( 'admin.php?page=sc-affiliate-payouts' );

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
		*  @param string[] $status_links An associative array of fully-formed comment status links. Includes 'All', 'Mine','Pending', 'Approved', 'Spam', and 'Trash'.
		* */
		return apply_filters( 'payout_status_links', $status_links );
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'date'         => __( 'Date', 'surecart' ),
			'status'       => __( 'Status', 'surecart' ),
			'affiliate'    => __( 'Affiliate', 'surecart' ),
			'payout_email' => __( 'Payout Email', 'surecart' ),
			'period_end'   => __( 'Period End', 'surecart' ),
			'referrals'    => __( 'Referrals', 'surecart' ),
			'amount'       => __( 'Amount', 'surecart' ),
		);
	}

	/**
	 * Handle the date column.
	 *
	 * @param \SureCart\Models\Payout $payout The Payout model.
	 *
	 * @return string
	 */
	public function column_date( $payout ) {
		$date = date_i18n( get_option( 'date_format' ), $payout->created_at );

		$actions = wp_kses_post(
			$this->row_actions(
				array_filter(
					array(
						'complete'        => '<a href="' . esc_url( $this->get_action_url( $payout->id, 'complete' ) ) . '">' . esc_html__( 'Complete', 'surecart' ) . '</a>',
						'make_processing' => '<a href="' . esc_url( $this->get_action_url( $payout->id, 'make_processing' ) ) . '">' . esc_html__( 'Make Processing', 'surecart' ) . '</a>',
						'delete'          => '<a href="' . esc_url( $this->get_action_url( $payout->id, 'delete' ) ) . '">' . esc_html__( 'Delete', 'surecart' ) . '</a>',
					),
					function( $action, $key ) use ( $payout ) {
						if ( 'complete' === $key && 'completed' === $payout->status ) {
							return false;
						}

						if ( 'make_processing' === $key && 'processing' === $payout->status ) {
							return false;
						}

						return true;
					},
					ARRAY_FILTER_USE_BOTH
				)
			)
		);

		return $date . $actions;
	}

	/**
	 * Handle the status column.
	 *
	 * @param \SureCart\Models\Payout $payout The Payout model.
	 *
	 * @return string
	 */
	public function column_status( $payout ) {
		$type = 'completed' === $payout->status ? 'success' : 'warning';

		return '<sc-tag type="' . $type . '">' . $payout->status_display_text . ' </sc-tag>';
	}

	/**
	 * Handle the affiliate column.
	 *
	 * @param \SureCart\Models\Payout $payout The Payout model.
	 *
	 * @return string
	 */
	public function column_affiliate( $payout ) {
		$affiliation = $payout->affiliation ?? null;
		if ( empty( $affiliation->id ) ) {
			return '';
		}

		ob_start();
		?>
		<div class="sc-affiliate-name">
			<a href="<?php echo esc_url( \SureCart::getUrl()->edit( 'affiliates', $affiliation->id ) ); ?>">
				<?php echo esc_html( $affiliation->display_name ); ?>
			</a>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Handle the payout email column.
	 *
	 * @param \SureCart\Models\Payout $payout The Payout model.
	 *
	 * @return string
	 */
	public function column_payout_email( $payout ) {
		return esc_html( $payout->affiliation->payout_email );
	}

	/**
	 * Handle the period end column.
	 *
	 * @param \SureCart\Models\Payout $payout The Payout model.
	 *
	 * @return string
	 */
	public function column_period_end( $payout ) {
		return "<sc-format-date date='$payout->end_date' type='timestamp' month='short' day='numeric' year='numeric' ></sc-format-date>";
	}

	/**
	 * Handle the referrals column.
	 *
	 * @param \SureCart\Models\Payout $payout The Payout model.
	 *
	 * @return string
	 */
	public function column_referrals( $payout ) {
		return (int) $payout->referrals->pagination->count;
	}

	/**
	 * Handle the amount column.
	 *
	 * @param \SureCart\Models\Payout $payout The Payout model.
	 *
	 * @return string
	 */
	public function column_amount( $payout ) {
		return '<sc-format-number type="currency" currency="' . $payout->currency . '" value="' . $payout->total_commission_amount . '"></sc-format-number>';
	}

	/**
	 * Get the table data
	 *
	 * @return \SureCart\Models\Collection
	 */
	private function table_data() {
		return Payout::where(
			array(
				'query'  => $this->get_search_query(),
				'status' => [ $this->getFilteredStatus() ],
				'expand' => [
					'affiliation',
					'referrals',
				],
			)
		)->paginate(
			array(
				'per_page' => $this->get_items_per_page( 'affiliate_payouts' ),
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
		echo esc_html_e( 'No affiliate payouts found.', 'surecart' );
	}

	/**
	 * Displays extra table navigation.
	 *
	 * @param string $which Top or bottom placement.
	 */
	protected function extra_tablenav( $which ) {
		?>
		<input type="hidden" name="page" value="sc-affiliate-payouts" />

		<?php if ( ! empty( $_GET['status'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<input type="hidden" name="status" value="<?php echo esc_attr( $_GET['status'] ); ?>" />
		<?php endif; ?>

		<?php
		/**
		 * Fires immediately following the closing "actions" div in the tablenav
		 * for the affiliate_payouts list table.
		 *
		 * @param string $which The location of the extra table nav markup: 'top' or 'bottom'.
		 */
		do_action( 'manage_affiliate_payouts_extra_tablenav', $which );
	}

	/**
	 * Get filtered status / default status.
	 *
	 * @return string|null
	 */
	private function getFilteredStatus() {
		if ( empty( $_GET['status'] ) || 'all' === $_GET['status'] ) {
			return null;
		}

		return sanitize_text_field( wp_unslash( $_GET['status'] ) );
	}

	/**
	 * Get all statuses.
	 *
	 * @return array
	 */
	private function getStatuses(): array {
		return array(
			'all'        => __( 'All', 'surecart' ),
			'processing' => __( 'Processing', 'surecart' ),
			'completed'  => __( 'Completed', 'surecart' ),
		);
	}

	/**
	 * Get action url.
	 *
	 * @param int    $id     The id.
	 * @param string $action The action.
	 *
	 * @return string
	 */
	public function get_action_url( $id, $action ) {
		return esc_url(
			add_query_arg(
				[
					'action' => $action,
					'nonce'  => wp_create_nonce( $action . '_affiliation_payout' ),
					'id'     => $id,
				],
				esc_url_raw( admin_url( 'admin.php?page=sc-affiliate-payouts' ) )
			)
		);
	}
}
