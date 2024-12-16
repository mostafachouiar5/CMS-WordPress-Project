<?php

namespace SureCart\Controllers\Admin\Coupons;

use NumberFormatter;
use SureCart\Models\Coupon;
use SureCart\Models\Product;
use SureCart\Models\Promotion;
use SureCart\Support\Currency;
use SureCart\Controllers\Admin\Tables\ListTable;

// WP_List_Table is not loaded automatically so we need to load it in our application.
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class CouponsListTable extends ListTable {

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
				'per_page'    => $this->get_items_per_page( 'coupons' ),
			]
		);

		$this->items = $query->data;
	}

	/**
	 * Search form.
	 *
	 * @return void
	 */
	public function search() {
		?>
	<form class="search-form"
		method="get">
		<?php $this->search_box( __( 'Search Coupons', 'surecart' ), 'coupon' ); ?>
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
			// 'cb'          => '<input type="checkbox" />',
			'name'           => __( 'Name', 'surecart' ),
			'promotion_code' => __( 'Code', 'surecart' ),
			'price'          => __( 'Price', 'surecart' ),
			'usage'          => __( 'Usage', 'surecart' ),
			'date'           => __( 'Date', 'surecart' ),
		];
	}

	/**
	 * Displays the checkbox column.
	 *
	 * @param Product $product The product model.
	 */
	public function column_cb( $product ) {
		?>
		<label class="screen-reader-text" for="cb-select-<?php echo esc_attr( $product['id'] ); ?>"><?php esc_html_e( 'Select comment', 'surecart' ); ?></label>
		<input id="cb-select-<?php echo esc_attr( $product['id'] ); ?>" type="checkbox" name="delete_comments[]" value="<?php echo esc_attr( $product['id'] ); ?>" />
			<?php
	}

	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns() {
		return array();
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
	 * @return Object
	 */
	private function table_data() {
		return Coupon::where(
			[
				'archived' => $this->getArchiveStatus(),
				'query'    => $this->get_search_query(),
			]
		)->with( [ 'promotions' ] )
		->paginate(
			[
				'per_page' => $this->get_items_per_page( 'coupons' ),
				'page'     => $this->get_pagenum(),
			]
		);
	}

	/**
	 * Handle the price column.
	 *
	 * @param \SureCart\Models\Coupon $coupon Coupon model.
	 *
	 * @return string
	 */
	public function column_price( $coupon ) {
		ob_start();
		// phpcs:ignore
		echo $this->get_price_string( $coupon ?? false ); // this is already escaped. ?>
		<br />
		<div style="opacity: 0.75"><?php echo esc_html( $this->get_duration_string( $coupon ?? false ) ); ?></div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Output the Promo Code
	 *
	 * @param Promotion $promotion Promotion model.
	 *
	 * @return string
	 */
	public function column_usage( $coupon ) {
		$max = $coupon->max_redemptions ?? '&infin;';
		ob_start();
		echo \esc_html( "$coupon->times_redeemed / $max" );
		?>
		<br />
		<div style="opacity: 0.75"><?php echo \esc_html( $this->get_expiration_string( $coupon->redeem_by ) ); ?></div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render the "Redeem By"
	 *
	 * @param string $timestamp Redeem timestamp.
	 * @return string
	 */
	public function get_expiration_string( $timestamp = '' ) {
		if ( ! $timestamp ) {
			return '';
		}
		// translators: coupon expiration date.
		return sprintf( __( 'Valid until %s', 'surecart' ), date_i18n( get_option( 'date_format' ), $timestamp ) );
	}

	/**
	 * Get the price string for the coupon.
	 *
	 * @param \SureCart\Models\Coupon|null $coupon Coupon model.
	 * @return string
	 */
	public function get_price_string( $coupon = null ) {
		if ( ! $coupon || empty( $coupon->duration ) ) {
			return;
		}
		if ( ! empty( $coupon->percent_off ) ) {
			// translators: Coupon % off.
			return esc_html( sprintf( __( '%d%% off', 'surecart' ), $coupon->percent_off ) );
		}

		if ( ! empty( $coupon->amount_off ) ) {
			// translators: Coupon amount off.
			return '<sc-format-number type="currency" currency="' . $coupon->currency . '" value="' . $coupon->amount_off . '"></sc-format-number>';
		}

		return esc_html__( 'No discount.', 'surecart' );
	}

	/**
	 * Get the duration string
	 *
	 * @param Coupon|boolean $coupon Coupon object.
	 * @return string|void;
	 */
	public function get_duration_string( $coupon = '' ) {
		if ( ! $coupon || empty( $coupon->duration ) ) {
			return;
		}

		if ( 'forever' === $coupon->duration ) {
			return __( 'Forever', 'surecart' );
		}
		if ( 'repeating' === $coupon->duration ) {
			// translators: number of months.
			return sprintf( __( 'For %d months', 'surecart' ), $coupon->duration_in_months ?? 1 );
		}

		return __( 'Once', 'surecart' );
	}

	/**
	 * Handle the status
	 *
	 * @param \SureCart\Models\Price $product Product model.
	 *
	 * @return string
	 */
	public function column_status( $coupon ) {
		// TODO: Add Badge.
		return $coupon->expired ? __( 'Expired', 'surecart' ) : __( 'Active', 'surecart' );
	}

	protected function extra_tablenav( $which ) {
		if ( 'top' === $which ) {
			return $this->views();
		}
	}

	/**
	 * Name of the coupon
	 *
	 * @param \SureCart\Models\Promotion $promotion Promotion model.
	 *
	 * @return string
	 */
	public function column_name( $coupon ) {
		ob_start();
		?>
		<a class="row-title" aria-label="<?php esc_attr_e( 'Edit Coupon', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'coupon', $coupon->id ) ); ?>">
			<?php echo esc_html_e( $coupon->name, 'surecart' ); ?>
		</a>

		<?php
		echo $this->row_actions(
			[
				'edit' => '<a href="' . esc_url( \SureCart::getUrl()->edit( 'coupon', $coupon->id ) ) . '" aria-label="' . esc_attr__( 'Edit Coupon', 'surecart' ) . '">' . __( 'Edit', 'surecart' ) . '</a>',
			],
		);

		return ob_get_clean();
	}

	/**
	 * Name of the coupon
	 *
	 * @param \SureCart\Models\Promotion $promotion Promotion model.
	 *
	 * @return string
	 */
	public function column_promotion_code( $coupon ) {
		if ( empty( $coupon->promotions->data[0]->code ) ) {
			return __( 'No code specified', 'surecart' );
		}
		$and = '';
		if ( $coupon->promotions->pagination->count > 1 ) {
			$coupon_count = $coupon->promotions->pagination->count - 1;
			$and          = sprintf( __( '+ %d more', 'surecart' ), number_format_i18n( $coupon_count ) );
		}
		return '<code>' . sanitize_text_field( $coupon->promotions->data[0]->code ) . '</code> ' . $and;
	}

		/**
		 * Toggle archive action link and text.
		 *
		 * @param \SureCart\Models\Product $product Product model.
		 * @return string
		 */
	public function action_toggle_archive( $coupon ) {
		$text            = $coupon->archived ? __( 'Un-Archive', 'surecart' ) : __( 'Archive', 'surecart' );
		$confirm_message = $coupon->archived ? __( 'Are you sure you want to restore this coupon? This will be be available to purchase.', 'surecart' ) : __( 'Are you sure you want to archive this coupon? This will be unavailable for purchase.', 'surecart' );
		$link            = \SureCart::getUrl()->toggleArchive( 'coupon', $coupon->id );

		return sprintf(
			'<a class="submitdelete" onclick="return confirm(\'%1s\')" href="%2s" aria-label="%3s">%4s</a>',
			esc_attr( $confirm_message ),
			esc_url( $link ),
			esc_attr__( 'Toggle Coupon Archive', 'surecart' ),
			esc_html( $text )
		);
	}

	/**
	 * Allows you to sort the data by the variables set in the $_GET.
	 *
	 * @return Mixed
	 */
	private function sort_data( $a, $b ) {
		// Set defaults.
		$orderby = 'title';
		$order   = 'asc';

		// If orderby is set, use this as the sort column.
		if ( ! empty( $_GET['orderby'] ) ) {
			$orderby = sanitize_text_field( wp_unslash( $_GET['orderby'] ) );
		}

		// If order is set use this as the order.
		if ( ! empty( $_GET['order'] ) ) {
			$order = sanitize_text_field( wp_unslash( $_GET['order'] ) );
		}

		$result = strcmp( $a[ $orderby ], $b[ $orderby ] );

		if ( 'asc' === $order ) {
			return $result;
		}

		return -$result;
	}

	/**
	 * @global string $comment_status
	 *
	 * @return array
	 */
	protected function get_bulk_actions() {
		return false;
		global $comment_status;

		$actions = array();
		if ( in_array( $comment_status, array( 'all', 'approved' ), true ) ) {
			$actions['unapprove'] = __( 'Unapprove', 'surecart' );
		}
		if ( in_array( $comment_status, array( 'all', 'moderated' ), true ) ) {
			$actions['approve'] = __( 'Approve', 'surecart' );
		}
		if ( in_array( $comment_status, array( 'all', 'moderated', 'approved', 'trash' ), true ) ) {
			$actions['spam'] = _x( 'Mark as spam', 'comment', 'surecart' );
		}

		if ( 'trash' === $comment_status ) {
			$actions['untrash'] = __( 'Restore', 'surecart' );
		} elseif ( 'spam' === $comment_status ) {
			$actions['unspam'] = _x( 'Not spam', 'comment', 'surecart' );
		}

		if ( in_array( $comment_status, array( 'trash', 'spam' ), true ) || ! EMPTY_TRASH_DAYS ) {
			$actions['delete'] = __( 'Delete permanently', 'surecart' );
		} else {
			$actions['trash'] = __( 'Move to Trash', 'surecart' );
		}

		return $actions;
	}
}
