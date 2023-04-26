<?php
/**
 * The file responsible for defining the custom admin screen columns
 *
 * @link       https://www.wpdispensary.com/
 * @since      2.1.0
 *
 * @package    WPD_Coupons
 * @subpackage WPD_Coupons/inc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Add Product Ratings stars to Products admin screen
 * 
 * @since  2.1.0
 * @return void
 */
function wpd_coupons_add_custom_html_column_to_admin_screen() {
    $screen = get_current_screen();

    // Only run this code if we're on the Coupons post type Edit screen.
    if ( 'edit' === $screen->base && 'coupons' === $screen->post_type ) {
        // Create an instance.
        $product_columns = new CPT_Columns( 'coupons' );

        // Add thumb column.
        $product_columns->add_column( 'custom_html',
            array(
                'label' => esc_html__( 'Code', 'wp-dispensary' ),
                'type'  => 'custom_html',
                'order' => '12',
                'html'  => '' // pass empty to utilize filter below
            )
        );
    }
}
add_action( 'load-edit.php', 'wpd_coupons_add_custom_html_column_to_admin_screen' );

/**
 * Add 'Code' column to Coupons admin screen
 * 
 * @since  2.1.0
 * @return string
 */
function wpd_coupons_add_custom_html_column_to_admin_screen_filter( $post_id, $column, $column_name ) {
    // Create variable of custom HTML that we'll add to the column.
    $custom_html = get_post_meta( $column, 'wpd_coupon_code', true );

    echo $custom_html;
}
add_filter( 'columns_custom_html_custom_html', 'wpd_coupons_add_custom_html_column_to_admin_screen_filter', 20, 3 );
