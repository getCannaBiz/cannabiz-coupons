<?php
/**
 * Plugin Name:	Dispensary Coupons
 * Plugin URI:	http://www.wpdispensary.com/
 * Description:	Easily add coupons to your dispensary website, brought to you by <a href="http://www.wpdispensary.com">WP Dispensary</a> and <a href="http://www.deviodigital.com/">Devio Digital</a>.
 * Version:		0.1
 * Author:		WP Dispensary
 * Author URI:	http://www.wpdispensary.com/
 * Text Domain: wpd-coupons
 *
 * @package		wpd-coupons
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
function wpdcoupons_load_scripts() {
	wp_enqueue_style( 'wpdcoupons', plugin_dir_url( __FILE__ ) . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wpdcoupons_load_scripts' );


/**
 * Load admin scripts and styles
 *
 * @since       1.1.0
 * @return      void
 */
function wpdcoupons_load_admin_scripts() {
	wp_enqueue_style( 'wpdcoupons', plugin_dir_url( __FILE__ ) . 'css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'wpdcoupons_load_admin_scripts' );


/**
 * Plugin update notification
 *
 * @since	   1.0.0
 */
include_once('updater.php');

if (is_admin()) { /* Double check that everything is happening in the admin */
	$config = array(
		'slug' => plugin_basename(__FILE__), /* This is the slug of your plugin */
		'proper_folder_name' => 'dispensary-coupons', /* This is the name of the folder your plugin lives in */
		'api_url' => 'https://api.github.com/repos/deviodigital/dispensary-coupons', /* The GitHub API url of your GitHub repo */
		'raw_url' => 'https://raw.github.com/deviodigital/dispensary-coupons/master', /* The GitHub raw url of your GitHub repo */
		'github_url' => 'https://github.com/deviodigital/dispensary-coupons', /* The GitHub url of your GitHub repo */
		'zip_url' => 'https://github.com/deviodigital/dispensary-coupons/zipball/master', /* The zip url of the GitHub repo */
		'sslverify' => true, /* Whether WP should check the validity of the SSL cert when getting an update */
		'requires' => '3.0', /* Which version of WordPress does your plugin require? */
		'tested' => '4.4.2', /* Which version of WordPress is your plugin tested up to? */
		'readme' => 'README.md', /* Which file to use as the readme for the version number */
		'access_token' => '', /* Access private repositories by authorizing under Appearance > GitHub Updates when this example plugin is installed */
	);
	new WP_GitHub_Updater($config);
}

/**
 * Coupons post type creation
 *
 * @since	   1.0.0
 */
if ( ! function_exists('wpdispensary_coupons') ) {

// Register Custom Post Type
function wpdispensary_coupons() {

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
		'label'                 => __( 'Coupons', 'wpd-coupons' ),
		'description'           => __( 'Display your dispensary coupons', 'wpd-coupons' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'            => array( ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'menu_icon'             => plugin_dir_url( __FILE__ ) . ('images/menu-icon.png'),
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'coupons', $args );

}
add_action( 'init', 'wpdispensary_coupons', 0 );

}


/**
 * Dispensary Coupons Widget
 *
 * @since       1.0.0
 */
class wpdcoupons_widget extends WP_Widget {

    /**
     * Constructor
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function wpdcoupons_widget() {
        parent::WP_Widget(
            false,
            __( 'Dispensary Coupons', 'wpd-coupons' ),
            array(
                'description'  => __( 'Display your recent dispensary coupons.', 'wpd-coupons' )
            )
        );
    }

    /**
     * Widget definition
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::widget
     * @param       array $args Arguments to pass to the widget
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function widget( $args, $instance ) {
        if( ! isset( $args['id'] ) ) {
            $args['id'] = 'dispensary_coupons_widget';
        }

        $title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

        echo $args['before_widget'];

        if( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        do_action( 'dispensary_coupons_before_widget' );
		
			$wpdispensary_coupons_widget = new WP_Query(
				array(
					'post_type' => 'coupons',
					'showposts' => $instance['limit']
				)
			);

			while ( $wpdispensary_coupons_widget->have_posts() ) : $wpdispensary_coupons_widget->the_post();
			
			$do_not_duplicate = $post->ID;
			
					echo "<div class='wpd-coupons-plugin-meta'>";

					if('on' == $instance['coupontitle'] ) {
						/** Display coupon title */
						echo "<span class='wpd-coupons-plugin-meta-item'><h3><a href='" . get_permalink( $post->ID ) ."'>". get_the_title( $post->ID ) ."</a></h3></span>";
					}
					
					if('on' == $instance['coupondetails'] ) {
						/** Display coupon details */
						echo "<p><span class='wpd-coupons-plugin-meta-item'>". the_content() ."</span></p>";
					}

					echo "</div>";

					if('on' == $instance['viewall'] ) {
						/** Display link to all coupons */
						echo "<p><span class='wpd-coupons-plugin-meta-item'><a class='wpd-coupons-plugin-viewall' href='". $instance['viewallurl'] ."' target='_blank'>View all coupons &rarr;</a></span></p>";
					}

			endwhile; // end loop

        do_action( 'dispensary_coupons_after_widget' );
        
        echo $args['after_widget'];
    }


    /**
     * Update widget options
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::update
     * @param       array $new_instance The updated options
     * @param       array $old_instance The old options
     * @return      array $instance The updated instance options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']      		= strip_tags( $new_instance['title'] );
        $instance['limit']   			= strip_tags( $new_instance['limit'] );
        $instance['coupontitle']		= $new_instance['coupontitle'];
        $instance['coupondetails']		= $new_instance['coupondetails'];
        $instance['viewall']			= $new_instance['viewall'];
        $instance['viewallurl']			= $new_instance['viewallurl'];

        return $instance;
    }


    /**
     * Display widget form on dashboard
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::form
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function form( $instance ) {
        $defaults = array(
            'title'  		    => 'Dispensary Coupons',
            'limit'  			=> '5',
            'coupontitle' 		=> '',
            'coupondetails' 	=> '',
			'viewall'			=> '',
			'viewallurl'		=> ''
        );

        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'wpd-coupons' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
		
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Amount of coupons to show:', 'wpd-coupons' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo $instance['limit']; ?>" />
        </p>
		
	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['coupontitle'], 'on'); ?> id="<?php echo $this->get_field_id('coupontitle'); ?>" name="<?php echo $this->get_field_name('coupontitle'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'coupontitle' ) ); ?>"><?php _e( 'Display coupon title?', 'wpd-coupons' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['coupondetails'], 'on'); ?> id="<?php echo $this->get_field_id('coupondetails'); ?>" name="<?php echo $this->get_field_name('coupondetails'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'coupondetails' ) ); ?>"><?php _e( 'Display coupon details?', 'wpd-coupons' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['viewall'], 'on'); ?> id="<?php echo $this->get_field_id('viewall'); ?>" name="<?php echo $this->get_field_name('viewall'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'viewall' ) ); ?>"><?php _e( 'Display link to all coupons?', 'wpd-coupons' ); ?></label>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'viewallurl' ) ); ?>"><?php _e( 'View all coupons URL:', 'wpd-coupons' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'viewallurl' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'viewallurl' ) ); ?>" type="text" value="<?php echo $instance['viewallurl']; ?>" />
        </p>
		
		<?php
    }
}


/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdcoupons_register_widget() {
    register_widget( 'wpdcoupons_widget' );
}
add_action( 'widgets_init', 'wpdcoupons_register_widget' );


/**
 * DispensaryCoupons Shortcode
 *
 * @since		1.0.0
 * @param		array  $atts Shortcode attributes
 * @param		string  $content
 * @return		string  $return The DispensaryCoupons
 */
function wpdcoupons_shortcode( $atts ) {

	extract(shortcode_atts( array(
		'limit' => '5',
		'title' => 'yes',
		'details' => 'yes',
	), $atts ) );

	ob_start();
	
			$wpdispensary_coupons_shortcode = new WP_Query(
				array(
					'post_type' => 'coupons',
					'showposts' => $limit
				)
			);

			while ( $wpdispensary_coupons_shortcode->have_posts() ) : $wpdispensary_coupons_shortcode->the_post();
			
			$do_not_duplicate = $post->ID;
			
					echo "<div class='wpd-coupons-plugin-meta'>";

					if ( 'yes' == $title ) {
						/** Display coupon title */
						echo "<span class='wpd-coupons-plugin-meta-item'><h3><a href='" . get_permalink( $post->ID ) ."'>". get_the_title( $post->ID ) ."</a></h3></span>";
					}
					
					if ( 'yes' == $details ) {
						/** Display coupon details */
						echo "<p><span class='wpd-coupons-plugin-meta-item'>". the_content() ."</span></p>";
					}

					echo "</div>";

			endwhile; // end loop

	$output_string = ob_get_contents();
	ob_end_clean();

	return $output_string;

}

add_shortcode( 'wpd-coupons', 'wpdcoupons_shortcode' );
