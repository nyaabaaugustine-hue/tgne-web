<?php
/**
 * Template Part: Related Posts
 * @package MyTheme
 */
$categories = get_the_category();
if ( ! $categories ) return;

$related_query = new WP_Query( array(
    'category__in'        => wp_list_pluck( $categories, 'term_id' ),
    'post__not_in'        => array( get_the_ID() ),
    'posts_per_page'      => 3,
    'orderby'             => 'rand',
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
) );

if ( ! $related_query->have_posts() ) return;
?>
<section class="section section--alt related-posts-section" aria-label="<?php esc_attr_e( 'Related Posts', 'my-theme' ); ?>">
    <div class="container">
        <header class="section__header">
            <h2 class="section__title" style="font-size:var(--font-size-3xl);">
                <?php esc_html_e( 'You Might Also Like', 'my-theme' ); ?>
            </h2>
        </header>
        <div class="posts-grid">
            <?php
            while ( $related_query->have_posts() ) :
                $related_query->the_post();
                get_template_part( 'template-parts/content', 'card' );
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
