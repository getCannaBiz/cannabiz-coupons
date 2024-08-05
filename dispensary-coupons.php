<?php
/**
 * Plugin Name: WP Dispensary's Coupons
 * Plugin URI: http://www.wpdispensary.com/
 * Description: Easily add and display coupons for your marijuana dispensary business. Brought to you by <a href="https://www.wpdispensary.com" target="_blank">WP Dispensary</a> and <a href="http://www.deviodigital.com/" target="_blank">Devio Digital</a>.
 * Version:     2.0
 * Author:      WP Dispensary
 * Author URI:  https://www.wpdispensary.com/
 * Text Domain: wpd-coupons
 * Domain Path: /languages
 *
 * @package WPD_Coupons
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Load scripts and styles
 *
 * @since  1.0.0
 * @return void
 */
function wpd_coupons_load_scripts() {
    wp_enqueue_style( 'wpd-coupons', plugin_dir_url( __FILE__ ) . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wpd_coupons_load_scripts' );

/**
 * Load admin scripts and styles
 *
 * @since  1.1.0
 * @return void
 */
function wpd_coupons_load_admin_scripts() {
    wp_enqueue_style( 'wpd-coupons', plugin_dir_url( __FILE__ ) . 'css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'wpd_coupons_load_admin_scripts' );

/**
 * The file responsible for creating custom helper functions
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/dispensary-coupons-helper-functions.php';

/**
 * The class responsible for creating custom permalinks
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/class-dispensary-coupons-permalinks.php';

/**
 * The file responsible for creating coupons post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/dispensary-coupons-post-type.php';

/**
 * The file responsible for creating coupons widget.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/dispensary-coupons-widget.php';

/**
 * The file responsible for creating coupons shortcode.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/dispensary-coupons-shortcode.php';

/**
 * The file responsible for creating coupons metabox.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/dispensary-coupons-metabox.php';

/**
 * The file responsible for adding columns to the Coupons admin screen.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/dispensary-coupons-admin-screens.php';

/**
 * The file responsible for running on plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/dispensary-coupons-activation.php';

/**
 * Check to make sure WP Dispensary is active
 */
if ( in_array( 'wp-dispensary/wp-dispensary.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    /**
     * Add 'Coupons' link to WPD admin menu
     * 
     * @return void
     */
    function dispensary_coupons_add_admin_menu() {
        add_submenu_page( 'wpd-settings', 'WP Dispensary\'s Coupons', 'Coupons', 'manage_options', 'edit.php?post_type=coupons', NULL );
    }
    add_action( 'admin_menu', 'dispensary_coupons_add_admin_menu', 5 ); 
}

/**
 * Add Coupons to the bottom of the Pricing data table
 *
 * @since  1.4.0
 * @return string
 */
function wpd_coupons_pricing() {
    global $post;
    $product_id = $post->ID;

    $args = [
        'meta_key'       => 'selected_product',
        'meta_value'     => $product_id,
        'post_type'      => 'coupons',
        'posts_per_page' => -1
    ];
    $product_coupons = new WP_Query( $args );
    if ( $product_coupons->have_posts() ) :

        echo '<td class="wpd-coupons" colspan="7"><span>' . esc_attr__( 'Coupons', 'wpd-coupons' ) . '</span> ';

        while ( $product_coupons->have_posts() ) : $product_coupons->the_post();
            ?>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <?php
        endwhile;

        echo '</td>';

    endif;

    // Reset Post Data
    wp_reset_postdata();

}
add_action( 'wpd_pricingoutput_bottom', 'wpd_coupons_pricing', 20 );
