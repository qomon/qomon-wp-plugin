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
 * Exit if plugin accessed directly 
 */
if (!defined('ABSPATH'))
	exit;

if (is_admin()) {
	/**
	 * Load translations
	 */
	if (!function_exists('wpqomon_load_translations')) {
		function wpqomon_load_translations()
		{
			load_plugin_textdomain('qomon', '', 'qomon/languages/');
		}
	}
	add_action('plugins_loaded', 'wpqomon_load_translations');


	/**
	 * Add Qomon admin page in tools submenu
	 */
	// Add admin page contents
	if (!function_exists('wpqomon_admin_page_contents')) {

		function wpqomon_admin_page_contents()
		{
			echo '<article style="padding: 12px;max-width:1000px;">
			<h1>
			<img style="width:40px; margin-right: 16px; vertical-align: middle;" src="' . esc_url(plugin_dir_url(__FILE__) . 'public/images/qomon-pink-shorted.svg') . '">
			' . esc_html(__('Welcome to Qomon for WordPress', 'qomon')) . '
			</h1>

			<p>
			<a href="' . esc_url(__('https://www.qomon.com', 'qomon')) . '" target="_blank">' . esc_html("Qomon") . '</a>
			' . esc_html(__(' is an organization that helps causes, NGOs, campaigns, elected officials, movements & businesses engage more citizens, take concrete action and amplify their impact.', 'qomon')) . '
			</p>
			<p>' . esc_html(__('Qomon allows, among other things, to create forms, customize their colors and fields, to consult the opinion of your contacts or allow new contacts, for example, to subscribe to your newsletter.', 'qomon')) . '</p>
			<p>' . esc_html(__('Integrate the form easily into your website with this plugin! ', 'qomon')) . '</p>
			<p>' . esc_html(__('If you are not a Qomon customer yet, and would like to use this feature, you can get more information and request a demo', 'qomon')) . ' 
			<a href="' . esc_url(__('https://www.qomon.com', 'qomon')) . '" target="_blank">
			' . esc_html(__('here', 'qomon')) . '</a>.
			</p>

			<h2 style="margin-top: 32px; font-size: 20px;">' . esc_html(__('Using the WordPress plugin', 'qomon')) . '</h2>
			<p>' . esc_html(__('To add a Qomon form to your page you have 2 options: ', 'qomon')) . '</p>

			<h3 style="margin-top: 24px;">' . esc_html(__('I. Adding through the Qomon Form Block', 'qomon')) . '</h3>
			<p>' . esc_html(__('Once activated you will be able to add a form to your page using a Qomon Form Block: ', 'qomon')) . '</p>
			<img style="width:244px" src="' . esc_url(plugin_dir_url(__FILE__) . 'public/images/qomon-form/block-search.png') . '">
			<p>' . esc_html(__('The block will appear, allowing you to add the id of your form to it:', 'qomon')) . '</p>
			<img style="width:424px" src="' . esc_url(plugin_dir_url(__FILE__) . 'public/images/qomon-form/block.png') . '">
			<p>' . esc_html(__('Specify your form type:', 'qomon')) . '</p>
			<img style="width:424px" src="' . esc_url(plugin_dir_url(__FILE__) . 'public/images/qomon-form/petition-type.png') . '">
			<p>' . esc_html(__('The published or previewed page will display the corresponding form:', 'qomon')) . '</p>
			<img style="width:424px" src="' . esc_url(plugin_dir_url(__FILE__) . 'public/images/qomon-form/form-example.png') . '">

			<h3 style="margin-top: 24px;">' . esc_html(__('II. Adding through the shortcode [qomon-form]', 'qomon')) . '</h3>
			<p>' . esc_html(__('In the same way you can add a shortcode block:', 'qomon')) . '</p>
			<img style="width:244px" src="' . esc_url(plugin_dir_url(__FILE__) . 'public/images/qomon-form/shortcode.png') . '">
			<p>' . esc_html(__('Once this block is on the page it will be necessary to write this code [qomon-form id=my-form-id] in the block, my-form-id will be to replace by the id of your form:', 'qomon')) . '</p>
			<img style="width:424px" src="' . esc_url(plugin_dir_url(__FILE__) . 'public/images/qomon-form/shortcode-filled.png') . '">
			<p>' . esc_html(__('The published or previewed page will display the corresponding form:', 'qomon')) . '</p>
			<img style="width:424px" src="' . esc_url(plugin_dir_url(__FILE__) . 'public/images/qomon-form/form-example.png') . '">

			<p>' . esc_html(__('Your form is now available, your signatories can fill out the form!', 'qomon')) . '</p>
			<p>' . esc_html(__('To go further in the customization of this one, or for any help concerning the plugin, you can consult', 'qomon')) . ' 
			<a href="' . esc_url(__('https://help.qomon.com/en/articles/7439238-how-can-i-integrate-a-qomon-form-on-my-website', 'qomon')) . '" target="_blank">'
				. esc_html(__('this page', 'qomon')) . '</a>.
			 </p>
			</article>';


		}
	}

	// Add admin page to tools submenu
	if (!function_exists('wpqomon_add_qomon_admin_menu')) {
		function wpqomon_add_qomon_admin_menu()
		{
			add_menu_page(
				'Qomon Plugin',
				//page title
				'Qomon',
				//menu title
				'edit_themes',
				//capability,
				'qomon-plugin',
				//menu slug
				'wpqomon_admin_page_contents',
				//callback function
				'' . 'data:image/svg+xml;base64,' . base64_encode('
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xml:space="preserve"  width="20" height="auto" viewBox="0 0 512 512" style="fill:#a7aaad" role="img" aria-hidden="true" focusable="false">
			<path d="M255.292 0C112.719 0 0 113.196 0 255.304C0 385.598 93.7125 491.672 218.269 509.382V385.268C190.126 376.747 165.485 359.37 148.01 335.721C130.535 312.071 121.16 283.413 121.279 254.007C121.279 179.628 181.223 115.884 256 115.884C329.338 115.884 390.743 179.557 390.743 254.007C390.747 269.977 387.937 285.823 382.443 300.819L328.748 247.923L245.223 334.164L295.639 384.56L387.23 476.178L423.073 512L509.31 425.782L473.938 390.927C498.982 350.136 512.162 303.171 511.998 255.304C511.998 113.055 398.525 0 255.292 0Z"/>
			</svg>
			') . '',
				// icon
				null
				//position
			);
		}
	}
	add_action('admin_menu', 'wpqomon_add_qomon_admin_menu');


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


} else {
	/**
	 * Add the script that converts a div.qomon-form[data-base_id] into a Qomon form with the corresponding base_id
	 */
	if (!function_exists('wpqomon_add_form_cdn_script')) {
		function wpqomon_add_form_cdn_script()
		{
			echo '<script type="text/javascript" async defer src="' . esc_url("https://scripts.qomon.org/forms/v1/setup.js") . '"></script>';
		}
	}
	add_action('wp_head', 'wpqomon_add_form_cdn_script');


	/**
	 * The [qomon-form] shortcode.
	 *
	 * Accepts an id and will display a Qomon form with the corresponding base_id.
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


			// form_type
			$form_type = isset($qomon_shortcode_atts['form-type']) ? esc_html($qomon_shortcode_atts['form-type']) : '';

			// generate form container
			
			$qomon_form_container = '<div class="qomon-form" form-type="' . esc_attr($form_type) . '" data-base_id="' . esc_html($qomon_shortcode_atts['id']) . '"></div>';

			// return output
			return $qomon_form_container;
		}
	}

	add_shortcode('qomon-form', 'wpqomon_add_form_shortcode');

}