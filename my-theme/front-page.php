<?php
/**
 * The template for displaying the front page.
 * @package MyTheme
 */
get_header();
?>
<main id="primary" class="site-main">
    <?php get_template_part( 'template-parts/home/section', 'hero' ); ?>
    <?php get_template_part( 'template-parts/home/section', 'features' ); ?>
    <?php get_template_part( 'template-parts/home/section', 'stats' ); ?>
    <?php get_template_part( 'template-parts/home/section', 'testimonials' ); ?>
    <?php get_template_part( 'template-parts/home/section', 'blog-preview' ); ?>
    <?php get_template_part( 'template-parts/home/section', 'cta' ); ?>
</main>
<?php get_footer(); ?>
