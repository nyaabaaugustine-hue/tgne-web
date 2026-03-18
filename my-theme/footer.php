<?php
/**
 * Footer template — TGNE Solutions
 * All helper functions are defined in functions.php.
 * @package MyTheme
 */

// Fallback nav functions — defined here so footer.php is self-contained
if ( ! function_exists( 'my_theme_fallback_menu' ) ) {
    function my_theme_fallback_menu() {
        echo '<ul id="primary-menu" class="nav-menu">';
        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">About</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">Contact</a></li>';
        echo '</ul>';
    }
}

if ( ! function_exists( 'my_theme_footer_fallback_nav' ) ) {
    function my_theme_footer_fallback_nav() {
        echo '<ul>';
        echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">About Us</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/our-approach/' ) ) . '">Our Approach</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">Contact</a></li>';
        echo '</ul>';
    }
}

if ( ! function_exists( 'my_theme_services_footer_nav' ) ) {
    function my_theme_services_footer_nav() {
        echo '<ul>';
        echo '<li><a href="' . esc_url( home_url( '/graphic-design/' ) ) . '">Graphic Design</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/printing/' ) ) . '">Digital Prints</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/services-technology/' ) ) . '">Technology</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/training-programs/' ) ) . '">Training</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/branded-souvenirs/' ) ) . '">Souvenirs</a></li>';
        echo '</ul>';
    }
}
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">

        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
            <div class="footer-widgets">
                <div class="container">
                    <div class="footer-widgets-grid">
                        <?php if ( is_active_sidebar( 'footer-1' ) ) : ?><div class="footer-widget-col"><?php dynamic_sidebar( 'footer-1' ); ?></div><?php endif; ?>
                        <?php if ( is_active_sidebar( 'footer-2' ) ) : ?><div class="footer-widget-col"><?php dynamic_sidebar( 'footer-2' ); ?></div><?php endif; ?>
                        <?php if ( is_active_sidebar( 'footer-3' ) ) : ?><div class="footer-widget-col"><?php dynamic_sidebar( 'footer-3' ); ?></div><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="footer-main">
            <div class="container">
                <div class="footer-grid">

                    <div class="footer-brand">
                        <?php if ( has_custom_logo() ) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <p class="footer-brand__name">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                            </p>
                        <?php endif; ?>

                        <?php $footer_desc = get_theme_mod( 'my_theme_footer_desc', get_bloginfo( 'description' ) ); ?>
                        <?php if ( $footer_desc ) : ?>
                            <p class="footer-brand__desc"><?php echo esc_html( $footer_desc ); ?></p>
                        <?php endif; ?>

                        <?php $social_links = my_theme_get_social_links(); ?>
                        <?php if ( ! empty( $social_links ) ) : ?>
                            <div class="footer-social">
                                <?php foreach ( $social_links as $network => $data ) : ?>
                                    <a href="<?php echo esc_url( $data['url'] ); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $data['label'] ); ?>">
                                        <i class="<?php echo esc_attr( $data['icon'] ); ?>" aria-hidden="true"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="footer-col">
                        <h4 class="footer-col__title">Company</h4>
                        <?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'footer-nav-list', 'container' => false, 'depth' => 1, 'fallback_cb' => 'my_theme_footer_fallback_nav' ) ); ?>
                    </div>

                    <div class="footer-col">
                        <h4 class="footer-col__title">Services</h4>
                        <?php my_theme_services_footer_nav(); ?>
                    </div>

                    <div class="footer-col">
                        <h4 class="footer-col__title">Contact</h4>
                        <ul>
                            <?php if ( get_theme_mod( 'my_theme_email' ) ) : ?>
                                <li><a href="mailto:<?php echo esc_attr( get_theme_mod( 'my_theme_email' ) ); ?>"><i class="fa-regular fa-envelope"></i> <?php echo esc_html( get_theme_mod( 'my_theme_email' ) ); ?></a></li>
                            <?php endif; ?>
                            <?php if ( get_theme_mod( 'my_theme_phone' ) ) : ?>
                                <li><a href="tel:<?php echo esc_attr( get_theme_mod( 'my_theme_phone' ) ); ?>"><i class="fa-solid fa-phone"></i> <?php echo esc_html( get_theme_mod( 'my_theme_phone' ) ); ?></a></li>
                            <?php endif; ?>
                            <?php if ( get_theme_mod( 'my_theme_address' ) ) : ?>
                                <li><span><i class="fa-solid fa-location-dot"></i> <?php echo esc_html( get_theme_mod( 'my_theme_address' ) ); ?></span></li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
                <p class="footer-bottom__copy">
                    <?php
                    $footer_text = get_theme_mod( 'my_theme_footer_text', '' );
                    if ( $footer_text ) {
                        echo wp_kses_post( $footer_text );
                    } else {
                        printf( '&copy; %s %s. All Rights Reserved.', esc_html( gmdate( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) );
                    }
                    ?>
                </p>
                <nav class="footer-bottom__menu">
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>">Terms of Service</a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </footer>

    <?php get_template_part( 'template-parts/tgne-footer-widgets' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
