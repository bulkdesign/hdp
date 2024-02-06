<?php
/**
 * Declares a block
 *
 * @package bulk
 */

/**
 * Function to be used in the action callback to declare this block.
 */
function child_theme_block_search() {
	theme_declare_block(
		array(
			'name'        => 'search',
			'title'       => __( 'Specialist Search', 'bulk' ),
			'description' => __( 'Search bar that results in finding doctors and specialists', 'bulk' ),
			'icon'        => 'search',
			'mode'        => 'edit',
			'supports'    => array(
				'align'  => true,
				'mode'   => false,
				'anchor' => true,
			),
		)
	);
}

add_action( 'theme_declare_block', 'child_theme_block_search', 20 );
