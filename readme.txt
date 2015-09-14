=== CMB2 Taxonomy ===
Contributors:      jcchavezs
Tags:              metaboxes, forms, fields, options, settings, cmb2, taxonomy
Requires at least: 3.8.0
Tested up to:      4.1.2
Stable tag:        1.0.2
License:           GPLv2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

CMB2 Taxonomy will create metaboxes and forms with custom fields for your taxonomies using the CMB2 API (and yes, it will blow your mind too).

== Description ==

CMB2 Taxonomy will create metaboxes and forms with custom fields for your taxonomies using the [CMB2](https://github.com/WebDevStudios/CMB2) API (and yes, it will blow your mind too).

This plugin adds an additional table for term's metadata storage following the metadata patterns which means that eventhough we add an extra table we still using the [metadata API](https://codex.wordpress.org/Metadata_API). Check the [Usage](https://github.com/jcchavezs/cmb2-taxonomy#usage) section for more information.

To get started, please follow the examples in the included `example-functions.php` file and have a look at the [basic usage instructions](https://github.com/WebDevStudios/CMB2/wiki/Basic-Usage).

You can see a list of available field types [here](https://github.com/WebDevStudios/CMB2/wiki/Field-Types#types).

### Features:

* Create metaboxes to be used on taxonomy edit screens.
* [Flexible API that allows you to use CMB forms almost anywhere, even on the front-end](https://github.com/WebDevStudios/CMB2/wiki/Bringing-Metaboxes-to-the-Front-end).
* [Several field types are included](https://github.com/WebDevStudios/CMB2/wiki/Field-Types).
* [Custom API hook that allows you to create your own field types](https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types).
* There are numerous hooks and filters, allowing you to modify many aspects of the library (without editing it directly).
* Repeatable fields for most field types are supported, as well as repeatable field groups.
* CMB2 is safe to bundle with any project. It will only load the newest version in the system.

### Links
* [Github project page](https://github.com/jcchavezs/cmb2-taxonomy)

== Installation ==

If installing the plugin from wordpress.org:

1. Upload the entire `/cmb2-taxonomy` directory to the `/wp-content/plugins/` directory.
2. Activate CMB2 Taxonomy through the 'Plugins' menu in WordPress.
2. Copy (and rename if desired) `example-functions.php` into to your theme or plugin's directory.
2. Edit to only include the fields you need and rename the functions.
4. Profit.

### Usage

This plugin adds a couple of new functions for metadata management, similar to the post_meta functions:

* [get_term_meta](https://github.com/jcchavezs/cmb2-taxonomy/blob/master/functions.php#L13): Retrieves metadata for the specified term.
* [update_term_meta](https://github.com/jcchavezs/cmb2-taxonomy/blob/master/functions.php#L28): Update metadata for the specified term. If no value already exists for the specified term ID and metadata key, the metadata will be added.
* [add_term_meta](https://github.com/jcchavezs/cmb2-taxonomy/blob/master/functions.php#L43): Add metadata for the specified term.
* [delete_term_meta](https://github.com/jcchavezs/cmb2-taxonomy/blob/master/functions.php#L59): Delete metadata for the specified term.

