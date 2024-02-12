<?php
/**
 * Functions used for the wp_ajax_*
 */

add_action( 'wp_ajax_cdevroe_tootfaves_destroy_cache', 'cdevroe_tootfaves_destroy_cache' );

function cdevroe_tootfaves_destroy_cache() {
    if ( isset($_POST['postID']) ) {
        delete_transient( 'cdevroe_tootfaves_cache_' . $_POST['postID'] );
    }
    wp_die();
}