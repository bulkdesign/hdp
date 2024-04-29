<?php
/**
 * Block: Posts Archive with Filter
 *
 * @package bulk
 */

$filters = get_query_var('filter_block');

if ( ! is_singular() && empty( $filters ) ) {
    $uses_custom_query = 0;
    $queried_object = get_queried_object();
} else {
    $uses_custom_query = 1;
    if(empty($filters)){
        $filters = array();
    }
}

// Add a fallback in case $queried_object is still not set
if ( ! isset( $queried_object ) ) {
    $queried_object = null; // Define a default value if $queried_object is not set
}

$post_types = get_field( 'post_types' ) ? get_field( 'post_types' ) : apply_filters( 'single_select_posts_archive_post_types', array( 'post' ) );

?>

<section <?php theme_block_attributes( $block, 'single-select-posts-archive alignwide' ); ?>>
    <?php if ( ! get_field( 'hide_title' ) ) : ?>
    <header>
        <h1>
            <?php 
                if( is_search() ){
                    $title = sprintf( esc_attr__( 'Search for: %s', 'bulk' ), get_search_query() );
                }elseif( is_home() ){
                    $title = get_the_title( get_option( 'page_for_posts', true ) );
                }else{
                    $title = get_the_archive_title(); 
                }

                if( get_field( 'title' ) ) {
                    the_field( 'title' );
                }else{
                    echo apply_filters( 'single_select_posts_archive_title', $title );
                }
            ?>
        </h1>
    </header>
    <?php endif; ?>

    <?php
        if( is_post_type_archive() ){
            $post_type_taxonomies = get_object_taxonomies( $queried_object->name );
        }elseif( is_tax() ){
            $post_type_taxonomies = array( $queried_object->taxonomy );
        }else{
            $post_type_taxonomies = get_object_taxonomies( $post_types );
        }

        $filter_taxonomies = get_field( 'taxonomies' ) ? get_field( 'taxonomies' ) : apply_filters( 'single_select_posts_archive_taxonomies', $post_type_taxonomies, $queried_object );
    ?>
    
    <?php if ( ! empty( $filter_taxonomies ) ) : ?>
        <form class="single-select-posts-archive-filters">
            <div>
                <div class="sr-only">
                    <h2><?php esc_attr_e('Filters', 'bulk'); ?></h2>
                    <p><?php esc_attr_e('Changing any of the form inputs will cause the content to refresh with the filtered results.'); ?></p>
                </div>
                <a href="#<?php echo esc_attr( theme_block_id( $block ) ); ?>-single-select-posts-archive-content-grid" class="sr-only ignore skip-filters"><?php esc_html_e( 'Skip filters', 'bulk' ); ?></a>
            </div>
            <input type="hidden" name="paged" value="1">

            <?php if (is_array($filter_taxonomies)) : ?>
                <?php foreach( $filter_taxonomies as $filter_taxonomy ): ?>
                    <?php
                        $taxonomy_details = get_taxonomy( $filter_taxonomy );

                        if ( ! is_wp_error( $taxonomy_details ) ) {
                            $taxonomies_to_display = get_terms( array(
                                'taxonomy' => $filter_taxonomy,
                            ) );
                        }else{
                            $taxonomies_to_display = array();
                        }
                    ?>

                    <?php if( ! empty( $taxonomies_to_display ) ): ?>
                    <div class="single-select-posts-archive-filters-group" data-taxonomy="<?php echo $filter_taxonomy; ?>">
                        <div class="single-select-posts-archive-filters-group-heading">
                            <button type="button" class="single-select-posts-archive-filters-group-clear" title="<?php printf(esc_attr__( 'Clear All %s', 'bulk' ), $taxonomy_details->label); ?>" aria-label="<?php printf(esc_attr__( 'Clear All %s', 'bulk' ), $taxonomy_details->label); ?>" tabindex="-1" aria-hidden disabled></button>
                            <button type="button" class="single-select-posts-archive-filters-group-title" aria-expanded="true" aria-haspopup="listbox" role="combobox">
                                <h2><?php echo $taxonomy_details->label; ?></h2>
                            </button>
                        </div>
                        <div class="single-select-posts-archive-filters-group-options" aria-label="<?php echo $taxonomy_details->label; ?>">
                            <?php
                                if ( ! $uses_custom_query ) {
                                    $selected_taxonomies = get_query_var( $taxonomy_details->query_var );
                                }else{
                                    if( ! empty( $filters['taxonomy'][$taxonomy_details->name] ) ){
                                        $selected_taxonomies = $filters['taxonomy'][$taxonomy_details->name];
                                    }
                                }
                                if( ! empty($selected_taxonomies) && ! is_array($selected_taxonomies) ){
                                    $selected_taxonomies = explode(',', get_query_var( $taxonomy_details->query_var ));
                                }
                                if( empty( $selected_taxonomies ) ){
                                    $selected_taxonomies = array();
                                }
                            ?>
                            <?php foreach( $taxonomies_to_display as $current_taxonomy ) : ?>
                            <div class="single-select-posts-archive-filters-group-options-item">
                                <?php
                                    $field_id = $current_taxonomy->taxonomy . '_' . $current_taxonomy->term_id;
                                    $field_name = 'filter_block[taxonomy][' . $taxonomy_details->name . '][]';
                                ?>
                                <input type="radio" name="<?php echo $field_name; ?>" id="<?php echo $field_id; ?>" value="<?php echo $current_taxonomy->slug; ?>" <?php echo in_array( $current_taxonomy->slug, $selected_taxonomies, false ) ? 'checked' : ''; ?>>
                                <label for="<?php echo $field_id; ?>">
                                    <?php echo $current_taxonomy->name; ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="single-select-posts-archive-filters-submit">
                <button type="submit" class="primary-button">
                    <?php esc_attr_e( 'Apply', 'bulk' ); ?>
                </button>
            </div>
        </form>
    <?php endif; ?>
    <div class="single-select-posts-archive-content-wrapper">
		<div class="single-select-posts-archive-content-loading">
			<?php theme_block_asset( 'img/loading.svg' ); ?>
		</div>
        <div class="single-select-posts-archive-content-inner">
            <?php
                if ( ! $uses_custom_query ) {
                    global $wp_query;
			        $query = $wp_query;
                } else {
                    $args = array(
                        'post_type'      => $post_types,
                        'paged'          => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
                        'orderby'        => 'date',
                        'order'          => 'desc',
                        // phpcs:ignore
                        'posts_per_page' => get_field( 'posts_per_page' ) ? get_field( 'posts_per_page' ) : get_option( 'posts_per_page' ),
                        // phpcs:ignore
                        'tax_query'      => array(),
                    );

                    if ( ! empty( $filters['s'] ) ) {
                        $args['s'] = $filters['s'];
                    }

                    if ( ! empty( $filters['taxonomy'] ) ) {
                        foreach ( $filters['taxonomy'] as $key => $filter ) {
                            $args['tax_query'][] = array(
                                'taxonomy' => $key,
                                'field'    => 'slug',
                                'terms'    => $filter,
                            );
                        }
                    }

				    $query = new WP_Query( $args );
                }
            ?>

            <?php if ( $query->have_posts() ) : ?>
                <div class="single-select-posts-archive-content-grid" id="<?php echo esc_attr( theme_block_id( $block ) ); ?>-single-select-posts-archive-content-grid" tabindex="0">
                    <?php while ( $query->have_posts() ) : ?>
                        <?php $query->the_post(); ?>
                        <?php get_template_part( 'template-parts/post', get_post_type() ); ?>
                    <?php endwhile; ?>
                </div>
                <div class="single-select-posts-archive-content-pagination">
                    <?php if ( ! $uses_custom_query ) : ?>
                        <?php the_posts_pagination(); ?>
                    <?php else: ?>
                    <nav class="navigation pagination" aria-label="<?php esc_attr_e( 'Pagination', 'bulk' ); ?>">
                        <div class="nav-links">
                            <?php  
                                echo wp_kses_post(
                                    paginate_links(
                                        array(
                                            'base'    => str_replace( PHP_INT_MAX, '%#%', get_pagenum_link( PHP_INT_MAX, false ) ),
                                            'format'  => '?paged=%#%',
                                            'current' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
                                            'total'   => $query->max_num_pages,
                                        )
                                    )
                                );
                            ?>
                        </div>
                    </nav>
                    <?php endif; ?>
                </div>
            <?php else : ?>
            <div class="single-select-posts-archive-content-not-found" id="<?php echo esc_attr( theme_block_id( $block ) ); ?>-single-select-posts-archive-content-grid" tabindex="0">
                <h3><?php esc_attr_e( 'Nothing found', 'bulk' ); ?></h3>
                <p><?php esc_attr_e( 'No content matching your selection was found. Please try again.', 'bulk' ); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>