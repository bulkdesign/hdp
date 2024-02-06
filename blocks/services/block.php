<?php
/**
 * Declares a block
 *
 * @package bulk
 */

/**
 * Function to be used in the action callback to declare this block.
 */
function child_theme_block_services() {
	theme_declare_block(
		array(
			'name'        => 'services',
			'title'       => __( 'Services', 'bulk' ),
			'description' => __( 'Featured services', 'bulk' ),
			'icon'        => 'plus',
			'mode'        => 'edit',
			'supports'    => array(
				'align'  => true,
				'mode'   => false,
				'anchor' => true,
			),
		)
	);
}

add_action( 'theme_declare_block', 'child_theme_block_services', 20 );
