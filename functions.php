<?php

/**
 * Retrieve metadata for the specified term.
 * *
 * @param int $term_id ID of the term metadata is for
 * @param string $meta_key Optional. Metadata key. If not specified, retrieve all metadata for
 * 		the specified term.
 * @param bool $single Optional, default is false. If true, return only the first value of the
 * 		specified meta_key. This parameter has no effect if meta_key is not specified.
 * @return string|array Single metadata value, or array of values
 */
function get_term_meta($term_id, $key = '', $single = false) {
    return get_metadata('term', $term_id, $key, $single);
}

/**
 * Update metadata for the specified term. If no value already exists for the specified term
 * ID and metadata key, the metadata will be added.
 *
 * @param int $term_id ID of the term metadata is for
 * @param string $meta_key Metadata key
 * @param mixed $meta_value Metadata value. Must be serializable if non-scalar.
 * @param mixed $prev_value Optional. If specified, only update existing metadata entries with
 * 		the specified value. Otherwise, update all entries.
 * @return int|bool Meta ID if the key didn't exist, true on successful update, false on failure.
 */
function update_term_meta($term_id, $meta_key, $meta_value, $prev_value = '') {
    return update_metadata('term', $term_id, $meta_key, $meta_value, $prev_value);
}

/**
 * Add metadata for the specified term.
 *
 * @param int $term_id ID of the term metadata is for
 * @param string $meta_key Metadata key
 * @param mixed $meta_value Metadata value. Must be serializable if non-scalar.
 * @param bool $unique Optional, default is false. Whether the specified metadata key should be
 * 		unique for the term. If true, and the term already has a value for the specified
 * 		metadata key, no change will be made
 * @return int|bool The meta ID on success, false on failure.
 */
function add_term_meta($term_id, $meta_key, $meta_value, $unique = false) {
    return add_metadata('term', $term_id, $meta_key, $meta_value, $unique);
}

/**
 * Delete metadata for the specified term.
 *
 * @param int $term_id ID of the term metadata is for
 * @param string $meta_key Metadata key
 * @param mixed $meta_value Optional. Metadata value. Must be serializable if non-scalar. If specified, only delete metadata entries
 * 		with this value. Otherwise, delete all entries with the specified meta_key.
 * @param bool $delete_all Optional, default is false. If true, delete matching metadata entries
 * 		for all terms, ignoring the specified term_id. Otherwise, only delete matching
 * 		metadata entries for the specified term_id.
 * @return bool True on successful delete, false on failure.
 */
function delete_term_meta($term_id, $meta_key, $meta_value = '', $delete_all = false) {
    return delete_metadata('term', $term_id, $meta_key, $meta_value, $delete_all);
}