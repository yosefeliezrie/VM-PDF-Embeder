# VM PDF Embeder
Contributors: yosefeliezrie, voilamedia
Requires at least: 5.8
Tested up to: 5.9.3
Requires PHP: 7.4
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: master

This Plugin Creates a shortcode called vm_embed_dcoument that Embeds PDF\\\'s using modern browsers default pdf embeds. *Requires advanced-custom-fields plugin***

## Description
This Plugin allows you to embed PDF\'s using modern browsers\' default pdf embed functionality without any javascript or iframes.

**Plugin Currently **Requires advanced-custom-fields plugin***

## Installation
1. Ensure you have the advanced custom fields plugin installed and activated https://wordpress.org/plugins/advanced-custom-fields/
2. Upload the vm-pdf-embed folder to your directory
3. Upload "vm-pdf-embed" folder to the \"wp-content/plugins/" directory.
4 Activate the plugin through the \"Plugins\" menu in WordPress.
6. Add the [vm_pdf_embeder width=”” height=”” src=””] to your post/page or to theme/plugin.

## Frequently Asked Questions

## Usage
* To add to an individual post: Add [vm_document_embed} shortcode to your post using the following syntax:
[vm_pdf_embeder width=\"\" height=\"\" src=\"\"]
*  You can add this functionality to your theme using do_shortcode('[vm_pdf_embeder width=”” height=”” src=””]')


## Storing Link URL's in Advanced Custom Fields

** IMPORTANT: Make sure you have the ACF Plugin Active **

* If you are storing your PDF in WordPress Uploads than you can embed it using the uploaded_document field in corresponding post.
* If you are storing the PDF on a 3rd party service than add the link to the pdf on 3rd party server in the 'Third Party Document' field in your corresponding post, with schema eg. https://link.tld/document.pdf
* To add to an individual post: Add [vm_document_embed} shortcode to your post using the following syntax:
[vm_pdf_embeder width=\"\" height=\"\" src=\"\"]
* You can add this functionality to your theme using do_shortcode(\"[vm_pdf_embeder width=\"\" height=\"\"]\")
d

## Changelog
1.1.0 
* Fix Plugin Headers and Readme File
* Update Plugin Function Names with a proper prefix to prevent plugin conflicts

1.0
* Initial Version

-----------------------

* Readme : https://github.com/yosefeliezrie/VM-PDF-Embeder/blob/master/readme.txt
* Support: Please first open an issue on github if you are still having an issue please email me at yosefeliezrie [at] gmail dot com
