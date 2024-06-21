/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

import { TextControl, RadioControl } from '@wordpress/components';

import { useBlockProps, BlockControls } from '@wordpress/block-editor';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	return (
		<div { ...useBlockProps() }>
			{ <BlockControls /> }
			<TextControl
				label={ __( 'Qomon form ID', 'qomon' ) }
				value={ attributes.base_id }
				onChange={ ( val ) => setAttributes( { base_id: val } ) }
			/>
			<RadioControl
				label={ __( 'Form Type', 'qomon' ) }
				selected={ attributes.form_type }
				options={ [
					{ label: 'Form', value: '' },
					{ label: 'Petition', value: 'petition' },
				] }
				onChange={ ( val ) => { 
					setAttributes( { form_type: val } );
				}}
			/>

		</div>
	);
}
