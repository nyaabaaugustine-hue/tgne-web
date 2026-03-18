<?php
/**
 * The template for displaying all pages.
 * @package MyTheme
 */
get_header();
?>
<main id="primary" class="site-main">
    <?php if ( ! is_front_page() ) : ?>
        <header class="page-header">
            <div class="container">
                <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
                <?php if ( has_excerpt() ) : ?><p><?php the_excerpt(); ?></p><?php endif; ?>
            </div>
        </header>
    <?php endif; ?>
    <section class="section">
        <div class="container">
            <div class="content-area content-area--no-sidebar">
                <?php
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', 'page' );
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                endwhile;
                ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
