<?php
/**
 * Renders the Favorite Toots block output
 * Uses each toot favorite URL to request an oEmbed iframe
 *
 * $attributes (array): The block attributes.
 * $content (string): The block default content.
 * $block (WP_Block): The block instance.
 *
 */
$numberOfToots 						= $attributes['numberOfToots'];
$cdevroe_tootfaves_instance_url 	= get_option('cdevroe_tootfaves_instance_url');
$cdevroe_tootfaves_access_token 	= get_option('cdevroe_tootfaves_access_token');
$block_content 						= '';

if ( ! empty( $cdevroe_tootfaves_instance_url ) && ! empty( $cdevroe_tootfaves_access_token ) && $numberOfToots > 0 && ! is_admin() ) {

	global $post; // Is this cool to do?
	$cdevroe_tootfaves_current_post_id 	= $post->ID;
	$cdevroe_tootfaves_cache 			= get_transient( 'cdevroe_tootfaves_cache_' . $cdevroe_tootfaves_current_post_id );

	if ( ! $cdevroe_tootfaves_cache ) :		

		$cdevroe_tootfaves_query_url = 'https://' . $cdevroe_tootfaves_instance_url . '/api/v1/favourites?limit=' . $numberOfToots;

		$cdevroe_tootfaves_query_headers = array(
			"Authorization" 	=> "Bearer " . $cdevroe_tootfaves_access_token,
			"Content-Type" 		=> "application/json",
			"Accept" 			=> "application/json",
			"Accept-Charset" 	=> "utf-8"
		);
		
		$cdevroe_tootfaves_query_response = wp_remote_get( $cdevroe_tootfaves_query_url, array( 'headers' => $cdevroe_tootfaves_query_headers ) );

		if ( is_wp_error( $cdevroe_tootfaves_query_response ) ) {
			echo $cdevroe_tootfaves_query_response->get_error_message();
		} else {
		
			$cdevroe_tootfaves_toots = json_decode( $cdevroe_tootfaves_query_response['body'], true );
			
			foreach( $cdevroe_tootfaves_toots as $favorite ) {

				$instance_of_origin = cdevroe_tootfaves_get_instance_from_toot_url( $favorite['url'] );

				if ( $instance_of_origin == 'www.threads.net' ) continue; // Threads doesn't currently support oEmbed 2024-02-08, skip

				// Use the instance of origin's oEmbed endpoint to get the iframe
				$get_favorite_embed = wp_remote_get( 'https://' . $instance_of_origin . '/api/oembed?url=' . $favorite['url'] );		

				if ( ! isset( $get_favorite_embed['body'] ) || is_null( $get_favorite_embed['body'] ) || '' == $get_favorite_embed['body'] ) continue; // Skip if the response from the endpoint is missing

				$get_favorite_embed_json = json_decode( $get_favorite_embed['body'], true );

				if ( ! isset( $get_favorite_embed_json['html'] ) || is_null( $get_favorite_embed_json['html'] ) || '' == $get_favorite_embed_json['html'] ) continue;
				
				$block_content .= '<div class="favorite-toots-toot-iframe-wrapper">' . $get_favorite_embed_json['html'] . '</div>';

			}

			set_transient( 'cdevroe_tootfaves_cache_' . $cdevroe_tootfaves_current_post_id, $block_content,  21600 ); // Cache results for 6 hours
		} // endif wp_error
	
	else :
		$block_content = '<div ' . get_block_wrapper_attributes() . '>' . $cdevroe_tootfaves_cache . '</div>';
	endif;

} else {
	$block_content = '<div ' . get_block_wrapper_attributes() . '><p>Mastodon Favorites currently unavailable.</p></div>';
}

echo wp_kses_post( $block_content );

/**
 * Parse out the instance of origin from a toot URL
 * Accepts: A URL
 * @return string
 */
function cdevroe_tootfaves_get_instance_from_toot_url( $toot_url = null ) {
	if ( empty($toot_url) ) return false;

	// TODO: Convert to regex?
	$toot_url_parts = explode( '/', $toot_url );

	if ( count($toot_url_parts) > 2 && isset($toot_url_parts[2]) ) {
		return $toot_url_parts[2]; // TODO: Basic validation that this string looks like a domain name?
	} else {
		return false;
	}
}