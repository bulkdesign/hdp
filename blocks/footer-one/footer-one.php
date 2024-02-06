<?php
/**
 * Block: Footer One
 *
 * @package mm
 */

?>

<footer <?php theme_block_attributes( $block, 'footer-one alignfull' ); ?> data-color-scheme="<?php the_field( 'color_scheme' ); ?>">
    <div class="footer-one-main">
        <?php $logo = get_field( 'logo' ); ?>
        <?php if (!empty($logo)): ?>
            <div class="footer-one-column">
                <a href="<?php echo esc_url( get_home_url() ); ?>" class="logo" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    <?php if(!empty($logo)): ?>
                        <?php if( 'image/svg+xml' === $logo['mime_type'] ): ?>
                            <?php 
                                // phpcs:ignore
                                echo file_get_contents( get_attached_file( $logo['ID'] ) );
                            ?>
                        <?php else: ?>
                            <img src="<?php echo esc_attr( $logo['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        <?php endif; ?>
                    <?php endif; ?>
                </a>

                <?php the_field( 'text_content' ); ?>
            </div>
        <?php endif; ?>

        <div class="footer-one-column-container">
            <?php if( have_rows( 'menus' ) ): ?>
                <?php while( have_rows( 'menus' ) ): ?>
                    <?php the_row(); ?>

                    <div class="footer-one-column">
                        <?php if( get_sub_field( 'title' ) ): ?>
                        <h2><?php the_sub_field( 'title' ); ?></h2>
                        <?php endif; ?>
                        <?php
                            $menu = wp_get_nav_menu_object( get_sub_field( 'menu' ) );
                            if ( ! is_wp_error( $menu ) ) {
                                $menu_name = $menu->name;
                            }else{
                                $menu_name = '';
                            }

                            wp_nav_menu(
                                array(
                                    'menu' => get_sub_field( 'menu' ),
                                    'depth' => 1,
                                    'container' => 'nav',
                                    'container_aria_label' => $menu_name,
                                )
                            );
                        ?>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

            <?php if( have_rows( 'social_media_links' ) ): ?>
            <div class="footer-one-column footer-one-social-media">
                <?php if( get_field( 'social_media_title' ) ): ?>
                <h2><?php the_field( 'social_media_title' ); ?></h2>
                <?php endif; ?>

                <ul>
                    <?php while( have_rows( 'social_media_links' ) ): ?>
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
    <div class="footer-one-copyright">
        <?php if ( get_field( 'copyright_text' ) ): ?>
            <p><?php echo get_field( 'copyright_text' ); ?></p>
        <?php endif; ?>
        
        <?php if( get_field( 'copyright' ) ): ?>
            <p><?php echo get_bloginfo(); ?> &copy; <?php echo esc_attr( date( 'Y' ) ); ?> <?php the_field( 'copyright' ); ?></p>
        <?php endif; ?>
    </div>
</footer>