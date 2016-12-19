=== Dispensary Coupons ===
Contributors: deviodigital
Tags: dispensary, cannabis, coupons, marijuana, wp dispensary, mmj, weed, discounts
Requires at least: 3.0
Tested up to: 4.7
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily add and display coupons for your marijuana dispensary.

== Description ==

The Dispensary Coupons plugin is an official add-on for the [WP Dispensary](https://www.wpdispensary.com) menu management plugin.

With this plugin you can add coupons to your website and show them off with a shortcode or widget.

When adding new coupons to your website, you'll be able to select what items in your dispensary menu the coupon is good for, and this information will be added to the coupon display.

**Requirements**

Although not required, Dispensary Coupons was built with the [WP Dispensary](https://www.wpdispensary.com) plugin to be installed and activated in order utilize the added functionality for websites that are running the WPD plugin.

If you do not have WP Dispensary installed, don't worry because Dispensary Coupons will still let you add coupons and display them on your website, without any mention of the WPD plugin whatsoever.

**Shortcode**

You can display your dispensary coupons by adding the following shortcode:

`[wpd-coupons]`

Here is the shortcode with all options included:

`[wpd-coupons limit="5" image="yes" title="yes" details="yes" products="yes"]`

If you'd like to hide the title, details, products or image, you can change **yes** to **no** in the shortcode example above.

**Contribute**

Want to help this plugin get better? Head over to [Github](https://github.com/deviodigital/dispensary-coupons) and open an issue or submit a pull request.

== Screenshots ==

1. Dispensary Coupons in the dashboard menu
2. An example of how the widget displays the coupons
3. The widget editor in the WordPress dashboard
4. The metaboxes that show on the Dispensary Coupon editor screen

== Installation ==

1. Upload the `dispensary-coupons` folder to the `/wp-content/plugins/` directory or add it directly through your WordPress admin dashboard
2. Activate the plugin through the `Plugins` menu in WordPress

== Changelog ==

= 1.4 =
* Added action hook to display coupons on single menu items pages (action hooks added to WP Dispensary in [WP Dispensary 1.8](http://www.wpdispensary.com/wp-dispensary-version-1-8/))

= 1.3 =
* Added option to select an item from the Growers menu type that was added in [WP Dispensary 1.7](https://www.wpdispensary.com/wp-dispensary-version-1-7/)

= 1.2 =
* Added new shortcode and widget options to show or hide the featured image of your dispensary coupon

= 1.1.1 =
* Added missing shortcode support for new Topicals menu type in [WP Dispensary 1.4](https://www.wpdispensary.com/wp-dispensary-version-1-4/)
* Updated CSS for `wpd-coupons-plugin-meta` class in `css/style.css`

= 1.1.0 =
* Added support for new Topicals menu type in [WP Dispensary 1.4](https://www.wpdispensary.com/wp-dispensary-version-1-4/)

= 1.0 =
* Stable release

= 0.1.0 =
* Initial release
