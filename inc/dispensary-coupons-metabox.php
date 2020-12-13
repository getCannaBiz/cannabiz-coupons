<?php
/**
 * The file responsible for defining the custom metabox.
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
 * Coupon Details metabox
 *
 * Adds the coupon details metabox.
 *
 * @since    1.5.2
 */
function wpd_coupons_add_details_metaboxes() {
	add_meta_box(
		'wpd_coupons',
		__( 'Coupon Details', 'wpd-coupons' ),
		'wpd_coupon_details',
		'coupons',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'wpd_coupons_add_details_metaboxes' );

/**
 * Building the metabox
 */
function wpd_coupon_details() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="wpd_coupons_details_meta_noncename" id="wpd_coupons_details_meta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the coupon data if its already been entered */
	$wpd_coupon_code   = get_post_meta( $post->ID, 'wpd_coupon_code', true );
	$wpd_coupon_amount = get_post_meta( $post->ID, 'wpd_coupon_amount', true );
	$wpd_coupon_type   = get_post_meta( $post->ID, 'wpd_coupon_type', true );
	$wpd_coupon_exp    = get_post_meta( $post->ID, 'wpd_coupon_exp', true );

	/** Echo out the fields */
	echo '<div class="wpd-coupons-box">';
	echo '<p>' . __( 'Coupon Code', 'wpd-coupons' ) . ':</p>';
	echo '<input type="text" name="wpd_coupon_code" value="' . esc_html( $wpd_coupon_code ) . '" class="widefat" />';
	echo '</div>';

	echo '<div class="wpd-coupons-box">';
	echo '<p>' . __( 'Coupon Amount', 'wpd-coupons' ) . ':</p>';
	echo '<input type="text" name="wpd_coupon_amount" value="' . esc_html( $wpd_coupon_amount ) . '" class="widefat" />';
	echo '</div>';

	echo '<div class="wpd-coupons-box">';
	echo '<p>' . __( 'Coupon Type', 'wpd-coupons' ) . ':</p>';

	// Get coupon types.
	$coupon_types = get_wpd_coupons_types();

	if ( $coupon_types ) {
		printf( '<select name="wpd_coupon_type" id="wpd_coupon_type" class="widefat">' );
		foreach ( $coupon_types as $id=>$value ) {
			if ( esc_html( $value ) != $wpd_coupon_type ) {
				$coupon_type_selected = '';
			} else {
				$coupon_type_selected = 'selected="selected"';
			}
			printf( '<option value="%s" ' . esc_html( $coupon_type_selected ) . '>%s</option>', esc_html( $value ), esc_html( $value ) );
		}
		print( '</select>' );
	}

	echo '</div>';

	echo '<div class="wpd-coupons-box">';
	echo '<p>' . __( 'Expiration Date', 'wpd-coupons' ) . ':</p>';
	echo '<input type="date" name="wpd_coupon_exp" value="' . esc_html( $wpd_coupon_exp ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpd_coupons_save_details_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['wpd_coupons_details_meta_noncename' ] ) ||
		! wp_verify_nonce( $_POST['wpd_coupons_details_meta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$wpd_coupons_meta['wpd_coupon_code']   = esc_html( $_POST['wpd_coupon_code'] );
	$wpd_coupons_meta['wpd_coupon_amount'] = esc_html( $_POST['wpd_coupon_amount'] );
	$wpd_coupons_meta['wpd_coupon_type']   = esc_html( $_POST['wpd_coupon_type'] );
	$wpd_coupons_meta['wpd_coupon_exp']    = esc_html( $_POST['wpd_coupon_exp'] );

	/** Add values of $compounddetails_meta as custom fields */

	foreach ( $wpd_coupons_meta as $key => $value ) {
		if ( 'revision' === $post->post_type ) {
			return;
		}
		$value = implode( ',', (array) $value );
		if ( get_post_meta( $post->ID, $key, false ) ) {
			update_post_meta( $post->ID, $key, $value );
		} else {
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpd_coupons_save_details_meta', 1, 2 ); // Save the custom fields.
