<?php
/**
 * Declares a block
 *
 * @package bulk
 */

/**
 * Function to be used in the action callback to declare this block.
 */
function child_theme_block_latest_news() {
	theme_declare_block(
		array(
			'name'        => 'latest-news',
			'title'       => __( 'Latest News', 'bulk' ),
			'description' => __( 'Most recent article and a list of other articles', 'bulk' ),
			'icon'        => 'info-outline',
			'mode'        => 'edit',
			'supports'    => array(
				'align'  => true,
				'mode'   => false,
				'anchor' => true,
			),
		)
	);
}

add_action( 'theme_declare_block', 'child_theme_block_latest_news', 20 );
