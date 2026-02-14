<?php
/**
 * WooCommerce Button-Text-Filter
 *
 * @package WooCommerce_Button_Text_Changer
 */

defined( 'ABSPATH' ) || exit;

/**
 * Klasse WCBTC_Filters
 */
final class WCBTC_Filters {

	/**
	 * Filter initialisieren.
	 */
	public static function init(): void {
		add_filter( 'woocommerce_product_single_add_to_cart_text', array( __CLASS__, 'single_add_to_cart_text' ), 10, 2 );
		add_filter( 'woocommerce_product_add_to_cart_text', array( __CLASS__, 'archive_add_to_cart_text' ), 10, 2 );
	}

	/**
	 * Button-Text auf der Einzelproduktseite (inkl. externer/Affiliate-Produkte).
	 *
	 * @param string        $text   Ursprünglicher Button-Text.
	 * @param WC_Product|null $product Produkt-Objekt (optional, je nach WooCommerce-Version).
	 * @return string
	 */
	public static function single_add_to_cart_text( $text, $product = null ): string {
		$product = $product instanceof WC_Product ? $product : ( isset( $GLOBALS['product'] ) && $GLOBALS['product'] instanceof WC_Product ? $GLOBALS['product'] : null );
		if ( $product && $product->is_type( 'external' ) ) {
			$new_text = get_option( 'wc_affiliate_button_text', __( 'Jetzt kaufen', 'woocommerce-button-text-changer' ) );
			return $new_text !== '' ? $new_text : (string) $text;
		}
		$new_text = get_option( 'wc_add_to_cart_text', __( 'In den Warenkorb', 'woocommerce-button-text-changer' ) );
		return $new_text !== '' ? $new_text : (string) $text;
	}

	/**
	 * Button-Text auf Shop-/Archivseiten.
	 *
	 * @param string        $text   Ursprünglicher Button-Text.
	 * @param WC_Product|null $product Produkt-Objekt (optional).
	 * @return string
	 */
	public static function archive_add_to_cart_text( $text, $product = null ): string {
		$product = $product instanceof WC_Product ? $product : null;
		if ( $product && $product->is_type( 'external' ) ) {
			$new_text = get_option( 'wc_affiliate_button_text', __( 'Jetzt kaufen', 'woocommerce-button-text-changer' ) );
			return $new_text !== '' ? $new_text : (string) $text;
		}
		$new_text = get_option( 'wc_add_to_cart_text', __( 'In den Warenkorb', 'woocommerce-button-text-changer' ) );
		return $new_text !== '' ? $new_text : (string) $text;
	}
}
