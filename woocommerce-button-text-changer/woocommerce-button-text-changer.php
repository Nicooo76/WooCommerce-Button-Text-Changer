<?php
/**
 * Plugin Name: WooCommerce Button Text Changer
 * Plugin URI: https://gauditz.com/
 * Description: Ändert den Text des WooCommerce "In den Warenkorb"- oder Affiliate-Buttons.
 * Version: 1.1.0
 * Author: Sven Gauditz
 * Author URI: https://gauditz.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: woocommerce-button-text-changer
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 8.x
 */

defined( 'ABSPATH' ) || exit;

define( 'WCBTC_VERSION', '1.1.0' );
define( 'WCBTC_PLUGIN_FILE', __FILE__ );
define( 'WCBTC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WCBTC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Prüft, ob WooCommerce aktiv ist.
 */
function wcbtc_is_woocommerce_active(): bool {
	return class_exists( 'WooCommerce' );
}

/**
 * Admin-Hinweis anzeigen, wenn WooCommerce fehlt.
 */
function wcbtc_woocommerce_missing_notice(): void {
	?>
	<div class="notice notice-error">
		<p>
			<strong><?php esc_html_e( 'WooCommerce Button Text Changer', 'woocommerce-button-text-changer' ); ?></strong>
			<?php esc_html_e( 'benötigt WooCommerce. Bitte installiere und aktiviere WooCommerce.', 'woocommerce-button-text-changer' ); ?>
		</p>
	</div>
	<?php
}

/**
 * Plugin initialisieren.
 */
function wcbtc_init(): void {
	if ( ! wcbtc_is_woocommerce_active() ) {
		add_action( 'admin_notices', 'wcbtc_woocommerce_missing_notice' );
		return;
	}

	load_plugin_textdomain(
		'woocommerce-button-text-changer',
		false,
		dirname( WCBTC_PLUGIN_BASENAME ) . '/languages'
	);

	require_once WCBTC_PLUGIN_DIR . 'includes/class-wcbtc-filters.php';
	WCBTC_Filters::init();

	if ( is_admin() ) {
		require_once WCBTC_PLUGIN_DIR . 'admin/class-wcbtc-admin.php';
		WCBTC_Admin::init();
	}
}

add_action( 'plugins_loaded', 'wcbtc_init' );
