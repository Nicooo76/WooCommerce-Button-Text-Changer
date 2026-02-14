<?php
/**
 * Uninstall WooCommerce Button Text Changer
 *
 * Löscht alle Plugin-Optionen bei Deinstallation.
 *
 * @package WooCommerce_Button_Text_Changer
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'wc_add_to_cart_text' );
delete_option( 'wc_affiliate_button_text' );
