<?php

namespace SureCart\Background;

use SureCart\Models\BulkAction;

/**
 * Handled the business logic for Bulk Actions.
 */
class BulkActionService {
	/**
	 * The cookie prefix.
	 *
	 * @var string
	 */
	public $cookie_prefix = 'sc_bulk_action_';

	/**
	 * The bulk actions data.
	 *
	 * @var array
	 */
	public $bulk_actions_data = [];

	/**
	 * The bulk actions.
	 *
	 * @var array
	 */
	public $bulk_actions = [];

	/**
	 * The bulk action statuses.
	 *
	 * @var array
	 */
	public $statuses = array( 'succeeded', 'processing', 'pending', 'invalid', 'completed' );

	/**
	 * Bootstrap any actions.
	 *
	 * @return void
	 */
	public function bootstrap() {
		// we will only do this in the admin or if there are bulk actions to check.
		if ( ! $this->hasBulkActionsToCheck() || ! is_admin() ) {
			return;
		}

		// store the bulk actions in the object.
		$this->bulk_actions = BulkAction::where(
			[
				'ids' => $this->getBulkActionsToCheck(),
			]
		)->get();

		// delete any succeeded bulk actions.
		$this->deleteCompletedBulkActions();
	}

	/**
	 * Get the active bulk actions.
	 *
	 * @return array
	 */
	protected function getBulkActionsToCheck() {
		$actions = [];
		foreach ( $_COOKIE as $key => $value ) {
			if ( 0 === strpos( $key, $this->cookie_prefix ) ) {
				$actions[] = sanitize_text_field( $value );
			}
		}
		return $actions;
	}

	/**
	 * Do we have processing bulk actions?
	 *
	 * @return boolean
	 */
	protected function hasBulkActionsToCheck() {
		return ! empty( $this->getBulkActionsToCheck() );
	}

	/**
	 * Check if the model has a pending action.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 * @param string                 $name The action name.
	 *
	 * @return boolean
	 */
	public function modelHasPendingAction( $model, $name = 'delete_products' ) {
		$pending_record_ids    = $this->getRecordIds( $name, 'pending' );
		$processing_record_ids = $this->getRecordIds( $name, 'processing' );

		if ( empty( $model->id ) ) {
			return false;
		}

		return in_array( $model->id, $pending_record_ids ) || in_array( $model->id, $processing_record_ids );
	}

	/**
	 * Group the bulk actions data by action type and status.
	 *
	 * @return array
	 */
	public function groupedBulkActions() {
		$sorted_bulk_actions = [];
		if ( ! empty( $this->bulk_actions ) ) {
			foreach ( $this->bulk_actions as $bulk_action ) {
				foreach ( $this->statuses as $status ) {
					if ( ! isset( $sorted_bulk_actions[ $bulk_action->action_type ][ $status . '_record_ids' ] ) ) {
						$sorted_bulk_actions[ $bulk_action->action_type ][ $status . '_record_ids' ] = array();
					}
					if ( ! isset( $sorted_bulk_actions[ $bulk_action->action_type ][ $status . '_bulk_actions' ] ) ) {
						$sorted_bulk_actions[ $bulk_action->action_type ][ $status . '_bulk_actions' ] = array();
					}
				}
				if ( ! is_wp_error( $bulk_action ) ) {
					$sorted_bulk_actions[ $bulk_action->action_type ][ $bulk_action->status ][] = $bulk_action;
					array_push( $sorted_bulk_actions[ $bulk_action->action_type ][ $bulk_action->status . '_bulk_actions' ], $bulk_action->id ); // Saves the bulks actions ids for each status.
					array_push( $sorted_bulk_actions[ $bulk_action->action_type ][ $bulk_action->status . '_record_ids' ], ...$bulk_action->record_ids ); // Saves the record ids for each status.
				}
			}
		}
		return $sorted_bulk_actions;
	}

	/**
	 * Get the completed bulk actions.
	 *
	 * @return array
	 */
	public function getCompletedBulkActions() {
		return array_filter(
			$this->bulk_actions,
			function ( $action ) {
				return in_array( $action->status, [ 'pending', 'processing' ] );
			}
		);
	}

	/**
	 * Delete succeeded bulk actions from the cookie.
	 *
	 * @return void
	 */
	public function deleteCompletedBulkActions() {
		// get any bulk actions that are processing.
		$processing = array_filter(
			$this->bulk_actions,
			function ( $action ) {
				return in_array( $action->status, [ 'pending', 'processing' ] );
			}
		);

		$completed = false;

		// for each of our cookies, if the bulk action is not processing, delete the cookie.
		foreach ( $_COOKIE as $key => $value ) {
			if ( 0 === strpos( $key, $this->cookie_prefix ) ) {
				if ( ! in_array( $value, array_column( $processing, 'id' ) ) ) {
					$completed = true;
					setcookie(
						$key,
						'',
						time() - DAY_IN_SECONDS,
						COOKIEPATH,
						COOKIE_DOMAIN,
						is_ssl(),
						true
					);
				}
			}
		}

		if ( ! $completed ) {
			return;
		}

		// make sure to clear cache since these are now deleted.
		\SureCart::account()->clearCache();
	}

	/**
	 * Show the bulk action admin notice.
	 *
	 * @param string $action_type The action type.
	 *
	 * @return void
	 */
	public function showBulkActionAdminNotice( $action_type = null ) {
		if ( empty( $action_type ) ) {
			return;
		}

		$actions = $this->groupedBulkActions();

		$status_parts = [];
		foreach ( $this->statuses as $status ) {
			$count = count( $actions[ $action_type ][ $status . '_record_ids' ] ?? [] );
			if ( $count > 0 ) {
				// translators: %1$d is Count of specific deletions, %2$s is bulk deletion progress status.
				$status_parts[] = sprintf( esc_html__( '%1$d %2$s', 'surecart' ), $count, $status );
			}
		}

		if ( ! empty( $status_parts ) ) {
			$status_summary = esc_html__( 'Bulk Action Summary:', 'surecart' ) . ' ' . implode( ', ', $status_parts ) . '.';
			echo wp_kses_post(
				\SureCart::notices()->render(
					[
						'type'  => 'info',
						'title' => esc_html__( 'SureCart bulk action progress status.', 'surecart' ),
						'text'  => '<p>' . $status_summary . '</p>',
					]
				)
			);
		}
	}

	/**
	 * Create a bulk action.
	 *
	 * This creates a bulk action and stores the id in
	 * a cookie so it can be checked later.
	 *
	 * @param string $action_type The action type.
	 * @param array  $record_ids  The record ids.
	 *
	 * @return void
	 */
	public function createBulkAction( $action_type, $record_ids ) {
		$bulk_action = BulkAction::create(
			[
				'action_type' => $action_type,
				'record_ids'  => $record_ids,
			]
		);

		if ( is_wp_error( $bulk_action ) ) {
			return $bulk_action;
		}

		setcookie(
			$this->cookie_prefix . '_' . $bulk_action->id,
			$bulk_action->id,
			time() + DAY_IN_SECONDS,
			COOKIEPATH,
			COOKIE_DOMAIN,
			is_ssl(),
			true
		);

		return $bulk_action;
	}

	/**
	 * Get the record ids for a specific action type and status.
	 *
	 * @param string $action_type The action type.
	 * @param string $status      The status.
	 *
	 * @return array
	 */
	public function getRecordIds( $action_type, $status ) {
		$actions = $this->groupedBulkActions();

		if ( empty( $action_type ) || empty( $actions[ $action_type ] ) ) {
			return [];
		}

		$action_data = $actions[ $action_type ] ?? [];
		$record_ids  = $action_data[ $status . '_record_ids' ] ?? [];

		return $record_ids;
	}
}
