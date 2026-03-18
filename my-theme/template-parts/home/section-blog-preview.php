<?php
/**
 * Template Part: Blog Preview Section
 * @package MyTheme
 */
$recent_posts = new WP_Query( array(
    'post_type'           => 'post',
    'posts_per_page'      => 3,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
) );

if ( ! $recent_posts->have_posts() ) return;
?>
<section class="section section--alt blog-preview-section" id="blog">
    <div class="container">
        <header class="section__header">
            <span class="section__label"><?php esc_html_e( 'From Our Blog', 'my-theme' ); ?></span>
            <h2 class="section__title"><?php esc_html_e( 'Latest Insights & News', 'my-theme' ); ?></h2>
            <p class="section__desc"><?php esc_html_e( 'Stay ahead with our latest articles on design, printing, technology, and business growth.', 'my-theme' ); ?></p>
        </header>
        <div class="posts-grid">
            <?php
            while ( $recent_posts->have_posts() ) :
                $recent_posts->the_post();
                get_template_part( 'template-parts/content', 'card' );
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
        <div style="text-align:center;margin-top:3rem;">
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog' ) ); ?>" class="btn btn--primary btn--lg">
                <?php esc_html_e( 'View All Articles', 'my-theme' ); ?>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>
