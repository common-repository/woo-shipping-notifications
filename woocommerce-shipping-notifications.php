<?php
/*
* Plugin Name
*
* @package     WoocommerceShippingNotifications
* @author      Jon Kristian Nilsen
* @copyright   2018 Divint
* @license     GPL-2.0+
*
* Plugin Name: Woocommerce Shipping Notifications
* Plugin URI: https://divint.no/wordpress/plugins/woocommerce-shipping-notifications
* Description: If a free shipping threshold is defined in Woo Commerce, this plugin provides a shortcode that displays a notification on the amount missing until eligible for free shipping.
* Version: 1.0
* Author: Jon Kristian Nilsen
* Author URI: https://jonkristian.no
* Text Domain: woocommerce-shipping-notifications
* Domain Path: /languages
* License:     GPL-2.0+
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

/**
 * Load the plugin's text domain.
 *
 * @return void
 */
function wcsn_load_plugin_textdomain()
{
    load_plugin_textdomain('woocommerce-shipping-notifications', false, basename(dirname(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'wcsn_load_plugin_textdomain');


/**
 * Accepts a zone name and returns its threshold for free shipping.
 *
 * @param  $zone The name of the zone to get the threshold of. Case-sensitive.
 * @return int The threshold corresponding to the zone, if there is any. If there is no such zone, or no free shipping method, null will be returned.
 */
function get_free_shipping_minimum($zone_name = 'Norge')
{
    $result = null;
    $zone   = null;

    $zones = WC_Shipping_Zones::get_zones();
    foreach ($zones as $z) {
        if ($z['zone_name'] == $zone_name) {
            $zone = $z;
        }
    }

    if ($zone) {
        $shipping_methods_nl = $zone['shipping_methods'];
        $free_shipping_method = null;
        foreach ($shipping_methods_nl as $method) {
            if ($method->id == 'free_shipping') {
                $free_shipping_method = $method;
                break;
            }
        }

        if ($free_shipping_method) {
            $result = $free_shipping_method->min_amount;
        }
    }

    return $result;
}


/**
 * Get fields from woo and calculate
 * how much money is needed until customer gets free shipping.
 *
 * @param  $atts  Array of available attributes for this shortcode function.
 * @return string Text describing how much is needed for free shipping.
 */
function wcsn_shortcode($atts)
{
    $a = shortcode_atts(array(
        'shipping_zone'  => 'Norge',
        'hide_free_text' => false,
    ), $atts);

    // Do even have free shipping treshold? (If this check fails we can't proceed).
    if ($free_shipping_min = get_free_shipping_minimum($a['shipping_zone'])) {
        // Gather our cart total amount.
        if (! WC()->cart->prices_include_tax) {
            $cart_amount = WC()->cart->cart_contents_total;
        } else {
            $cart_amount = WC()->cart->cart_contents_total + WC()->cart->tax_total;
        }

        // Calculate how much remaining until free shipping.
        $remaining = $free_shipping_min-$cart_amount;

        // Shipping is free or not?
        if ($remaining > 0) {
            $output = sprintf(__("To get free shipping, you should consider increasing your purchase by %s.", 'woocommerce-shipping-notifications'), wc_price($remaining));
        } else {
            $output = ($a['hide_free_text'] == false ? __("Wohoo! Shipping is free.", 'woocommerce-shipping-notifications') : '');
        }

        return $output;
    }
}
add_shortcode('wcsn', 'wcsn_shortcode');
