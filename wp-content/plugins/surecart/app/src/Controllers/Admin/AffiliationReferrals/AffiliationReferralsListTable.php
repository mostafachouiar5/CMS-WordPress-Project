<?php

namespace SureCart\Controllers\Admin\AffiliationReferrals;

use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Models\Referral;
use SureCart\Support\Currency;
use SureCart\Controllers\Admin\Tables\HasModeFilter;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class AffiliationReferralsListTable extends ListTable {
	use HasModeFilter;

	/**
	 * Checkbox
	 *
	 * @var boolean
	 */
	public $checkbox = true;

	/**
	 * Error
	 *
	 * @var string
	 */
	public $error = '';

	/**
	 * Pages
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
				'per_page'    => $this->get_items_per_page( 'affiliate_referrals' ),
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
	 *
	 * @return string
	 */
	protected function get_views() {
		foreach ( $this->getStatuses() as $status => $label ) {
			$link = admin_url( 'admin.php?page=sc-affiliate-referrals' );

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
		 * Filters the affiliation referrals status links.
		 *
		* @since 2.5.0
		* @since 5.1.0 The 'Mine' link was added.
		*
		*  @param string[] $status_links An associative array of fully-formed affiliation referrals status links. Includes 'All', 'Reviewing', 'Approved', 'Denied', 'Cancelled' and 'Paid Out'.
		* */
		return apply_filters( 'sc_affiliation_referrals_status_links', $status_links );
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'date'          => esc_html__( 'Date', 'surecart' ),
			'status'        => esc_html__( 'Status', 'surecart' ),
			'payout_status' => esc_html__( 'Payout Status', 'surecart' ),
			'payout_date'   => esc_html__( 'Payout Date', 'surecart' ),
			'affiliate'     => esc_html__( 'Affiliate', 'surecart' ),
			'description'   => esc_html__( 'Description', 'surecart' ),
			'order'         => esc_html__( 'Order', 'surecart' ),
			'commission'    => esc_html__( 'Commission', 'surecart' ),
			'mode'          => '',
		);
	}

	/**
	 * Handle the date column.
	 *
	 * @param \SureCart\Models\Referral $referral The Referral model.
	 *
	 * @return string
	 */
	public function column_date( $referral ) {
		ob_start();
		echo wp_kses_post( date_i18n( get_option( 'date_format' ), $referral->created_at ) );
		?>
		<?php
		echo wp_kses_post(
			$this->row_actions(
				array_filter(
					array(
						'view'           => '<a href="' . esc_url( \SureCart::getUrl()->edit( 'affiliate-referrals', $referral->id ) ) . '" aria-label="' . esc_attr__( 'View', 'surecart' ) . '">' . esc_html__( 'View', 'surecart' ) . '</a>',
						'edit'           => '<a href="' . esc_url( \SureCart::getUrl()->edit( 'affiliate-referrals', $referral->id ) ) . '" aria-label="' . esc_attr__( 'Edit', 'surecart' ) . '">' . esc_html__( 'Edit', 'surecart' ) . '</a>',
						'approve'        => '<a href="' . esc_url( $this->get_action_url( $referral->id, 'approve' ) ) . '" aria-label="' . esc_attr__( 'Approve', 'surecart' ) . '">' . esc_html__( 'Approve', 'surecart' ) . '</a>',
						'deny'           => '<a href="' . esc_url( $this->get_action_url( $referral->id, 'deny' ) ) . '" aria-label="' . esc_attr__( 'Deny', 'surecart' ) . '">' . esc_html__( 'Deny', 'surecart' ) . '</a>',
						'make_reviewing' => '<a href="' . esc_url( $this->get_action_url( $referral->id, 'make_reviewing' ) ) . '" aria-label="' . esc_attr__( 'Make Reviewing', 'surecart' ) . '">' . esc_html__( 'Make Reviewing', 'surecart' ) . '</a>',
						'delete'         => '<a href="' . esc_url( $this->get_action_url( $referral->id, 'delete' ) ) . '" aria-label="' . esc_attr__( 'Delete', 'surecart' ) . '">' . esc_html__( 'Delete', 'surecart' ) . '</a>',
					),
					function ( $action, $key ) use ( $referral ) {
						// only view a paid referral.
						if ( 'view' === $key && 'paid' !== $referral->status ) {
							return false;
						}

						// don't edit a paid referral.
						if ( 'paid' === $referral->status && 'view' !== $key ) {
							return false;
						}

						// don't approve approved referral.
						if ( 'approve' === $key && 'approved' === $referral->status ) {
							return false;
						}

						// don't deny denied referral.
						if ( 'deny' === $key && 'denied' === $referral->status ) {
							return false;
						}

						// don't make reviewing reviewing referral.
						if ( 'make_reviewing' === $key && 'reviewing' === $referral->status ) {
							return false;
						}

						return true;
					},
					ARRAY_FILTER_USE_BOTH
				)
			)
		)
		?>
		<?php
		return ob_get_clean();
	}

	/**
	 * Handle the status column.
	 *
	 * @param \SureCart\Models\Referral $referral The Referral model.
	 *
	 * @return string
	 */
	public function column_status( $referral ) {
		if ( empty( $referral->status_display_text ) ) {
			return '';
		}
		ob_start();
		?>
		<sc-tag type="<?php echo esc_attr( $referral->status_type ); ?>">
		<?php echo esc_html( $referral->status_display_text ); ?>
		</sc-tag>
		<?php
		return ob_get_clean();
	}

	/**
	 * Handle the payout status column.
	 *
	 * @param \SureCart\Models\Referral $referral The Referral model.
	 *
	 * @return string
	 */
	public function column_payout_status( $referral ) {
		if ( empty( $referral->payout ) ) {
			return '_';
		}

		$type = 'completed' === $referral->payout->status ? 'success' : 'warning';

		return '<sc-tag type="' . $type . '">' . $referral->payout->status_display_text . ' </sc-tag>';
	}

	/**
	 * Handle the payout date column.
	 *
	 * @param \SureCart\Models\Referral $referral The Referral model.
	 *
	 * @return string
	 */
	public function column_payout_date( $referral ) {
		if ( empty( $referral->payout ) ) {
			return '_';
		}

		return date_i18n( get_option( 'date_format' ), $referral->payout->created_at );
	}


	/**
	 * Handle the affiliate column.
	 *
	 * @param \SureCart\Models\Referral $referral The Referral model.
	 *
	 * @return string
	 */
	public function column_affiliate( $referral ) {
		$affiliation = $referral->affiliation ?? null;
		if ( empty( $affiliation->id ) ) {
			return '-';
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
	 * Handle the description column.
	 *
	 * @param \SureCart\Models\Referral $referral The Referral model.
	 *
	 * @return string
	 */
	public function column_description( $referral ) {
		return esc_html( $referral->description );
	}

	/**
	 * Handle the order column.
	 *
	 * @param \SureCart\Models\Referral $referral The Referral model.
	 *
	 * @return string
	 */
	public function column_order( $referral ) {
		$checkout = $referral->checkout ?? null;
		if ( empty( $checkout->order->id ) ) {
			return '-';
		}
		ob_start();
		?>
		<a aria-label="<?php esc_attr_e( 'View Order', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'order', $checkout->order->id ) ); ?>">
			#<?php echo esc_html( $checkout->order->number ?? $checkout->order->id ); ?>
		</a>
		<?php
		return ob_get_clean();
	}

	/**
	 * Handle the commission column.
	 *
	 * @param \SureCart\Models\Referral $referral The Referral model.
	 *
	 * @return string
	 */
	public function column_commission( $referral ) {
		return Currency::format( $referral->commission_amount, $referral->currency );
	}

	/**
	 * Get the table data
	 *
	 * @return \SureCart\Models\Collection;
	 */
	private function table_data() {
		$mode = sanitize_text_field( wp_unslash( $_GET['mode'] ?? '' ) );
		$conditions = array(
			'query'     => $this->get_search_query(),
			'status'    => [ $this->getFilteredStatus() ],
			'expand'    => [
				'affiliation',
				'checkout',
				'checkout.order',
				'payout',
			],
		);

		if ( ! empty( $mode ) ) {
			$conditions['live_mode'] = 'live' === $mode;
		}

		return Referral::where($conditions)->paginate(
			array(
				'per_page' => $this->get_items_per_page( 'affiliate_referrals' ),
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
		echo esc_html_e( 'No affiliate referrals found . ', 'surecart' );
	}

	/**
	 * Displays extra table navigation.
	 *
	 * @param string $which Top or bottom placement.
	 */
	protected function extra_tablenav( $which ) {
		?>
		<input type="hidden" name="page" value="sc-affiliate-referrals" />

		<?php if ( ! empty( $_GET['status'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<input type="hidden" name="status" value="<?php echo esc_attr( $_GET['status'] ); ?>" />
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
			do_action( 'restrict_manage_affiliate_referrals', $this->screen->post_type, $which );

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
		 * Fires immediately following the closing "actions" div in the tablenav
		 * for the affiliate referrals list table.
		 *
		 * @param string $which The location of the extra table nav markup: 'top' or 'bottom'.
		 */
		do_action( 'manage_affiliate_referrals_extra_tablenav', $which );
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

		// transform in payout status.
		if ( 'in_payout' === $_GET['status'] ) {
			return 'paid';
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
			'all'       => __( 'All', 'surecart' ),
			'reviewing' => __( 'Reviewing', 'surecart' ),
			'approved'  => __( 'Approved', 'surecart' ),
			'denied'    => __( 'Denied', 'surecart' ),
			'canceled'  => __( 'Canceled', 'surecart' ),
			'in_payout' => __( 'In Payout', 'surecart' ),
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
				array_filter(
					[
						'action'    => $action,
						'nonce'     => wp_create_nonce( $action . '_affiliation' ),
						'id'        => $id,
					]
				),
				esc_url_raw( admin_url( 'admin.php?page=sc-affiliate-referrals' ) )
			)
		);
	}
}
