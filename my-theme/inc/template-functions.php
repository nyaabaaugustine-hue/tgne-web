<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 * @package MyTheme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* Open Graph meta tags */
function my_theme_head_meta() { ?>
    <meta name="theme-color" content="#061B33">
    <?php if ( is_singular() ) : ?>
        <meta property="og:type"        content="article">
        <meta property="og:title"       content="<?php echo esc_attr( get_the_title() ); ?>">
        <meta property="og:url"         content="<?php echo esc_url( get_permalink() ); ?>">
        <meta property="og:description" content="<?php echo esc_attr( wp_strip_all_tags( get_the_excerpt() ) ); ?>">
        <?php if ( has_post_thumbnail() ) : ?>
            <meta property="og:image" content="<?php echo esc_url( get_the_post_thumbnail_url( null, 'large' ) ); ?>">
        <?php endif; ?>
    <?php else : ?>
        <meta property="og:type"        content="website">
        <meta property="og:title"       content="<?php bloginfo( 'name' ); ?>">
        <meta property="og:url"         content="<?php echo esc_url( home_url( '/' ) ); ?>">
        <meta property="og:description" content="<?php bloginfo( 'description' ); ?>">
    <?php endif; ?>
    <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">
<?php }
add_action( 'wp_head', 'my_theme_head_meta' );

/* Google Fonts preconnect */
function my_theme_preconnect_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'my_theme_preconnect_fonts', 1 );

/* Wrap oEmbed in responsive container */
function my_theme_wrap_embed( $html ) {
    return '<div class="responsive-embed">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'my_theme_wrap_embed', 10, 3 );

/* Disable emoji scripts */
function my_theme_disable_emojis() {
    remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles',     'print_emoji_styles' );
    remove_action( 'admin_print_styles',  'print_emoji_styles' );
    remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );
    remove_filter( 'wp_mail',             'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'my_theme_disable_emojis' );

/* Clean up head */
function my_theme_clean_head() {
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
}
add_action( 'init', 'my_theme_clean_head' );

/* Responsive embed + social share CSS */
function my_theme_extra_css() { ?>
    <style>
    .responsive-embed{position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:var(--radius-lg);margin:var(--space-6) 0}
    .responsive-embed iframe,.responsive-embed object,.responsive-embed embed{position:absolute;top:0;left:0;width:100%;height:100%}
    .social-share{display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;margin-top:1.5rem}
    .social-share__label{font-size:.875rem;font-weight:600;color:var(--color-text-muted)}
    .social-share__btn{display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:50%;background:var(--share-color,var(--color-primary));color:#fff;font-size:.875rem;transition:transform .2s ease,box-shadow .2s ease;text-decoration:none}
    .social-share__btn:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,.2);color:#fff}
    .breadcrumbs{display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:rgba(255,255,255,.7);flex-wrap:wrap;margin-top:.75rem}
    .breadcrumbs a{color:rgba(255,255,255,.85)}.breadcrumbs a:hover{color:#fff}.breadcrumb-sep{opacity:.5}
    .post-navigation{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:2rem}
    .post-navigation .nav-previous,.post-navigation .nav-next{padding:1.25rem;border:1px solid var(--color-border);border-radius:var(--radius-lg);transition:all .25s ease}
    .post-navigation .nav-previous:hover,.post-navigation .nav-next:hover{border-color:var(--color-primary);box-shadow:var(--shadow-md)}
    .post-navigation .nav-next{text-align:right}
    .nav-direction{display:block;font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;color:var(--color-primary);font-weight:600;margin-bottom:.25rem}
    .nav-title{display:block;font-weight:600;color:var(--color-text);font-size:.9rem;line-height:1.4}
    @media(max-width:640px){.post-navigation{grid-template-columns:1fr}.post-navigation .nav-next{text-align:left}}
    </style>
<?php }
add_action( 'wp_head', 'my_theme_extra_css' );

/* Custom search form */
function my_theme_search_form( $form ) {
    return '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
        <label class="screen-reader-text" for="s">' . esc_html__( 'Search for:', 'my-theme' ) . '</label>
        <input type="search" id="s" class="form-control search-field"
               placeholder="' . esc_attr__( 'Search&hellip;', 'my-theme' ) . '"
               value="' . get_search_query() . '" name="s">
        <button type="submit" class="search-submit">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            <span class="screen-reader-text">' . esc_html__( 'Search', 'my-theme' ) . '</span>
        </button>
    </form>';
}
add_filter( 'get_search_form', 'my_theme_search_form' );

/* Add active class to current menu items */
function my_theme_nav_menu_css_class( $classes, $item ) {
    if ( in_array( 'current-menu-item', $classes, true ) ) $classes[] = 'active';
    return $classes;
}
add_filter( 'nav_menu_css_class', 'my_theme_nav_menu_css_class', 10, 2 );

/* Image alt fallback */
function my_theme_image_alt_fallback( $attr, $attachment ) {
    if ( empty( $attr['alt'] ) ) $attr['alt'] = esc_attr( get_the_title( $attachment->ID ) );
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'my_theme_image_alt_fallback', 10, 2 );

/* Defer non-critical scripts */
function my_theme_script_loader_tag( $tag, $handle, $src ) {
    if ( in_array( $handle, array( 'my-theme-main', 'my-theme-navigation' ), true ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'my_theme_script_loader_tag', 10, 3 );

/* Excerpt strip shortcodes */
add_filter( 'the_excerpt', 'shortcode_unautop' );
add_filter( 'the_excerpt', 'do_shortcode' );
