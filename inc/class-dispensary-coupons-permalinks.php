<?php

/**
 * The Class responsible for defining the custom permalink settings.
 *
 * @link       https://www.wpdispensary.com/
 * @since      1.6
 *
 * @package    WPD_Coupons
 * @subpackage WPD_Coupons/inc
 */
class WPD_Coupons_Permalink_Settings {
	/**
	 * Initialize class.
	 */
	public function __construct() {
		$this->init();
		$this->settings_save();
	}

	/**
	 * Call register fields.
	 */
	public function init() {
		add_filter( 'admin_init', array( &$this, 'register_fields' ) );
	}

	/**
	 * Add setting to permalinks page.
	 */
	public function register_fields() {
		register_setting( 'permalink', 'wpd_coupons_slug', 'esc_attr' );
		add_settings_field( 'wpd_coupons_slug_setting', '<label for="wpd_coupons_slug">' . __( 'Coupons Base', 'wpd-coupons' ) . '</label>', array( &$this, 'fields_html' ), 'permalink', 'optional' );
	}

	/**
	 * HTML for permalink setting.
	 */
	public function fields_html() {
		$value = get_option( 'wpd_coupons_slug' );
		wp_nonce_field( 'wpd-coupons-slug', 'wpd_coupons_slug_nonce' );
		echo '<input type="text" class="regular-text code" id="wpd_coupons_slug" name="wpd_coupons_slug" placeholder="coupons" value="' . esc_attr( $value ) . '" />';
	}

	/**
	 * Save permalink settings.
	 */
	public function settings_save() {
		if ( ! is_admin() ) {
			return;
		}

		// We need to save the options ourselves; settings api does not trigger save for the permalinks page.
		if ( isset( $_POST['permalink_structure'] ) ||
			 isset( $_POST['wpd_coupons_slug'] ) &&
			 wp_verify_nonce( wp_unslash( $_POST['wpd_coupons_slug_nonce'] ), 'wpd-coupons' ) ) {
				$wpd_coupons_slug = sanitize_title( wp_unslash( $_POST['wpd_coupons_slug'] ) );
				update_option( 'wpd_coupons_slug', $wpd_coupons_slug );
		}
	}
}
$wpd_coupons_permalink_settings = new WPD_Coupons_Permalink_Settings();
