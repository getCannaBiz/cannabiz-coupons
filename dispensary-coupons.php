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

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

	foreach ( $wpd_coupons_meta as $key => $value ) { /** Cycle through the $wpd_coupons_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely)
		if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value.
			update_post_meta( $post->ID, $key, $value );
		} else { // If the custom field doesn't have a value.
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpd_coupons_save_details_meta', 1, 2 ); // Save the custom fields.


// Registers the plugin activation hook.
function activate_wpd_coupons() {
	wp_dispensary_coupons();

	global $wp_rewrite;
	$wp_rewrite->init();
	$wp_rewrite->flush_rules();
}
register_activation_hook( __FILE__, 'activate_wpd_coupons' );

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
