<?php
/**
 * Qomon
 *
 * @author            Qomon
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Qomon
 * Description:       Easily insert your Qomon form in your site. By adding a shortcode [qomon-form] or even by adding a custom block created by Qomon.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Qomon
 * Author URI:        https://qomon.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       qomon
 */

/**
 * Load translations
 */
if (!function_exists('wpqomon_load_translations')) {
	function wpqomon_load_translations()
	{
		load_plugin_textdomain('qomon', FALSE, 'qomon/languages/');
	}
}
add_action('plugins_loaded', 'wpqomon_load_translations');


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


/**
 * Add Qomon admin page in tools submenu
 */
// Add admin page contents
if (!function_exists('wpqomon_admin_page_contents')) {

	function wpqomon_admin_page_contents()
	{
		$qomon_form_page = '
<article style="padding: 12px;max-width:1000px;">
<h1><img style="width:40px; margin-right: 16px; vertical-align: middle;" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-pink-shorted.svg' . '">' . __('Welcome to Qomon for WordPress', 'qomon') . '</h1>

<p><a href="' . __('https://www.qomon.com', 'qomon') . '" target="_blank">Qomon</a>' . __(' is an organization that helps causes, NGOs, campaigns, elected officials, movements & businesses engage more citizens, take concrete action and amplify their impact.', 'qomon') . '</p>
<p>' . __('Qomon allows, among other things, to create forms, customize their colors and fields, to consult the opinion of your contacts or allow new contacts, for example, to subscribe to your newsletter.', 'qomon') . '</p>
<p>' . __('Integrate the form easily into your website with this plugin! ', 'qomon') . '</p>
<p>' . __('If you are not a Qomon customer yet, and would like to use this feature, you can get more information and request a demo', 'qomon') . ' <a href="' . __('https://www.qomon.com', 'qomon') . '" target="_blank">' . __('here', 'qomon') . '</a>.</p>

<h2 style="margin-top: 32px; font-size: 20px;">' . __('Using the WordPress plugin', 'qomon') . '</h2>
<p>' . __('To add a Qomon form to your page you have 2 options: ', 'qomon') . '</p>

<h3 style="margin-top: 24px;">' . __('I. Adding through the Qomon Form Block', 'qomon') . '</h3>
<p>' . __('Once activated you will be able to add a form to your page using a Qomon Form Block: ', 'qomon') . '</p>
<img style="width:244px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form/block-search.png' . '">
<p>' . __('The block will appear, allowing you to add the id of your form to it:', 'qomon') . '</p>
<img style="width:424px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form/block.png' . '">
<p>' . __('The published or previewed page will display the corresponding form:', 'qomon') . '</p>
<img style="width:424px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form/form-example.png' . '">

<h3 style="margin-top: 24px;">' . __('II. Adding through the shortcode [qomon-form]', 'qomon') . '</h3>
<p>' . __('In the same way you can add a shortcode block:', 'qomon') . '</p>
<img style="width:244px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form/shortcode.png' . '">
<p>' . __('Once this one on the page it will be necessary to write this code [qomon-form id=my-form-id] in the block, my-form-id will be to replace by the id of your form:', 'qomon') . '</p>
<img style="width:424px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form/shortcode-filled.png' . '">
<p>' . __('The published or previewed page will display the corresponding form:', 'qomon') . '</p>
<img style="width:424px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form/form-example.png' . '">

<p>' . __('Your form is now available, your signatories can fill out the form!', 'qomon') . '</p>
<p>' . __('To go further in the customization of this one, or for any help concerning the plugin, you can consult', 'qomon') . ' <a href="' . __('https://help.qomon.com/en/articles/7439238-how-can-i-integrate-a-qomon-form-on-my-website', 'qomon') . '" target="_blank">' . __('this page', 'qomon') . '</a>.</p>
</article>';

		echo $qomon_form_page;
	}
}

// Add admin page to tools submenu
if (!function_exists('wpqomon_add_qomon_admin_submenu')) {
	function wpqomon_add_qomon_admin_submenu()
	{
		add_management_page(
			'Qomon Plugin',
			//page title
			'<img style="width:16px; margin-right: 4px; vertical-align: middle;" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-white-shorted.svg' . '"> Qomon Plugin',
			//menu title
			'edit_themes',
			//capability,
			'qomon-plugin',
			//menu slug
			'wpqomon_admin_page_contents',
			//callback function
			null
			//position
		);
	}
}
add_action('admin_menu', 'wpqomon_add_qomon_admin_submenu');