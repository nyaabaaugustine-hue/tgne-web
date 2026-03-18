<?php
/**
 * The main template file.
 * @package MyTheme
 */
get_header();
?>

<?php if ( is_home() && ! is_front_page() ) : ?>
    <main id="primary" class="site-main">
        <header class="page-header">
            <div class="container">
                <h1 class="page-title"><?php esc_html_e( 'Latest Posts', 'my-theme' ); ?></h1>
            </div>
        </header>
        <section class="section">
            <div class="container">
                <?php get_template_part( 'template-parts/loop', 'blog' ); ?>
            </div>
        </section>
    </main>
<?php else : ?>
    <main id="primary" class="site-main">
        <?php get_template_part( 'template-parts/home/section', 'hero' ); ?>
        <?php get_template_part( 'template-parts/home/section', 'features' ); ?>
        <?php get_template_part( 'template-parts/home/section', 'stats' ); ?>
        <?php get_template_part( 'template-parts/home/section', 'testimonials' ); ?>
        <?php get_template_part( 'template-parts/home/section', 'blog-preview' ); ?>
        <?php get_template_part( 'template-parts/home/section', 'cta' ); ?>
    </main>
<?php endif; ?>

<?php get_footer(); ?>
