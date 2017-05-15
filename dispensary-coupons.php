<?php
/**
 * Plugin Name:	Dispensary Coupons
 * Plugin URI:	http://www.wpdispensary.com/
 * Description:	Easily add and display coupons for your marijuana dispensary business. Brought to you by <a href="http://www.wpdispensary.com">WP Dispensary</a> and <a href="http://www.deviodigital.com/">Devio Digital</a>.
 * Version:		1.4
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
 * Coupons post type creation
 *
 * @since	   1.0.0
 */
if ( ! function_exists( 'wpdispensary_coupons' ) ) {

/** Register Custom Post Type */
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
		'menu_icon'             => plugin_dir_url( __FILE__ ) . ( 'images/menu-icon.png' ),
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

if ( in_array( 'wp-dispensary/wp-dispensary.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
/**
 * Flowers Coupons
 *
 * Adds the option to select a Flower in the Dispensary Coupons custom post type
 *
 * @since    1.0.0
 */

class Coupons_Flowers {
	var $FOR_POST_TYPE = 'coupons';
	var $SELECT_POST_TYPE = 'flowers';
	var $SELECT_POST_LABEL = 'Flower';
	var $box_id;
	var $box_label;
	var $field_id;
	var $field_label;
	var $field_name;
	var $meta_key;
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	function admin_init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		$this->meta_key     = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id       = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id     = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name   = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label    = __( 'Apply Coupon to Flower', 'wpd-coupons' );
		$this->field_label  = __( "Choose {$this->SELECT_POST_LABEL}", 'wpd-coupons' );
	}
	function add_meta_boxes() {
		add_meta_box(
			$this->box_id,
			$this->box_label,
			array( $this, 'select_box' ),
			$this->FOR_POST_TYPE,
			'side'
		);
	}
	function select_box( $post ) {
		$selected_post_id = get_post_meta( $post->ID, $this->meta_key, true );
		global $wp_post_types;
		$save_hierarchical = $wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical;
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = true;
		wp_dropdown_pages( array(
			'id' => $this->field_id,
			'name' => $this->field_name,
			'selected' => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type' => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	function save_post( $post_id, $post ) {
		if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$fieldflowers = sanitize_text_field( $_POST['selected_flowers'] );
			update_post_meta( $post_id, $this->meta_key, $fieldflowers );
		}
	}
}
new Coupons_Flowers();

/**
 * Edibles Coupons
 *
 * Adds the option to select an Edible in the Dispensary Coupons custom post type
 *
 * @since    1.0.0
 */

class Coupons_Edibles {
	var $FOR_POST_TYPE = 'coupons';
	var $SELECT_POST_TYPE = 'edibles';
	var $SELECT_POST_LABEL = 'Edible';
	var $box_id;
	var $box_label;
	var $field_id;
	var $field_label;
	var $field_name;
	var $meta_key;
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	function admin_init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		$this->meta_key     = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id       = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id     = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name   = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label    = __( 'Apply Coupon to Edible', 'wpd-coupons' );
		$this->field_label  = __( "Choose {$this->SELECT_POST_LABEL}", 'wpd-coupons' );
	}
	function add_meta_boxes() {
		add_meta_box(
			$this->box_id,
			$this->box_label,
			array( $this, 'select_box' ),
			$this->FOR_POST_TYPE,
			'side'
		);
	}
	function select_box( $post ) {
		$selected_post_id = get_post_meta( $post->ID, $this->meta_key, true );
		global $wp_post_types;
		$save_hierarchical = $wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical;
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = true;
		wp_dropdown_pages( array(
			'id' => $this->field_id,
			'name' => $this->field_name,
			'selected' => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type' => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	function save_post( $post_id, $post ) {
		if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$fieldedibles = sanitize_text_field( $_POST['selected_edibles'] );
			update_post_meta( $post_id, $this->meta_key, $fieldedibles );
		}
	}
}
new Coupons_Edibles();

/**
 * Concentrates Coupons
 *
 * Adds the option to select a Concentrate in the Dispensary Coupons custom post type
 *
 * @since    1.0.0
 */

class Coupons_Concentrates {
	var $FOR_POST_TYPE = 'coupons';
	var $SELECT_POST_TYPE = 'concentrates';
	var $SELECT_POST_LABEL = 'Concentrate';
	var $box_id;
	var $box_label;
	var $field_id;
	var $field_label;
	var $field_name;
	var $meta_key;
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	function admin_init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		$this->meta_key     = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id       = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id     = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name   = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label    = __( 'Apply Coupon to Concentrate', 'wpd-coupons' );
		$this->field_label  = __( "Choose {$this->SELECT_POST_LABEL}", 'wpd-coupons' );
	}
	function add_meta_boxes() {
		add_meta_box(
			$this->box_id,
			$this->box_label,
			array( $this, 'select_box' ),
			$this->FOR_POST_TYPE,
			'side'
		);
	}
	function select_box( $post ) {
		$selected_post_id = get_post_meta( $post->ID, $this->meta_key, true );
		global $wp_post_types;
		$save_hierarchical = $wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical;
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = true;
		wp_dropdown_pages( array(
			'id' => $this->field_id,
			'name' => $this->field_name,
			'selected' => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type' => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	function save_post( $post_id, $post ) {
		if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$fieldconcentrates = sanitize_text_field( $_POST['selected_concentrates'] );
			update_post_meta( $post_id, $this->meta_key, $fieldconcentrates );
		}
	}
}
new Coupons_Concentrates();

/**
 * Pre-rolls Coupons
 *
 * Adds the option to select a Pre-roll in the Dispensary Coupons custom post type
 *
 * @since    1.0.0
 */

class Coupons_Prerolls {
	var $FOR_POST_TYPE = 'coupons';
	var $SELECT_POST_TYPE = 'prerolls';
	var $SELECT_POST_LABEL = 'Pre-roll';
	var $box_id;
	var $box_label;
	var $field_id;
	var $field_label;
	var $field_name;
	var $meta_key;
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	function admin_init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		$this->meta_key     = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id       = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id     = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name   = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label    = __( 'Apply Coupon to Pre-roll', 'wpd-coupons' );
		$this->field_label  = __( "Choose {$this->SELECT_POST_LABEL}", 'wpd-coupons' );
	}
	function add_meta_boxes() {
		add_meta_box(
			$this->box_id,
			$this->box_label,
			array( $this, 'select_box' ),
			$this->FOR_POST_TYPE,
			'side'
		);
	}
	function select_box( $post ) {
		$selected_post_id = get_post_meta( $post->ID, $this->meta_key, true );
		global $wp_post_types;
		$save_hierarchical = $wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical;
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = true;
		wp_dropdown_pages( array(
			'id' => $this->field_id,
			'name' => $this->field_name,
			'selected' => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type' => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	function save_post( $post_id, $post ) {
		if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$fieldprerolls = sanitize_text_field( $_POST['selected_prerolls'] );
			update_post_meta( $post_id, $this->meta_key, $fieldprerolls );
		}
	}
}
new Coupons_Prerolls();

/**
 * Topicals Coupons
 *
 * Adds the option to select a Topical in the Dispensary Coupons custom post type
 *
 * @since    1.1.0
 */

class Coupons_Topicals {
	var $FOR_POST_TYPE = 'coupons';
	var $SELECT_POST_TYPE = 'topicals';
	var $SELECT_POST_LABEL = 'Topical';
	var $box_id;
	var $box_label;
	var $field_id;
	var $field_label;
	var $field_name;
	var $meta_key;
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	function admin_init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		$this->meta_key     = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id       = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id     = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name   = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label    = __( 'Apply Coupon to Topical', 'wpd-coupons' );
		$this->field_label  = __( "Choose {$this->SELECT_POST_LABEL}", 'wpd-coupons' );
	}
	function add_meta_boxes() {
		add_meta_box(
			$this->box_id,
			$this->box_label,
			array( $this, 'select_box' ),
			$this->FOR_POST_TYPE,
			'side'
		);
	}
	function select_box( $post ) {
		$selected_post_id = get_post_meta( $post->ID, $this->meta_key, true );
		global $wp_post_types;
		$save_hierarchical = $wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical;
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = true;
		wp_dropdown_pages( array(
			'id' => $this->field_id,
			'name' => $this->field_name,
			'selected' => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type' => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	function save_post( $post_id, $post ) {
		if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$fieldconcentrates = sanitize_text_field( $_POST['selected_topicals'] );
			update_post_meta( $post_id, $this->meta_key, $fieldconcentrates );
		}
	}
}
new Coupons_Topicals();


}

/**
 * Growers Coupons
 *
 * Adds the option to select a Grower in the Dispensary Coupons custom post type
 *
 * @since    1.3.0
 */

class Coupons_Growers {
	var $FOR_POST_TYPE = 'coupons';
	var $SELECT_POST_TYPE = 'growers';
	var $SELECT_POST_LABEL = 'Grower';
	var $box_id;
	var $box_label;
	var $field_id;
	var $field_label;
	var $field_name;
	var $meta_key;
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	function admin_init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		$this->meta_key     = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id       = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id     = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name   = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label    = __( 'Apply Coupon to Grower', 'wpd-coupons' );
		$this->field_label  = __( "Choose {$this->SELECT_POST_LABEL}", 'wpd-coupons' );
	}
	function add_meta_boxes() {
		add_meta_box(
			$this->box_id,
			$this->box_label,
			array( $this, 'select_box' ),
			$this->FOR_POST_TYPE,
			'side'
		);
	}
	function select_box( $post ) {
		$selected_post_id = get_post_meta( $post->ID, $this->meta_key, true );
		global $wp_post_types;
		$save_hierarchical = $wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical;
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = true;
		wp_dropdown_pages( array(
			'id' => $this->field_id,
			'name' => $this->field_name,
			'selected' => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type' => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	function save_post( $post_id, $post ) {
		if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$fieldflowers = sanitize_text_field( $_POST['selected_growers'] );
			update_post_meta( $post_id, $this->meta_key, $fieldflowers );
		}
	}
}
new Coupons_Growers();


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
	public function __construct() {

		parent::__construct(
			'wpdcoupons_widget',
			__( 'Dispensary Coupons', 'wpd-coupons' ),
			array(
				'description' => __( 'Display your recent dispensary coupons.', 'wpd-coupons' ),
				'classname'   => 'wpd-coupons-widget',
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

		global $post;

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

					if('on' == $instance['couponimage'] ) {
						/** Display coupon featured image */
						echo the_post_thumbnail( 'medium' );
					}

					if('on' == $instance['coupontitle'] ) {
						/** Display coupon title */
						echo "<span class='wpd-coupons-plugin-meta-item'><h3><a href='" . get_permalink( $post->ID ) ."'>". get_the_title( $post->ID ) ."</a></h3></span>";
					}
					
					if('on' == $instance['coupondetails'] ) {
						/** Display coupon details */
						echo "<p><span class='wpd-coupons-plugin-meta-item'>". the_content() ."</span></p>";
					}
					
					if('on' == $instance['couponproduct'] ) {
						/** Display products that the coupon applies to */
						$couponflower		= get_post_meta( get_the_id(), '_selected_flowers', true );
						$couponedible		= get_post_meta( get_the_id(), '_selected_edibles', true );
						$couponconcentrate	= get_post_meta( get_the_id(), '_selected_concentrates', true );
						$couponpreroll		= get_post_meta( get_the_id(), '_selected_prerolls', true );
						$coupontopical		= get_post_meta( get_the_id(), '_selected_topicals', true );
						$coupongrower		= get_post_meta( get_the_id(), '_selected_growers', true );
						
						echo "<span class='wpd-coupons-plugin-meta-item'>";
						
						if ( ! $couponflower == '' ) {
							echo "<strong>Flower:</strong> <a href='". get_permalink( $couponflower ) ."'>". get_the_title( $couponflower ) ."</a> ";
						}
						if ( ! $couponedible == '' ) {
							echo "<strong>Edible:</strong> <a href='". get_permalink( $couponedible ) ."'>". get_the_title( $couponedible ) ."</a> ";
						}
						if ( ! $couponconcentrate == '' ) {
							echo "<strong>Concentrate:</strong> <a href='". get_permalink( $couponconcentrate ) ."'>". get_the_title( $couponconcentrate ) ."</a> ";
						}
						if ( ! $couponpreroll == '' ) {
							echo "<strong>Pre-roll:</strong> <a href='". get_permalink( $couponpreroll ) ."'>". get_the_title( $couponpreroll ) ."</a>";
						}
						if ( ! $coupontopical == '' ) {
							echo "<strong>Topical:</strong> <a href='". get_permalink( $coupontopical ) ."'>". get_the_title( $coupontopical ) ."</a>";
						}
						if ( ! $coupongrower == '' ) {
							echo "<strong>Grower:</strong> <a href='". get_permalink( $coupongrower ) ."'>". get_the_title( $coupongrower ) ."</a>";
						}
						
						echo "</span>";
					}

					echo "</div>";

					if('on' == $instance['viewall'] ) {
						/** Display link to all coupons */
						echo "<p><span class='wpd-coupons-plugin-meta-item'><a class='wpd-coupons-plugin-viewall' href='". $instance['viewallurl'] ."' target='_blank'>View all coupons &rarr;</a></span></p>";
					}

			endwhile; // end loop

			wp_reset_postdata();

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
        $instance['couponimage']		= $new_instance['couponimage'];
        $instance['coupondetails']		= $new_instance['coupondetails'];
		$instance['couponproduct']		= $new_instance['couponproduct'];
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
            'title'				=> 'Dispensary Coupons',
            'limit'				=> '5',
            'coupontitle'		=> '',
            'couponimage'		=> '',
            'coupondetails'		=> '',
            'couponproduct'		=> '',
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
			<input class="checkbox" type="checkbox" <?php checked($instance['couponimage'], 'on'); ?> id="<?php echo $this->get_field_id('couponimage'); ?>" name="<?php echo $this->get_field_name('couponimage'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'couponimage' ) ); ?>"><?php _e( 'Display coupon featured image?', 'wpd-coupons' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['coupondetails'], 'on'); ?> id="<?php echo $this->get_field_id('coupondetails'); ?>" name="<?php echo $this->get_field_name('coupondetails'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'coupondetails' ) ); ?>"><?php _e( 'Display coupon details?', 'wpd-coupons' ); ?></label>
        </p>

		<?php if( is_plugin_active( 'wp-dispensary/wp-dispensary.php' ) ) { ?>
	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['couponproduct'], 'on'); ?> id="<?php echo $this->get_field_id('couponproduct'); ?>" name="<?php echo $this->get_field_name('couponproduct'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'couponproduct' ) ); ?>"><?php _e( 'Display products this coupon applies to?', 'wpd-coupons' ); ?></label>
        </p>
		<?php } ?>

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
		'limit'		=> '5',
		'image'		=> 'yes',
		'title'		=> 'yes',
		'details'	=> 'yes',
		'products'	=> 'yes'
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

		/** Display products that the coupon applies to */
		$couponflower		= get_post_meta( get_the_id(), '_selected_flowers', true );
		$couponedible		= get_post_meta( get_the_id(), '_selected_edibles', true );
		$couponconcentrate	= get_post_meta( get_the_id(), '_selected_concentrates', true );
		$couponpreroll		= get_post_meta( get_the_id(), '_selected_prerolls', true );
		$coupontopical		= get_post_meta( get_the_id(), '_selected_topicals', true );
		$coupongrower		= get_post_meta( get_the_id(), '_selected_growers', true );

		
			echo "<div class='wpd-coupons-plugin-meta shortcode'>";

			if ( 'yes' == $image ) {
				/** Display coupon featured image */
				echo the_post_thumbnail( 'thumbnail' );
			}
			
			if ( 'yes' == $title ) {
				/** Display coupon title */
				echo "<span class='wpd-coupons-plugin-meta-item'><h3><a href='" . get_permalink( $post->ID ) ."'>". get_the_title( $post->ID ) ."</a></h3></span>";
			}
			
			if ( 'yes' == $details ) {
				/** Display coupon details */
				echo "<p><span class='wpd-coupons-plugin-meta-item'>". the_content() ."</span></p>";
			}

			if('yes' == $products ) {

				echo "<span class='wpd-coupons-plugin-meta-item'>";
				
				if ( ! $couponflower == '' ) {
					echo "<strong>Flower:</strong> <a href='". get_permalink( $couponflower ) ."'>". get_the_title( $couponflower ) ."</a> ";
				}
				if ( ! $couponedible == '' ) {
					echo "<strong>Edible:</strong> <a href='". get_permalink( $couponedible ) ."'>". get_the_title( $couponedible ) ."</a> ";
				}
				if ( ! $couponconcentrate == '' ) {
					echo "<strong>Concentrate:</strong> <a href='". get_permalink( $couponconcentrate ) ."'>". get_the_title( $couponconcentrate ) ."</a> ";
				}
				if ( ! $couponpreroll == '' ) {
					echo "<strong>Pre-roll:</strong> <a href='". get_permalink( $couponpreroll ) ."'>". get_the_title( $couponpreroll ) ."</a>";
				}
				if ( ! $coupontopical == '' ) {
					echo "<strong>Topical:</strong> <a href='". get_permalink( $coupontopical ) ."'>". get_the_title( $coupontopical ) ."</a>";
				}
				if ( ! $coupongrower == '' ) {
					echo "<strong>Grower:</strong> <a href='". get_permalink( $coupongrower ) ."'>". get_the_title( $coupongrower ) ."</a>";
				}

				echo "</span>";
			}

			echo "</div>";

		endwhile; // end loop

	$output_string = ob_get_contents();
	ob_end_clean();

	return $output_string;

}

add_shortcode( 'wpd-coupons', 'wpdcoupons_shortcode' );


/**
 * Add Action Hook
 *
 * @since       1.4.0
 */
add_action( 'wpd_pricingoutput_bottom', 'wpd_coupons_pricing' );

function wpd_coupons_pricing() {
?>

<?php if ( in_array( get_post_type(), array( 'flowers' ) ) ) {
	
	global $post;
	$flowerid = $post->ID;

	$args = array(
		'meta_key' => '_selected_flowers',
		'meta_value' => $flowerid,
		'post_type' => 'coupons',
		'posts_per_page' => -1
	);
	$flower_coupons = new WP_Query( $args );
	if ( $flower_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="6"><span>Current Coupons:</span> ';

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
		'meta_key' => '_selected_edibles',
		'meta_value' => $edibleid,
		'post_type' => 'coupons',
		'posts_per_page' => -1
	);
	$edible_coupons = new WP_Query( $args );
	if ( $edible_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="6"><span>Current Coupons:</span> ';

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
		'meta_key' => '_selected_concentrates',
		'meta_value' => $concentrateid,
		'post_type' => 'coupons',
		'posts_per_page' => -1
	);
	$concentrate_coupons = new WP_Query( $args );
	if ( $concentrate_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="6"><span>Current Coupons:</span> ';

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
		'meta_key' => '_selected_prerolls',
		'meta_value' => $prerollid,
		'post_type' => 'coupons',
		'posts_per_page' => -1
	);
	$preroll_coupons = new WP_Query( $args );
	if ( $preroll_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="6"><span>Current Coupons:</span> ';

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
		'meta_key' => '_selected_topicals',
		'meta_value' => $topicalid,
		'post_type' => 'coupons',
		'posts_per_page' => -1
	);
	$topical_coupons = new WP_Query( $args );
	if ( $topical_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="6"><span>Current Coupons:</span> ';

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
		'meta_key' => '_selected_growers',
		'meta_value' => $growerid,
		'post_type' => 'coupons',
		'posts_per_page' => -1
	);
	$grower_coupons = new WP_Query( $args );
	if ( $grower_coupons->have_posts() ) :

	echo '<td class="wpd-coupons" colspan="6"><span>Current Coupons:</span> ';

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

<?php }

