<?php
/**
 * Template Part: Hero Section
 * @package MyTheme
 */
?>
<section class="hero" aria-label="<?php esc_attr_e( 'Hero', 'my-theme' ); ?>">
    <div class="container">
        <div class="hero__inner">

            <div class="hero__content">
                <span class="hero__label">
                    <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                    <?php esc_html_e( 'Welcome to TGNE Solutions', 'my-theme' ); ?>
                </span>
                <h1 class="hero__title">
                    <?php esc_html_e( 'Technology.', 'my-theme' ); ?>
                    <span class="highlight"><?php esc_html_e( 'Graphics.', 'my-theme' ); ?></span>
                    <?php esc_html_e( 'Education.', 'my-theme' ); ?>
                </h1>
                <p class="hero__desc">
                    <?php esc_html_e( 'TGNE Solutions delivers premium branding, print, digital design, and technology services that help your business stand out and grow.', 'my-theme' ); ?>
                </p>
                <div class="hero__actions">
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary btn--lg">
                        <?php esc_html_e( 'Get a Free Quote', 'my-theme' ); ?>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/home/' ) ); ?>" class="btn btn--ghost btn--lg">
                        <i class="fa-solid fa-play" aria-hidden="true"></i>
                        <?php esc_html_e( 'View Our Work', 'my-theme' ); ?>
                    </a>
                </div>
            </div>

            <div class="hero__media">
                <?php if ( is_front_page() && has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'my-theme-hero', array( 'loading' => 'eager', 'alt' => get_the_title() ) ); ?>
                <?php else : ?>
                    <img src="<?php echo esc_url( MY_THEME_URI . '/assets/images/hero-placeholder.svg' ); ?>"
                         alt="<?php esc_attr_e( 'TGNE Solutions', 'my-theme' ); ?>"
                         width="600" height="500" loading="eager">
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
