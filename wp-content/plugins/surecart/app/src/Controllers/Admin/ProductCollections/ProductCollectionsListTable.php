<?php

namespace SureCart\Controllers\Admin\ProductCollections;

use SureCart\Controllers\Admin\Tables\ListTable;
use SureCart\Models\ProductCollection;

/**
 * Create a new table class that will extend the WP_List_Table
 */
class ProductCollectionsListTable extends ListTable {
	/**
	 * Prepare the items for the table to process
	 *
	 * @return void
	 */
	public function prepare_items(): void {
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
				'per_page'    => $this->get_items_per_page( 'product_collections' ),
			]
		);

		$this->items = $query->data;
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return array
	 */
	public function get_columns(): array {
		return [
			'name'           => __( 'Name', 'surecart' ),
			'products_count' => __( 'Products', 'surecart' ),
			'description'    => __( 'Description', 'surecart' ),
			'created'        => __( 'Created', 'surecart' ),
		];
	}

	/**
	 * Define which columns are hidden.
	 *
	 * @return array
	 */
	public function get_hidden_columns(): array {
		return [];
	}

	/**
	 * Define the sortable columns.
	 *
	 * @return array
	 */
	public function get_sortable_columns(): array {
		return [];
	}

	/**
	 * Get the table data.
	 *
	 * @return object
	 */
	protected function table_data() {
		return ProductCollection::where(
			[
				'archived' => $this->getArchiveStatus(),
				'query'    => $this->get_search_query(),
			]
		)->paginate(
			[
				'per_page' => $this->get_items_per_page( 'product_collection' ),
				'page'     => $this->get_pagenum(),
			]
		);
	}

	/**
	 * Handle the description column.
	 *
	 * @param \SureCart\Models\ProductCollection $product_collection Product collection object.
	 *
	 * @return string
	 */
	public function column_description( $product_collection ) {
		$description         = wp_strip_all_tags( $product_collection->description );
		$trimmed_description = substr( $description, 0, 30 );
		if ( strlen( $description ) > 30 ) {
			$trimmed_description .= '...';
		}
		return $trimmed_description;
	}

	/**
	 * Handle the name column.
	 *
	 * @param \SureCart\Models\ProductCollection $collection Product collection object.
	 *
	 * @return string
	 */
	public function column_name( $collection ) {
		ob_start();
		?>
		<a class="row-title" aria-label="<?php esc_attr_e( 'Edit Product Collection', 'surecart' ); ?>" href="<?php echo esc_url( \SureCart::getUrl()->edit( 'product_collection', $collection->id ) ); ?>">
			<?php echo esc_html( $collection->name ); ?>
		</a>
		<?php
		echo wp_kses_post(
			$this->row_actions(
				[
					'edit' => '<a href="' . esc_url( \SureCart::getUrl()->edit( 'product_collection', $collection->id ) ) . '" aria-label="' . esc_attr__( 'Edit Product Collection', 'surecart' ) . '">' . esc_attr__( 'Edit', 'surecart' ) . '</a>',
					'view' => '<a href="' . esc_url( $collection->permalink ) . '" aria-label="' . esc_attr__( 'View', 'surecart' ) . '">' . esc_html__( 'View', 'surecart' ) . '</a>',
				],
			)
		);
		return ob_get_clean();
	}

	/**
	 * Handle the products_count column.
	 *
	 * @param \SureCart\Models\ProductCollection $collection Product collection object.
	 *
	 * @return int
	 */
	public function column_products_count( $collection ) {
		return '<a href="' . esc_url( add_query_arg( [ 'sc_collection' => $collection->id ], \SureCart::getUrl()->index( 'product' ) ) ) . '">' . $collection->products_count ?? 0 . '</a>';
	}
}
