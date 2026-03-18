<?php
/**
 * Custom template tags for this theme.
 * @package MyTheme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'my_theme_posted_on' ) ) {
    function my_theme_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s" style="display:none">%4$s</time>';
        }
        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( DATE_W3C ) ), esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ), esc_html( get_the_modified_date() )
        );
        echo '<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>'; // phpcs:ignore
    }
}

if ( ! function_exists( 'my_theme_posted_by' ) ) {
    function my_theme_posted_by() {
        $byline = sprintf(
            esc_html_x( 'by %s', 'post author', 'my-theme' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );
        echo '<span class="byline">' . $byline . '</span>'; // phpcs:ignore
    }
}

if ( ! function_exists( 'my_theme_breadcrumbs' ) ) {
    function my_theme_breadcrumbs() {
        if ( is_front_page() ) return;
        $sep   = '<span class="breadcrumb-sep" aria-hidden="true">/</span>';
        $items = array();
        $items[] = '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'my-theme' ) . '</a>';
        if ( is_singular( 'post' ) ) {
            $cats = get_the_category();
            if ( $cats ) $items[] = '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
            $items[] = '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
        } elseif ( is_singular() ) {
            $items[] = '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
        } elseif ( is_category() ) {
            $items[] = '<span aria-current="page">' . esc_html( single_cat_title( '', false ) ) . '</span>';
        } elseif ( is_search() ) {
            $items[] = '<span aria-current="page">' . sprintf( esc_html__( 'Search: %s', 'my-theme' ), esc_html( get_search_query() ) ) . '</span>';
        } elseif ( is_404() ) {
            $items[] = '<span aria-current="page">' . esc_html__( '404 – Not Found', 'my-theme' ) . '</span>';
        }
        echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'my-theme' ) . '">';
        echo implode( $sep, $items ); // phpcs:ignore
        echo '</nav>';
    }
}

if ( ! function_exists( 'my_theme_reading_time' ) ) {
    function my_theme_reading_time() {
        $word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
        return max( 1, (int) ceil( $word_count / 200 ) );
    }
}

if ( ! function_exists( 'my_theme_social_share' ) ) {
    function my_theme_social_share() {
        $post_url   = rawurlencode( get_permalink() );
        $post_title = rawurlencode( get_the_title() );
        $share_links = array(
            'twitter'  => array( 'url' => 'https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . $post_title, 'icon' => 'fa-brands fa-x-twitter', 'label' => 'Share on X', 'color' => '#000' ),
            'facebook' => array( 'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url, 'icon' => 'fa-brands fa-facebook-f', 'label' => 'Share on Facebook', 'color' => '#1877f2' ),
            'linkedin' => array( 'url' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $post_url, 'icon' => 'fa-brands fa-linkedin-in', 'label' => 'Share on LinkedIn', 'color' => '#0a66c2' ),
            'whatsapp' => array( 'url' => 'https://api.whatsapp.com/send?text=' . $post_title . '%20' . $post_url, 'icon' => 'fa-brands fa-whatsapp', 'label' => 'Share on WhatsApp', 'color' => '#25d366' ),
        );
        echo '<div class="social-share" aria-label="' . esc_attr__( 'Share this post', 'my-theme' ) . '">';
        echo '<span class="social-share__label">' . esc_html__( 'Share:', 'my-theme' ) . '</span>';
        foreach ( $share_links as $key => $link ) {
            printf( '<a href="%s" class="social-share__btn social-share__btn--%s" target="_blank" rel="noopener noreferrer" aria-label="%s" style="--share-color:%s"><i class="%s" aria-hidden="true"></i></a>',
                esc_url( $link['url'] ), esc_attr( $key ), esc_attr( $link['label'] ), esc_attr( $link['color'] ), esc_attr( $link['icon'] ) );
        }
        echo '</div>';
    }
}
