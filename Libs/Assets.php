<?php
namespace JLTUNIK\Libs;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Assets' ) ) {

	/**
	 * Assets Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 * @version     1.0.4
	 */
	class Assets {

		/**
		 * Constructor method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'jltunik_enqueue_scripts' ), 100 );
			add_action( 'admin_enqueue_scripts', array( $this, 'jltunik_admin_enqueue_scripts' ), 100 );
		}


		/**
		 * Get environment mode
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function get_mode() {
			return defined( 'WP_DEBUG' ) && WP_DEBUG ? 'development' : 'production';
		}

		/**
		 * Enqueue Scripts
		 *
		 * @method wp_enqueue_scripts()
		 */
		public function jltunik_enqueue_scripts() {			

			// CSS Files .
			wp_enqueue_style( 'unik-ultimate-pricing-table-frontend', JLTUNIK_ASSETS . 'css/unik-ultimate-pricing-table-frontend.css', JLTUNIK_VER, 'all' );
			wp_enqueue_style( 'unik-ultimate-bootstrap', JLTUNIK_ASSETS . 'css/bootstrap.min.css', JLTUNIK_VER, 'all' );

			// JS Files .
			wp_enqueue_script( 'unik-ultimate-pricing-table-frontend', JLTUNIK_ASSETS . 'js/unik-ultimate-pricing-table-frontend.js', array( 'jquery' ), JLTUNIK_VER, true );
			wp_enqueue_script( 'unik-bootstrap', JLTUNIK_ASSETS . 'js/unik-bootstrap.js', array( 'jquery' ), JLTUNIK_VER, true );
		}


		/**
		 * Enqueue Scripts
		 *
		 * @method admin_enqueue_scripts()
		 */
		public function jltunik_admin_enqueue_scripts( $hook ) {

			if( $hook != 'post.php' && $hook != 'post-new.php' ){
				return;	
			}

			// CSS Files .
			wp_enqueue_style( 'unik-ultimate-pricing-table-admin', JLTUNIK_ASSETS . 'css/unik-ultimate-pricing-table-admin.css', array( 'dashicons' ), JLTUNIK_VER, 'all' );

			// JS Files .
			wp_enqueue_script( 'unik-ultimate-pricing-table-admin', JLTUNIK_ASSETS . 'js/unik-ultimate-pricing-table-admin.js', array( 'jquery' ), JLTUNIK_VER, true );
			wp_localize_script(
				'unik-ultimate-pricing-table-admin',
				'JLTUNIKCORE',
				array(
					'admin_ajax'        => admin_url( 'admin-ajax.php' ),
					'recommended_nonce' => wp_create_nonce( 'jltunik_recommended_nonce' ),
				)
			);
		}
	}
}