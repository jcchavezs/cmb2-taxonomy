<?php

/**
 * Create meta boxes for taxonomies
 */
class CMB2_Taxonomy {

    /**
     * Get started
     */
    public function __construct()
    {
        global $wpdb;

        $wpdb->termmeta = $wpdb->prefix . 'termmeta';

        add_action('init', array($this, 'init_actions'), 9999);
    }

    /**
     * Initialize the hooks for the actions in the lifecycle of a term.
     */
    function init_actions() {
        if(!is_admin()){
            return;
        }

        $taxonomies = get_taxonomies(array('public' => true), 'names');

        foreach($taxonomies as $taxonomy_name) {
            add_action( "{$taxonomy_name}_add_form_fields", array($this, 'render_meta_fields_add_form'), 10);
            add_action( "{$taxonomy_name}_edit_form", array($this, 'render_meta_fields_edit_form'), 10, 2 );

            // Save our form data
            add_action( "created_{$taxonomy_name}", array( $this, 'save_meta_data' ) );
            add_action( "edited_{$taxonomy_name}", array( $this, 'save_meta_data' ) );

            // Delete it if necessary
            add_action( "delete_{$taxonomy_name}", array( $this, 'delete_meta_data' ) );
        }
    }

    /**
     * Render the meta fields for a certain taxonomy when adding a new term.
     * @param  string $taxonomy_name        The name of the taxonomy
     */
    function render_meta_fields_add_form($taxonomy_name) {
        $this->render_meta_fields($taxonomy_name);
    }

    /**
     * Render the meta fields for a certain taxonomy when editing an existing term.
     * @param  object $term                 The term which is being edited
     * @param  string $taxonomy_name        The name of the taxonomy
     */
    function render_meta_fields_edit_form($term, $taxonomy_name) {
        $this->render_meta_fields($taxonomy_name, $term->term_id);
    }

    /**
     * Render metaboxes inside a term form.
     * @param  string $taxonomy_name Name of the taxonomy metaboxes are for
     * @param  int $term_id         ID of the term metadata is for
     */
    function render_meta_fields($taxonomy_name, $term_id = null) {
        $metaboxes = apply_filters('cmb2-taxonomy_meta_boxes', array());

        foreach($metaboxes as $key => $metabox) {
            if(!in_array($taxonomy_name, $metabox['object_types'])) {
                continue;
            }

            if(null === $term_id){
                $this->render_form($metabox);
            } else {
                $this->render_form($metabox, $term_id);
            }
        }
    }

    /**
     * Render the form of a meta box.
     * @param  string  $metabox     ID of the meta box
     * @param  int $term_id         ID of the term metadata is for
     * @return string               Markup of the form
     */
    function render_form($metabox, $term_id = 0)
    {
        if ( ! class_exists( 'CMB2' ) ) {
            return;
        }

        $cmb = cmb2_get_metabox( $metabox, $term_id );

        // if passing a metabox ID, and that ID was not found
        if ( ! $cmb ) {
            return;
        }

        // Hard-code object type
        $cmb->object_type( 'term' );

        // Enqueue JS/CSS
        if ( $cmb->prop( 'cmb_styles' ) ) {
            CMB2_hookup::enqueue_cmb_css();
        }

        CMB2_hookup::enqueue_cmb_js();

        // Show cmb form
        $cmb->show_form();
    }

    /**
     * Save all metadata for a term
     * @param  int $term_id         ID of the term metadata is for
     */
    public function save_meta_data($term_id)
    {
        if(!isset($_POST['taxonomy'])) {
            return;
        }

        $taxonomy_name = $_POST['taxonomy'];

        if ( ! current_user_can( get_taxonomy( $taxonomy_name )->cap->edit_terms ) ) {
            return;
        }

        $metaboxes = apply_filters('cmb2-taxonomy_meta_boxes', array());

        foreach($metaboxes as $key => $metabox) {
            if(!in_array($taxonomy_name, $metabox['object_types'])) {
                continue;
            }

            $cmb = cmb2_get_metabox( $metabox, $term_id );

             if (
                // check nonce
                isset( $_POST[ $cmb->nonce() ] )
                && wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() )
            ) {
                $cmb->save_fields( $term_id, 'term', $_POST );
            }
        }
    }

    /**
     * Delete all the metadata for a certain term.
     * @param  int $term_id         ID of the term metadata is for
     */
    public function delete_meta_data($term_id)
    {
        global $wpdb;

        $wpdb->query(
            $wpdb->prepare("DELETE FROM {$wpdb->termmeta} WHERE term_id = %s", $term_id)
        );
    }
}