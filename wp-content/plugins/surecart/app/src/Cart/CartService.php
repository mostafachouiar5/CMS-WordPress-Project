<?php

namespace SureCart\Cart;

use SureCart\Models\Form;

/**
 * The cart service.
 */
class CartService {
	/**
	 * Bootstrap the cart.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_filter( 'wp_nav_menu_items', array( $this, 'addCartMenu' ), 10, 2 );

		// only load scripts if cart is enabled.
		if ( $this->isCartEnabled() ) {
			add_action(
				'wp_enqueue_scripts',
				function () {
					// Enqueue the cart drawer script modules.
					wp_enqueue_script_module( '@surecart/cart' );
					wp_enqueue_script_module( '@surecart/checkout' );
				}
			);

			add_action( 'wp_footer', [ $this, 'renderCartComponent' ] );
		}
	}

	/**
	 * Get the icon name saved in the settings
	 *
	 * @return string
	 */
	public function getIconNameFromSettings() {
		return get_option( 'surecart_cart_icon', 'shopping-bag' );
	}

	/**
	 * Get the icon.
	 *
	 * @param 'menu'|'floating' $type Menu type.
	 *
	 * @return string
	 */
	public function getIcon( $type ) {
		$icon = $this->getIconNameFromSettings();

		/**
		 * Allow filtering of the cart menu icon.
		 *
		 * @param string $icon The icon.
		 * @param string $mode The icon position.
		 */
		return apply_filters( 'sc_cart_menu_icon', $icon, $type );
	}


	/**
	 * Get selected ids.
	 *
	 * @return array|false
	 */
	public function getSelectedIds() {
		return get_option( 'surecart_cart_menu_selected_ids', false );
	}

	/**
	 * Get icon type.
	 *
	 * @return array|false
	 */
	public function getIconType() {
		return get_option( 'surecart_cart_icon_type', 'floating_icon' );
	}

	/**
	 * Check if cart menu is always shown.
	 *
	 * @return boolean
	 */
	public function isAlwaysShown() {
		return (bool) get_option( 'surecart_cart_menu_always_shown', true );
	}

	/**
	 * Is the cart enabled?
	 */
	public function isCartEnabled() {
		return ! (bool) get_option( 'sc_slide_out_cart_disabled', false );
	}

	/**
	 * Get cart menu alignment.
	 *
	 * @return 'left'|'right
	 */
	public function getAlignment() {
		return (string) get_option( 'surecart_cart_menu_alignment', 'right' );
	}

	/**
	 * Get mode.
	 *
	 * @return string
	 */
	public function getMode() {
		$form = $this->getForm();
		if ( empty( $form->ID ) ) {
			return '';
		}

		return Form::getMode( $form->ID );
	}

	/**
	 * Add cart to menu.
	 *
	 * @param array  $items Menu items.
	 * @param object $args Menu args.
	 *
	 * @return array
	 */
	public function addCartMenu( $items, $args ) {
		$menu = wp_get_nav_menu_object( $args->menu );
		$id   = $menu ? $menu->term_id : false;

		// if there is no id, or the menu icon is not enabled, or the cart is disabled, return.
		if ( ! $id || ! $this->isMenuIconEnabled( $id ) || ! $this->isCartEnabled() ) {
			return $items;
		}

		$cart_menu_alignment = $this->getAlignment();

		$menu = $this->menuItemTemplate();

		// left or right.
		$items = 'right' === $cart_menu_alignment ? $items . $menu : $menu . $items;

		return $items;
	}

	public function menuItemTemplate() {
		$cart_menu_icon_attributes    = [
			'cart_menu_always_shown' => $this->isAlwaysShown(),
			'cart_icon'              => $this->getIcon( 'menu' ) ?? 'shopping-bag',
		];
		$cart_menu_icon_block_content = '<!-- wp:surecart/cart-menu-icon-button ' . wp_json_encode( $cart_menu_icon_attributes ) . ' /-->';

		ob_start(); ?>
			<li class='menu-item'>
				<?php echo do_blocks( $cart_menu_icon_block_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</li>
		<?php
		return ob_get_clean();
	}

	/**
	 * Get the cart template.
	 *
	 * @return string
	 */
	public function cartTemplate() {
		$form = $this->getForm();
		if ( empty( $form->ID ) ) {
			return '';
		}

		// get cart block.
		$template = get_block_template( 'surecart/surecart//cart', 'wp_template_part' );
		if ( ! $template || empty( $template->content ) ) {
			return;
		}

		$cart_icon_block_content = '<!-- wp:surecart/cart-icon /-->';

		ob_start();
		?>

		<!-- Render the cart. -->
		<?php echo do_blocks( $template->content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<!-- Render floating cart icon -->
		<?php if ( $this->isFloatingIconEnabled() ) : ?>
			<?php echo do_blocks( $cart_icon_block_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>

		<?php
		return trim( preg_replace( '/\s+/', ' ', ob_get_clean() ) );
	}

	/**
	 * Render the cart components.
	 *
	 * @return void
	 */
	public function renderCartComponent() {
		$form = $this->getForm();
		if ( empty( $form->ID ) ) {
			return;
		}

		echo $this->cartTemplate();
	}

	/**
	 * Get the form post.
	 *
	 * @return \WP_Post The default form post.
	 */
	public function getForm() {
		return \SureCart::forms()->getDefault();
	}

	/**
	 * Check if floating cart icon is enabled
	 *
	 * @return string
	 */
	public function isFloatingIconEnabled() {
		// If we have a checkout form block or shortcode, don't render the cart.
		$object = get_queried_object();

		if ( is_a( $object, \WP_Post::class ) ) {
			$block = wp_get_first_block( parse_blocks( $object->post_content ), 'surecart/checkout-form' ) || has_shortcode( $object->post_content, 'sc_form' );
			if ( ! empty( $block ) ) {
				return false;
			}
		}

		$cart_icon_type = (string) get_option( 'surecart_cart_icon_type', 'floating_icon' );
		return in_array( $cart_icon_type, array( 'floating_icon', 'both' ) );
	}

	/**
	 * Check if menu cart icon is enabled
	 *
	 * @param integer $term_id Term ID.
	 * @return bool
	 */
	public function isMenuIconEnabled( $term_id ) {
		$cart_menu_ids  = (array) $this->getSelectedIds();
		$cart_icon_type = (string) $this->getIconType();
		if ( ! in_array( $cart_icon_type, array( 'menu_icon', 'both' ) ) ) {
			return;
		}
		return in_array( $term_id, $cart_menu_ids );
	}

	/**
	 * Remove deprecated cart content.
	 *
	 * @param string $content Cart content.
	 *
	 * @return string
	 */
	public static function removeDeprecatedCartContent( $content ) {
		$review_cart_present = strpos( $content, 'wp:surecart/slide-out-cart-header {"text":"Review Your Cart"' );
		$my_cart_present     = strpos( $content, '<sc-cart-header><span>My Cart</span></sc-cart-header>' );

		if ( false !== $review_cart_present && false !== $my_cart_present ) {
			$content = str_replace( '<sc-cart-header><span>My Cart</span></sc-cart-header>', '<sc-cart-header><span>Review Your Cart</span></sc-cart-header>', $content );
		}

		return $content;
	}
}
