<?php
/**
 * The file responsible for defining the updated messages.
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
 * Updated messages for Coupons.
 * 
 * @since 1.7
 */
function wpd_coupons_updated_messages( $messages ) {
	global $post;
    if ( 'coupons' === get_post_type() ) {
        $messages['post'] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => esc_attr__( 'Coupon updated.', 'wpd-coupons' ),
            2  => esc_attr__( 'Custom field updated.', 'wpd-coupons' ),
            3  => esc_attr__( 'Custom field deleted.', 'wpd-coupons' ),
            4  => esc_attr__( 'Coupon updated.', 'wpd-coupons' ),
            5  => isset( $_GET['revision'] ) ? sprintf( __( 'Coupon restored to revision from %s' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => esc_attr__( 'Coupon published.', 'wpd-coupons' ),
            7  => esc_attr__( 'Coupon saved.', 'wpd-coupons' ),
            8  => esc_attr__( 'Coupon submitted.', 'wpd-coupons' ),
            9  => sprintf( __( 'Coupon scheduled for: <strong>%1$s</strong>.' ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) ),
            10 => esc_attr__( 'Coupon draft updated.', 'wpd-coupons' ),
        );
    }
    return $messages;
}
add_filter( 'post_updated_messages', 'wpd_coupons_updated_messages' );
