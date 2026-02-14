<?php
/**
 * Plugin Name: WooCommerce Button Text Changer
 * Plugin URI: https://gauditz.com/
 * Description: Ändert den Text des WooCommerce "In den Warenkorb"- oder Affiliate-Buttons.
 * Version: 1.0.0
 * Author: Sven Gauditz
 * Author URI: https://gauditz.com/
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Direktzugriff verhindern
}

// Einstellungsmenü für den Button-Text hinzufügen
function wc_button_text_changer_menu() {
    add_options_page(
        'WooCommerce Button Text', 
        'WooCommerce Button Text', 
        'manage_options', 
        'wc-button-text-changer', 
        'wc_button_text_changer_settings_page'
    );
}
add_action('admin_menu', 'wc_button_text_changer_menu');

// Einstellungen speichern und anzeigen
function wc_button_text_changer_settings_page() {
    ?>
    <div class="wrap">
        <h1>WooCommerce Button Text Changer</h1>
        <form method="post" action="options.php">
            <?php settings_fields('wc_button_text_options'); ?>
            <?php do_settings_sections('wc_button_text_options'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Normaler "In den Warenkorb"-Button Text</th>
                    <td><input type="text" name="wc_add_to_cart_text" value="<?php echo esc_attr(get_option('wc_add_to_cart_text', 'In den Warenkorb')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Affiliate-Button Text</th>
                    <td><input type="text" name="wc_affiliate_button_text" value="<?php echo esc_attr(get_option('wc_affiliate_button_text', 'Jetzt kaufen')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Einstellungen registrieren
function wc_button_text_changer_register_settings() {
    register_setting('wc_button_text_options', 'wc_add_to_cart_text');
    register_setting('wc_button_text_options', 'wc_affiliate_button_text');
}
add_action('admin_init', 'wc_button_text_changer_register_settings');

// Button-Text für normale Produkte ändern
add_filter('woocommerce_product_single_add_to_cart_text', function($text) {
    $new_text = get_option('wc_add_to_cart_text', 'In den Warenkorb');
    return !empty($new_text) ? $new_text : $text;
});

// Button-Text für Archivseiten ändern
add_filter('woocommerce_product_add_to_cart_text', function($text) {
    $new_text = get_option('wc_add_to_cart_text', 'In den Warenkorb');
    return !empty($new_text) ? $new_text : $text;
});

// Button-Text für externe Produkte (Affiliate-Links) ändern
add_filter('woocommerce_product_single_add_to_cart_text', function($text) {
    global $product;
    if ($product->is_type('external')) {
        $new_text = get_option('wc_affiliate_button_text', 'Jetzt kaufen');
        return !empty($new_text) ? $new_text : $text;
    }
    return $text;
});
