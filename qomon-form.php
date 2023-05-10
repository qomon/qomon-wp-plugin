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


/**
 * Add Qomon admin page in tools submenu
 */
// Add page contents
if (!function_exists('wpqomon_admin_page_contents')) {

	function wpqomon_admin_page_contents()
	{
		$qomon_form_page = '
<h1>Welcome to my custom admin page.</h1>
<br/>

<h2>Utiliser le plugin WordPress</h2>
<p>Si votre site utilise WordPress, vous pouvez ajouter le plugin Qomon form. </p>
<p>Pour cela, allez dans&nbsp;<em>Extensions &gt; Ajouter </em>à partir du&nbsp;menu latéral. Vous pourrez alors utiliser la barre de recherche pour trouver le plugin. Cliquer sur installer, puis une fois fait, activer.</p>
<br/>

<h3>I. Ajout grâce au bloc Qomon Form</h3>
<p>Une fois activé vous pourrez ajouter un formulaire sur votre page en utilisant un bloc Qomon Form : </p>
<img style="width:288px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form-block-search.png' . '">
<p>Le bloc s’affichera, vous permettant d’y ajouter l’id de votre formulaire :</p>
<img style="width:576px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form-block.png' . '">
<p>Une fois la page mise à jour le formulaire correspondant s’affichera :</p>
<img style="width:576px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form-example.png' . '">
<br/>
<br/>

<h3>II. Ajout grâce au shortcode [qomon-form]</h3><p>De la même façon vous pouvez ajouter un bloc shortcode :</p>
<img style="width:288px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form-shortcode.png' . '">
<p>Une fois celui-ci sur la page il faudra écrire ce code [qomon-form id=my-form-id] dans le bloc, my-form-id sera à remplacer par l’id de votre formulaire : </p>
<img style="width:576px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form-shortcode-filled.png' . '">
<p>Une fois la page mise à jour le formulaire correspondant s’affichera :</p>
<img style="width:576px" src="' . plugin_dir_url(__FILE__) . 'public/images/qomon-form-example.png' . '">
	';

		echo $qomon_form_page;
	}
}

// Add page to tools submenu
if (!function_exists('wpqomon_admin_page_contents')) {
	function wpqomon_add_qomon_admin_submenu()
	{
		add_management_page(
			'Qomon Plugin',
			//page title
			'Qomon Plugin',
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