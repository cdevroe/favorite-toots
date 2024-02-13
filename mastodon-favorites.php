<?php
/**
 * Plugin Name:       Mastodon Favorites
 * Description:       Add embeds of your favorite toots from Mastodon to your website using an Editor Block.
 * Plugin URI: 		  https://cdevroe.com/projects/mastodon-favorites
 * Version:           0.2.1
 * Requires at least: 6.2
 * Requires PHP:      7.0
 * Author:            Colin Devroe
 * Author URI:		  https://cdevroe.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mastodon-favorites
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load necessary code
 * Load Mastodon Favorites Block
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
function cdevroe_tootfaves_allow_iframes( $allowed_tags ){
    
	$allowed_tags['iframe'] = array(
		'align' => true,
		'allow' => true,
		'allowfullscreen' => true,
		'class' => true,
		'frameborder' => true,
		'height' => true,
		'id' => true,
		'marginheight' => true,
		'marginwidth' => true,
		'name' => true,
		'scrolling' => true,
		'src' => true,
		'style' => true,
		'width' => true,
		'height' => true,
		'allowFullScreen' => true,
		'frameborder' => true,
		'mozallowfullscreen' => true,
		'title' => true,
		'webkitAllowFullScreen' => true,
	);

	return $allowed_tags;
}
add_filter( 'wp_kses_allowed_html', 'cdevroe_tootfaves_allow_iframes', 1 );

/** 
 * Enqueue JavaScript needed to adjust height of iframes
 */
function cdevroe_tootfaves_enqueue_scripts( ) {
	$cdevroe_tootfaves_data = get_plugin_data( __FILE__ );
	wp_enqueue_script( 'cdevroe_tootfaves_javascript', plugin_dir_url( __FILE__ ) . '/assets/js/cdevroe-mastodon-favorites.js', array(), $cdevroe_tootfaves_data['Version'], true );
}
add_action( 'wp_enqueue_scripts', 'cdevroe_tootfaves_enqueue_scripts' );