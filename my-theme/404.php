<?php
/**
 * The template for displaying 404 pages.
 * @package MyTheme
 */
get_header();
?>
<main id="primary" class="site-main">
    <section class="error-404 not-found">
        <div class="error-404__content">
            <p class="error-404__code" aria-hidden="true">404</p>
            <h1 class="error-404__title"><?php esc_html_e( 'Page Not Found', 'my-theme' ); ?></h1>
            <p class="error-404__desc"><?php esc_html_e( "Oops! The page you're looking for doesn't exist or has been moved.", 'my-theme' ); ?></p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary btn--lg">
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                    <?php esc_html_e( 'Back to Home', 'my-theme' ); ?>
                </a>
            </div>
            <div style="margin-top:3rem;max-width:480px;margin-left:auto;margin-right:auto;">
                <?php get_search_form(); ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
