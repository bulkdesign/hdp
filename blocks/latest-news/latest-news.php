<?php
/**
 * The block code
 *
 * @package bulk
 */

?>

<section <?php theme_block_attributes( $block, 'latest-news' ); ?>>

    <?php if ( ! empty( get_field('title') ) ): ?>
        <h1><?php echo get_field('title'); ?></h1>
    <?php endif; ?>

    <?php if ( ! empty( get_field('subtitle') ) ): ?>
        <p><?php echo get_field('subtitle'); ?></p>
    <?php endif; ?>

    <div class="news">

        <?php
        $featured = array( 
            'post_type'      => array( 'post'),
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'orderby'        => 'date',
            'order'          => 'DESC'
        );

        $the_query = new WP_Query( $featured );
        ?>

        <?php if ( $the_query->have_posts() ) : ?>
            <?php while ( $the_query->have_posts() ) : ?>
                <?php $the_query->the_post(); ?>
                <article>
                    <a href="<?php echo get_permalink(); ?>">
                        <?php $featured_image = get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>
                        <?php $featured_image_alt = get_post_meta($featured_image , '_wp_attachment_image_alt', true); ?>

                        <?php if ( ! empty( $featured_image ) ) : ?>
                            <img src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt; ?>" title="<?php the_title(); ?>">
                            <h3><?php the_title(); ?></h3>
                    </a>

                    <p class="excerpt">
                        <?php the_excerpt(); ?>
                    </p>
                </article>

                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>

        <?php
        $list = array( 
            'post_type'      => array( 'post'),
            'post_status'    => 'publish',
            'posts_per_page' => 3,
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

</section>