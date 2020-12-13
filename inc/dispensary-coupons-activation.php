<?php
/**
 * The file responsible for defining the custom helper functions.
 *
 * @link       https://www.wpdispensary.com/
 * @since      2.1
 *
 * @package    WPD_Coupons
 * @subpackage WPD_Coupons/inc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Registers the plugin activation hook.
 * 
 * @since 1.0.0
 * @return void
 */
function activate_wpd_coupons() {
    // Coupons post type.
	wp_dispensary_coupons();
    // Rewrite permalinks.
	global $wp_rewrite;
	$wp_rewrite->init();
	$wp_rewrite->flush_rules();
}
register_activation_hook( __FILE__, 'activate_wpd_coupons' );
