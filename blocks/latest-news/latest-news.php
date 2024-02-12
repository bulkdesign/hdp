<?php
/**
 * The block code
 *
 * @package bulk
 */

?>

<section <?php theme_block_attributes( $block, 'latest-news' ); ?>>

    <?php if ( ! empty( get_field('title') ) ): ?>
        <h2><?php echo get_field('title'); ?></h2>
    <?php endif; ?>

    <?php if ( ! empty( get_field('subtitle') ) ): ?>
        <p><?php echo get_field('subtitle'); ?></p>
    <?php endif; ?>

    <div class="news">

        <?php
        $featured = array( 
            'post_type'      => array( 'post'),
            'post_status'    => 'publish',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC'
        );

        $the_query = new WP_Query( $featured );
        ?>

        <?php if ( $the_query->have_posts() ) : ?>
            <div class="latest-news-list-wrapper">
                <div class="swiper news-carousel-list" data-loop="<?php the_field( 'enable_carousel_loop' ); ?>" data-autoplay="<?php the_field( 'enable_carousel_autoplay' ); ?>" data-animation>
                    <div class="swiper-wrapper">
                        <?php while ( $the_query->have_posts() ) : ?>
                            <?php $the_query->the_post(); ?>
                            <div class="swiper-slide">
                                <?php $featured_image = get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>
                                <?php $featured_image_alt = get_post_meta($featured_image , '_wp_attachment_image_alt', true); ?>

                                <?php if ( ! empty( $featured_image ) ) : ?>
                                    <a class="news-wrapper-featured" href="<?php echo get_permalink(); ?>">
                                        <img src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt; ?>" title="<?php the_title(); ?>">
                                    </a>
                                <?php endif; ?>

                                <a href="<?php echo get_permalink(); ?>">
                                    <h3><?php the_title(); ?></h3>
                                </a>
                                
                                <p class="excerpt">
                                    <?php the_excerpt(); ?>
                                </p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php if ( get_field( 'enable_carousel_pagination' ) ) : ?>
                <div class="latest-news-pagination" role="presentation" data-animation></div>
                <?php endif; ?>
                <?php if ( get_field( 'enable_carousel_navigation' ) ) : ?>
                    <div class="latest-news-navigation" data-animation>
                        <button class="latest-news-navigation-prev" aria-label="<?php esc_attr_e( 'Previous Logo', 'bulk' ); ?>" title="<?php esc_attr_e( 'Previous Logo', 'bulk' ); ?>">
                            <?php theme_block_asset( 'img/nav-button-left.svg' ); ?>
                        </button>
                        <button class="latest-news-navigation-next" aria-label="<?php esc_attr_e( 'Next Logo', 'bulk' ); ?>" title="<?php esc_attr_e( 'Next Logo', 'bulk' ); ?>">
                            <?php theme_block_asset( 'img/nav-button-right.svg' ); ?>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        $list = array( 
            'post_type'      => array( 'post'),
            'post_status'    => 'publish',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'offset'         => 1
        );

        $the_query = new WP_Query( $list );
        ?>

        <ul>
        <?php if ( $the_query->have_posts() ) : ?>
            <?php while ( $the_query->have_posts() ) : ?>
                <?php $the_query->the_post(); ?>
                <li>
                    <?php $featured_image = get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>
                    <?php $featured_image_alt = get_post_meta($featured_image , '_wp_attachment_image_alt', true); ?>

                    <?php if ( ! empty( $featured_image ) ) : ?>
                        <a class="news-wrapper" href="<?php echo get_permalink(); ?>">
                            <img src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt; ?>" title="<?php the_title(); ?>">
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo get_permalink(); ?>">
                        <h3><?php the_title(); ?></h3>
                    </a>

                    <p class="excerpt">
                        <?php the_excerpt(); ?>
                    </p>
                </li>
            <?php endwhile; ?>
        <?php endif; ?>
        </ul>

    </div>

    <?php $button = get_field( 'primary_button' ); ?>
    <?php if ( ! empty( $button ) ) : ?>
    <a class="primary-button all-news" href="<?php echo esc_attr( $button['url'] ); ?>" target="<?php echo esc_attr( theme_get_link_target( $button ) ); ?>" aria-label="<?php echo esc_attr( theme_get_link_aria_label( $button ) ); ?>">
        <?php echo wp_kses_post( $button['title'] ); ?>
    </a>
    <?php endif; ?>

</section>