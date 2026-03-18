<?php
/**
 * Template Part: No Content Found
 * @package MyTheme
 */
?>
<section class="no-results not-found" style="text-align:center;padding:var(--space-20) 0;">
    <header class="page-header" style="background:none;padding:0;margin-bottom:var(--space-8);">
        <h2 class="page-title" style="color:var(--color-text);">
            <?php esc_html_e( 'Nothing Found', 'my-theme' ); ?>
        </h2>
    </header>
    <div class="page-content">
        <?php if ( is_search() ) : ?>
            <p style="color:var(--color-text-muted);margin-bottom:var(--space-6);">
                <?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'my-theme' ); ?>
            </p>
        <?php else : ?>
            <p style="color:var(--color-text-muted);margin-bottom:var(--space-6);">
                <?php esc_html_e( "It seems we can't find what you're looking for. Perhaps searching can help.", 'my-theme' ); ?>
            </p>
        <?php endif; ?>
        <?php get_search_form(); ?>
    </div>
</section>
