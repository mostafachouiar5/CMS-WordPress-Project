<?php

namespace SureCart\Controllers\Admin\Upsells;

use SureCart\Models\UpsellFunnel;
use SureCart\Support\TimeDate;
use SureCart\Controllers\Admin\Tables\ListTable;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class UpsellsListTable extends ListTable {
	public $checkbox = true;
	public $error    = '';

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
			$this->error = $query->get_error_message();
			$this->items = [];
			return;
		}

		$this->set_pagination_args(
			[
				'total_items' => $query->pagination->count,
				'per_page'    => $this->get_items_per_page( 'upsells' ),
			]
		);

		$this->items = $query->data;
	}

	/**
	 * @global int $post_id
	 * @global string $comment_status
	 * @global string $comment_type
	 */
	protected function get_views() {
		$stati = [
			'active'   => __( 'Active', 'surecart' ),
			'archived' => __( 'Archived', 'surecart' ),
			'all'      => __( 'All', 'surecart' ),
		];

		foreach ( $stati as $status => $label ) {
			$link = admin_url( 'admin.php?page=sc-upsell-funnels' );
			$current_link_attributes = '';

			if ( ! empty( $_GET['status'] ) ) {
				if ( $status === $_GET['status'] ) {
					$current_link_attributes = ' class="current" aria-current="page"';
				}
			} elseif ( 'active' === $status ) {
				$current_link_attributes = ' class="current" aria-current="page"';
			}

			$link = add_query_arg( 'status', $status, $link );

			$link = esc_url( $link );

			$status_links[ $status ] = "<a href='$link'$current_link_attributes>" . $label . '</a>';
		}

		/**
		 * Filters the comment status links.
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
		return [
			'name'     => __( 'Name', 'surecart' ),
			'priority' => __( 'Priority', 'surecart' ),
			'enabled'  => __( 'Status', 'surecart' ),
			'date'     => __( 'Date', 'surecart' ),
		];
	}

	/**
	 * Displays the checkbox column.
	 *
	 * @param Upsell $upsell_funnel The upsell model.
	 */
	public function column_cb( $upsell_funnel ) {
		?>
		<label class="screen-reader-text" for="cb-select-<?php echo esc_attr( $upsell_funnel['id'] ); ?>"><?php _e( 'Select comment', 'surecart' ); ?></label>
		<input id="cb-select-<?php echo esc_attr( $upsell_funnel['id'] ); ?>" type="checkbox" name="delete_comments[]" value="<?php echo esc_attr( $upsell_funnel['id'] ); ?>" />
		<?php
	}

	/**
	 * Get the priority column
	 *
	 * @return bool
	 */
	public function column_priority( $upsell_funnel ) {
		echo (int) $upsell_funnel->priority;
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
	 * Define the sortable columns
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return array( 'title' => array( 'title', false ) );
	}

	/**
	 * Get the table data
	 *
	 * @return array
	 */
	private function table_data() {
		return UpsellFunnel::where(
			[
				'archived' => $this->getArchiveStatus(),
				'query'    => $this->get_search_query(),
			]
		)
		->where( [ 'sort' => 'priority:desc' ] )
		->paginate(
			[
				'per_page' => $this->get_items_per_page( 'upsells' ),
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
		if ( $this->error ) {
			echo esc_html( $this->error );
			return;
		}
		echo esc_html_e( 'No upsell funnels found.', 'surecart' );
	}

	/**
	 * Handle the type column output.
	 *
	 * @param \SureCart\Models\UpsellFunnel $upsell_funnel Upsell model.
	 *
	 * @return string
	 */
	public function column_type( $upsell_funnel ) {
		if ( $upsell_funnel->recurring ) {
			return '<sc-tag type="success">
			<div
				style="
					display: flex;
					align-items: center;
					gap: 0.5em;"
			>
				<sc-icon name="repeat"></sc-icon>
				' . esc_html__( 'Subscription', 'surecart' ) . '
			</div>
		</sc-tag>';
		}

		return '<sc-tag type="info">
		<div
			style="
				display: flex;
				align-items: center;
				gap: 0.5em;"
		>
			<sc-icon name="bookmark"></sc-icon>
			' . esc_html__( 'One-Time', 'surecart' ) . '
		</div>
	</sc-tag>';
	}

	/**
	 * Handle the status
	 *
	 * @param \SureCart\Models\UpsellFunnel $upsell_funnel Upsell model.
	 *
	 * @return string
	 */
	public function column_date( $upsell_funnel ) {
		$created = sprintf(
			'<time datetime="%1$s" title="%2$s">%3$s</time>',
			esc_attr( $upsell_funnel->created_at ),
			esc_html( TimeDate::formatDateAndTime( $upsell_funnel->created_at ) ),
			esc_html( TimeDate::humanTimeDiff( $upsell_funnel->created_at ) )
		);
		$updated = sprintf(
			'%1$s <time datetime="%2$s" title="%3$s">%4$s</time>',
			__( 'Updated', 'surecart' ),
			esc_attr( $upsell_funnel->updated_at ),
			esc_html( TimeDate::formatDateAndTime( $upsell_funnel->updated_at ) ),
			esc_html( TimeDate::humanTimeDiff( $upsell_funnel->updated_at ) )
		);
		return $created . '<br /><small style="opacity: 0.75">' . $updated . '</small>';
	}

	/**
	 * Enabled column
	 *
	 * @param \SureCart\Models\UpsellFunnel $upsell_funnel Upsell model.
	 *
	 * @return string
	 */
	public function column_enabled( $upsell_funnel ) {
		$toggle_url = add_query_arg(
			[
				'action' => 'toggle_enabled',
				'nonce'  => wp_create_nonce( 'archive_product' ), // use archive product nonce.
				'id'     => $upsell_funnel->id,
			]
		);
		?>
		<sc-switch checked="<?php echo esc_attr( $upsell_funnel->enabled ) ? 'true' : 'false'; ?>"
			onClick="window.location.assign('<?php echo esc_url_raw( $toggle_url ); ?>'); document.querySelector('#loading-<?php echo esc_attr( $upsell_funnel->id ); ?>').style.display = '';"></sc-switch>
		<sc-block-ui id="loading-<?php echo esc_attr( $upsell_funnel->id ); ?>" spinner style="display: none;"></sc-block-ui>
		<?php
	}

	/**
	 * Name column
	 *
	 * @param \SureCart\Models\UpsellFunnel $upsell_funnel Upsell model.
	 *
	 * @return string
	 */
	public function column_name( $upsell_funnel ) {
		ob_start();
		?>
		<div>
			<a class="row-title" aria-label="<?php esc_attr_e( 'Edit Upsell', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'upsell', $upsell_funnel->id ) ); ?>">
				<?php echo esc_html( $upsell_funnel->name ); ?>
			</a>
			<?php
			echo $this->row_actions(
				[
					'edit' => ' <a href="' . esc_url( \SureCart::getUrl()->edit( 'upsell', $upsell_funnel->id ) ) . '" aria-label="' . esc_attr__( 'Edit Upsell Funnel', 'surecart' ) . '">' . esc_html__( 'Edit', 'surecart' ) . '</a>',
				],
			);
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Define what data to show on each column of the table
	 *
	 * @param \SureCart\Models\UpsellFunnel $upsell_funnel Upsell model.
	 * @param string                        $column_name - Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $upsell_funnel, $column_name ) {
		switch ( $column_name ) {
			case 'name':
				return ' < a href     = "' . \SureCart::getUrl()->edit( 'upsell', $upsell_funnel->id ) . '" > ' . $upsell_funnel->name . ' < / a > ';

			case 'name':
			case 'description':
				return $upsell_funnel->$column_name ?? '';
		}
	}
}
