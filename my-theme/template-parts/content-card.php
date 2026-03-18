<?php
/**
 * Template Part: Post Card
 * Used in archive, blog preview, and search results.
 * @package MyTheme
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="post-card__thumbnail" tabindex="-1" aria-hidden="true">
            <?php the_post_thumbnail( 'my-theme-card', array( 'loading' => 'lazy', 'alt' => esc_attr( get_the_title() ) ) ); ?>
        </a>
    <?php endif; ?>

    <div class="post-card__body">
        <?php
        $categories = get_the_category();
        if ( $categories ) :
        ?>
            <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="post-card__category">
                <?php echo esc_html( $categories[0]->name ); ?>
            </a>
        <?php endif; ?>

        <h3 class="post-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <p class="post-card__excerpt">
            <?php echo wp_trim_words( get_the_excerpt(), 20, '&hellip;' ); // phpcs:ignore ?>
        </p>

        <div class="post-card__meta">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 28, '', get_the_author(), array( 'class' => 'avatar' ) ); ?>
            <span><?php the_author(); ?></span>
            <span class="sep">&bull;</span>
            <time datetime="<?php the_date( 'c' ); ?>"><?php the_date(); ?></time>
        </div>
    </div>

</article>
