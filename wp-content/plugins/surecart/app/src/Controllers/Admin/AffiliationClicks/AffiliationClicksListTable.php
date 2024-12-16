<?php

namespace SureCart\Controllers\Admin\AffiliationClicks;

use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Models\Click;
use SureCart\Support\TimeDate;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class AffiliationClicksListTable extends ListTable {

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
				'per_page'    => $this->get_items_per_page( 'affiliate_clicks' ),
			)
		);

		$this->items = $query->data;
	}

	/**
	 * Get views for the list table status links.
	 */
	protected function get_views() {
		foreach ( $this->getStatuses() as $status => $label ) {
			$link = admin_url( 'admin.php?page=sc-affiliate-clicks' );
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
		 * Filters the status links.
		 *
		 * @since 2.5.0
		 * @since 5.1.0 The 'Mine' link was added.
		 *
		 * @param string[] $status_links An associative array of fully-formed comment status links.
		 */
		return apply_filters( 'sc_affiliate_clicks_status_links', $status_links );
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'date'      => __( 'Date', 'surecart' ),
			'url'       => __( 'Landing URL', 'surecart' ),
			'referrer'  => __( 'Referring URL', 'surecart' ),
			'affiliate' => __( 'Affiliate', 'surecart' ),
			'converted' => __( 'Converted', 'surecart' ),
		);
	}

	/**
	 * Handle the date column.
	 *
	 * @param \SureCart\Models\Click $click The Click model.
	 *
	 * @return string
	 */
	public function column_date( $click ) {
		$created = sprintf(
			'<time datetime="%1$s" title="%2$s">%3$s</time>',
			esc_attr( $click->created_at ),
			esc_html( TimeDate::formatDateAndTime( $click->created_at ) ),
			esc_html( TimeDate::humanTimeDiff( $click->created_at ) )
		);

		$is_expired = $click->expires_at < time();
		$expires    = sprintf(
			'%1$s <time datetime="%2$s" title="%3$s">%4$s</time>',
			$is_expired ? __( 'Expired', 'surecart' ) : __( 'Expires on', 'surecart' ),
			esc_attr( $click->expires_at ),
			esc_html( TimeDate::formatDateAndTime( $click->expires_at ) ),
			esc_html( $is_expired ? TimeDate::humanTimeDiff( $click->expires_at ) : TimeDate::formatDate( $click->expires_at ) )
		);

		return $created . '<br /><small style="opacity: 0.75">' . $expires . '</small>';
	}

	/**
	 * Handle the url column.
	 *
	 * @param \SureCart\Models\Click $click The Click model.
	 *
	 * @return string
	 */
	public function column_url( $click ) {
		return '<a href="' . esc_url( $click->url ) . '" target="_blank">' . esc_html( $click->url ) . '</a>';
	}

	/**
	 * Handle the referrer column.
	 *
	 * @param \SureCart\Models\Click $click The Click model.
	 *
	 * @return string
	 */
	public function column_referrer( $click ) {
		return ! empty( $click->referrer ) ? $click->referrer : '-';
	}


	/**
	 * Handle the affiliate column.
	 *
	 * @param \SureCart\Models\Click $click The Click model.
	 *
	 * @return string
	 */
	public function column_affiliate( $click ) {
		$affiliation = $click->affiliation ?? null;
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
	 * Handle the converted column.
	 *
	 * @param \SureCart\Models\Click $click The Click model.
	 *
	 * @return string
	 */
	public function column_converted( $click ) {
		return '<sc-icon style="font-size: 30px; line-height:1; height: 20px; color: var(' . ( $click->converted ? '--sc-color-success-600' : '--sc-color-gray-600' ) . ');"  name="' . ( $click->converted ? 'check-circle' : 'minus-circle' ) . '" />';
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
		return Click::where(
			array(
				'converted' => $this->get_filtered_status(),
				'query'     => $this->get_search_query(),
				'expand'    => [
					'affiliation',
				],
			)
		)->paginate(
			array(
				'per_page' => $this->get_items_per_page( 'affiliate_clicks' ),
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
		echo esc_html_e( 'No affiliate clicks found.', 'surecart' );
	}


	/**
	 * Displays extra table navigation.
	 *
	 * @param string $which Top or bottom placement.
	 */
	protected function extra_tablenav( $which ) {
		?>
		<input type="hidden" name="page" value="sc-affiliate-clicks" />

		<?php if ( ! empty( $_GET['status'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<input type="hidden" name="status" value="<?php echo esc_attr( $_GET['status'] ); ?>" />
		<?php endif; ?>

		<?php
		/**
		 * Fires immediately following the closing "actions" div in the tablenav
		 * for the affiliate_clicks list table.
		 *
		 * @param string $which The location of the extra table nav markup: 'top' or 'bottom'.
		 */
		do_action( 'manage_affiliate_clicks_extra_tablenav', $which );
	}


	/**
	 * Get filtered status / default status.
	 *
	 * @return string|null
	 */
	private function get_filtered_status() {
		if ( empty( $_GET['status'] ) || 'all' === $_GET['status'] ) {
			return null;
		}

		if ( 'converted' === $_GET['status'] ) {
			return true;
		}

		return false;
	}

	/**
	 * Define what data to show on each column of the table
	 *
	 * @param \SureCart\Models\AffiliationClick $affiliation_click AffiliationClick model.
	 * @param string                            $column_name - Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		return $item->$column_name ?? '';
	}

	/**
	 * Get all statuses.
	 *
	 * @return array
	 */
	private function getStatuses(): array {
		return array(
			'all'           => __( 'All', 'surecart' ),
			'converted'     => __( 'Converted', 'surecart' ),
			'not_converted' => __( 'Not Converted', 'surecart' ),
		);
	}
}
