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

function dispensary_coupons_add_admin_menu() {
//create a submenu under Settings
	add_submenu_page( 'wpd-settings', 'WP Dispensary\'s Coupons', 'Coupons', 'manage_options', 'edit.php?post_type=coupons', NULL );
}
add_action( 'admin_menu', 'dispensary_coupons_add_admin_menu', 5 ); 


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
		$this->meta_key    = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id      = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id    = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name  = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label   = __( 'Apply Coupon to Topical', 'wpd-coupons' );
		$this->field_label = __( "Choose {$this->SELECT_POST_LABEL}", 'wpd-coupons' );
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
			'id'               => $this->field_id,
			'name'             => $this->field_name,
			'selected'         => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type'        => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	function save_post( $post_id, $post ) {
		if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$fieldtopicals = sanitize_text_field( $_POST['selected_topicals'] );
			update_post_meta( $post_id, $this->meta_key, $fieldtopicals );
		}
	}
}
new Coupons_Topicals();


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
			'id'               => $this->field_id,
			'name'             => $this->field_name,
			'selected'         => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type'        => $this->SELECT_POST_TYPE,
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
 * Gear Coupons
 *
 * Adds the option to select Gear in the Dispensary Coupons custom post type
 *
 * @since    1.9.0
 */
class Coupons_Gear {
	var $FOR_POST_TYPE     = 'coupons';
	var $SELECT_POST_TYPE  = 'gear';
	var $SELECT_POST_LABEL = 'Gear';
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
		$this->meta_key    = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id      = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id    = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name  = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label   = __( 'Apply Coupon to Gear', 'wpd-coupons' );
		$this->field_label = __( "Choose {$this->SELECT_POST_LABEL}", 'wpd-coupons' );
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
			'id'               => $this->field_id,
			'name'             => $this->field_name,
			'selected'         => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type'        => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	function save_post( $post_id, $post ) {
		if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$fieldgear = sanitize_text_field( $_POST['selected_gear'] );
			update_post_meta( $post_id, $this->meta_key, $fieldgear );
		}
	}
}
new Coupons_Gear();


/**
 * Tinctures Coupons
 *
 * Adds the option to select a Tincture in the Dispensary Coupons custom post type
 *
 * @since    1.9.0
 */
class Coupons_Tinctures {
	var $FOR_POST_TYPE     = 'coupons';
	var $SELECT_POST_TYPE  = 'tinctures';
	var $SELECT_POST_LABEL = 'Tinctures';
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
		$this->meta_key    = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id      = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id    = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name  = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label   = __( 'Apply Coupon to Tincture', 'wpd-coupons' );
		$this->field_label = __( "Choose {$this->SELECT_POST_LABEL}", 'wpd-coupons' );
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
			'id'               => $this->field_id,
			'name'             => $this->field_name,
			'selected'         => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type'        => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	function save_post( $post_id, $post ) {
		if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$fieldtincture = sanitize_text_field( $_POST['selected_tincture'] );
			update_post_meta( $post_id, $this->meta_key, $fieldtincture );
		}
	}
}
new Coupons_Tinctures();


}


/**
 * Dispensary Coupons Widget
 *
 * @since       1.0.0
 */
class wpd_coupons_widget extends WP_Widget {

    /**
     * Constructor
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
	public function __construct() {

		parent::__construct(
			'wpd_coupons_widget',
			__( 'Dispensary Coupons', 'wpd-coupons' ),
			array(
				'description' => __( 'Your WP Dispensary coupons', 'wpd-coupons' ),
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

			$wp_dispensary_coupons_widget = new WP_Query(
				array(
					'post_type' => 'coupons',
					'showposts' => $instance['limit']
				)
			);

			while ( $wp_dispensary_coupons_widget->have_posts() ) : $wp_dispensary_coupons_widget->the_post();

			$theme = wp_get_theme(); // gets the current theme so we can check for CannaBiz from WP Dispensary
			if ( 'CannaBiz' == $theme->name || 'CannaBiz' == $theme->parent_theme ) {
				$couponlink = " target='_blank'";
			} else {
				$couponlink = '';
			}

			echo "<div class='wpd-coupons-plugin-meta'>";

					if ( 'on' == $instance['couponimage'] ) {
						/** Display coupon featured image */
						echo "<a " . $couponlink . " href='" . get_permalink( $post->ID ) . "'>";
						the_post_thumbnail( 'medium' );
						echo "</a>";
					}

					$wpd_coupon_code   = get_post_meta( $post->ID, 'wpd_coupon_code', true );
					$wpd_coupon_amount = get_post_meta( $post->ID, 'wpd_coupon_amount', true );
					$wpd_coupon_type   = get_post_meta( $post->ID, 'wpd_coupon_type', true );
					$wpd_coupon_exp    = get_post_meta( $post->ID, 'wpd_coupon_exp', true );

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

					if ( 'on' == $instance['coupontitle'] ) {
						/** Display coupon title */
						echo '<span class="wpd-coupons-plugin-meta-item title">' . get_the_title( $post->ID ) . '</span>';
					}

					// Display coupon code.
					if ( $wpd_coupon_code ) {
						echo '<span class="wpd-coupons-plugin-meta-item code"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M13.219 4h-3.926c-1.654-2.58-4.919-4.182-8.293-3.983v1.688c2.286-.164 4.79.677 6.113 2.295h-2.113v2.339c-2.059-.157-4.005.605-5 1.159l.688 1.617c1.196-.625 2.53-1.243 4.312-1.026v4.084l10.796 10.827 8.204-8.223-10.781-10.777zm-2.226 5.875c-.962.963-2.598.465-2.88-.85 1.318.139 2.192-.872 2.114-2.017 1.261.338 1.701 1.93.766 2.867z"/></svg> ' . $wpd_coupon_code . '</span>';
					}

					if ( 'on' == $instance['coupondetails'] ) {
						/** Display coupon details */
						echo '<span class="wpd-coupons-plugin-meta-item">' . the_content() . '</span>';
					}

					// Display coupon expiration date.
					if ( 'on' == $instance['couponexp'] ) {
						if ( $wpd_coupon_exp ) {
							echo '<span class="wpd-coupons-plugin-meta-item exp">' . esc_attr__( 'Exp', 'wpd-coupons' ) . ': ' . $wpd_coupon_exp . '</span>';
						}
					}

					if ( 'on' == $instance['couponproduct'] ) {
						/** Display products that the coupon applies to */
						$couponflower      = get_post_meta( get_the_id(), '_selected_flowers', true );
						$couponedible      = get_post_meta( get_the_id(), '_selected_edibles', true );
						$couponconcentrate = get_post_meta( get_the_id(), '_selected_concentrates', true );
						$couponpreroll     = get_post_meta( get_the_id(), '_selected_prerolls', true );
						$coupontopical     = get_post_meta( get_the_id(), '_selected_topicals', true );
						$coupongrower      = get_post_meta( get_the_id(), '_selected_growers', true );
						$coupongear        = get_post_meta( get_the_id(), '_selected_gear', true );
						$coupontincture    = get_post_meta( get_the_id(), '_selected_tinctures', true );

						echo "<span class='wpd-coupons-plugin-meta-item'>";

						if ( '' !== $couponflower ) {
							echo "<a href='" . get_permalink( $couponflower ) . "'>" . get_the_title( $couponflower ) . "</a> ";
						}
						if ( '' !== $couponedible ) {
							echo "<a href='" . get_permalink( $couponedible ) . "'>" . get_the_title( $couponedible ) . "</a> ";
						}
						if ( '' !== $couponconcentrate ) {
							echo "<a href='" . get_permalink( $couponconcentrate ) . "'>" . get_the_title( $couponconcentrate ) . "</a> ";
						}
						if ( '' !== $couponpreroll ) {
							echo "<a href='" . get_permalink( $couponpreroll ) . "'>" . get_the_title( $couponpreroll ) . "</a>";
						}
						if ( '' !== $coupontopical ) {
							echo "<a href='" . get_permalink( $coupontopical ) . "'>" . get_the_title( $coupontopical ) . "</a>";
						}
						if ( '' !== $coupongrower ) {
							echo "<a href='" . get_permalink( $coupongrower ) . "'>" . get_the_title( $coupongrower ) . "</a>";
						}
						if ( '' !== $coupongear ) {
							echo "<a href='" . get_permalink( $coupongear ) . "'>" . get_the_title( $coupongear ) . "</a>";
						}
						if ( '' !== $coupontincture ) {
							echo "<a href='" . get_permalink( $coupontincture ) . "'>" . get_the_title( $coupontincture ) . "</a>";
						}

						echo '</span>';
					}

					echo '</div>';

					if ( 'on' == $instance['viewall'] ) {
						/** Display link to all coupons */
						echo "<p><span class='wpd-coupons-plugin-meta-item'><a class='wpd-coupons-plugin-viewall' href='" . $instance['viewallurl'] . "' target='_blank'>" . __( 'View all coupons', 'wpd-coupons' ) . " &rarr;</a></span></p>";
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

        $instance['title']         = strip_tags( $new_instance['title'] );
        $instance['limit']         = strip_tags( $new_instance['limit'] );
        $instance['couponexp']     = $new_instance['couponexp'];
        $instance['coupontitle']   = $new_instance['coupontitle'];
        $instance['couponimage']   = $new_instance['couponimage'];
        $instance['coupondetails'] = $new_instance['coupondetails'];
		$instance['couponproduct'] = $new_instance['couponproduct'];
        $instance['viewall']       = $new_instance['viewall'];
        $instance['viewallurl']    = $new_instance['viewallurl'];

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
			'title'         => __( 'Coupons','wpd-coupons' ),
			'limit'         => '5',
			'coupon'        => '',
			'couponexp'     => 'on',
			'coupontitle'   => 'on',
			'couponimage'   => '',
			'coupondetails' => 'on',
			'couponproduct' => '',
			'viewall'       => '',
			'viewallurl'    => ''
        );

        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpd-coupons' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Amount of coupons to show:', 'wpd-coupons' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo $instance['limit']; ?>" />
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['couponexp'], 'on' ); ?> id="<?php echo $this->get_field_id( 'couponexp' ); ?>" name="<?php echo $this->get_field_name( 'couponexp' ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'couponexp' ) ); ?>"><?php esc_html_e( 'Display coupon expiration?', 'wpd-coupons' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['coupontitle'], 'on' ); ?> id="<?php echo $this->get_field_id( 'coupontitle' ); ?>" name="<?php echo $this->get_field_name( 'coupontitle' ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'coupontitle' ) ); ?>"><?php esc_html_e( 'Display coupon title?', 'wpd-coupons' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['couponimage'], 'on' ); ?> id="<?php echo $this->get_field_id( 'couponimage' ); ?>" name="<?php echo $this->get_field_name( 'couponimage' ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'couponimage' ) ); ?>"><?php esc_html_e( 'Display coupon featured image?', 'wpd-coupons' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['coupondetails'], 'on' ); ?> id="<?php echo $this->get_field_id( 'coupondetails' ); ?>" name="<?php echo $this->get_field_name( 'coupondetails' ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'coupondetails' ) ); ?>"><?php esc_html_e( 'Display coupon details?', 'wpd-coupons' ); ?></label>
        </p>

		<?php if ( is_plugin_active( 'wp-dispensary/wp-dispensary.php' ) ) { ?>
	    <p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['couponproduct'], 'on' ); ?> id="<?php echo $this->get_field_id( 'couponproduct' ); ?>" name="<?php echo $this->get_field_name( 'couponproduct' ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'couponproduct' ) ); ?>"><?php esc_html_e( 'Display products this coupon applies to?', 'wpd-coupons' ); ?></label>
        </p>
		<?php } ?>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['viewall'], 'on' ); ?> id="<?php echo $this->get_field_id( 'viewall' ); ?>" name="<?php echo $this->get_field_name( 'viewall' ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'viewall' ) ); ?>"><?php esc_html_e( 'Display link to all coupons?', 'wpd-coupons' ); ?></label>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'viewallurl' ) ); ?>"><?php esc_html_e( 'View all coupons URL:', 'wpd-coupons' ); ?></label>
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
function wpd_coupons_register_widget() {
    register_widget( 'wpd_coupons_widget' );
}
add_action( 'widgets_init', 'wpd_coupons_register_widget' );


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
	), $atts ) );

	ob_start();

	$wpd_coupons_shortcode = new WP_Query(
		array(
			'post_type' => 'coupons',
			'showposts' => $limit
		)
	);

	while ( $wpd_coupons_shortcode->have_posts() ) : $wpd_coupons_shortcode->the_post();

	echo '<div class="wpd-coupons-plugin-meta shortcode">';

	if ( 'yes' == $image ) {
		/** Display coupon featured image */
		if ( 'medium' == $imagesize ) {
			the_post_thumbnail( 'medium' );
		} else {
			the_post_thumbnail( $imagesize );
		}
	}

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
	if ( 'yes' == $couponexp ) {
		if ( $wpd_coupon_exp ) {
			echo '<span class="wpd-coupons-plugin-meta-item exp">' . esc_attr__( 'Exp', 'wpd-coupons' ) . ': ' . $wpd_coupon_exp . '</span>';
		}
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
		$couponflower      = get_post_meta( get_the_id(), '_selected_flowers', true );
		$couponedible      = get_post_meta( get_the_id(), '_selected_edibles', true );
		$couponconcentrate = get_post_meta( get_the_id(), '_selected_concentrates', true );
		$couponpreroll     = get_post_meta( get_the_id(), '_selected_prerolls', true );
		$coupontopical     = get_post_meta( get_the_id(), '_selected_topicals', true );
		$coupongrower      = get_post_meta( get_the_id(), '_selected_growers', true );
		$coupongear        = get_post_meta( get_the_id(), '_selected_gear', true );
		$coupontincture    = get_post_meta( get_the_id(), '_selected_tinctures', true );

		echo "<span class='wpd-coupons-plugin-meta-item'>";

		if ( '' !== $couponflower ) {
			echo "<a href='" . get_permalink( $couponflower ) . "'>" . get_the_title( $couponflower ) . "</a> ";
		}
		if ( '' !== $couponedible ) {
			echo "<a href='" . get_permalink( $couponedible ) . "'>" . get_the_title( $couponedible ) . "</a> ";
		}
		if ( '' !== $couponconcentrate ) {
			echo "<a href='" . get_permalink( $couponconcentrate ) . "'>" . get_the_title( $couponconcentrate ) . "</a> ";
		}
		if ( '' !== $couponpreroll ) {
			echo "<a href='" . get_permalink( $couponpreroll ) . "'>" . get_the_title( $couponpreroll ) . "</a>";
		}
		if ( '' !== $coupontopical ) {
			echo "<a href='" . get_permalink( $coupontopical ) . "'>" . get_the_title( $coupontopical ) . "</a>";
		}
		if ( '' !== $coupongrower ) {
			echo "<a href='" . get_permalink( $coupongrower ) . "'>" . get_the_title( $coupongrower ) . "</a>";
		}
		if ( '' !== $coupongear ) {
			echo "<a href='" . get_permalink( $coupongear ) . "'>" . get_the_title( $coupongear ) . "</a>";
		}
		if ( '' !== $coupontincture ) {
			echo "<a href='" . get_permalink( $coupontincture ) . "'>" . get_the_title( $coupontincture ) . "</a>";
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
