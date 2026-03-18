<?php
/**
 * Template Part: Author Box
 * @package MyTheme
 */
$author_id  = get_the_author_meta( 'ID' );
$author_bio = get_the_author_meta( 'description' );
if ( ! $author_bio ) return;
?>
<div class="author-box" itemscope itemtype="https://schema.org/Person">
    <div class="author-box__avatar">
        <?php echo get_avatar( $author_id, 80, '', get_the_author(), array( 'itemprop' => 'image' ) ); ?>
    </div>
    <div class="author-box__info">
        <p style="font-size:var(--font-size-xs);text-transform:uppercase;letter-spacing:.08em;color:var(--color-text-muted);margin-bottom:.25rem;">
            <?php esc_html_e( 'Written by', 'my-theme' ); ?>
        </p>
        <h4 class="author-box__name" itemprop="name">
            <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php the_author(); ?></a>
        </h4>
        <p class="author-box__bio" itemprop="description"><?php echo wp_kses_post( $author_bio ); ?></p>
        <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="btn btn--ghost btn--sm">
            <?php printf( esc_html__( 'More posts by %s', 'my-theme' ), esc_html( get_the_author() ) ); ?>
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</div>
