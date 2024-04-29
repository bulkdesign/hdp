<?php
/**
 * Declares a block
 *
 * @package bulk
 */

/**
 * Function to be used in the action callback to declare this block.
 */
function child_theme_single_select_posts_archive() {
	theme_declare_block(
		array(
			'name'        => 'single-select-posts-archive',
			'title'       => __( 'Single Select Posts Archive', 'bulk' ),
			'description' => __( 'Displays a list of posts and a sidebar with single selection filters.', 'bulk' ),
			'icon'        => 'admin-post',
			'mode'        => 'edit',
			'supports'    => array(
				'align'  => false,
				'mode'   => false,
				'anchor' => true,
			),
            'post_types'  => array( 'page', 'template' ),
		)
	);

	function child_theme_single_select_posts_archive_query_vars( $query_vars ){
		$query_vars[] = 'filter_block';
		return $query_vars;
	}
	add_filter( 'query_vars', 'child_theme_single_select_posts_archive_query_vars' );
	
    function child_theme_single_select_posts_archive_load_post_types( $field ) {
		$post_types = get_post_types( array(), 'objects');

		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $current_post_type ) {
				if ( $current_post_type->exclude_from_search || $current_post_type->name === 'attachment' ) continue;
				$field['choices'][ $current_post_type->name ] = $current_post_type->label;
			}
		}

        return $field;
    }
    add_filter( 'acf/prepare_field/key=field_77c158a4ed708', 'child_theme_single_select_posts_archive_load_post_types' );
	
    function child_theme_single_select_posts_archive_load_taxonomies( $field ) {
		$taxonomies = get_taxonomies( array(), 'objects');

		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $current_taxonomy ) {
				if ( ! $current_taxonomy->publicly_queryable || $current_taxonomy->name === 'post_format' ) continue;
				$field['choices'][ $current_taxonomy->name ] = $current_taxonomy->label;
			}
		}

        return $field;
    }
    add_filter( 'acf/prepare_field/key=field_77c158b2ed709', 'child_theme_single_select_posts_archive_load_taxonomies' );
}

add_action( 'theme_declare_block', 'child_theme_single_select_posts_archive', 60 );