<?php
/**
 * MyTheme functions and definitions
 *
 * @package    MyTheme
 * @version    1.0.0
 * @author     Your Name
 * @license    GPL-2.0-or-later
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* =========================================================
   CONSTANTS
   ========================================================= */

define( 'MY_THEME_VERSION', '1.0.0' );
define( 'MY_THEME_DIR', get_template_directory() );
define( 'MY_THEME_URI', get_template_directory_uri() );
define( 'MY_THEME_TEXT_DOMAIN', 'tgne-tema' );
define( 'MY_THEME_DEV_URL', 'https://cybertechgh.netlify.app' );

/* =========================================================
   1. THEME SETUP
   ========================================================= */

if ( ! function_exists( 'tgne_setup' ) ) :
    function tgne_setup() {

        load_theme_textdomain( 'tgne-tema', MY_THEME_DIR . '/languages' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );

        add_image_size( 'my-theme-card',      780, 440, true );
        add_image_size( 'my-theme-hero',     1440, 600, true );
        add_image_size( 'my-theme-portrait',  600, 800, true );
        add_image_size( 'my-theme-square',    600, 600, true );

        register_nav_menus(
            array(
                'primary' => esc_html__( 'Primary Menu',  MY_THEME_TEXT_DOMAIN ),
                'footer'  => esc_html__( 'Footer Menu',   MY_THEME_TEXT_DOMAIN ),
                'social'  => esc_html__( 'Social Links',  MY_THEME_TEXT_DOMAIN ),
            )
        );

        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
        add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio' ) );
        add_theme_support( 'custom-background', array( 'default-color' => 'ffffff' ) );

        add_theme_support( 'custom-logo', array(
            'height'               => 80,
            'width'                => 200,
            'flex-height'          => true,
            'flex-width'           => true,
            'header-text'          => array( 'site-title', 'site-description' ),
            'unlink-homepage-logo' => false,
        ) );

        add_theme_support( 'custom-header', array(
            'default-image'      => '',
            'default-text-color' => '000000',
            'width'              => 1440,
            'height'             => 600,
            'flex-height'        => true,
            'flex-width'         => true,
        ) );

        add_theme_support( 'customize-selective-refresh-widgets' );
        add_theme_support( 'align-wide' );
        remove_theme_support( 'core-block-patterns' );
        add_theme_support( 'editor-styles' );
        add_editor_style( 'assets/css/editor-style.css' );
        add_theme_support( 'responsive-embeds' );
    }
endif;
add_action( 'after_setup_theme', 'tgne_setup' );

/* =========================================================
   2. CONTENT WIDTH
   ========================================================= */

function my_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'my_theme_content_width', 1280 );
}
add_action( 'after_setup_theme', 'my_theme_content_width', 0 );

/* =========================================================
   3. ENQUEUE SCRIPTS & STYLES
   ========================================================= */

function my_theme_scripts() {

    wp_enqueue_style(
        'my-theme-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'my-theme-style',
        get_stylesheet_uri(),
        array( 'my-theme-google-fonts' ),
        MY_THEME_VERSION
    );

    wp_enqueue_style(
        'my-theme-font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(),
        '6.5.0'
    );

    wp_enqueue_script(
        'my-theme-navigation',
        MY_THEME_URI . '/assets/js/navigation.js',
        array(),
        MY_THEME_VERSION,
        true
    );

    wp_enqueue_script(
        'my-theme-main',
        MY_THEME_URI . '/assets/js/main.js',
        array( 'my-theme-navigation' ),
        MY_THEME_VERSION,
        true
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // TGNE Footer Widgets — map, floating WhatsApp, dark/light toggle
    wp_add_inline_style( 'my-theme-style', tgne_footer_widget_css() );
    wp_add_inline_script( 'my-theme-main', tgne_footer_widget_js() );

    // TGNE Elementor Page Fix — scoped isolation CSS so HTML widget pages
    // render identically to the standalone HTML source files (Fix v2.0).
    wp_enqueue_style(
        'tgne-elementor-fix',
        MY_THEME_URI . '/assets/css/elementor-page-fix.css',
        array( 'my-theme-style' ),
        MY_THEME_VERSION
    );

    wp_localize_script(
        'my-theme-main',
        'myThemeData',
        array(
            'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'my-theme-nonce' ),
            'siteUrl'  => get_site_url(),
            'themeUrl' => MY_THEME_URI,
            'i18n'     => array(
                'menuOpen'  => esc_html__( 'Open menu',  MY_THEME_TEXT_DOMAIN ),
                'menuClose' => esc_html__( 'Close menu', MY_THEME_TEXT_DOMAIN ),
            ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );

/* =========================================================
   3b. TGNE FOOTER WIDGET CSS & JS
   ========================================================= */

function tgne_footer_widget_css() {
    return '
#location{background:var(--sd,#061B33);padding:0;position:relative;z-index:1}
.map-wrapper{display:grid;grid-template-columns:1fr 1.2fr}
.map-info-col{padding:64px 6% 64px 5%;display:flex;flex-direction:column;justify-content:center;background:var(--sd,#061B33);position:relative;overflow:hidden}
.map-info-col::before{content:"";position:absolute;top:-60px;right:-60px;width:280px;height:280px;border-radius:50%;background:rgba(255,168,102,.05);pointer-events:none}
.map-iframe-col{position:relative;min-height:480px}
.map-iframe-col iframe{display:block;width:100%;height:100%;min-height:520px;border:0;filter:grayscale(10%) contrast(1.05)}
.map-item{display:flex;align-items:flex-start;gap:14px;margin-bottom:18px}
.map-item-ic{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;border:1px solid rgba(255,255,255,.12)}
.mi-orange{background:rgba(255,168,102,.15);border-color:rgba(255,168,102,.25)!important}
.mi-green{background:rgba(76,175,136,.15);border-color:rgba(76,175,136,.25)!important}
.mi-blue{background:rgba(44,127,184,.15);border-color:rgba(44,127,184,.25)!important}
.map-item-label{font-family:"Poppins",sans-serif;font-size:10.5px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:3px}
.lb-orange{color:#FFA866}.lb-green{color:#4CAF88}.lb-blue{color:#2C7FB8}
.map-item-val{font-size:14.5px;color:#D8E4F0;font-weight:500;line-height:1.55}
.map-badge{position:absolute;top:20px;left:20px;background:rgba(6,27,51,.92);backdrop-filter:blur(12px);border:1px solid rgba(255,168,102,.3);border-radius:12px;padding:10px 16px;display:flex;align-items:center;gap:10px;pointer-events:none}
.mb-dot{width:10px;height:10px;background:#4CAF88;border-radius:50%;animation:tgne-pulse 2s infinite;flex-shrink:0}
.mb-text{font-family:"Poppins",sans-serif;font-size:12px;font-weight:600;color:#D8E4F0}
@keyframes tgne-pulse{0%,100%{box-shadow:0 0 0 0 rgba(76,175,136,.4)}50%{box-shadow:0 0 0 6px rgba(76,175,136,0)}}
.floating-widgets-container{position:fixed;bottom:28px;left:20px;right:20px;z-index:3000;display:flex;justify-content:space-between;align-items:flex-end;pointer-events:none}
.float-btn,.theme-toggle{pointer-events:auto}
.float-btn{display:inline-flex;align-items:center;gap:10px;border:none;border-radius:50px;cursor:pointer;font-family:"Poppins",sans-serif;font-weight:700;font-size:13.5px;text-decoration:none;transition:all .3s cubic-bezier(.4,0,.2,1);padding:12px 18px 12px 14px;box-shadow:0 6px 24px rgba(0,0,0,.22)}
.float-wa{background:#25D366;color:white;animation:tgne-float-pop 3.5s ease-in-out infinite}
.float-wa:hover{background:#1ebe5a;transform:translateY(-3px) scale(1.04);box-shadow:0 10px 32px rgba(37,211,102,.45);color:white}
@keyframes tgne-float-pop{0%,100%{transform:translateY(0)}50%{transform:translateY(-5px)}}
.theme-toggle{width:48px;height:48px;background:#061B33;border:1px solid rgba(255,255,255,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .3s;box-shadow:0 6px 24px rgba(0,0,0,.22);position:relative}
.theme-toggle:hover{transform:translateY(-3px) scale(1.05);border-color:#FFA866}
.tt-icon{font-size:22px;position:absolute;transition:opacity .3s,transform .3s}
.tt-sun{opacity:1;transform:translateY(0)}
.tt-moon{opacity:0;transform:translateY(10px)}
body.tgne-dark .tt-sun{opacity:0;transform:translateY(-10px)}
body.tgne-dark .tt-moon{opacity:1;transform:translateY(0)}
body.tgne-dark .theme-toggle{background:#0A2B50;border-color:#2C7FB8}
@media(max-width:768px){
    .map-wrapper{grid-template-columns:1fr}
    .map-info-col{padding:48px 6%}
    .map-iframe-col iframe{min-height:300px}
    .float-btn span{display:none}
    .float-btn{padding:14px;width:52px;height:52px;justify-content:center}
    .floating-widgets-container{left:12px;right:12px;bottom:20px}
}
';
}

function tgne_footer_widget_js() {
    return '
(function(){
    "use strict";
    var btn=document.getElementById("tgne-theme-toggle");
    if(!btn)return;
    if(localStorage.getItem("tgne-theme")==="dark"){document.body.classList.add("tgne-dark");}
    btn.addEventListener("click",function(){
        var isDark=document.body.classList.toggle("tgne-dark");
        localStorage.setItem("tgne-theme",isDark?"dark":"light");
        btn.setAttribute("aria-pressed",isDark?"true":"false");
    });
}());
';
}

/* =========================================================
   4. WIDGET AREAS (SIDEBARS)
   ========================================================= */

function my_theme_widgets_init() {

    register_sidebar( array(
        'name'          => esc_html__( 'Blog Sidebar', MY_THEME_TEXT_DOMAIN ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in the blog sidebar.', MY_THEME_TEXT_DOMAIN ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 1', MY_THEME_TEXT_DOMAIN ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'First footer widget column.', MY_THEME_TEXT_DOMAIN ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 2', MY_THEME_TEXT_DOMAIN ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Second footer widget column.', MY_THEME_TEXT_DOMAIN ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 3', MY_THEME_TEXT_DOMAIN ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Third footer widget column.', MY_THEME_TEXT_DOMAIN ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'my_theme_widgets_init' );

/* =========================================================
   5. CUSTOM LOGO HELPER
   ========================================================= */

function my_theme_logo() {
    if ( has_custom_logo() ) {
        the_custom_logo();
    } else {
        echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="site-title" rel="home">' .
             esc_html( get_bloginfo( 'name' ) ) . '</a>';
    }
}

/* =========================================================
   6. EXCERPT
   ========================================================= */

function my_theme_excerpt_length( $length ) { return 25; }
add_filter( 'excerpt_length', 'my_theme_excerpt_length', 999 );

function my_theme_excerpt_more( $more ) { return '&hellip;'; }
add_filter( 'excerpt_more', 'my_theme_excerpt_more' );

/* =========================================================
   7. BODY CLASSES
   ========================================================= */

function my_theme_body_classes( $classes ) {
    if ( ! is_singular() ) { $classes[] = 'hfeed'; }
    if ( ! is_active_sidebar( 'sidebar-1' ) || is_page() ) { $classes[] = 'no-sidebar'; }
    return $classes;
}
add_filter( 'body_class', 'my_theme_body_classes' );

/* =========================================================
   8. PAGINATION
   ========================================================= */

function my_theme_pagination() {
    the_posts_pagination( array(
        'prev_text'          => '<i class="fa-solid fa-chevron-left"></i> ' . esc_html__( 'Prev', MY_THEME_TEXT_DOMAIN ),
        'next_text'          => esc_html__( 'Next', MY_THEME_TEXT_DOMAIN ) . ' <i class="fa-solid fa-chevron-right"></i>',
        'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page', MY_THEME_TEXT_DOMAIN ) . ' </span>',
    ) );
}

/* =========================================================
   9. CUSTOMIZER SETTINGS
   ========================================================= */

function my_theme_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'my_theme_contact', array(
        'title'    => esc_html__( 'Contact Info', MY_THEME_TEXT_DOMAIN ),
        'priority' => 120,
    ) );

    $wp_customize->add_setting( 'my_theme_phone', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'my_theme_phone', array( 'label' => esc_html__( 'Phone Number', MY_THEME_TEXT_DOMAIN ), 'section' => 'my_theme_contact', 'type' => 'text' ) );

    $wp_customize->add_setting( 'my_theme_email', array( 'default' => '', 'sanitize_callback' => 'sanitize_email' ) );
    $wp_customize->add_control( 'my_theme_email', array( 'label' => esc_html__( 'Email Address', MY_THEME_TEXT_DOMAIN ), 'section' => 'my_theme_contact', 'type' => 'email' ) );

    $wp_customize->add_setting( 'my_theme_address', array( 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ) );
    $wp_customize->add_control( 'my_theme_address', array( 'label' => esc_html__( 'Address', MY_THEME_TEXT_DOMAIN ), 'section' => 'my_theme_contact', 'type' => 'textarea' ) );

    $wp_customize->add_section( 'my_theme_social', array( 'title' => esc_html__( 'Social Media Links', MY_THEME_TEXT_DOMAIN ), 'priority' => 130 ) );

    foreach ( array( 'facebook' => 'Facebook URL', 'twitter' => 'Twitter / X URL', 'instagram' => 'Instagram URL', 'linkedin' => 'LinkedIn URL', 'youtube' => 'YouTube URL', 'tiktok' => 'TikTok URL' ) as $network => $label ) {
        $wp_customize->add_setting( 'my_theme_' . $network, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_control( 'my_theme_' . $network, array( 'label' => esc_html__( $label, MY_THEME_TEXT_DOMAIN ), 'section' => 'my_theme_social', 'type' => 'url' ) );
    }

    $wp_customize->add_section( 'my_theme_footer', array( 'title' => esc_html__( 'Footer Settings', MY_THEME_TEXT_DOMAIN ), 'priority' => 140 ) );
    $wp_customize->add_setting( 'my_theme_footer_text', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'my_theme_footer_text', array( 'label' => esc_html__( 'Footer Copyright Text', MY_THEME_TEXT_DOMAIN ), 'section' => 'my_theme_footer', 'type' => 'textarea' ) );
    $wp_customize->add_setting( 'my_theme_footer_desc', array( 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ) );
    $wp_customize->add_control( 'my_theme_footer_desc', array( 'label' => esc_html__( 'Footer Brand Description', MY_THEME_TEXT_DOMAIN ), 'section' => 'my_theme_footer', 'type' => 'textarea' ) );
}
add_action( 'customize_register', 'my_theme_customize_register' );

/* =========================================================
   10. SOCIAL LINKS HELPER
   ========================================================= */

function my_theme_get_social_links() {
    $networks = array(
        'facebook'  => array( 'label' => 'Facebook',  'icon' => 'fa-brands fa-facebook-f' ),
        'twitter'   => array( 'label' => 'Twitter',   'icon' => 'fa-brands fa-x-twitter'  ),
        'instagram' => array( 'label' => 'Instagram', 'icon' => 'fa-brands fa-instagram'  ),
        'linkedin'  => array( 'label' => 'LinkedIn',  'icon' => 'fa-brands fa-linkedin-in' ),
        'youtube'   => array( 'label' => 'YouTube',   'icon' => 'fa-brands fa-youtube'    ),
        'tiktok'    => array( 'label' => 'TikTok',    'icon' => 'fa-brands fa-tiktok'     ),
    );
    $active = array();
    foreach ( $networks as $key => $data ) {
        $url = get_theme_mod( 'my_theme_' . $key, '' );
        if ( ! empty( $url ) ) {
            $active[ $key ] = array_merge( $data, array( 'url' => esc_url( $url ) ) );
        }
    }
    return $active;
}

/* =========================================================
   11. META HELPERS
   ========================================================= */

function my_theme_post_meta( $args = array() ) {
    $args = wp_parse_args( $args, array( 'author' => true, 'date' => true, 'categories' => true, 'read_time' => true ) );
    $meta = array();
    if ( $args['author'] ) {
        $meta[] = sprintf( '<span class="meta-author"><i class="fa-regular fa-user"></i> %s</span>', esc_html( get_the_author() ) );
    }
    if ( $args['date'] ) {
        $meta[] = sprintf( '<time class="meta-date" datetime="%s"><i class="fa-regular fa-calendar"></i> %s</time>', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) );
    }
    if ( $args['categories'] ) {
        $cats = get_the_category_list( ' &bull; ' );
        if ( $cats ) { $meta[] = '<span class="meta-cats"><i class="fa-regular fa-folder"></i> ' . $cats . '</span>'; }
    }
    if ( $args['read_time'] ) {
        $wc = str_word_count( wp_strip_all_tags( get_the_content() ) );
        $rt = max( 1, ceil( $wc / 200 ) );
        $meta[] = sprintf( '<span class="meta-read-time"><i class="fa-regular fa-clock"></i> %d %s</span>', $rt, esc_html( _n( 'min read', 'min read', $rt, MY_THEME_TEXT_DOMAIN ) ) );
    }
    echo '<div class="entry-meta">' . implode( '<span class="sep">&bull;</span>', $meta ) . '</div>'; // phpcs:ignore
}

/* =========================================================
   12. SECURITY HARDENING
   ========================================================= */

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
add_filter( 'xmlrpc_enabled', '__return_false' );

function my_theme_failed_login() {
    return esc_html__( 'Login failed. Please try again.', MY_THEME_TEXT_DOMAIN );
}
add_filter( 'login_errors', 'my_theme_failed_login' );

/* =========================================================
   13. LOAD MODULAR INC FILES
   ========================================================= */

$inc_files = array(
    '/inc/tgne-header.php',        // TGNE branded header — fonts, CSS, JS, HTML, Elementor canvas fix
    '/inc/template-tags.php',      // Extra template functions
    '/inc/template-functions.php', // Additional hooks
    '/inc/customizer-extras.php',  // Customizer extras (optional)
);

foreach ( $inc_files as $file ) {
    if ( file_exists( MY_THEME_DIR . $file ) ) {
        require_once MY_THEME_DIR . $file;
    }
}
