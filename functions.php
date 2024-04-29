<?php
/**
 * WordPress theme functions and definitions
 *
 * @package bulk
 */

/**
 * Include helper scripts
 */
require_once get_stylesheet_directory() . '/inc/post-types.php';
require_once get_stylesheet_directory() . '/inc/taxonomies.php';

/**
 * Enqueue all the stylesheets necessary for the child theme.
 */
function child_theme_enqueue_styles() {
    //wp_enqueue_style( 'font-montserrat', 'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap' );
    wp_enqueue_style( 'child-main-css', get_stylesheet_directory_uri() . '/css/main.css', array('main-css'), theme_get_app_css_version() );
}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );

/**
 * Enqueue all the scripts necessary for the child.
 */

function child_theme_enqueue_scripts() {
    //wp_enqueue_script( 'select2-js', get_stylesheet_directory_uri() . '/js/select2.min.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_scripts', 30 );


/**
 * Filter allowed blocks
 */
function child_theme_allowed_blocks() {
	return array(
        'columns-with-content',
        'content-in-columns',
        'content-with-media',
        'contact-with-map',
        'footer-one',
        'header-simple',
        'latest-news',
        'links-accordion',
        'logos-carousel',
        'logos-grid',
        'page-hero',
        'page-hero-carousel',
        'single-select-posts-archive',
        'section-background',
        'single-post-content',
        'template-content',
        'testimonials',
        'title-and-content',
        'photos-carousel',
        'timeline',
        'top-bar',
    );
}
add_filter( 'theme_allowed_blocks', 'child_theme_allowed_blocks', 10, 0);

/**
 * Define Filters for achive
 *
 */ 
function child_theme_posts_archive_with_filter_taxonomies(){
    //return array('resource_type', 'topic');
}
add_action( 'posts_archive_with_filter_taxonomies', 'child_theme_posts_archive_with_filter_taxonomies' );

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function child_theme_custom_excerpt_size( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'child_theme_custom_excerpt_size', 999 );

/*
** Include ZIP files upload
*/
add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {
    // add your extension to the mimes array as below
    $existing_mimes['zip'] = 'application/zip';
    $existing_mimes['gz'] = 'application/x-gzip';
    return $existing_mimes;
}

// Development mode - delete before completing the project
// function bulk_is_developing(){
//     return true;
// }