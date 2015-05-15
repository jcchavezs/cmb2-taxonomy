<?php

/**
 * Plugin Name:  CMB2 Taxonomy
 * Plugin URI:   https://github.com/jcchavezs/cmb2-taxonomy
 * Description:  CMB2 Taxonomy will create metaboxes and forms with custom fields for your taxonomies using the CMB2 API.
 * Author:       José Carlos Chávez <jcchavezs@gmail.com>
 * Author URI:   http://github.com/jcchavezs
 * Github Plugin URI: https://github.com/jcchavezs/cmb2-taxonomy
 * Github Branch: master
 * Version:      1.0.2
 */

/**
 * Create the tables for the taxonomies metadata when activating the plugin.
 */
function cmb2_taxonomy_register_activation_hook() {
    global $wpdb;

    $wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}termmeta` (
        `meta_id` bigint(20) unsigned NOT NULL auto_increment,
        `term_id` bigint(20) unsigned NOT NULL default '0',
        `meta_key` varchar(255) default NULL,
        `meta_value` longtext,
        PRIMARY KEY  (`meta_id`),
        KEY `term_id` (`term_id`),
        KEY `meta_key` (`meta_key`)
    )");
}

register_activation_hook(__FILE__, 'cmb2_taxonomy_register_activation_hook');

require_once dirname(__FILE__) . '/init.php';