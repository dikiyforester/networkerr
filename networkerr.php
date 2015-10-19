<?php
/*
Plugin Name: Networkerr
Plugin URI:  https://github.com/dikiyforester/networkerr
Description: Enable additional social networks support for the Taskerr theme.
Version:     1.0
Author:      Artem Frolov
Author URI:  https://profiles.wordpress.org/dikiy_forester
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: networkerr
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'NWKR_TD', 'networkerr' );
define( 'NWKR_VER', '1.0' );

add_action( 'init', 'nwkr_init' );

/**
 * Initiates the plugin.
 */
function nwkr_init() {

	if ( ! class_exists( 'APP_Social_Networks' ) ) {
		return;
	}

	// Register networks in the AppThemes social API.
	APP_Social_Networks::register_network( 'vk', array(
		'title' => __( 'VK', NWKR_TD ),
		'base_url' => 'https://vk.com/'
	) );

	// Add filters to allow networks.
	add_filter( 'tr_user_social', 'nwkr_allow_network' );
	add_filter( 'tr_top_bar_social', 'nwkr_allow_network' );
	add_filter( 'tr_settings_social', 'nwkr_allow_network' );
	add_filter( 'tr_author_social_info', 'nwkr_allow_network' );

	// Enqueue custom icon font.
	add_action( 'wp_enqueue_scripts', 'nwkr_enqueue_scripts' );
}

/**
 * Adds networks on the top of the available networks list.
 *
 * @param array $networks Allowed networks.
 * @return array Updated list of the allowed networks.
 */
function nwkr_allow_network( $networks ) {
	return array_merge( array( 'vk' ), $networks );
}

/**
 * Enqueue custom icon font.
 */
function nwkr_enqueue_scripts() {
	$uri = plugin_dir_url( __FILE__ ) . '/css/nwkr-font.css';
	wp_enqueue_style( 'nwkr-font', $uri, array( 'genericons' ), NWKR_VER );
}