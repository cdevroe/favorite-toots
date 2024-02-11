import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useEffect } from 'react';

/**
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { numberOfToots } = attributes;

	if ( numberOfToots < 1 ) numberOfToots = 1; // do not allow less than 1, and default to 1

	useEffect( () => {
		if ( numberOfToots > 0 ) {
			setAttributes( { numberOfToots: numberOfToots } );
		}
	}, [ setAttributes ] );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'cdevroe' ) }>
					<SelectControl
						label={ __(
							'Number of toots to show',
							'cdevroe'
						) }
						value={ numberOfToots }
						options={ [
							{ label: '1', value: '1' },
							{ label: '5', value: '5' },
							{ label: '10', value: '10' },
							{ label: '25', value: '25' },
							{ label: '50', value: '50' },
						] }
						onChange={ ( value ) => setAttributes( { numberOfToots: value } ) }
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }><strong>Mastodon Favorites:</strong> Will display { numberOfToots } toots</div>
		</>
	);
}
