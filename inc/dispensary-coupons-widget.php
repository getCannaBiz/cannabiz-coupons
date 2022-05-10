<?php
/**
 * The file responsible for defining the coupons widget.
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
 * Dispensary Coupons Widget
 *
 * @since       1.0.0
 */
class WPD_Coupons_Widget extends WP_Widget {

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
				'description' => esc_attr__( 'WP Dispensary coupons', 'wpd-coupons' ),
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
        if ( ! isset( $args['id'] ) ) {
            $args['id'] = 'dispensary_coupons_widget';
        }

        $title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

        echo $args['before_widget'];

        if ( $title ) {
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

			$theme       = wp_get_theme();
            $coupon_link = '';
            $img_size    = apply_filters( 'wpd_coupons_widget_image_size', 'medium' );

            if ( 'CannaBiz' == $theme->name || 'CannaBiz' == $theme->parent_theme ) {
				$coupon_link = " target='_blank'";
			}

			echo '<div class="wpd-coupons-plugin-meta">';

                // Display coupon featured image.
                if ( 'on' == $instance['couponimage'] ) {
                    echo '<a ' . $coupon_link . ' href="' . get_permalink( $post->ID ) . '">';
                    the_post_thumbnail( $img_size );
                    echo '</a>';
                }

                // Get the Coupon metadata.
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

                    echo '<span class="wpd-coupons-plugin-meta-item amount">' . esc_attr__( 'Save', 'dispensary-coupons' ) . ' ' . $coupon_amount . '</span>';
                }

                if ( 'on' == $instance['coupontitle'] ) {
                    /** Display coupon title */
                    echo '<span class="wpd-coupons-plugin-meta-item title">' . get_the_title( $post->ID ) . '</span>';
                }

                // Display coupon code.
                if ( $wpd_coupon_code ) {
                    echo '<span class="wpd-coupons-plugin-meta-item code"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M13.219 4h-3.926c-1.654-2.58-4.919-4.182-8.293-3.983v1.688c2.286-.164 4.79.677 6.113 2.295h-2.113v2.339c-2.059-.157-4.005.605-5 1.159l.688 1.617c1.196-.625 2.53-1.243 4.312-1.026v4.084l10.796 10.827 8.204-8.223-10.781-10.777zm-2.226 5.875c-.962.963-2.598.465-2.88-.85 1.318.139 2.192-.872 2.114-2.017 1.261.338 1.701 1.93.766 2.867z"/></svg> ' . $wpd_coupon_code . '</span>';
                }

                // Display coupon details.
                if ( 'on' == $instance['coupondetails'] ) {
                    echo '<span class="wpd-coupons-plugin-meta-item">' . the_content() . '</span>';
                }

                // Display coupon expiration date.
                if ( 'on' == $instance['couponexp'] && $wpd_coupon_exp ) {
                    echo '<span class="wpd-coupons-plugin-meta-item exp">' . esc_attr__( 'Exp', 'wpd-coupons' ) . ': ' . $wpd_coupon_exp . '</span>';
                }

                // Display products that the coupon applies to.
                if ( 'on' == $instance['couponproduct'] ) {
                    $selected_product = get_post_meta( get_the_id(), 'selected_product', true );
            
                    echo '<span class="wpd-coupons-plugin-meta-item">';

                    if ( '' !== $selected_product ) {
                        echo '<a href="' . get_permalink( $selected_product ) . '">' . get_the_title( $selected_product ) . '</a> ';
                    }
            
                    echo '</span>';
                }

                echo '</div>';

                // Display link to all coupons.
                if ( 'on' == $instance['viewall'] ) {
                    echo "<p><span class='wpd-coupons-plugin-meta-item'><a class='wpd-coupons-plugin-viewall' href='" . $instance['viewallurl'] . "' target='_blank'>" . esc_attr__( 'View all coupons', 'wpd-coupons' ) . " &rarr;</a></span></p>";
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
			'title'         => esc_attr__( 'Coupons','wpd-coupons' ),
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
    register_widget( 'WPD_Coupons_Widget' );
}
add_action( 'widgets_init', 'wpd_coupons_register_widget' );
