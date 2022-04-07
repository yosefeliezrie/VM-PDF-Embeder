<?php
/*
Plugin Name: VM PDF Embeder
Plugin URI:
Description: Embeds PDF's using modern browsers default pdf embed. with flexible width and height. No third-party services required.
Version: 1.0
Author: Yosef Eiezrie
Author URI: http://yosefeliezrie.com
License: GPL
Copyright: Yosef Eliezrie
*/

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package     VM_PDF_Embeder
 * @author      Yosef Eliezrie
 * @copyright   2022 Yosef Eliezrie
 * @license     GPL-2.0-or-later
 * @link        https://github.com/yosefeliezrie
 * @version     1.1.0
 *
 * @wordpress-plugin
 * Plugin Name:       VM PDF Embeder
 * Plugin URI:        https://github.com/yosefeliezrie/VM-PDF-Embeder
 * Description:       Embeds PDF's using modern browsers default pdf embed. with flexible width and height. No third-party services required.
 * Version:           1.1.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            yosefeliezrie
 * Author URI:        https://yosefeliezrie.com
 * License GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vm_pdf_embeder
 * Domain Path:       /languages
 *
 * Copyright 2022 Yosef Eliezrie (https://github.com/yosefeliezrie)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 */

/**
 * Current plugin version.
 * Started at version 1.0.0 and uses SemVer - https://semver.org.
 */
define('VM_PDF_EMBEDER_PLUGIN_VERSION', '1.1.0');

// A. ENSURE ACF (ADVANCED CUSTOM FIELDS) IS ACTIVE. IF NOT DISPLAY ERRORS
if (!class_exists('acf')) {
	$vm_pdf_embeder_acf_notice_msg = __('This VM PDF Embeder Plugin needs "Advanced Custom Fields Pro" to run. Please download and activate it', 'vm_pdf_embeder-notice-acf');

	/*
	*	Admin notice
	*/
	add_action('admin_notices', 'vm_pdf_embeder_notice_missing_acf');
	function vm_pdf_embeder_notice_missing_acf()
	{
		global $vm_pdf_embeder_acf_notice_msg;
		echo '<section class="notice notice-error notice-large"><div class="notice-title">' . $vm_pdf_embeder_acf_notice_msg . '</div></section>';
	}

	/*
	*	Frontend notice
	*/
	add_action('template_redirect', 'vm_pdf_embeder_get_notice_frontend_missing_acf', 0);
	function vm_pdf_embeder_get_notice_frontend_missing_acf()
	{
		global $vm_pdf_embeder_get_acf_notice_msg;

		wp_die($vm_pdf_embeder_get_acf_notice_msg);
	}
}
// ALL IS WELL ACF IS ACTIVE. Continue Plugin setup
else {

	// Regsiter field group to store url of PDF
	if (function_exists("register_field_group")) {
		register_field_group(array(
			'id' => 'acf_documents',
			'title' => 'Documents',
			'fields' => array(
				array(
					'key' => 'field_56ee98b5aa071',
					'label' => 'Uploaded Document',
					'name' => 'uploaded_document',
					'type' => 'file',
					'instructions' => 'Add A Document From Your Library',
					'save_format' => 'url',
					'library' => 'all',
				),
				array(
					'key' => 'field_56ee9909aa072',
					'label' => 'Third Party Document',
					'name' => 'third_party_document',
					'type' => 'text',
					'instructions' => 'url with schema eg. https://link.tld/document.pdf',
					'default_value' => '',
					'placeholder' => 'url with schema eg. https://link.tld/document.pdf',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'post',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'page',
						'order_no' => 0,
						'group_no' => 1,
					),
				),
			),
			'options' => array(
				'position' => 'normal',
				'layout' => 'no_box',
				'hide_on_screen' => array(),
			),
			'menu_order' => 0,
		));
	}
}

// Function to get a pdf attachment from the current post ID
function vm_pdf_embeder_get_pdf_attachments()
{
	$attachment_args = array('post_mime_type' => 'application/pdf', 'post_type' => 'attachment', 'numberposts' => 1, 'post_status' => null, 'post_parent' => get_the_id());
	$attachments = get_posts($attachment_args);
	if ($attachments) {
		foreach ($attachments as $attachment) {
			$attachment_url = wp_get_attachment_url($attachment->ID);
			return $attachment_url;
		}
	}
}

function vm_pdf_embeder_shortcode($atts)
{

	// Attributes
	extract(
		shortcode_atts(
			array(
				'src' => '',
				'width' => '',
				'height' => '',
			),
			$atts
		)
	);


	// Grab the URL from the third_party_document advanced-custom-field - field
	$third_party_document = get_field("third_party_document", get_the_id());

	// Check if there is a PDF attached to the current post
	if (vm_pdf_embeder_get_pdf_attachments()) {
		$uploaded_document = vm_pdf_embeder_get_pdf_attachments();
		// Otherwise check there is anything uploaded the the uploaded_document advanced-custom-field - field and Grab the URL from there
	} else {
		$uploaded_document = get_field("uploaded_document", get_the_id());
	}

	if ($uploaded_document) {
		$document_embed = $uploaded_document;
	} elseif ($third_party_document) {
		$document_embed = $third_party_document;
	}

	if ((!$width)) {
		$width = "100%";
	} elseif ((!$height)) {
		$height = "1000px";
	}
	// If there is a valid PDF embed than go ahead otherwise return false
	if ($document_embed) {
		// Important: make sure type is "application/pdf" otherwise there will be issues
		$document_embed_html = '<div class="vm-pdf-embeder">';
		$document_embed_html .= '<embed
      width="' . $width . '"
  		height="' . $height . '"
      src="' . $document_embed . '"
      type="application/pdf"
      allowscriptaccess="always"
      allowfullscreen="true">';
		$document_embed_html .= '</div>';

		return $document_embed_html;
	} else {
		return false;
	}
}
add_shortcode('vm_pdf_embeder', 'vm_pdf_embeder_shortcode');
