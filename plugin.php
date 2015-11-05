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
 * Call table creation function when activating the plugin.
 */
function cmb2_taxonomy_register_activation_hook( $network_wide = false ) {
    global $wpdb;

    /**
     *  Check if install is multisite and plugin activation is network wide.
     *  If so, loop all blogs in network to create table. Otherwise just
     *  create table.
     */
    if( is_multisite() && $network_wide ) {
        $current_blog = $wpdb->blogid;
        $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

        foreach( $blog_ids as $blog_id ) {
            switch_to_blog( $blog_id );
            cmb2_taxonomy_create_table();
            restore_current_blog();
        }
    } else {
        cmb2_taxonomy_create_table();
    }
}

/**
 *  Call table creation when new network blog is created
 */
function cmb2_taxonomy_on_create_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    if( !function_exists( 'is_plugin_active_for_network' ) ) {
        require_once( ABSPATH.'/wp-admin/includes/plugin.php' );
    }

    if( is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
        switch_to_blog( $blog_id );
        cmb2_taxonomy_create_table();
        restore_current_blog();
    }
}

/**
 *  Create the tables for the taxonomies metadata
 */
function cmb2_taxonomy_create_table() {
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
add_action( 'wpmu_new_blog', 'cmb2_taxonomy_on_create_blog', 10, 6 );


require_once dirname(__FILE__) . '/init.php';
