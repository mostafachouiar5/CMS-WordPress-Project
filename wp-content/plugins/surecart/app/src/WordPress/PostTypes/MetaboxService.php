<?php

namespace SureCart\WordPress\PostTypes;

/**
 * Meta Box Service.
 */
class MetaboxService {
	/**
	 * Locations
	 *
	 * @var array
	 */
	protected $locations = array( 'side', 'normal', 'advanced' );

	/**
	 * Priorities
	 *
	 * @var array
	 */
	protected $priorities = array( 'high', 'core', 'default', 'low' );

	/**
	 * Register meta boxes.
	 *
	 * @return void
	 */
	public function register() {
		global $post, $current_screen, $typenow;

		/**
		 * Fires once all needed post type meta boxes have been registered.
		 */
		do_action( 'load-post.php' );

		/**
		 * Fires after all built-in meta boxes have been added.
		 *
		 * @since 3.0.0
		 *
		 * @param string  $post_type Post type.
		 * @param WP_Post $post      Post object.
		 */
		do_action( 'add_meta_boxes', $post->post_type, $post );

		/**
		 * Fires after all built-in meta boxes have been added, contextually for the given post type.
		 *
		 * The dynamic portion of the hook name, `$post_type`, refers to the post type of the post.
		 *
		 * Possible hook names include:
		 *
		 *  - `add_meta_boxes_post`
		 *  - `add_meta_boxes_page`
		 *  - `add_meta_boxes_attachment`
		 *
		 * @since 3.0.0
		 *
		 * @param WP_Post $post Post object.
		 */
		do_action( "add_meta_boxes_{$post->post_type}", $post );

		/**
		 * Fires after meta boxes have been added.
		 *
		 * Fires once for each of the default meta box contexts: normal, advanced, and side.
		 *
		 * @since 3.0.0
		 *
		 * @param string                $post_type Post type of the post on Edit Post screen, 'link' on Edit Link screen,
		 *                                         'dashboard' on Dashboard screen.
		 * @param string                $context   Meta box context. Possible values include 'normal', 'advanced', 'side'.
		 * @param WP_Post|object|string $post      Post object on Edit Post screen, link object on Edit Link screen,
		 *                                         an empty string on Dashboard screen.
		 */
		do_action( 'do_meta_boxes', $post->post_type, 'normal', $post );
		/** This action is documented in wp-admin/includes/meta-boxes.php */
		do_action( 'do_meta_boxes', $post->post_type, 'advanced', $post );
		/** This action is documented in wp-admin/includes/meta-boxes.php */
		do_action( 'do_meta_boxes', $post->post_type, 'side', $post );

		/** Set the current screen for metaboxes */
		$current_screen = convert_to_screen( $post->post_type ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		/** Set the typenow. */
		$typenow = $post->post_type; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	}

	/**
	 * Render meta boxes.
	 *
	 * @return void
	 */
	public function render() {
		global $current_screen, $post;
		?>
		<form class="metabox-base-form">
			<?php the_block_editor_meta_box_post_form_hidden_fields( $post ); ?>
		</form>
		<form id="toggle-custom-fields-form" method="post" action="<?php echo esc_url( admin_url( 'post.php' ) ); ?>">
			<?php wp_nonce_field( 'toggle-custom-fields', 'toggle-custom-fields-nonce' ); ?>
			<input type="hidden" name="action" value="toggle-custom-fields" />
		</form>
			<?php foreach ( $this->locations as $location ) : ?>
			<form class="metabox-location-<?php echo esc_attr( $location ); ?>" onsubmit="return false;">
				<div id="poststuff" class="sidebar-open">
					<div id="postbox-container-2" class="postbox-container">
						<?php
						do_meta_boxes(
							$current_screen,
							$location,
							$post
						);
						?>
					</div>
				</div>
			</form>
		<?php endforeach; ?>
		<?php
	}

	/**
	 * Get meta boxes per location.
	 */
	public function perLocation() {
		global $current_screen, $wp_meta_boxes;

		$meta_boxes_per_location = array();

		foreach ( $this->locations as $location ) {
			$meta_boxes_per_location[ $location ] = array();

			if ( ! isset( $wp_meta_boxes[ $current_screen->id ][ $location ] ) ) {
				continue;
			}

			foreach ( $this->priorities as $priority ) {
				if ( ! isset( $wp_meta_boxes[ $current_screen->id ][ $location ][ $priority ] ) ) {
					continue;
				}

				$meta_boxes = (array) $wp_meta_boxes[ $current_screen->id ][ $location ][ $priority ];
				foreach ( $meta_boxes as $meta_box ) {
					if ( false == $meta_box || ! $meta_box['title'] ) {
						continue;
					}

					// If a meta box is just here for back compat, don't show it in the block editor.
					if ( isset( $meta_box['args']['__back_compat_meta_box'] ) && $meta_box['args']['__back_compat_meta_box'] ) {
						continue;
					}

					$meta_boxes_per_location[ $location ][] = array(
						'id'    => $meta_box['id'],
						'title' => $meta_box['title'],
					);
				}
			}
		}

		return $meta_boxes_per_location;
	}
}
