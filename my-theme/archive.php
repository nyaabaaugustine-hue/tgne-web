<?php
/**
 * The template for displaying archive pages.
 * @package MyTheme
 */
get_header();
?>
<main id="primary" class="site-main">
    <header class="page-header">
        <div class="container">
            <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
            <?php the_archive_description( '<p class="archive-description">', '</p>' ); ?>
        </div>
    </header>
    <section class="section">
        <div class="container">
            <div class="content-area <?php echo is_active_sidebar( 'sidebar-1' ) ? '' : 'content-area--no-sidebar'; ?>">
                <div>
                    <?php if ( have_posts() ) : ?>
                        <div class="posts-grid">
                            <?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content', 'card' ); endwhile; ?>
                        </div>
                        <div class="pagination" role="navigation"><?php my_theme_pagination(); ?></div>
                    <?php else : ?>
                        <?php get_template_part( 'template-parts/content', 'none' ); ?>
                    <?php endif; ?>
                </div>
                <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                    <aside id="secondary" class="sidebar" role="complementary"><?php dynamic_sidebar( 'sidebar-1' ); ?></aside>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
