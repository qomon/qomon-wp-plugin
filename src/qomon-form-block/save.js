/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */

export default function save( { attributes } ) {
	return <div class="qomon-form" data-base_id={ attributes.base_id } form-type={ attributes.form_type }></div>;
}
