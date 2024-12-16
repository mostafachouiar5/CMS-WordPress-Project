<?php

namespace SureCart\Background;

/**
 * SureCart Queue
 *
 * A job queue using WordPress actions.
 */
class QueueService {
	/**
	 * Enqueue an action to run one time, as soon as possible
	 *
	 * @param string $hook The hook to trigger.
	 * @param array  $args Arguments to pass when the hook triggers.
	 * @param string $group The group to assign this job to.
	 * @param bool   $unique If true, ensure this action is not already scheduled.
	 *
	 * @return string $this.
	 */
	public function async( $hook, $args = array(), $group = '', $unique = false ) {
		\as_enqueue_async_action( $hook, $args, $group, $unique );
		return $this;
	}

	/**
	 * Schedule an action to run once at some time in the future
	 *
	 * @param int    $timestamp When the job will run.
	 * @param string $hook The hook to trigger.
	 * @param array  $args Arguments to pass when the hook triggers.
	 * @param string $group The group to assign this job to.
	 * @return string $this.
	 */
	public function scheduleSingle( $timestamp, $hook, $args = array(), $group = '' ) {
		\as_schedule_single_action( $timestamp, $hook, $args, $group );
		return $this;
	}

	/**
	 * Schedule a recurring action
	 *
	 * @param int    $timestamp When the first instance of the job will run.
	 * @param int    $interval_in_seconds How long to wait between runs.
	 * @param string $hook The hook to trigger.
	 * @param array  $args Arguments to pass when the hook triggers.
	 * @param string $group The group to assign this job to.
	 * @return string $this.
	 */
	public function scheduleRecurring( $timestamp, $interval_in_seconds, $hook, $args = array(), $group = '' ) {
		\as_schedule_recurring_action( $timestamp, $interval_in_seconds, $hook, $args, $group );
		return $this;
	}

	/**
	 * Schedule an action that recurs on a cron-like schedule.
	 *
	 * @param int    $timestamp The schedule will start on or after this time.
	 * @param string $cron_schedule A cron-link schedule string.
	 * @see http://en.wikipedia.org/wiki/Cron
	 *   *    *    *    *    *    *
	 *   ┬    ┬    ┬    ┬    ┬    ┬
	 *   |    |    |    |    |    |
	 *   |    |    |    |    |    + year [optional]
	 *   |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
	 *   |    |    |    +---------- month (1 - 12)
	 *   |    |    +--------------- day of month (1 - 31)
	 *   |    +-------------------- hour (0 - 23)
	 *   +------------------------- min (0 - 59)
	 * @param string $hook The hook to trigger.
	 * @param array  $args Arguments to pass when the hook triggers.
	 * @param string $group The group to assign this job to.
	 * @return string $this
	 */
	public function scheduleCron( $timestamp, $cron_schedule, $hook, $args = array(), $group = '' ) {
		\as_schedule_cron_action( $timestamp, $cron_schedule, $hook, $args, $group );
		return $this;
	}

	/**
	 * Dequeue the next scheduled instance of an action with a matching hook (and optionally matching args and group).
	 *
	 * Any recurring actions with a matching hook should also be cancelled, not just the next scheduled action.
	 *
	 * While technically only the next instance of a recurring or cron action is unscheduled by this method, that will also
	 * prevent all future instances of that recurring or cron action from being run. Recurring and cron actions are scheduled
	 * in a sequence instead of all being scheduled at once. Each successive occurrence of a recurring action is scheduled
	 * only after the former action is run. As the next instance is never run, because it's unscheduled by this function,
	 * then the following instance will never be scheduled (or exist), which is effectively the same as being unscheduled
	 * by this method also.
	 *
	 * @param string $hook The hook that the job will trigger.
	 * @param array  $args Args that would have been passed to the job.
	 * @param string $group The group the job is assigned to (if any).
	 */
	public function cancel( $hook, $args = array(), $group = '' ) {
		\as_unschedule_action( $hook, $args, $group );
		return $this;
	}

	/**
	 * Dequeue all actions with a matching hook (and optionally matching args and group) so no matching actions are ever run.
	 *
	 * @param string $hook The hook that the job will trigger.
	 * @param array  $args Args that would have been passed to the job.
	 * @param string $group The group the job is assigned to (if any).
	 */
	public function cancelAll( $hook, $args = array(), $group = '' ) {
		\as_unschedule_all_actions( $hook, $args, $group );
		return $this;
	}

	/**
	 * Get the date and time for the next scheduled occurrence of an action with a given hook
	 * (an optionally that matches certain args and group), if any.
	 *
	 * @param string $hook The hook that the job will trigger.
	 * @param array  $args Filter to a hook with matching args that will be passed to the job when it runs.
	 * @param string $group Filter to only actions assigned to a specific group.
	 * @return DateTime|null The date and time for the next occurrence, or null if there is no pending, scheduled action for the given hook.
	 */
	public function getNext( $hook, $args = null, $group = '' ) {
		return as_next_scheduled_action( $hook, $args, $group );
	}

	/**
	 * Get the date and time for the next scheduled occurrence of an action with a given hook
	 * (an optionally that matches certain args and group), if any.
	 *
	 * @param string $hook The hook that the job will trigger.
	 * @param array  $args Filter to a hook with matching args that will be passed to the job when it runs.
	 * @param string $group Filter to only actions assigned to a specific group.
	 * @return DateTime|null The date and time for the next occurrence, or null if there is no pending, scheduled action for the given hook.
	 */
	public function getNextDate( $hook, $args = null, $group = '' ) {
		$next_timestamp = as_next_scheduled_action( $hook, $args, $group );

		if ( is_numeric( $next_timestamp ) ) {
			return new \DateTime( "@{$next_timestamp}", new \DateTimeZone( 'UTC' ) );
		}

		return null;
	}


	/**
	 * Check if there is a scheduled action in the queue but more efficiently than as_next_scheduled_action().
	 *
	 * It's recommended to use this function when you need to know whether a specific action is currently scheduled
	 * (pending or in-progress).
	 *
	 * @since 3.3.0
	 *
	 * @param string $hook  The hook of the action.
	 * @param array  $args  Args that have been passed to the action. Null will matches any args.
	 * @param string $group The group the job is assigned to.
	 *
	 * @return bool True if a matching action is pending or in-progress, false otherwise.
	 */
	public function isScheduled( $hook, $args = null, $group = '' ) {
		return \as_has_scheduled_action( $hook, $args, $group );
	}

	/**
	 * Shold we show a migration notice?
	 *
	 * @param string $hook The hook that the job will trigger.
	 * @param array  $args Args that have been passed to the action. Null will matches any args.
	 * @param string $group The group the job is assigned to.
	 *
	 * @return bool
	 */
	public function showNotice( $hook, $args = null, $group = '' ) {
		// no scheduled actions (this is quicker for us to check).
		$has_action = \as_has_scheduled_action( $hook, $args, $group );
		if ( ! $has_action ) {
			return false;
		}

		$next_action = as_get_scheduled_actions(
			[
				'hook'     => $hook,
				'status'   => \ActionScheduler_Store::STATUS_PENDING,
				'per_page' => 1,
			],
		);

		if ( empty( $next_action ) || ! is_array( $next_action ) ) {
			return false;
		}

		// find out if any actions get_args() has 'show_notice' => true.
		$show_notice = false;
		foreach ( $next_action as $action ) {
			$args = $action->get_args();
			if ( isset( $args['show_notice'] ) && ! empty( $args['show_notice'] ) ) {
				$show_notice = true;
				break;
			}
		}

		return $show_notice;
	}

	/**
	 * Check if there are any failed actions for a given hook and group.
	 *
	 * @param string $hook The hook that the job will trigger.
	 * @param string $group The group the job is assigned to (if any).
	 * @return bool True if there are any failed actions, false otherwise.
	 */
	public function hasFailedActions( $hook, $group = '' ) {
		$args = [
			'hook'     => $hook,
			'group'    => $group,
			'status'   => \ActionScheduler_Store::STATUS_FAILED,
			'per_page' => 1, // We only need to know if at least one exists.
		];

		$failed_actions = $this->search( $args, 'ids' );

		return ! empty( $failed_actions );
	}

	/**
	 * Find scheduled actions
	 *
	 * @param array  $args Possible arguments, with their default values:
	 *        'hook' => '' - the name of the action that will be triggered
	 *        'args' => null - the args array that will be passed with the action
	 *        'date' => null - the scheduled date of the action. Expects a DateTime object, a unix timestamp, or a string that can parsed with strtotime(). Used in UTC timezone.
	 *        'date_compare' => '<=' - operator for testing "date". accepted values are '!=', '>', '>=', '<', '<=', '='
	 *        'modified' => null - the date the action was last updated. Expects a DateTime object, a unix timestamp, or a string that can parsed with strtotime(). Used in UTC timezone.
	 *        'modified_compare' => '<=' - operator for testing "modified". accepted values are '!=', '>', '>=', '<', '<=', '='
	 *        'group' => '' - the group the action belongs to
	 *        'status' => '' - ActionScheduler_Store::STATUS_COMPLETE or ActionScheduler_Store::STATUS_PENDING
	 *        'claimed' => null - TRUE to find claimed actions, FALSE to find unclaimed actions, a string to find a specific claim ID
	 *        'per_page' => 5 - Number of results to return
	 *        'offset' => 0
	 *        'orderby' => 'date' - accepted values are 'hook', 'group', 'modified', or 'date'
	 *        'order' => 'ASC'.
	 *
	 * @param string $return_format OBJECT, ARRAY_A, or ids.
	 * @return array
	 */
	public function search( $args = array(), $return_format = OBJECT ) {
		return \as_get_scheduled_actions( $args, $return_format );
	}

	/**
	 * Start running the queue immediately.
	 *
	 * @return void
	 */
	public function run() {
		$identifier = 'as_async_request_queue_runner';

		// make an async request to run the queue.
		wp_remote_post(
			esc_url_raw(
				add_query_arg(
					[
						'action' => $identifier,
						'nonce'  => wp_create_nonce( $identifier ),
					],
					admin_url( 'admin-ajax.php' )
				)
			),
			array(
				'timeout'   => 0.01,
				'blocking'  => false,
				'cookies'   => $_COOKIE,
				'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
			)
		);
	}
}
