=== VM PDF Embeder ===
Contributors: yosefeliezrie, voilamedia
Tags: pdf embed, document embed
Requires at least: 3.5.0
Tested up to: 4.5.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This Plugin Creates a shortcode called vm_embed_dcoument that Embeds PDF\'s using modern browsers default pdf embeds. *Requires advanced-custom-fields plugin***

== Description ==
This Plugin allows you to Embeds PDF's using modern browsers default pdf embed functionality without any javascript or iframes.

**Plugin Currentyl Requires advanced-custom-fields plugin***



== Usage ==

* To add to an individual post: Add [vm_document_embed} shortcode to your post using the following syntax:
[vm_pdf_embeder width="" height="" src=""]
* You can add this functionality to your theme using do_shortcode("[vm_pdf_embeder width="" height="" src=""]")[/code]

== Optional ==
Storing Link URL's in Advanced Custom Fields

** IMPORTANT: Make sure you have the ACF Plugin Active **

* If you are storing your PDF in WordPress Uploads than you can embed it using the uploaded_document field in corresponding post.
* If you are storing the PDF on a 3rd party service than add the link to the pdf on 3rd party server in the \'Third Party Document\' field in your corresponding post, with schema eg. https://link.tld/document.pdf
* To add to an individual post: Add [vm_document_embed} shortcode to your post using the following syntax:
[vm_pdf_embeder width="" height="" src=""]
* You can add this functionality to your theme using do_shortcode("[vm_pdf_embeder width="" height=""]")



== Installation ==
1. Ensure you have the advanced custom fields plugin installed and activated https://wordpress.org/plugins/advanced-custom-fields/
2. Upload the vm-pdf-embed folder to your directory
3. Upload "vm-pdf-embed" folder to the "/wp-content/plugins/" directory.
4 Activate the plugin through the "Plugins" menu in WordPress.
6. Add the vm_pdf_embeder shortcode to your post/page or to theme/plugin.


== Changelog ==
1.0
Initial Version
