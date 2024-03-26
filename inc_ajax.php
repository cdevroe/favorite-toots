<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Functions used for the wp_ajax_*
 */

function cdevroe_tootfaves_destroy_cache() {
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'cdevroe_tootfaves_ajax_nonce' ) ) {
        wp_die( 'This page is no longer valid.');
    }
    if ( isset($_POST['postID']) ) {
        delete_transient( 'cdevroe_tootfaves_cache_' . sanitize_text_field( $_POST['postID'] ) );
    }
    wp_die();
}
add_action( 'wp_ajax_cdevroe_tootfaves_destroy_cache', 'cdevroe_tootfaves_destroy_cache' );

function cdevroe_tootfaves_setup_nonce() {
    global $pagenow;

	if ($pagenow != 'post.php') {
		return;
	}

    $cdevroe_tootfaves_data = get_plugin_data( __FILE__ );

    wp_enqueue_script( 'admin-favorite-toots', plugin_dir_url( __FILE__ ) . '/assets/js/admin-cdevroe-favorite-toots.js', array(), $cdevroe_tootfaves_data['Version'], true );
    wp_localize_script('admin-favorite-toots', 'cdevroe_tootfaves_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('cdevroe_tootfaves_ajax_nonce')
    ));
}
add_action( 'admin_enqueue_scripts', 'cdevroe_tootfaves_setup_nonce' );