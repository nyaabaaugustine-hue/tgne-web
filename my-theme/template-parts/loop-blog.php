<?php
/**
 * Template Part: Blog Loop
 * @package MyTheme
 */
?>
<div class="content-area <?php echo is_active_sidebar( 'sidebar-1' ) ? '' : 'content-area--no-sidebar'; ?>">
    <div>
        <?php if ( have_posts() ) : ?>
            <div class="posts-grid">
                <?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content', 'card' ); endwhile; ?>
            </div>
            <div class="pagination" role="navigation" aria-label="<?php esc_attr_e( 'Blog Pagination', 'my-theme' ); ?>">
                <?php my_theme_pagination(); ?>
            </div>
        <?php else : ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; ?>
    </div>
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <aside id="secondary" class="sidebar" role="complementary">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </aside>
    <?php endif; ?>
</div>
