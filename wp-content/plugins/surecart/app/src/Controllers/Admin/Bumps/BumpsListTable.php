<?php

namespace SureCart\Controllers\Admin\Bumps;

use SureCart\Models\Bump;
use SureCart\Support\TimeDate;
use SureCart\Controllers\Admin\Tables\ListTable;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class BumpsListTable extends ListTable {
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
				'per_page'    => $this->get_items_per_page( 'bumps' ),
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
			$link = admin_url( 'admin.php?page=sc-bumps' );
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
	 * @return Array
	 */
	public function get_columns() {
		return [
			// 'cb'          => '<input type="checkbox" />',
			'name'  => __( 'Name', 'surecart' ),
			// 'description' => __( 'Description', 'surecart' ),
			'price' => __( 'Price', 'surecart' ),
			// 'type'         => __( 'Type', 'surecart' ),
			// 'integrations' => __( 'Integrations', 'surecart' ),
			'date'  => __( 'Date', 'surecart' ),
		];
	}

	/**
	 * Displays the checkbox column.
	 *
	 * @param Bump $bump The bump model.
	 */
	public function column_cb( $bump ) {
		?>
		<label class="screen-reader-text" for="cb-select-<?php echo esc_attr( $bump['id'] ); ?>"><?php _e( 'Select comment', 'surecart' ); ?></label>
		<input id="cb-select-<?php echo esc_attr( $bump['id'] ); ?>" type="checkbox" name="delete_comments[]" value="<?php echo esc_attr( $bump['id'] ); ?>" />
		<?php
	}

	/**
	 * Show any integrations.
	 */
	public function column_integrations( $bump ) {
		$list = $this->bumpIntegrationsList( $bump->id );
		return $list ? $list : '-';
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
	 * @return Array
	 */
	private function table_data() {
		return Bump::where(
			[
				'archived' => $this->getArchiveStatus(),
				'query'    => $this->get_search_query(),
			]
		)
		->with( [ 'price', 'price.product' ] )
		->paginate(
			[
				'per_page' => $this->get_items_per_page( 'bumps' ),
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
		echo esc_html_e( 'No order bumps found.', 'surecart' );
	}

	/**
	 * Handle the type column output.
	 *
	 * @param \SureCart\Models\Price $bump Bump model.
	 *
	 * @return string
	 */
	public function column_type( $bump ) {
		if ( $bump->recurring ) {
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
	 * @param \SureCart\Models\Price $bump Bump model.
	 *
	 * @return string
	 */
	public function column_date( $bump ) {
		$created = sprintf(
			'<time datetime="%1$s" title="%2$s">%3$s</time>',
			esc_attr( $bump->created_at ),
			esc_html( TimeDate::formatDateAndTime( $bump->created_at ) ),
			esc_html( TimeDate::humanTimeDiff( $bump->created_at ) )
		);
		$updated = sprintf(
			'%1$s <time datetime="%2$s" title="%3$s">%4$s</time>',
			__( 'Updated', 'surecart' ),
			esc_attr( $bump->updated_at ),
			esc_html( TimeDate::formatDateAndTime( $bump->updated_at ) ),
			esc_html( TimeDate::humanTimeDiff( $bump->updated_at ) )
		);
		return $created . '<br /><small style="opacity: 0.75">' . $updated . '</small>';
	}

	/**
	 * Price
	 *
	 * @param \SureCart\Models\Bump $bump Bump model.
	 *
	 * @return string
	 */
	public function column_price( $bump ) {
		if ( empty( $bump->price->id ) ) {
			return;
		}

		$price = $bump->price ?? null;

		ob_start();
		?>
			<strong><?php echo esc_html( $price->product->name ); ?></strong><br/>
			<sc-format-number type="currency" currency="<?php echo esc_attr( $price->currency ); ?>" value="<?php echo (float) $price->amount; ?>"></sc-format-number>
			<sc-format-interval value="<?php echo (int) $price->recurring_interval_count; ?>" interval="<?php echo esc_attr( $price->recurring_interval ); ?>"></sc-format-interval>
		<?php
		return ob_get_clean();

		return '<sc-format-number type="currency" currency="' . esc_attr( $price->currency ) . '" value="' . (float) $price->amount . '"></sc-format-number>';
	}

	/**
	 * Name column
	 *
	 * @param \SureCart\Models\Bump $bump Bump model.
	 *
	 * @return string
	 */
	public function column_name( $bump ) {
		ob_start();
		?>

	  <div>
		<a class="row-title" aria-label="<?php esc_attr_e( 'Edit Bump', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'bump', $bump->id ) ); ?>">
			<?php echo esc_html( $bump->name ? $bump->name : $bump->price->product->name ); ?>
		</a>

		<?php
		echo $this->row_actions(
			[
				'edit' => ' <a href="' . esc_url( \SureCart::getUrl()->edit( 'bump', $bump->id ) ) . '" aria-label="' . esc_attr__( 'Edit Bump', 'surecart' ) . '">' . __( 'Edit', 'surecart' ) . '</a>',
			],
		);
		?>
		</div>

		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Define what data to show on each column of the table
	 *
	 * @param \SureCart\Models\Bump $bump Bump model.
	 * @param String                $column_name - Current column name.
	 *
	 * @return Mixed
	 */
	public function column_default( $bump, $column_name ) {
		switch ( $column_name ) {
			case 'name':
				return ' < a href     = "' . \SureCart::getUrl()->edit( 'bump', $bump->id ) . '" > ' . $bump->name . ' < / a > ';
			case 'name':
			case 'description':
				return $bump->$column_name ?? '';
		}
	}
}
