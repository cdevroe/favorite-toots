<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$numberOfToots = $attributes['numberOfToots'];
$block_content = '';

if ( $numberOfToots > 0 ) {

	$cdevroe_tootfaves_cache = get_transient( 'cdevroe_tootfaves_cache' );

	if ( ! $cdevroe_tootfaves_cache ) :

		$cdevroe_tootfaves_instance_url = get_option('cdevroe_tootfaves_instance_url');
		$cdevroe_tootfaves_access_token = get_option('cdevroe_tootfaves_access_token');

		$cdevroe_tootfaves_query_url = $url = 'https://' . $cdevroe_tootfaves_instance_url . '/api/v1/favourites?limit=' . $numberOfToots;

		$cdevroe_tootfaves_query_headers = array(
			"Authorization" 	=> "Bearer " . $cdevroe_tootfaves_access_token,
			"Content-Type" 		=> "application/json",
			"Accept" 			=> "application/json",
			"Accept-Charset" 	=> "utf-8"
		);
		
		$cdevroe_tootfaves_query_response = wp_remote_get( $cdevroe_tootfaves_query_url, array( 'headers' => $cdevroe_tootfaves_query_headers ) );
		$cdevroe_tootfaves_toots = json_decode( $cdevroe_tootfaves_query_response['body'], true );
		
		foreach( $cdevroe_tootfaves_toots as $favorite ) {

			// Split the toot URL to find the toot's instance of origin
			$instance_of_origin_url_parts = explode( '/', $favorite['url'] );
			$instance_of_origin = $instance_of_origin_url_parts[2]; // 0 https, 1 empty, 2 instance url, 3 username, 4 ID

			if ( $instance_of_origin == 'www.threads.net' ) continue; // Threads doesn't currently support oEmbed 2024-02-08

			// Use the instance's oEmbed endpoint to get the iframe
			$get_favorite_embed = wp_remote_get( 'https://' . $instance_of_origin . '/api/oembed?url=' . $favorite['url'] );		

			if ( ! isset( $get_favorite_embed['body'] ) || is_null( $get_favorite_embed['body'] ) || '' == $get_favorite_embed['body'] ) continue; // Skip if the response from the endpoint is missing

			$get_favorite_embed_json = json_decode( $get_favorite_embed['body'], true );

			if ( ! isset( $get_favorite_embed_json['html'] ) || is_null( $get_favorite_embed_json['html'] ) || '' == $get_favorite_embed_json['html'] ) continue;
			
			$block_content .= '<div>' . $get_favorite_embed_json['html'] . '</div>';

		}

		set_transient( 'cdevroe_tootfaves_cache', $block_content,  21600 ); // Cache results for 6 hours
	
	else :
		$block_content = $cdevroe_tootfaves_cache;
	endif;

} else {

	$block_content = '<p ' . get_block_wrapper_attributes() . '>Showing ' . esc_html( $numberOfToots ) . '</p>';
}

echo wp_kses_post( $block_content );
