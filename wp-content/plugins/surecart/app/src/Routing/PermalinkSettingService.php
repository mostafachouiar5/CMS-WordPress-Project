<?php
namespace SureCart\Routing;

/**
 * A service for handling permalink settings on the permalinks page.
 */
class PermalinkSettingService {
	/**
	 * The slug of the setting.
	 *
	 * @var string
	 */
	protected $slug = '';

	/**
	 * The label of the setting.
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * The label of the setting.
	 *
	 * @var string
	 */
	protected $label = '';

	/**
	 * The permalinks for the setting.
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * Currently saved base.
	 *
	 * @var string
	 */
	protected $current_base = '';

	/**
	 * The option key.
	 *
	 * @var string
	 */
	protected $option_key = '';

	/**
	 * Last part of the permalink. This is used to generate the preview.
	 *
	 * @var string
	 */
	protected $sample_preview_text = '';

	/**
	 * Build the permalink setting.
	 *
	 * @param array $args The arguments.
	 */
	public function __construct( $args = [] ) {
		$this->slug                = $args['slug'] ?? '';
		$this->label               = $args['label'] ?? '';
		$this->description         = $args['description'] ?? '';
		$this->options             = $args['options'] ?? [];
		$this->current_base        = \SureCart::settings()->permalinks()->getBase( "{$this->slug}_page" );
		$this->sample_preview_text = $args['sample_preview_text'] ?? 'sample-product';
	}

	/**
	 * Boostrap settings.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'admin_init', [ $this, 'addSettingsSection' ] );
		add_action( 'admin_init', [ $this, 'maybeSaveSettings' ] );
	}

	/**
	 * Add sections to permalinks page.
	 */
	public function addSettingsSection() {
		add_settings_section( "surecart-$this->slug-permalink", $this->label, [ $this, 'settings' ], 'permalink' );
	}

	/**
	 * Display the settings.
	 */
	public function settings() {
		echo wp_kses_post( wpautop( $this->description ) );

		$values = array_values(
			array_map(
				function( $permalink ) {
					return $permalink['value'];
				},
				$this->options
			)
		);
		?>

		<table class="form-table sc-<?php echo esc_attr( $this->slug ); ?>-permalink-structure">
			<tbody>
				<?php foreach ( $this->options as $permalink ) : ?>
				<tr>
					<th><label><input name="sc_<?php echo esc_attr( $this->slug ); ?>_permalink" type="radio" value="<?php echo esc_attr( $permalink['value'] ); ?>" class="sc-tog-<?php echo esc_attr( $this->slug ); ?>" <?php checked( $permalink['value'], $this->current_base ); ?> /> <?php echo esc_html( $permalink['label'] ); ?></label></th>
					<td><code><?php echo esc_html( home_url() ); ?>/<?php echo esc_attr( $permalink['value'] ); ?>/<?php echo esc_attr( $this->sample_preview_text ); ?>/</code></td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<th>
						<label>
							<input
								name="sc_<?php echo esc_attr( $this->slug ); ?>_permalink"
								id="surecart_<?php echo esc_attr( $this->slug ); ?>_custom_selection"
								type="radio"
								value="custom"
								class="tog"
								<?php
									checked(
										in_array(
											$this->current_base,
											array_map(
												function( $opt ) {
													return $opt['value'];
												},
												$this->options
											),
											true
										),
										false
									);
								?>
							 />
							<?php esc_html_e( 'Custom base', 'surecart' ); ?>
						</label>
					</th>
					<td>
						<input name="sc_<?php echo esc_attr( $this->slug ); ?>_permalink_structure" id="surecart_<?php echo esc_attr( $this->slug ); ?>_permalink_structure" type="text" value="<?php echo esc_attr( ! in_array( $this->current_base, [ $values ], true ) ? untrailingslashit( $this->current_base ) : '' ); ?>" class="regular-text code"> <span class="description"><?php esc_html_e( 'Enter a custom base to use. A base must be set or WordPress will use default instead.', 'surecart' ); ?></span>
					</td>
				</tr>
			</tbody>
		</table>

		<?php wp_nonce_field( 'surecart-permalinks', 'surecart-permalinks-nonce' ); ?>

		<script>
			jQuery( function() {
				jQuery('input.sc-tog-<?php echo esc_attr( $this->slug ); ?>').on( 'change', function() {
					jQuery('#surecart_<?php echo esc_attr( $this->slug ); ?>_permalink_structure').val( jQuery( this ).val() );
				});
				jQuery('.sc-<?php echo esc_attr( $this->slug ); ?>-permalink-structure input:checked').trigger( 'change' );
				jQuery('#surecart_<?php echo esc_attr( $this->slug ); ?>_permalink_structure').on( 'focus', function(){
					jQuery('#surecart_<?php echo esc_attr( $this->slug ); ?>_custom_selection').trigger( 'click' );
				} );
			} );
		</script>
		<?php
	}

	/**
	 * Save the settings.
	 */
	public function maybeSaveSettings() {
		if ( ! is_admin() ) {
			return;
		}

		$structure_key = 'sc_' . esc_attr( $this->slug ) . '_permalink_structure';
		$permalink_key = 'sc_' . esc_attr( $this->slug ) . '_permalink';

		// we must have our permalink post data and nonce.
		if ( ! isset( $_POST[ $structure_key ], $_POST[ $permalink_key ] ) || ! wp_verify_nonce( wp_unslash( $_POST['surecart-permalinks-nonce'] ), 'surecart-permalinks' ) ) { // WPCS: input var ok, sanitization ok.
			return;
		}

		// get the buy base.
		$page        = isset( $_POST[ $permalink_key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $permalink_key ] ) ) : '';
		$page_struct = isset( $_POST[ $structure_key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $structure_key ] ) ) : '';

		if ( 'custom' === $page ) {
			$page = ! empty( $_POST[ $structure_key ] ) ? preg_replace( '#/+#', '/', '/' . str_replace( '#', '', trim( wp_unslash( $_POST[ $structure_key ] ) ) ) ) : $this->options[0]['value']; // WPCS: input var ok, sanitization ok.
		} elseif ( empty( $page ) ) {
			$page = $this->options[0]['value'];
		}

		\SureCart::settings()->permalinks()->updatePermalinkSettings( $this->slug . '_page', sanitize_title( $page ) );
	}

}
