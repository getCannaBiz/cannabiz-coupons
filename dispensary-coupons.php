<?php
/**
 * Plugin Name:	WP Dispensary's Coupons
 * Plugin URI:	http://www.wpdispensary.com/
 * Description:	Easily add and display coupons for your marijuana dispensary business. Brought to you by <a href="https://www.wpdispensary.com" target="_blank">WP Dispensary</a> and <a href="http://www.deviodigital.com/" target="_blank">Devio Digital</a>.
 * Version:		2.0
 * Author:		WP Dispensary
 * Author URI:	https://www.wpdispensary.com/
 * Text Domain: wpd-coupons
 * Domain Path: /languages
 *
 * @package		WPD_Coupons
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Load scripts and styles
 *
 * @since       1.0.0
 * @return      void
 */
function wpd_coupons_load_scripts() {
	wp_enqueue_style( 'wpd-coupons', plugin_dir_url( __FILE__ ) . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wpd_coupons_load_scripts' );

/**
 * Load admin scripts and styles
 *
 * @since       1.1.0
 * @return      void
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
 * The file responsible for running on plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/dispensary-coupons-activation.php';

/**
 * Check to make sure WP Dispensary is active
 */
if ( in_array( 'wp-dispensary/wp-dispensary.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	/**
	 * Add 'Coupons' link to WPD admin menu
	 */
	function dispensary_coupons_add_admin_menu() {
		add_submenu_page( 'wpd-settings', 'WP Dispensary\'s Coupons', 'Coupons', 'manage_options', 'edit.php?post_type=coupons', NULL );
	}
	add_action( 'admin_menu', 'dispensary_coupons_add_admin_menu', 5 ); 
}

/**
 * Add Coupons to the bottom of the Pricing data table
 *
 * @since       1.4.0
 */
function wpd_coupons_pricing() {
?>

<?php if ( in_array( get_post_type(), array( 'flowers' ) ) ) {

	global $post;
	$flowerid = $post->ID;

	$args = array(
		'meta_key'       => '_selected_flowers',
		'meta_value'     => $flowerid,
		'post_type'      => 'coupons',
		'posts_per_page' => -1
	);
	$flower_coupons = new WP_Query( $args );
	if ( $flower_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="7"><span>' . esc_attr__( 'Coupons', 'wpd-coupons' ) . '</span> ';

	while ( $flower_coupons->have_posts() ) : $flower_coupons->the_post();
	?>
	<a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
	<?php
	endwhile;

	echo '</td>';

	endif;

	// Reset Post Data
	wp_reset_postdata(); ?>

<?php } // if Flower ?>

<?php if ( in_array( get_post_type(), array( 'edibles' ) ) ) {

	global $post;
	$edibleid = $post->ID;

	$args = array(
		'meta_key'       => '_selected_edibles',
		'meta_value'     => $edibleid,
		'post_type'      => 'coupons',
		'posts_per_page' => -1
	);
	$edible_coupons = new WP_Query( $args );
	if ( $edible_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="7"><span>' . __( 'Coupons', 'wpd-coupons' ) . '</span> ';

	while ( $edible_coupons->have_posts() ) : $edible_coupons->the_post();
	?>
	<a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
	<?php
	endwhile;

	echo '</td>';

	endif;

	// Reset Post Data
	wp_reset_postdata(); ?>

<?php } // if Edible ?>

<?php if ( in_array( get_post_type(), array( 'concentrates' ) ) ) {

	global $post;
	$concentrateid = $post->ID;

	$args = array(
		'meta_key'       => '_selected_concentrates',
		'meta_value'     => $concentrateid,
		'post_type'      => 'coupons',
		'posts_per_page' => -1
	);
	$concentrate_coupons = new WP_Query( $args );
	if ( $concentrate_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="7"><span>' . __( 'Coupons', 'wpd-coupons' ) . '</span> ';

	while ( $concentrate_coupons->have_posts() ) : $concentrate_coupons->the_post();
	?>
	<a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
	<?php
	endwhile;

	echo '</td>';

	endif;

	// Reset Post Data
	wp_reset_postdata(); ?>

<?php } // if Concentrate ?>

<?php if ( in_array( get_post_type(), array( 'prerolls' ) ) ) {

	global $post;
	$prerollid = $post->ID;

	$args = array(
		'meta_key'       => '_selected_prerolls',
		'meta_value'     => $prerollid,
		'post_type'      => 'coupons',
		'posts_per_page' => -1
	);
	$preroll_coupons = new WP_Query( $args );
	if ( $preroll_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="7"><span>' . __( 'Coupons', 'wpd-coupons' ) . '</span> ';

	while ( $preroll_coupons->have_posts() ) : $preroll_coupons->the_post();
	?>
	<a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
	<?php
	endwhile;

	echo '</td>';

	endif;

	// Reset Post Data
	wp_reset_postdata(); ?>

<?php } // if Preroll ?>

<?php if ( in_array( get_post_type(), array( 'topicals' ) ) ) {

	global $post;
	$topicalid = $post->ID;

	$args = array(
		'meta_key'       => '_selected_topicals',
		'meta_value'     => $topicalid,
		'post_type'      => 'coupons',
		'posts_per_page' => -1
	);
	$topical_coupons = new WP_Query( $args );
	if ( $topical_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="7"><span>' . __( 'Coupons', 'wpd-coupons' ) . '</span> ';

	while ( $topical_coupons->have_posts() ) : $topical_coupons->the_post();
	?>
	<a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
	<?php
	endwhile;

	echo '</td>';

	endif;

	// Reset Post Data
	wp_reset_postdata(); ?>

<?php } // if Topical ?>

<?php if ( in_array( get_post_type(), array( 'growers' ) ) ) {

global $post;
$growerid = $post->ID;

$args = array(
	'meta_key'       => '_selected_growers',
	'meta_value'     => $growerid,
	'post_type'      => 'coupons',
	'posts_per_page' => -1
);
$grower_coupons = new WP_Query( $args );
if ( $grower_coupons->have_posts() ) :

echo '<td class="wpd-coupons" colspan="7"><span>' . __( 'Coupons', 'wpd-coupons' ) . '</span> ';

while ( $grower_coupons->have_posts() ) : $grower_coupons->the_post();
?>
<a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
<?php
endwhile;

echo '</td>';

endif;

// Reset Post Data
wp_reset_postdata(); ?>

<?php } // if Grower ?>

<?php if ( in_array( get_post_type(), array( 'gear' ) ) ) {

	global $post;
	$gearid = $post->ID;

	$args = array(
		'meta_key'       => '_selected_gear',
		'meta_value'     => $gearid,
		'post_type'      => 'coupons',
		'posts_per_page' => -1
	);
	$gear_coupons = new WP_Query( $args );
	if ( $gear_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="7"><span>' . __( 'Coupons', 'wpd-coupons' ) . '</span> ';

	while ( $gear_coupons->have_posts() ) : $gear_coupons->the_post();
	?>
	<a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
	<?php
	endwhile;

	echo '</td>';

	endif;

	// Reset Post Data
	wp_reset_postdata(); ?>

<?php } // if Gear ?>

<?php if ( in_array( get_post_type(), array( 'tinctures' ) ) ) {

global $post;
$tinctureid = $post->ID;

$args = array(
	'meta_key'       => '_selected_tinctures',
	'meta_value'     => $tinctureid,
	'post_type'      => 'coupons',
	'posts_per_page' => -1
);
$tincture_coupons = new WP_Query( $args );
if ( $tincture_coupons->have_posts() ) :

echo '<td class="wpd-coupons" colspan="7"><span>' . __( 'Coupons', 'wpd-coupons' ) . '</span> ';

while ( $tincture_coupons->have_posts() ) : $tincture_coupons->the_post();
?>
<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
<?php
endwhile;

echo '</td>';

endif;

// Reset Post Data
wp_reset_postdata(); ?>

<?php } // if Tinctures ?>

<?php }
add_action( 'wpd_pricingoutput_bottom', 'wpd_coupons_pricing', 20 );

/**
 * Update messages for Coupons.
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
