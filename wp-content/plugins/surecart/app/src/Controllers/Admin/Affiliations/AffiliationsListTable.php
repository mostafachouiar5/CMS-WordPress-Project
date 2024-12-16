<?php

namespace SureCart\Controllers\Admin\Affiliations;

use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Models\Affiliation;

/**
 * Affiliations List Table
 */
class AffiliationsListTable extends ListTable {
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
				'per_page'    => $this->get_items_per_page( 'affiliations' ),
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
			$link = admin_url( 'admin.php?page=sc-affiliates' );
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
			'name'                             => __( 'Name', 'surecart' ),
			'email'                            => __( 'Email', 'surecart' ),
			'status'                           => __( 'Status', 'surecart' ),
			'clicks'                           => __( 'Clicks', 'surecart' ),
			'referrals'                        => __( 'Referrals', 'surecart' ),
			'total_commission_amount'          => __( 'Total Earnings', 'surecart' ),
			'total_not_paid_commission_amount' => __( 'Unpaid Earnings', 'surecart' ),
			'date'                             => __( 'Date', 'surecart' ),
		);
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
	 * @return array
	 */
	private function table_data() {
		$affiliates_query = Affiliation::where(
			array(
				'active' => $this->getFilteredStatus(),
				'query'  => $this->get_search_query(),
				'expand' => [
					'clicks',
					'referrals',
				],
			)
		);

		return $affiliates_query->paginate(
			array(
				'per_page' => $this->get_items_per_page( 'affiliate' ),
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
		echo esc_html_e( 'No affiliates found.', 'surecart' );
	}

	/**
	 * Published column
	 *
	 * @param \SureCart\Models\Affiliation $affiliation Affiliation model.
	 *
	 * @return string
	 */
	public function column_status( $affiliation ) {
		ob_start();
		?>
		<sc-tag type="<?php echo esc_attr( $affiliation->status_type ); ?>">
			<?php echo esc_html( $affiliation->status_display_text ); ?>
		</sc-tag>
		<?php
		return ob_get_clean();
	}

	/**
	 * Total clicks column.
	 *
	 * @param \SureCart\Models\Affiliation $affiliation Affiliation model.
	 * @return int
	 */
	public function column_clicks( $affiliation ) {
		return esc_html( $affiliation->clicks->pagination->count ?? 0 );
	}

	/**
	 * Total referrals column.
	 *
	 * @param \SureCart\Models\Affiliation $affiliation Affiliation model.
	 * @return int
	 */
	public function column_referrals( $affiliation ) {
		return esc_html( $affiliation->referrals->pagination->count ?? 0 );
	}

	/**
	 * Total commission amount column.
	 *
	 * @param \SureCart\Models\Affiliation $affiliation Affiliation model.
	 * @return string
	 */
	public function column_total_commission_amount( $affiliation ) {
		$store_currency = \SureCart::account()->currency ?? 'usd';
		return '<sc-format-number type="currency" currency="' . strtoupper( esc_html( $store_currency ) ) . '" value="' . (float) $affiliation->total_commission_amount . '"></sc-format-number>';
	}

	/**
	 * Total unpaid commission amount column.
	 *
	 * @param \SureCart\Models\Affiliation $affiliation Affiliation model.
	 * @return string
	 */
	public function column_total_not_paid_commission_amount( $affiliation ) {
		$store_currency = \SureCart::account()->currency ?? 'usd';
		return '<sc-format-number type="currency" currency="' . strtoupper( esc_html( $store_currency ) ) . '" value="' . (float) $affiliation->total_not_paid_commission_amount . '"></sc-format-number>';
	}

	/**
	 * Name column.
	 *
	 * @param \SureCart\Models\Affiliation $affiliation Affiliation model.
	 *
	 * @return string
	 */
	public function column_name( $affiliation ) {
		ob_start();
		?>

		<div class="sc-affiliate-name">
			<a href="<?php echo esc_url( \SureCart::getUrl()->edit( 'affiliates', $affiliation->id ) ); ?>">
				<?php echo esc_html( $affiliation->first_name . ' ' . $affiliation->last_name ); ?>
			</a>
			<?php
				echo $this->row_actions(
					array(
						'view'  => '<a href="' . esc_url( \SureCart::getUrl()->edit( 'affiliates', $affiliation->id ) ) . '" aria-label="' . esc_attr__( 'View Affiliate', 'surecart' ) . '">' . esc_html__( 'View Details', 'surecart' ) . '</a>',
						'trash' => $this->action_toggle_activate( $affiliation ),
					)
				);
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Define what data to show on each column of the table
	 *
	 * @param \SureCart\Models\Affiliation $affiliation Affiliation model.
	 * @param string                       $column_name - Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $affiliation, $column_name ) {
		switch ( $column_name ) {
			case 'description':
			case 'email':
				return $affiliation->$column_name ?? '';
		}
	}

	/**
	 * Displays extra table navigation.
	 *
	 * @param string $which Top or bottom placement.
	 */
	protected function extra_tablenav( $which ) {
		?>
		<input type="hidden" name="page" value="sc-affiliates" />

		<?php if ( ! empty( $_GET['status'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<input type="hidden" name="status" value="<?php echo esc_attr( $_GET['status'] ); ?>" />
		<?php endif; ?>

		<?php
		/**
		 * Fires immediately following the closing "actions" div in the tablenav
		 * for the affiliates list table.
		 *
		 * @param string $which The location of the extra table nav markup: 'top' or 'bottom'.
		 */
		do_action( 'manage_affiliates_extra_tablenav', $which );
	}

	/**
	 * Toggle archive action link and text.
	 *
	 * @param \SureCart\Models\Affiliation $affiliation Affiliation model.
	 * @return string
	 */
	public function action_toggle_activate( $affiliation ) {
		$text            = $affiliation->active ? __( 'Deactivate', 'surecart' ) : __( 'Activate', 'surecart' );
		$confirm_message = $affiliation->active ? __( 'Are you sure you want to deactivate this affilate?', 'surecart' ) : __( 'Are you sure you want to activate this affiliate?', 'surecart' );
		$link            = $this->get_toggle_activate_url( $affiliation->id, $affiliation->active ? 'deactivate' : 'activate' );

		return sprintf(
			// translators: %1s: confirm message, %2s: link, %3s: aria label, %4s: text.
			'<a class="submitdelete" onclick="return confirm(\'%1s\')" href="%2s" aria-label="%3s">%4s</a>',
			esc_attr( $confirm_message ),
			esc_url( $link ),
			esc_attr__( 'Toggle Affiliate active status', 'surecart' ),
			esc_html( $text )
		);
	}

	/**
	 * Get the toggle activate URL.
	 *
	 * @param string $id     Model id.
	 * @param string $action Action activate or deactivate.
	 *
	 * @return string URL for the page.
	 */
	public function get_toggle_activate_url( $id, $action ) {
		return esc_url(
			add_query_arg(
				[
					'action' => $action,
					'nonce'  => wp_create_nonce( $action . '_affiliation' ),
					'id'     => $id,
				],
				esc_url_raw( admin_url( 'admin.php?page=sc-affiliates' ) )
			)
		);
	}

	/**
	 * Get filtered status / default status.
	 *
	 * @return string|null
	 */
	private function getFilteredStatus() {
		$status     = sanitize_text_field( wp_unslash( $_GET['status'] ?? '' ) );
		$transforms = [
			'all'      => null,
			'active'   => '1',
			'inactive' => '0',
		];

		return $transforms[ $status ] ?? null;
	}

	/**
	 * Get all affiliation statuses.
	 *
	 * @return array
	 */
	private function getStatuses(): array {
		return array(
			'all'      => __( 'All', 'surecart' ),
			'active'   => __( 'Active', 'surecart' ),
			'inactive' => __( 'Inactive', 'surecart' ),
		);
	}
}
