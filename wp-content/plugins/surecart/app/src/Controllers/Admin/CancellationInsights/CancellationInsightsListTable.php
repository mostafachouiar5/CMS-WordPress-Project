<?php

namespace SureCart\Controllers\Admin\CancellationInsights;

use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Models\CancellationAct;
use SureCart\Controllers\Admin\Tables\HasModeFilter;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class CancellationInsightsListTable extends ListTable {
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
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return Array
	 */
	public function get_columns() {
		return [
			'customer'            => __( 'Customer', 'surecart' ),
			'plan'                => __( 'Plan', 'surecart' ),
			'cancellation_reason' => __( 'Cancellation Reason', 'surecart' ),
			'comment'             => __( 'Comment', 'surecart' ),
			'status'              => __( 'Plan Status', 'surecart' ),
			'date'                => __( 'Date', 'surecart' ),
			'mode'                => '',
		];
	}

	/**
	 * The subscription product.
	 *
	 * @param \SureCart\Models\CancellationAct $act Cancellation reason model.
	 *
	 * @return string
	 */
	public function column_plan( $act ) {
		if ( empty( $act->subscription->price->product ) ) {
			return __( 'No product', 'surecart' );
		}
		return '<a href="' . esc_url( \SureCart::getUrl()->show( 'subscription', $act->subscription->id ) ) . '">' . $act->subscription->price->product->name . '</a>';
	}

	/**
	 * The subscription product.
	 *
	 * @param \SureCart\Models\CancellationAct $act Cancellation reason model.
	 *
	 * @return string
	 */
	public function column_date( $act ) {
		return '<sc-format-date date="' . (int) $act->performed_at . '" type="timestamp" month="short" day="numeric" year="numeric" hour="numeric" minute="numeric"></sc-format-date>';
	}

	/**
	 * We only have one default view.
	 */
	protected function get_views() {
		return [ 'all' => __( 'All Cancellation Attempts', 'surecart' ) ];
	}

	/**
	 * Get the table data
	 *
	 * @return Object
	 */
	protected function table_data() {
		$mode = sanitize_text_field( wp_unslash( $_GET['mode'] ?? '' ) );
		$conditions = array();

		if ( ! empty( $mode ) ) {
			$conditions['live_mode'] = 'live' === $mode;
		}

		return CancellationAct::where($conditions)
		->with(
			[
				'subscription',
				'subscription.customer',
				'cancellation_reason',
				'subscription.price',
				'price.product',
			]
		)
		->paginate(
			[
				'per_page' => $this->get_items_per_page( 'cancellation_acts' ),
				'page'     => $this->get_pagenum(),
			]
		);
	}

	/**
	 * Nothing found.
	 *
	 * @return void
	 */
	public function no_items() {
		echo esc_html_e( 'No cancellation acts.', 'surecart' );
	}

	/**
	 * The cancellation reason.
	 *
	 * @param \SureCart\Models\CancellationAct $act Cancellation act.
	 *
	 * @return string
	 */
	public function column_cancellation_reason( $act ) {
		return $act->cancellation_reason->label ?? '-';
	}

	/**
	 * The customer.
	 *
	 * @param \SureCart\Models\CancellationAct $act Cancellation act model.
	 *
	 * @return string
	 */
	public function column_customer( $act ) {
		ob_start();
		?>
		<a class="row-title" aria-label="<?php esc_attr_e( 'Edit Customer', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'customers', $act->subscription->customer->id ) ); ?>">
		<?php echo wp_kses_post( $act->subscription->customer->name ?? $act->subscription->customer->email ?? esc_html__( 'No name provided', 'surecart' ) ); ?>
		</a>

		<?php
		echo $this->row_actions(
			[
				'edit' => '<a href="' . esc_url( \SureCart::getUrl()->edit( 'customers', $act->subscription->customer->id ) ) . '" aria-label="' . esc_attr__( 'View Customer', 'surecart' ) . '">' . esc_html__( 'View Customer', 'surecart' ) . '</a>',
			],
		);
		?>

		<?php
		return ob_get_clean();
	}

	/**
	 * Cancellation comment.
	 *
	 * @param \SureCart\Models\CancellationAct $act Cancellation act model.
	 *
	 * @return string
	 */
	public function column_comment( $act ) {
		return $act->comment ?? '-';
	}

	/**
	 * The mode for the model.
	 *
	 * @param SureCart\Model $model Model.
	 *
	 * @return string
	 */
	public function column_mode( $act ) {
		return empty( $act->subscription->live_mode ) ? '<sc-tag type="warning">' . __( 'Test', 'surecart' ) . '</sc-tag>' : '';
	}

	/**
	 * The status
	 *
	 * @param \SureCart\Models\CancellationAct $act Cancellation act model.
	 *
	 * @return string
	 */
	public function column_status( $act ) {
		if ( $act->preserved ) {
			ob_start();
			?>
			<sc-tag type="success"><?php
			// translators: Subscription saver feature. This is displayed if the subscription has been "Saved" from cancellation.
			echo esc_html__( 'Saved', 'surecart' ); ?> </sc-tag>
			<?php if ( $act->coupon_applied ) { ?>
				<sc-tag type="info"><?php echo esc_html__( 'Coupon Applied', 'surecart' ); ?></sc-tag>
			<?php } ?>
			<?php
			return ob_get_clean();
		}

		$badge = '<sc-subscription-status-badge id="act-' . esc_attr( $act->id ) . '"></sc-subscription-status-badge>';

		\SureCart::assets()->addComponentData(
			'sc-subscription-status-badge',
			'#act-' . esc_attr( $act->id ),
			[
				'subscription' => $act->subscription,
			]
		);

		return $badge;
	}

	/**
	 * Displays extra table navigation.
	 *
	 * @param string $which Top or bottom placement.
	 */
	protected function extra_tablenav( $which ) {
		?>
		<input type="hidden" name="page" value="sc-cancellation-insights" />

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
			do_action( 'restrict_manage_cancellation_insights', $this->screen->post_type, $which );

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
		do_action( 'manage_cancellation_insights_extra_tablenav', $which );
	}
}
