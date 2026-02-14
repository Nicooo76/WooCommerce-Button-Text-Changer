<?php
/**
 * Admin-Einstellungen für WooCommerce Button Text Changer
 *
 * @package WooCommerce_Button_Text_Changer
 */

defined( 'ABSPATH' ) || exit;

/**
 * Klasse WCBTC_Admin
 */
final class WCBTC_Admin {

	const OPTION_GROUP = 'wc_button_text_options';

	/**
	 * Admin initialisieren.
	 */
	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	/**
	 * Einstellungsseite ins Menü einfügen.
	 */
	public static function add_menu(): void {
		add_options_page(
			__( 'WooCommerce Button Text', 'woocommerce-button-text-changer' ),
			__( 'WooCommerce Button Text', 'woocommerce-button-text-changer' ),
			'manage_options',
			'wc-button-text-changer',
			array( __CLASS__, 'render_settings_page' )
		);
	}

	/**
	 * Einstellungen registrieren (Settings API inkl. Sanitization).
	 */
	public static function register_settings(): void {
		register_setting(
			self::OPTION_GROUP,
			'wc_add_to_cart_text',
			array(
				'type'              => 'string',
				'default'           => __( 'In den Warenkorb', 'woocommerce-button-text-changer' ),
				'sanitize_callback' => array( __CLASS__, 'sanitize_button_text' ),
			)
		);

		register_setting(
			self::OPTION_GROUP,
			'wc_affiliate_button_text',
			array(
				'type'              => 'string',
				'default'           => __( 'Jetzt kaufen', 'woocommerce-button-text-changer' ),
				'sanitize_callback' => array( __CLASS__, 'sanitize_button_text' ),
			)
		);

		add_settings_section(
			'wcbtc_button_text_section',
			__( 'Button-Texte', 'woocommerce-button-text-changer' ),
			array( __CLASS__, 'render_section_description' ),
			'wc-button-text-changer'
		);

		add_settings_field(
			'wc_add_to_cart_text',
			__( '„In den Warenkorb“-Button', 'woocommerce-button-text-changer' ),
			array( __CLASS__, 'render_field_add_to_cart' ),
			'wc-button-text-changer',
			'wcbtc_button_text_section',
			array( 'label_for' => 'wc_add_to_cart_text' )
		);

		add_settings_field(
			'wc_affiliate_button_text',
			__( 'Affiliate-/Externe-Produkt-Button', 'woocommerce-button-text-changer' ),
			array( __CLASS__, 'render_field_affiliate' ),
			'wc-button-text-changer',
			'wcbtc_button_text_section',
			array( 'label_for' => 'wc_affiliate_button_text' )
		);
	}

	/**
	 * Button-Text sanitizen (max. 200 Zeichen, Strip-Tags).
	 *
	 * @param mixed $value Eingabewert.
	 * @return string
	 */
	public static function sanitize_button_text( $value ): string {
		$value = is_string( $value ) ? $value : '';
		$value = wp_strip_all_tags( $value );
		return mb_substr( $value, 0, 200 );
	}

	/**
	 * Beschreibung der Einstellungssektion ausgeben.
	 */
	public static function render_section_description(): void {
		echo '<p>' . esc_html__( 'Hier kannst du die Texte für die WooCommerce-Buttons anpassen. Leere Felder lassen den Standardtext von WooCommerce unverändert.', 'woocommerce-button-text-changer' ) . '</p>';
	}

	/**
	 * Feld „In den Warenkorb“ ausgeben.
	 */
	public static function render_field_add_to_cart(): void {
		$value = get_option( 'wc_add_to_cart_text', __( 'In den Warenkorb', 'woocommerce-button-text-changer' ) );
		?>
		<input type="text" id="wc_add_to_cart_text" name="wc_add_to_cart_text" value="<?php echo esc_attr( $value ); ?>" class="regular-text" maxlength="200" />
		<p class="description"><?php esc_html_e( 'Text für den „In den Warenkorb“-Button (normale Produkte).', 'woocommerce-button-text-changer' ); ?></p>
		<?php
	}

	/**
	 * Feld „Affiliate-Button“ ausgeben.
	 */
	public static function render_field_affiliate(): void {
		$value = get_option( 'wc_affiliate_button_text', __( 'Jetzt kaufen', 'woocommerce-button-text-changer' ) );
		?>
		<input type="text" id="wc_affiliate_button_text" name="wc_affiliate_button_text" value="<?php echo esc_attr( $value ); ?>" class="regular-text" maxlength="200" />
		<p class="description"><?php esc_html_e( 'Text für externe/Affiliate-Produkte (z. B. „Jetzt kaufen“).', 'woocommerce-button-text-changer' ); ?></p>
		<?php
	}

	/**
	 * Einstellungsseite rendern.
	 */
	public static function render_settings_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( self::OPTION_GROUP );
				do_settings_sections( 'wc-button-text-changer' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
