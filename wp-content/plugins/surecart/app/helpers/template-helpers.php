<?php
/**
 * Returns the markup for the current template.
 *
 * @access private
 * @since 5.8.0
 *
 * @global string   $_wp_current_template_content
 * @global WP_Embed $wp_embed
 *
 * @return string Block template markup.
 */
function surecart_get_the_block_template_html( $template_content ) {
	global $wp_embed;

	if ( ! $template_content ) {
		if ( is_user_logged_in() ) {
			return '<h1>' . esc_html__( 'No matching template found', 'surecart' ) . '</h1>';
		}
		return;
	}

	$content = $wp_embed->run_shortcode( $template_content );
	$content = $wp_embed->autoembed( $content );
	$content = do_blocks( $content );
	$content = wptexturize( $content );
	$content = convert_smilies( $content );
	$content = shortcode_unautop( $content );
	$content = wp_filter_content_tags( $content, 'template' );
	$content = do_shortcode( $content );
	$content = str_replace( ']]>', ']]&gt;', $content );

	// Wrap block template in .wp-site-blocks to allow for specific descendant styles
	// (e.g. `.wp-site-blocks > *`).
	return '<div class="wp-site-blocks">' . $content . '</div>';
}

/**
 * Prints a block template part.
 *
 * @since 5.9.0
 *
 * @param string $part The block template part to print.
 */
function sc_block_template_part( $part ) {
	// add surecart/surecart prefix.
	$template_part = get_block_template( $part, 'wp_template_part' );
	if ( ! $template_part || empty( $template_part->content ) ) {
		return;
	}
	echo do_blocks( $template_part->content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Prints a block template part.
 *
 * @since 5.9.0
 *
 * @param string $part The block template part to print.
 */
function sc_block_template( $part ) {
	$template_part = get_block_template( 'surecart/surecart//' . $part );
	if ( ! $template_part || empty( $template_part->content ) ) {
		return;
	}
	echo do_blocks( $template_part->content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
