<?php
/**
 * Qomon Form
 *
 * @author            Qomon
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Qomon Form
 * Description:       Easily insert your Qomon form in your site. By adding a shortcode [qomon-form] or even by adding a custom block created by Qomon.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Qomon
 * Author URI:        https://qomon.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       qomon-form
 */


/**
 * Add the script that converts a div.qomon-form[data-base_id] into a Qomon form with the corresponding base_id
 */
if (!function_exists('wpqomon_add_form_cdn_script')) {
	function wpqomon_add_form_cdn_script()
	{
		$is_test_env = true;
		$form_cdn_script_uri = 'https://scripts.qomon.org/forms/v1/setup.js';

		if ($is_test_env) {
			$form_cdn_script_uri = 'https://scripts-test.qomon.org/forms/v1/setup.js';
		}

		echo '<script type="text/javascript" async defer src="' . esc_html($form_cdn_script_uri) . '"></script>';
	}
}
add_action('wp_head', 'wpqomon_add_form_cdn_script');


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
if (!function_exists('wpqomon_create_form_block')) {
	function wpqomon_create_form_block()
	{
		register_block_type(__DIR__ . '/build');
	}
}
add_action('init', 'wpqomon_create_form_block');


/**
 * The [qomon-form] shortcode.
 *
 * Accepts a id and will display a Qomon form with the corresponding base_id.
 *
 * @param array  $atts    Shortcode attributes. Default empty. Example: [qomon-form id=5652feb3-bc2a-4c0d-ba75-e5f68997f308]
 * @return string Shortcode output.
 */
if (!function_exists('wpqomon_add_form_shortcode')) {
	function wpqomon_add_form_shortcode($atts = [], $content = null, $tag = '')
	{
		// normalize attribute keys, lowercase
		$atts = array_change_key_case((array) $atts, CASE_LOWER);

		// override default attributes with user attributes
		$qomon_shortcode_atts = shortcode_atts(
			$atts,
			$tag
		);

		// generate form container
		$qomon_form_container = '<div class="qomon-form" data-base_id="' . esc_html($qomon_shortcode_atts['id']) . '"></div>';

		// return output
		return $qomon_form_container;
	}
}

add_shortcode('qomon-form', 'wpqomon_add_form_shortcode');