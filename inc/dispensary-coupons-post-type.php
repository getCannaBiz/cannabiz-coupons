<?php
/**
 * The file responsible for defining the custom post type.
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
 * Coupons post type creation
 *
 * @since	   1.0.0
 */
if ( ! function_exists( 'wp_dispensary_coupons' ) ) {

    /**
     * Register Custom Post Type
     */
    function wp_dispensary_coupons() {
    
        // Get permalink base for Coupons.
        $wpd_coupons_slug = get_option( 'wpd_coupons_slug' );
    
        // If custom base is empty, set default.
        if ( '' == $wpd_coupons_slug ) {
            $wpd_coupons_slug = 'coupons';
        }
    
        // Capitalize first letter of new slug.
        $wpd_coupons_slug_cap = ucfirst( $wpd_coupons_slug );
    
        $rewrite = array(
            'slug'       => $wpd_coupons_slug,
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );
    
        $labels = array(
            'name'                  => _x( 'Coupons', 'Post Type General Name', 'wpd-coupons' ),
            'singular_name'         => _x( 'Coupon', 'Post Type Singular Name', 'wpd-coupons' ),
            'menu_name'             => __( 'Coupons', 'wpd-coupons' ),
            'name_admin_bar'        => __( 'Coupons', 'wpd-coupons' ),
            'archives'              => __( 'Coupon Archives', 'wpd-coupons' ),
            'parent_item_colon'     => __( 'Parent Coupon:', 'wpd-coupons' ),
            'all_items'             => __( 'All Coupons', 'wpd-coupons' ),
            'add_new_item'          => __( 'Add New Coupon', 'wpd-coupons' ),
            'add_new'               => __( 'Add New', 'wpd-coupons' ),
            'new_item'              => __( 'New Coupon', 'wpd-coupons' ),
            'edit_item'             => __( 'Edit Coupon', 'wpd-coupons' ),
            'update_item'           => __( 'Update Coupon', 'wpd-coupons' ),
            'view_item'             => __( 'View Coupon', 'wpd-coupons' ),
            'search_items'          => __( 'Search Coupons', 'wpd-coupons' ),
            'not_found'             => __( 'Not found', 'wpd-coupons' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'wpd-coupons' ),
            'featured_image'        => __( 'Featured Image', 'wpd-coupons' ),
            'set_featured_image'    => __( 'Set featured image', 'wpd-coupons' ),
            'remove_featured_image' => __( 'Remove featured image', 'wpd-coupons' ),
            'use_featured_image'    => __( 'Use as featured image', 'wpd-coupons' ),
            'insert_into_item'      => __( 'Insert into Coupon', 'wpd-coupons' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Coupon', 'wpd-coupons' ),
            'items_list'            => __( 'Coupons list', 'wpd-coupons' ),
            'items_list_navigation' => __( 'Coupons list navigation', 'wpd-coupons' ),
            'filter_items_list'     => __( 'Filter coupons list', 'wpd-coupons' ),
        );
        $args = array(
            'label'               => sprintf( esc_html__( '%s', 'wp-dispensary' ), $wpd_coupons_slug_cap ),
            'description'         => sprintf( esc_html__( 'Display your %s', 'wp-dispensary' ), $wpd_coupons_slug ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', ),
            'taxonomies'          => array(),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_rest'        => true,
            'menu_position'       => 10,
            'menu_icon'           => plugin_dir_url( __FILE__ ) . ( 'images/menu-icon.png' ),
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => $rewrite,
            'capability_type'     => 'post',
        );
        register_post_type( 'coupons', $args );
    
    }
    add_action( 'init', 'wp_dispensary_coupons', 0 );

}
