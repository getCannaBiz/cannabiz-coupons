=== Dispensary Coupons ===
Contributors: wpdispensary, deviodigital
Tags: dispensary, cannabis, marijuana, wp-dispensary, mmj, weed, coupons, discounts
Requires at least: 3.0
Tested up to: 5.3
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily add and display coupons for your marijuana dispensary.

== Description ==

The Dispensary Coupons plugin is an official add-on for the [WP Dispensary](https://www.wpdispensary.com) menu management plugin.

With this plugin installed, you can add coupons to your website and show them off via the included shortcode and widget.

This plugin also extends the [eCommerce](https://www.wpdispensary.com/product/ecommerce/) add-on for WP Dispensary, allowing customers to use the coupon codes when placing orders.

**Requirements**

Dispensary Coupons was built with the [WP Dispensary](https://www.wpdispensary.com) plugin to be installed and activated in order utilize the added functionality for websites that are running the WPD plugin.

**Shortcode**

You can display your dispensary coupons by adding the following shortcode:

`[wpd-coupons]`

Here is the shortcode with all options included:

`[wpd-coupons limit="5" image="yes" imagesize="medium" title="yes" couponexp="yes" details="yes" products="yes"]`

If you'd like to hide any of the included details, you can change **yes** to **no** in the shortcode attributes from the above example.

**Widget**

You can also display your coupons by adding the included Dispensary Coupons widget to your sidebar, as seen in the example screenshots below.

**Contribute**

Want to help this plugin get better? Head over to [Github](https://github.com/wpdispensary/dispensary-coupons) and open an issue or submit a pull request.

== Screenshots ==

1. An example of how the shortcode displays the coupons
2. Coupons in the admin dashboard menu
3. An example of the Edit Coupon screen
4. The widget editor in the WordPress dashboard
5. An example of how the widget displays the coupons

== Installation ==

1. Upload the `dispensary-coupons` folder to the `/wp-content/plugins/` directory or add it directly through your WordPress admin dashboard
2. Activate the plugin through the `Plugins` menu in WordPress

== Changelog ==

= 2.0 =
*   Added coupon code, amount and exp date to widget in `dispensary-coupons.php`
*   Added coupon code, amount and exp date to shortcode in `dispensary-coupons.php`
*   Added multiple style updates for the widget and shortcode in `assets/css/style.css`
*   Updated admin widget description text in `dispensary-coupons.php`
*   Updated `.pot` file with new text strings for localization in `languages/wpd-coupons.pot`
*   WordPress Coding Standards updates in `dispensary-coupons.php`

= 1.9.1 =
*   Bugfix added missing helper functions file in `inc/dispensary-coupons-helper-functions.php`

= 1.9 =
*   Added `Gear` and `Tinctures` metaboxes to the Coupons post type in `dispensary-coupons.php`
*   Added `Gear` and `Tinctures` menu types to coupons widget in `dispensary-coupons.php`
*   Added coupons to WP Dispensary's `Gear` and `Tinctures` pricing tables in `dispensary-coupons.php`
*   Updated coupon output in the pricing table to colspan 7 in `dispensary-coupons.php`
*   Updated `.pot` file with new text strings for localization in `languages/wpd-coupons.pot`
*   WordPress Coding Standards updates in `dispensary-coupons.php`

= 1.8.1 =
*   Updated post type to support the new Gutenberg editor in WordPress 5.0+ in `dispensary-coupons.php`

= 1.8 =
*   Added `global $post` to updated messages function in `dispensary-coupons.php`
*   Updated function names to be uniform with other WPD plugins in `dispensary-coupons.php`
*   Updated variable names to match other WPD plugins in `dispensary-coupons.php`
*   Updated Coupons CPT `$args` to remove from search results in `dispensary-coupons.php`
*   Updated `Coupon Details` metabox location to main column under title in `dispensary-coupons.php`
*   Updated text strings for localization in `dispensary-coupons.php`
*   Updated `.pot` file with new text strings for localization in `languages/wpd-coupons.pot`
*   WordPress Coding Standards updates in `dispensary-coupons.php`

= 1.7 =
*   Updated text for admin `post_updated_messages` in `dispensary-coupons.php`
*   Updated Coupons post type to no longer be publicly queryable in `dispensary-coupons.php`
*   Updated Coupons post type to no longer support the editor in `dispensary-coupons.php`

= 1.6 =
*   Added permalink settings Classs for `coupons` base in `inc/class-dispensary-coupons-permalinks.php`
*   Added permalink settings option for `coupons` base in `dispensary-coupons.php`
*   Updated permalink base codes for `coupons` custom post type in `dispensary-coupons.php`

= 1.5.2 =
*   Added `Coupons Details` metabox with `wpd_coupon_code`, `wpd_coupon_amount`, `wpd_coupon_type` and `wpd_coupon_exp` options

= 1.5.1 =
*   Updated admin submenu order number
*   Updated <td> Coupons text in Pricing table
*   Updated the default widget title
*   General code clean up for easier reading

= 1.5 =
*   Updated `Coupons` menu placement to be a sub-menu under WP Dispensary **requires version 1.9.8+ of WP Dispensary**
*   Updated widget title size from `h3` to `strong` to make the text more uniformly sized.
*   Updated the widget name to "WP Dispensary's Coupons"

= 1.4 =
*   Added action hook to display coupons on single menu items pages (action hooks added to WP Dispensary in [WP Dispensary 1.8](http://www.wpdispensary.com/wp-dispensary-version-1-8/))

= 1.3 =
*   Added option to select an item from the Growers menu type that was added in [WP Dispensary 1.7](https://www.wpdispensary.com/wp-dispensary-version-1-7/)

= 1.2 =
*   Added new shortcode and widget options to show or hide the featured image of your dispensary coupon

= 1.1.1 =
*   Added missing shortcode support for new Topicals menu type in [WP Dispensary 1.4](https://www.wpdispensary.com/wp-dispensary-version-1-4/)
*   Updated CSS for `wpd-coupons-plugin-meta` class in `css/style.css`

= 1.1.0 =
*   Added support for new Topicals menu type in [WP Dispensary 1.4](https://www.wpdispensary.com/wp-dispensary-version-1-4/)

= 1.0 =
*   Stable release

= 0.1.0 =
*   Initial release
