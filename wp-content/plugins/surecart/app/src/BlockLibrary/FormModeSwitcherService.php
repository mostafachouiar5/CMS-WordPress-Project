<?php

declare(strict_types=1);

namespace SureCart\BlockLibrary;

/**
 * Provide general block-related functionality.
 */
class FormModeSwitcherService {
	/**
	 * Whether the ui has been rendered.
	 *
	 * @var bool
	 */
	protected $rendered = false;

	/**
	 * The mode.
	 *
	 * @var string
	 */
	protected $mode = 'live';

	/**
	 * Bootstrap the service.
	 *
	 * @return void
	 */
	public function bootstrap(): void {
		// add the admin bar menu.
		add_action( 'admin_bar_menu', [ $this, 'addAdminBarMenu' ], 99 );
		// add the script to confirm changing the cart.
		add_action( 'wp_after_admin_bar_render', [ $this, 'confirmScript' ] );
	}

	/**
	 * Get the menu title.
	 *
	 * @return string
	 */
	public function getMenuTitle() {
		ob_start(); ?>

		<span style="color: #fff;">
				<?php echo esc_html__( 'Checkout Form', 'surecart' ); ?>
		</span>
		<span style="color: <?php echo 'live' === $this->mode ? 'var(--sc-color-success-900, #21382a)' : 'var(--sc-color-warning-900, #4d3d11)'; ?>; display: inline-block; background-color: <?php echo 'live' === $this->mode ? 'var(--sc-color-success-400, #49de80)' : 'var(--sc-color-warning-400, #fbbf24)'; ?>; font-size: 10px; line-height: 1; border-radius: 999px; padding: 3px 6px; margin: 0 5px; text-transform: uppercase; font-weight: bold; vertical-align: text-bottom;">
				<?php echo 'live' === $this->mode ? esc_html__( 'Live Mode', 'surecart' ) : esc_html__( 'Test Mode', 'surecart' ); ?>
		</span>

		<?php
		return ob_get_clean();
	}

	/**
	 * Get the menu item.
	 *
	 * @param string $mode The mode.
	 *
	 * @return string
	 */
	public function getMenuItem( $mode = 'live' ) {
		ob_start();
		?>
		<span style="display: flex; justify-content: space-between;">
			<span>
				<span style="color: <?php echo 'live' === $mode ? 'var(--sc-color-success-400, #21382a)' : 'var(--sc-color-warning-400, #4d3d11)'; ?>; font-weight: bold; font-size: 16px; line-height: 1;">• </span>
				<span style="color: <?php echo 'live' === $mode ? 'var(--sc-color-success-100, #49de80)' : 'var(--sc-color-warning-100, #fbbf24)'; ?>;">
				<?php echo 'live' === $mode ? esc_html__( 'Live Mode', 'surecart' ) : esc_html__( 'Test Mode', 'surecart' ); ?>
				</span>
			</span>
			<span>
			<?php echo $this->mode === $mode ? ' ✓' : ''; ?>
			</span>
		</span>
		<?php
		return ob_get_clean();
	}

	/**
	 * Add admin bar menu.
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar The admin bar.
	 *
	 * @return void
	 */
	public function addAdminBarMenu( $wp_admin_bar ): void {
		// We don't want to show this in admin area.
		if ( is_admin() ) {
			return;
		}

		// Don't render if its for a checkout persisted in the url.
		if ( ! empty( $_GET['checkout_id'] ) ) {
			return;
		}

		// The post must have a checkout form block.
		if( ! has_block( 'surecart/checkout-form', get_post() ) ) {
			return;
		}

		// The form post.
		$form_post = \SureCart::post()->getFormPost( get_post() );
		if ( empty( $form_post->post_content ) ) {
			return;
		}

		// Get the checkout form block.
		$checkout_form_block = wp_get_first_block( parse_blocks( $form_post->post_content ), 'surecart/form' );
		if ( empty( $checkout_form_block ) ) {
			return;
		}

		// get the mode from the block.
		$this->mode = $checkout_form_block['attrs']['mode'] ?? 'live';

		// build the url to change the mode.
		$url = add_query_arg(
			[
				'sc_checkout_change_mode' => $form_post->ID,
				'sc_checkout_post'        => get_the_ID(),
				'nonce'                   => wp_create_nonce( 'update_checkout_mode' ),
			],
			get_home_url( null, 'surecart/change-checkout-mode' )
		);

		// add the top level menu item.
		$wp_admin_bar->add_menu(
			[
				'id'    => 'sc_change_checkout_mode',
				'title' => $this->getMenuTitle(),
			]
		);

		// add the live mode menu item.
		$wp_admin_bar->add_menu(
			[
				'parent' => 'sc_change_checkout_mode',
				'id'     => 'sc_live_mode',
				'title'  => $this->getMenuItem( 'live' ),
				'href'   => 'live' === $this->mode ? '#' : $url,
			]
		);

		// add the test mode menu item.
		$wp_admin_bar->add_menu(
			[
				'parent' => 'sc_change_checkout_mode',
				'id'     => 'sc_test_mode',
				'title'  => $this->getMenuItem( 'test' ),
				'href'   => 'test' === $this->mode ? '#' : $url,
			],
		);

		// Mark as rendered.
		$this->rendered = true;
	}

	/**
	 * Confirm script.
	 *
	 * @return void
	 */
	public function confirmScript() {
		if ( ! $this->rendered ) {
			return;
		}

		$mode = 'test' === $this->mode ? esc_html__( 'live mode', 'surecart' ) : esc_html__( 'test mode', 'surecart' );

		// translators: %s: live mode or test mode.
		$message = sprintf( esc_html__( "Are you sure you want to change this form to %1\$s? \n\nThis will change the form to %2\$s for EVERYONE, and %3\$s cart contents will be used - your cart contents may not transfer.", 'surecart' ), $mode, $mode, $mode );
		?>

		<script>
			const items = document.querySelectorAll('#wp-admin-bar-sc_change_checkout_mode a:not([href="#"])');
			(items || []).forEach(item => {
				item.addEventListener('click', function(e) {
					if (!confirm('<?php echo esc_js( $message ); ?>')) {
						e.preventDefault();
					}
				})
			});
		</script>

			<?php
	}

	/**
	 * Get checkout form post.
	 *
	 * @return object|null
	 */
	public function getCheckoutFormPost() {
		$post = get_post();

		if ( ! $post ) {
			return null;
		}

		// Check post has block surecart/checkout-form and then check the attributes.
		$blocks = parse_blocks( $post->post_content );

		if ( ! has_block( 'surecart/checkout-form', $post ) ) {
			return null;
		}

		$checkout_form_block = wp_get_first_block( $blocks, 'surecart/checkout-form' );

		// Get the form post id.
		$checkout_form_post_id = $checkout_form_block['attrs']['id'] ?? null;

		if ( ! $checkout_form_post_id ) {
			return null;
		}

		return get_post( $checkout_form_post_id ) ?? null;
	}

	/**
	 * Get block from post.
	 *
	 * @param \WP_Post $checkout_form_post The checkout form post.
	 *
	 * @return array|null
	 */
	public function getBlockFromPost( $checkout_form_post ) {
		if ( ! $checkout_form_post ) {
			return null;
		}

		$checkout_form_inner_block = parse_blocks( $checkout_form_post->post_content );

		// Find the surecart/form block.
		return wp_get_first_block( $checkout_form_inner_block, 'surecart/form' );
	}
}
