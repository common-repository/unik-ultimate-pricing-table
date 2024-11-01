<?php
/**
 * Plugin Name: Unik - Ultimate Pricing Table
 * Plugin URI:  https://jeweltheme.com
 * Description: Ultimate Pricing Table Plugin for WordPress
 * Version:     1.0.5
 * Author:      Jewel Theme
 * Author URI:  https://jeweltheme.com
 * Text Domain: unik-ultimate-pricing-table
 * Domain Path: languages/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package unik-ultimate-pricing-table
 */

/*
 * don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'unik-ultimate-pricing-table' ) );
}

$jltunik_plugin_data = get_file_data(
	__FILE__,
	array(
		'Version'     => 'Version',
		'Plugin Name' => 'Plugin Name',
		'Author'      => 'Author',
		'Description' => 'Description',
		'Plugin URI'  => 'Plugin URI',
	),
	false
);

// Define Constants.
if ( ! defined( 'JLTUNIK' ) ) {
	define( 'JLTUNIK', $jltunik_plugin_data['Plugin Name'] );
}

if ( ! defined( 'JLTUNIK_VER' ) ) {
	define( 'JLTUNIK_VER', $jltunik_plugin_data['Version'] );
}

if ( ! defined( 'JLTUNIK_AUTHOR' ) ) {
	define( 'JLTUNIK_AUTHOR', $jltunik_plugin_data['Author'] );
}

if ( ! defined( 'JLTUNIK_DESC' ) ) {
	define( 'JLTUNIK_DESC', $jltunik_plugin_data['Author'] );
}

if ( ! defined( 'JLTUNIK_URI' ) ) {
	define( 'JLTUNIK_URI', $jltunik_plugin_data['Plugin URI'] );
}

if ( ! defined( 'JLTUNIK_DIR' ) ) {
	define( 'JLTUNIK_DIR', __DIR__ );
}

if ( ! defined( 'JLTUNIK_FILE' ) ) {
	define( 'JLTUNIK_FILE', __FILE__ );
}

if ( ! defined( 'JLTUNIK_SLUG' ) ) {
	define( 'JLTUNIK_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'JLTUNIK_BASE' ) ) {
	define( 'JLTUNIK_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'JLTUNIK_PATH' ) ) {
	define( 'JLTUNIK_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'JLTUNIK_URL' ) ) {
	define( 'JLTUNIK_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

if ( ! defined( 'JLTUNIK_INC' ) ) {
	define( 'JLTUNIK_INC', JLTUNIK_PATH . '/Inc/' );
}

if ( ! defined( 'JLTUNIK_LIBS' ) ) {
	define( 'JLTUNIK_LIBS', JLTUNIK_PATH . 'Libs' );
}

if ( ! defined( 'JLTUNIK_ASSETS' ) ) {
	define( 'JLTUNIK_ASSETS', JLTUNIK_URL . 'assets/' );
}

if ( ! defined( 'JLTUNIK_IMAGES' ) ) {
	define( 'JLTUNIK_IMAGES', JLTUNIK_ASSETS . 'images' );
}

if ( ! class_exists( '\\JLTUNIK\\JLT_Unik_Pricing_Table' ) ) {
	// Autoload Files.
	include_once JLTUNIK_DIR . '/vendor/autoload.php';
	// Instantiate JLT_Unik_Pricing_Table Class.
	include_once JLTUNIK_DIR . '/class-unik-ultimate-pricing-table.php';
}