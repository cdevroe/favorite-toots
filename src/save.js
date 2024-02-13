/**
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 *
 * @param {Object} props            Properties passed to the function.
 * @param {Object} props.attributes Available block attributes.
 *
 * @return {Element} Element to render.
 */
export default function save( { attributes } ) {
	const { numberOfToots } = attributes;

	/**
	 * Whenever a save happens, delete the cache
	 * TODO: Update this to only trigger when the settings for the block change
	*/
	const postID = wp.data.select('core/editor').getCurrentPostId();
    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: new URLSearchParams({
            action: 'cdevroe_tootfaves_destroy_cache',
			postID: postID,
			nonce: cdevroe_tootfaves_ajax.nonce, 
        }),
    });
	
	if ( numberOfToots < 1 ) {
		return null;
	}

	return <div { ...useBlockProps.save() }><strong>Mastodon Favorites</strong></div>;
}
