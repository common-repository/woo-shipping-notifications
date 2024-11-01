=== Woocommerce Shipping Notifications ===
Contributors: divint,trollheimendesign
Donate link: https://divint.no/donate/
Tags: woocommerce, shipping, notifications
Requires at least: 4.0
Tested up to: 4.8
Stable tag: trunk
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

If a free shipping threshold is defined in Woo Commerce, this plugin provides a shortcode that displays a notification on the amount missing until eligible for free shipping.

== Description ==

If a free shipping threshold is defined in Woocommerce, this plugin provides a shortcode that displays a notification on the amount missing until eligible for free shipping.

**USAGE**

Use the shortcode [wcsn shipping_zone=YourZone] where *YourZone* is a shipping zone defined under Woocommerce Settings.

To read more about this plugin go to [Divint](https://divint.no/wordpress/plugins/woocommerce-shipping-notifications "Woocommerce Shipping Notifications").

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.

1. Activate the plugin through the 'Plugins' screen in WordPress

1. Set up your shipping zone in WooCommerce Settings > Shipping and add "Free shipping requires ... Minimum order amount.

1. To use this plugin add the shortcode `[wcsn shipping_zone=NameOfZone]` and it will display how much left to add before the customer can benefit from free shipping.

== Frequently Asked Questions ==

= Will this update the status in realtime? =

Not yet, but it's next on our list.


== Screenshots ==


== Changelog ==
1.0 - Initial release.

== Upgrade Notice ==
