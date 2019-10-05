<?php
/**
 * The file responsible for defining the custom helper functions.
 *
 * @link       https://www.wpdispensary.com/
 * @since      1.9
 *
 * @package    WPD_Coupons
 * @subpackage WPD_Coupons/inc
 */

/**
 * Coupon types
 * 
 * @since 1.9
 */
function get_wpd_coupons_types() {
	return (array) apply_filters(
		'wpd_coupons_types',
		array(
			'percentage' => __( 'Percentage', 'wpd-coupons' ),
			'flat_rate'  => __( 'Flat Rate', 'wpd-coupons' ),
		)
	);
}

/**
 * Get a coupon type's name.
 *
 * @param string $type Coupon type.
 * @return string
 */
function get_wpd_coupons_type( $type = '' ) {
	$types = get_wpd_coupons_types();
	return isset( $types[ $type ] ) ? $types[ $type ] : '';
}

/**
 * Get a coupon code by ID.
 *
 * @param string $coupon_id Coupon ID.
 * @return string
 */
function get_wpd_coupon_code( $coupon_id = '' ) {
    // Require ID.
    if ( '' == $coupon_id ) {
        return false;
    }

    // Get coupon code.
    $coupon_code = get_post_meta( $coupon_id, 'wpd_coupon_code', TRUE );

    return $coupon_code;
}
