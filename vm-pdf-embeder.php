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
/*if ( class_exists('acf')){
} else {
  echo "This plugin will only work with the Advanced Custom Fields Plugin Active, please add it from the repo https://wordpress.org/plugins/advanced-custom-fields/";
}*/
// Regsiter field group to store url of PDF
  if(function_exists("register_field_group")) {
  	register_field_group(array (
  		'id' => 'acf_documents',
  		'title' => 'Documents',
  		'fields' => array (
  			array (
  				'key' => 'field_56ee98b5aa071',
  				'label' => 'Uploaded Document',
  				'name' => 'uploaded_document',
  				'type' => 'file',
  				'instructions' => 'Add A Document From Your Library',
  				'save_format' => 'url',
  				'library' => 'all',
  			),
  			array (
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
  		'location' => array (
  			array (
  				array (
  					'param' => 'post_type',
  					'operator' => '==',
  					'value' => 'post',
  					'order_no' => 0,
  					'group_no' => 0,
  				),
  			),
  			array (
  				array (
  					'param' => 'post_type',
  					'operator' => '==',
  					'value' => 'page',
  					'order_no' => 0,
  					'group_no' => 1,
  				),
  			),
  		),
  		'options' => array (
  			'position' => 'normal',
  			'layout' => 'no_box',
  			'hide_on_screen' => array (
  			),
  		),
  		'menu_order' => 0,
  	));
}

function vm_get_pdf_attachments() {
  $attachment_args = array( 'post_mime_type' => 'application/pdf', 'post_type' => 'attachment', 'numberposts' => 1, 'post_status' => null, 'post_parent' => get_the_id() );
  $attachments = get_posts($attachment_args);
  if ($attachments) {
  	foreach ( $attachments as $attachment ) {
  		$attachment_url = wp_get_attachment_url( $attachment->ID );
      return $attachment_url;
  	}
  }
}

function vm_pdf_embeder_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'src' => '',
			'width' => '',
			'height' => '',
		), $atts )
	);

  if ( vm_get_pdf_attachments() ) {
    $uploaded_document = vm_get_pdf_attachments();
  } else {
    $uploaded_document = get_field( "uploaded_document", get_the_id() );
  }

  $third_party_document = get_field( "third_party_document", get_the_id() );

  if ($uploaded_document) {
    $document_embed = $uploaded_document;
  } elseif ($third_party_document)  {
    $document_embed = $third_party_document;
  }

  if ( (!$width) ) {
    $width = "100%";
  } elseif ( (!$height ) ){
    $height = "1000px";
  }

  if ($document_embed) {
    $document_embed_html = '<div class="vm-document-embed">';
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
add_shortcode( 'vm_pdf_embeder', 'vm_document_embed_shortcode' );
