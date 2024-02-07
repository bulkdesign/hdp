<?php
/**
 * The block code
 *
 * @package bulk
 */

?>

<div <?php theme_block_attributes( $block, 'top-bar' ); ?>>
    <div class="top-bar-inner">
        <?php if( get_field( 'text' ) ): ?>
        <div class="top-bar-content">
            <p><?php the_field( 'text' ); ?></p>
        </div>
        <?php endif; ?>

        <?php if( have_rows( 'social_media' ) ): ?>
            <div class="top-bar-social-media">
                <?php if( get_field( 'social_media_title' ) ): ?>
                <h2><?php the_field( 'social_media_title' ); ?></h2>
                <?php endif; ?>

                <ul>
                    <?php while( have_rows( 'social_media' ) ): ?>
                    <?php the_row(); ?>
                    <li>
                        <?php 
                            $logo   = get_sub_field( 'icon' ); 
                            $button = get_sub_field( 'link' ); 
                        ?>
                        <?php if ( ! empty( $button ) ) : ?>
                        <a href="<?php echo esc_attr( $button['url'] ); ?>" target="<?php echo esc_attr( theme_get_link_target( $button ) ); ?>" aria-label="<?php echo esc_attr( theme_get_link_aria_label( $button ) ); ?>" title="<?php echo esc_attr( $button['title'] ); ?>">
                            <?php if(!empty($logo)): ?>
                                <?php if( 'image/svg+xml' === $logo['mime_type'] ): ?>
                                    <?php 
                                        // phpcs:ignore
                                        echo file_get_contents( get_attached_file( $logo['ID'] ) );
                                    ?>
                                <?php else: ?>
                                    <img src="<?php echo esc_attr( $logo['url'] ); ?>" alt="<?php echo esc_attr( $button['title'] ); ?>" loading="lazy">
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <span>
                                <?php echo wp_kses_post( $button['title'] ); ?>
                            </span>

                            <?php if ( '_blank' === theme_get_link_target( $button ) ) : ?>
                            <span class="sr-only">
                                <?php esc_attr_e( '(Opens in a new tab)', 'bulk'); ?>
                            </span>
                            <?php endif; ?>
                        </a>
                        <?php endif; ?>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>