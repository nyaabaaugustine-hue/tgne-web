<?php
/**
 * The template for displaying search results.
 * @package MyTheme
 */
get_header();
?>
<main id="primary" class="site-main">
    <header class="page-header">
        <div class="container">
            <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'my-theme' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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
                        <div class="pagination"><?php my_theme_pagination(); ?></div>
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
