/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

import { TextControl } from "@wordpress/components";

import { useBlockProps, BlockControls } from "@wordpress/block-editor";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const isTestEnv = true;

	if (isTestEnv) {
		attributes.env = "cdn-form-test.qomon.org";
	}

	return (
		<div {...useBlockProps()}>
			{<BlockControls />}
			<TextControl
				label={__("Qomon form ID", "qomon")}
				value={attributes.base_id}
				onChange={(val) => setAttributes({ base_id: val })}
			/>
		</div>
	);
}
