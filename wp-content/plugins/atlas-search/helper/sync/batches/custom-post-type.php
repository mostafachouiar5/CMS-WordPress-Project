<?php

namespace Wpe_Content_Engine\Helper\Sync\Batches;

use ErrorException;
use WP_CLI;
use WP_Post;
use WP_Post_Type;
use WP_Query;
use Wpe_Content_Engine\Helper\Constants\Post_Status;
use Wpe_Content_Engine\Helper\Progress_Bar_Info_Trait;
use Wpe_Content_Engine\Helper\Multisite_Network_Sync;

class Custom_Post_Type extends Multisite_Network_Sync {

	use Progress_Bar_Info_Trait;

	/**
	 * @param int   $offset Offset.
	 * @param mixed $number Offset.
	 * @return WP_Post_Type[]
	 */
	protected function _get_items( $offset, $number ): array {
		$post_types = \AtlasSearch\Index\get_supported_custom_post_types();

		if ( empty( $post_types ) ) {
			return array();
		}

		$q   = array(
			'post_type'           => $post_types,
			'post_status'         => Post_Status::WP_PUBLISH,
			'posts_per_page'      => $number,
			'paged'               => $offset,
			'ignore_sticky_posts' => true,
		);
		$qry = new WP_Query( $q );

		return $qry->posts;
	}


	/**
	 * @param mixed $items Items.
	 * @param mixed $page Page.
	 */
	public function format_items( $items, $page ) {
		$o = array_column( $items, 'ID' );
		WP_CLI::log( WP_CLI::colorize( "%RSyncing Custom Post Type Data - Page:{$page} Ids:" . implode( ',', $o ) . '%n ' ) );
	}

	/**
	 * @return int
	 */
	public function get_total_items(): int {
		$post_types = \AtlasSearch\Index\get_supported_custom_post_types();
		if ( empty( $post_types ) ) {
			return 0;
		}
		$total_items = 0;
		foreach ( $post_types as $post_type ) {
			$total_items += (int) wp_count_posts( $post_type )->publish;
		}

		return $total_items;
	}
}
