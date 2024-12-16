<?php

if ( ! defined( 'WP_CLI' ) ) {
	return;
}

use Wpe_Content_Engine\WPSettings;

/**
 * Implements example command.
 */
class Wpe_Content_Engine_Sync_Data {
	private $start_time;
	/**
	 * Syncs all data to Smart Search.
	 *
	 * ## EXAMPLES
	 *    wp wpe-smart-search sync-data
	 *    or
	 *    wp wpe-smart-search sync-data --reset
	 *
	 * [--reset]
	 * : Clear all data before sync
	 * default: false
	 *
	 * [--site-id]
	 * : Site ID to sync data for
	 * default: current site or network admin if in multi-site mode
	 * options: <site-id> | network
	 *
	 * @subcommand sync-data
	 * @when after_wp_load
	 *
	 * @param array $args    Command arguments.
	 * @param array $assoc_args Command associative arguments.
	 */
	public function _sync_data( $args, $assoc_args ) {
		try {
			$this->start_time = time();
			$client           = new \Wpe_Content_Engine\Helper\Sync\GraphQL\Client( Wpe_Content_Engine::get_plugin_name(), Wpe_Content_Engine::get_version() );
			$controller       = new \Wpe_Content_Engine\Helper\API\Sync_Data\Sync_Data_Controller( $client, new WPSettings() );

			$reset = $assoc_args['reset'] ?? false;
			if ( $reset ) {
				WP_CLI::line( 'Clearing all data.' );
				$result = $controller->delete_sync_data( new WP_REST_Request( 'DELETE' ) );
				if ( 200 !== $result->status ) {
					WP_CLI::error( 'Failed to clear data.' );
				}
				WP_CLI::line( $result->data['message'] );
			}

			$site_id_arg = $assoc_args['site-id'] ?? false;
			$site_id     = $this->parse_site_id( $site_id_arg );
			$uuid        = '';
			/**
			 * @var \Wpe_Content_Engine\Helper\API\Sync_Data\Response $result
			 */
			$result = $this->perform_index( $controller, $uuid, $site_id );

			$this->display_progress( $result->message ?? '', $result->progress, 100 );

			while ( \Wpe_Content_Engine\Helper\Constants\Sync_Response_Status::PENDING === $result->status ) {
				$result = $this->perform_index( $controller, $result->uuid, $site_id );
				if ( \Wpe_Content_Engine\Helper\Constants\Sync_Response_Status::COMPLETED === $result->status ) {
					break;
				} else {
					$this->display_progress( $result->message ?? '', $result->progress, 100 );

				}
			}
			WP_CLI::log( "\r\nIndexing completed!" );
		} catch ( \Exception $e ) {
			WP_CLI::error( $e->getMessage() );
		}
	}

	private function perform_index( $controller, $uuid, $site_id ) {
		$rest_request = new WP_REST_Request( 'POST', '/wpe-content-engine/v1/sync-data' );
			$rest_request->set_body(
				wp_json_encode(
					array(
						'uuid'   => $uuid,
						'siteId' => $site_id,
					)
				)
			);
			$rest_request->set_headers(
				array(
					'Content-Type' => 'application/json',
				),
			);
			return $controller->sync_data( $rest_request );
	}

	private function parse_site_id( $site_id ) {
		if ( 'network' === $site_id ) {
			return \AtlasSearch\Support\WordPress\NETWORK_ADMIN;
		} elseif ( $site_id ) {
			return $site_id;
		} elseif ( is_multisite() ) {
			return \AtlasSearch\Support\WordPress\NETWORK_ADMIN;
		} else {
			return (string) get_current_blog_id();
		}
	}

	private function display_progress( string $message, int $current, int $total, int $length = 50 ) {
		if ( 0 === $current ) {
			$current = 1;
		}

		$percent = floor( ( $current * 100 ) / $total );

		$output = sprintf(
			"  %s%% | %s\r",
			esc_html( $percent ),
			esc_html( $message . str_repeat( ' ', 20 ) ),
		);
		WP_CLI::log( $output );
	}

}

WP_CLI::add_command( 'wpe-smart-search', 'Wpe_Content_Engine_Sync_Data' );
