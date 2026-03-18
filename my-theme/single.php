<?php
/**
 * The template for displaying all single posts.
 * @package MyTheme
 */
get_header();
?>
<main id="primary" class="site-main">
    <section class="section">
        <div class="container">
            <div class="content-area">
                <div class="post-column">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>
                        <header class="entry-header">
                            <?php
                            $categories = get_the_category();
                            if ( $categories ) :
                            ?>
                                <div class="entry-cats">
                                    <?php foreach ( $categories as $cat ) : ?>
                                        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="post-card__category">
                                            <?php echo esc_html( $cat->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                            <?php my_theme_post_meta(); ?>
                        </header>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="entry-thumbnail">
                                <?php the_post_thumbnail( 'my-theme-card', array( 'loading' => 'eager', 'alt' => esc_attr( get_the_title() ) ) ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="entry-content">
                            <?php the_content(); ?>
                            <?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'my-theme' ), 'after' => '</div>' ) ); ?>
                        </div>
                        <footer class="entry-footer">
                            <?php
                            $tags = get_the_tags();
                            if ( $tags ) :
                            ?>
                                <div class="tags-links">
                                    <span class="label"><?php esc_html_e( 'Tags:', 'my-theme' ); ?></span>
                                    <?php foreach ( $tags as $tag ) : ?>
                                        <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-link">#<?php echo esc_html( $tag->name ); ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <nav class="post-navigation" aria-label="<?php esc_attr_e( 'Post navigation', 'my-theme' ); ?>">
                                <?php the_post_navigation( array(
                                    'prev_text' => '<span class="nav-direction"><i class="fa-solid fa-arrow-left"></i> ' . esc_html__( 'Previous Post', 'my-theme' ) . '</span><span class="nav-title">%title</span>',
                                    'next_text' => '<span class="nav-direction">' . esc_html__( 'Next Post', 'my-theme' ) . ' <i class="fa-solid fa-arrow-right"></i></span><span class="nav-title">%title</span>',
                                ) ); ?>
                            </nav>
                        </footer>
                    </article>
                    <?php get_template_part( 'template-parts/content', 'author-box' ); ?>
                    <?php if ( comments_open() || get_comments_number() ) : ?>
                        <div class="comments-area"><?php comments_template(); ?></div>
                    <?php endif; ?>
                    <?php endwhile; ?>
                </div>
                <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                    <aside id="secondary" class="sidebar" role="complementary">
                        <?php dynamic_sidebar( 'sidebar-1' ); ?>
                    </aside>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php get_template_part( 'template-parts/content', 'related-posts' ); ?>
</main>
<?php get_footer(); ?>
