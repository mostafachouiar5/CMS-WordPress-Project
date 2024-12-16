<?php
/**
 * @package   SureCartAppCore
 * @author    SureCart <support@surecart.com>
 * @copyright  SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com
 */

namespace SureCart\WordPress;

/**
 * Main communication channel with the theme.
 */
class ActionsService {
	/**
	 * Broadcast the php hook.
	 * This sets the a transient so that it is not accidentally broadcasted twice.
	 *
	 * @param string          $event Event name.
	 * @param \SureCart\Model $model Model.
	 *
	 * @return void
	 */
	public function doOnce( $event, $model ) {
		$action = get_transient( 'surecart_action_' . $event . $model->id, false );
		if ( false === $action ) {
			// perform the action.
			do_action( $event, $model );
			set_transient( 'surecart_action_' . $event . $model->id, true, MINUTE_IN_SECONDS );
		}
		return $this;
	}

	/**
	 * Clear any previous action.
	 *
	 * @param string          $event Event name.
	 * @param \SureCart\Model $model Model.
	 *
	 * @return void
	 */
	public function clear( $event, $model ) {
		delete_transient( 'surecart_action_' . $event . $model->id );
		return $this;
	}
}
