<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
/**
 * Plugin Name:       Favorite Toots
 * Description:       Add embeds of your favorite toots from Mastodon to your website using an Editor Block.
 * Plugin URI: 		  https://cdevroe.com/favorite-toots
 * Version:           0.2.5
 * Requires at least: 6.2
 * Requires PHP:      7.0
 * Author:            Colin Devroe
 * Author URI:		  https://cdevroe.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       favorite-toots
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load necessary code
 * Load Favorite Toots Block
 */
function cdevroe_tootfaves_init() {
	require __DIR__ . '/inc_admin.php';
	require __DIR__ . '/inc_ajax.php';
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'cdevroe_tootfaves_init' );

/**
 * Allow iframes
 */
function cdevroe_tootfaves_allow_embed_scripts( $allowed_tags ){
    
	$allowed_tags['script'] = array(
		'src' => true,
		'data-allowed-prefixes' => true,
		'async' => true,
	);

	return $allowed_tags;
}
add_filter( 'wp_kses_allowed_html', 'cdevroe_tootfaves_allow_embed_scripts', 1 );

/** 
 * Enqueue JavaScript needed to adjust height of iframes
 */
function cdevroe_tootfaves_enqueue_scripts( ) {
	$cdevroe_tootfaves_data = get_plugin_data( __FILE__ );
	wp_enqueue_script( 'cdevroe_tootfaves_javascript', plugin_dir_url( __FILE__ ) . '/assets/js/cdevroe-favorite-toots.js', array(), $cdevroe_tootfaves_data['Version'], true );
}
add_action( 'wp_enqueue_scripts', 'cdevroe_tootfaves_enqueue_scripts' );