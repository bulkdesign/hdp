<?php
/**
 * Setup suggested and required plugins for the theme.
 *
 * @package mm
 */

/**
 * Suggested and required plugins for the theme.
 */
function child_theme_register_required_plugins() {
	$plugins = array(
		
	);

	$config = array(
		'id'           => 'bulk',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'child_theme_register_required_plugins' );
