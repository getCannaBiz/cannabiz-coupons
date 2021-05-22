<?php
/**
 * The file responsible for defining the coupons shortcode.
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
 * Dispensary Coupons Shortcode
 *
 * @since		1.0.0
 * @param		array  $atts Shortcode attributes
 * @param		string  $content
 * @return		string  $return The Dispensary Coupons shortcode
 */
function wpd_coupons_shortcode( $atts ) {

	extract( shortcode_atts( array(
		'limit'     => '5',
		'image'     => 'yes',
		'imagesize' => 'medium',
		'title'     => 'yes',
		'details'   => 'yes',
		'couponexp' => 'yes',
		'products'  => 'yes'
    ), $atts, 'wpd_coupons' ) );

	ob_start();

	$wpd_coupons_shortcode = new WP_Query(
		array(
			'post_type' => 'coupons',
			'showposts' => $limit
		)
	);

	while ( $wpd_coupons_shortcode->have_posts() ) : $wpd_coupons_shortcode->the_post();

	echo '<div class="wpd-coupons-plugin-meta shortcode">';

    // Display coupon featured image.
	if ( 'yes' == $image ) {
		if ( 'medium' == $imagesize ) {
			the_post_thumbnail( 'medium' );
		} else {
			the_post_thumbnail( $imagesize );
		}
	}

    // Get the Coupon metadata.
	$wpd_coupon_code   = get_post_meta( get_the_id(), 'wpd_coupon_code', true );
	$wpd_coupon_amount = get_post_meta( get_the_id(), 'wpd_coupon_amount', true );
	$wpd_coupon_type   = get_post_meta( get_the_id(), 'wpd_coupon_type', true );
	$wpd_coupon_exp    = get_post_meta( get_the_id(), 'wpd_coupon_exp', true );

	// Wrap the coupon code and expiration date.
	echo '<div class="wpd-coupons-plugin-meta-item code-exp">';

	// Display coupon code.
	if ( $wpd_coupon_code ) {
		echo '<span class="wpd-coupons-plugin-meta-item code"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M13.219 4h-3.926c-1.654-2.58-4.919-4.182-8.293-3.983v1.688c2.286-.164 4.79.677 6.113 2.295h-2.113v2.339c-2.059-.157-4.005.605-5 1.159l.688 1.617c1.196-.625 2.53-1.243 4.312-1.026v4.084l10.796 10.827 8.204-8.223-10.781-10.777zm-2.226 5.875c-.962.963-2.598.465-2.88-.85 1.318.139 2.192-.872 2.114-2.017 1.261.338 1.701 1.93.766 2.867z"/></svg> ' . $wpd_coupon_code . '</span>';
	}

	// Display coupon expiration date.
	if ( 'yes' == $couponexp && $wpd_coupon_exp ) {
        echo '<span class="wpd-coupons-plugin-meta-item exp">' . esc_attr__( 'Exp', 'wpd-coupons' ) . ': ' . $wpd_coupon_exp . '</span>';
	}

	echo '</div>';

	// Display coupon amount.
	if ( $wpd_coupon_amount && $wpd_coupon_type ) {
		// Coupon amount default.
		$coupon_amount = wpd_currency_code() . $wpd_coupon_amount;

		// Coupon amount (if percentage).
		if ( 'Percentage' == $wpd_coupon_type ) {
			$coupon_amount = $wpd_coupon_amount . '%';
		}

		echo '<span class="wpd-coupons-plugin-meta-item amount">' . __( 'Save', 'dispensary-coupons' ) . ' ' . $coupon_amount . '</span>';
	}

	if ( 'yes' == $title ) {
		/** Display coupon title */
		echo '<span class="wpd-coupons-plugin-meta-item title">' . get_the_title( get_the_id() ) . '</span>';
	}

	if ( 'yes' == $details ) {
		/** Display coupon details */
		echo '<span class="wpd-coupons-plugin-meta-item">' . the_content() . '</span>';
	}

	if ( 'yes' == $products ) {
		/** Display products that the coupon applies to */
		$selected_product = get_post_meta( get_the_id(), 'selected_product', true );

		echo '<span class="wpd-coupons-plugin-meta-item">';

		if ( '' !== $selected_product ) {
			echo '<a href="' . get_permalink( $selected_product ) . '">' . get_the_title( $selected_product ) . '</a> ';
		}

		echo '</span>';
	}

	echo '</div>';

	endwhile; // end loop

	$output_string = ob_get_contents();
	ob_end_clean();

	return $output_string;

}
add_shortcode( 'wpd-coupons', 'wpd_coupons_shortcode' );
