<?php
namespace JLTUNIK;

use JLTUNIK\Libs\Assets;
use JLTUNIK\Libs\Helper;
use JLTUNIK\Libs\Featured;
use JLTUNIK\Inc\Classes\Recommended_Plugins;
use JLTUNIK\Inc\Classes\Notifications\Notifications;
use JLTUNIK\Inc\Classes\Pro_Upgrade;
use JLTUNIK\Inc\Classes\Row_Links;
use JLTUNIK\Inc\Classes\Upgrade_Plugin;
use JLTUNIK\Inc\Classes\Feedback;
use JLTUNIK\Inc\Classes\Unik_CPT;
use JLTUNIK\Inc\Classes\Shortcodes;

/**
 * Main Class
 *
 * @unik-ultimate-pricing-table
 * Jewel Theme <support@jeweltheme.com>
 * @version     1.0.4
 */

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JLT_Unik_Pricing_Table Class
 */
if ( ! class_exists( '\JLTUNIK\JLT_Unik_Pricing_Table' ) ) {

	/**
	 * Class: JLT_Unik_Pricing_Table
	 */
	final class JLT_Unik_Pricing_Table {

		const VERSION            = JLTUNIK_VER;
		private static $instance = null;

		/**
		 * what we collect construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'jltunik_plugins_loaded' ), 999 );
			// Body Class.
			add_filter( 'admin_body_class', array( $this, 'jltunik_body_class' ) );
			// This should run earlier .
			// add_action( 'plugins_loaded', [ $this, 'jltunik_maybe_run_upgrades' ], -100 ); .
		}

		/**
		 * plugins_loaded method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltunik_plugins_loaded() {
			$this->jltunik_activate();
		}

		/**
		 * Version Key
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function plugin_version_key() {
			return Helper::jltunik_slug_cleanup() . '_version';
		}

		/**
		 * Activation Hook
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function jltunik_activate() {
			$current_jltunik_version = get_option( self::plugin_version_key(), null );

			if ( get_option( 'jltunik_activation_time' ) === false ) {
				update_option( 'jltunik_activation_time', strtotime( 'now' ) );
			}

			if ( is_null( $current_jltunik_version ) ) {
				update_option( self::plugin_version_key(), self::VERSION );
			}

			$allowed = get_option( Helper::jltunik_slug_cleanup() . '_allow_tracking', 'no' );

			// if it wasn't allowed before, do nothing .
			if ( 'yes' !== $allowed ) {
				return;
			}
			// re-schedule and delete the last sent time so we could force send again .
			$hook_name = Helper::jltunik_slug_cleanup() . '_tracker_send_event';
			if ( ! wp_next_scheduled( $hook_name ) ) {
				wp_schedule_event( time(), 'weekly', $hook_name );
			}
		}


		/**
		 * Add Body Class
		 *
		 * @param [type] $classes .
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltunik_body_class( $classes ) {
			$classes .= ' unik-ultimate-pricing-table ';
			return $classes;
		}

		/**
		 * Run Upgrader Class
		 *
		 * @return void
		 */
		public function jltunik_maybe_run_upgrades() {
			if ( ! is_admin() && ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Run Upgrader .
			$upgrade = new Upgrade_Plugin();

			// Need to work on Upgrade Class .
			if ( $upgrade->if_updates_available() ) {
				$upgrade->run_updates();
			}
		}

		/**
		 * Include methods
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {
			new Assets();
			new Recommended_Plugins();
			new Row_Links();
			new Pro_Upgrade();
			new Notifications();
			new Featured();
			new Feedback();
			new Unik_CPT();
			new Shortcodes();
		}


		/**
		 * Initialization
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltunik_init() {
			$this->jltunik_load_textdomain();
		}


		/**
		 * Text Domain
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltunik_load_textdomain() {
			$domain = 'unik-ultimate-pricing-table';
			$locale = apply_filters( 'jltunik_plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( JLTUNIK_BASE ) . '/languages/' );
		}
		
		
		

		/**
		 * Returns the singleton instance of the class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof JLT_Unik_Pricing_Table ) ) {
				self::$instance = new JLT_Unik_Pricing_Table();
				self::$instance->jltunik_init();
			}

			return self::$instance;
		}
	}

	// Get Instant of JLT_Unik_Pricing_Table Class .
	JLT_Unik_Pricing_Table::get_instance();
}