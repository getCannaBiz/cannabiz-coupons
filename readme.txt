=== Dispensary Coupons ===
Contributors: wpdispensary, deviodigital
Tags: dispensary, cannabis, marijuana, wp-dispensary, mmj, weed, coupons, discounts
Requires at least: 3.0
Tested up to: 5.1
Stable tag: 1.8.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily add and display coupons for your marijuana dispensary.

== Description ==

The Dispensary Coupons plugin is an official add-on for the [WP Dispensary](https://www.wpdispensary.com) menu management plugin.

With this plugin you can add coupons to your website and show them off with a shortcode or widget.

When adding new coupons to your website, you'll be able to select what items in your dispensary menu the coupon is good for, and this information will be added to the coupon display.

**Requirements**

Dispensary Coupons was built with the [WP Dispensary](https://www.wpdispensary.com) plugin to be installed and activated in order utilize the added functionality for websites that are running the WPD plugin.

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

= 1.8.1 =
* Updated post type to support the new Gutenberg editor in WordPress 5.0+ in `dispensary-coupons.php`

= 1.8 =
* Added `global $post` to updated messages function in `dispensary-coupons.php`
* Updated function names to be uniform with other WPD plugins in `dispensary-coupons.php`
* Updated variable names to match other WPD plugins in `dispensary-coupons.php`
* Updated Coupons CPT `$args` to remove from search results in `dispensary-coupons.php`
* Updated `Coupon Details` metabox location to main column under title in `dispensary-coupons.php`
* Updated text strings for localization in `dispensary-coupons.php`
* Updated `.pot` file with new text strings for localization in `languages/wpd-coupons.pot`
* WordPress Coding Standards updates in `dispensary-coupons.php`

= 1.7 =
* Updated text for admin `post_updated_messages` in `dispensary-coupons.php`
* Updated Coupons post type to no longer be publicly queryable in `dispensary-coupons.php`
* Updated Coupons post type to no longer support the editor in `dispensary-coupons.php`

= 1.6 =
* Added permalink settings Classs for `coupons` base in `inc/class-dispensary-coupons-permalinks.php`
* Added permalink settings option for `coupons` base in `dispensary-coupons.php`
* Updated permalink base codes for `coupons` custom post type in `dispensary-coupons.php`

= 1.5.2 =
* Added `Coupons Details` metabox with `wpd_coupon_code`, `wpd_coupon_amount`, `wpd_coupon_type` and `wpd_coupon_exp` options

= 1.5.1 =
* Updated admin submenu order number
* Updated <td> Coupons text in Pricing table
* Updated the default widget title
* General code clean up for easier reading

= 1.5 =
* Updated `Coupons` menu placement to be a sub-menu under WP Dispensary **requires version 1.9.8+ of WP Dispensary**
* Updated widget title size from `h3` to `strong` to make the text more uniformly sized.
* Updated the widget name to "WP Dispensary's Coupons"

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
