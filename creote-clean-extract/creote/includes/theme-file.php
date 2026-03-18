<?php
/*
==========================================
Meta Box Css File
==========================================
*/

function creote_safe_require($path) {
    if (is_string($path) && is_readable($path)) {
        require_once $path;
    }
}
require_once get_template_directory() . '/includes/WP_Bootstrap_Navwalker.php';
creote_safe_require(get_template_directory() . '/includes/WP_Bootstrap_Navwalker.php');

function creote_cat_meta_postbox_css(){
	wp_enqueue_style('meta-box-css', get_template_directory_uri().'/assets/css/metabox.css' );    
  }
add_action('admin_enqueue_scripts', 'creote_cat_meta_postbox_css');
/*
==========================================
Theme Support
==========================================
*/
 

function creote_load_textdomain() {
    load_theme_textdomain('creote', get_template_directory() . '/lang');
}
add_action('after_setup_theme', 'creote_load_textdomain');

function creote_setup(){
if(!isset($content_width))
$content_width = 840;
/*---------- Make theme available for translation-----------*/

/*----------Add Theme Support-----------*/
add_theme_support('post-thumbnails');
add_theme_support('html5', array(
    'search-form'
));
add_theme_support('title-tag');
add_theme_support('post_format', ['aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat']);
add_theme_support('automatic-feed-links');
/*----------woocommerce Theme Support-----------*/ 
add_theme_support( 'woocommerce');
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
/*----------editor-style-----------*/
add_editor_style('assets/css/editor-style.css');
/*----------register_nav_menus-----------*/
register_nav_menus(array(
     'primary' => esc_html__('Primary Menu (For Sticky Header And Mobile Header)', 'creote') ,
));
}
add_action('after_setup_theme', 'creote_setup');

/*
==========================================
Register widgetized area and update sidebar with default widgets.
==========================================
*/
function creote_register_sidebar(){
    $sidebars = array(
        'sidebar-blog' => esc_html__('Blog Sidebar', 'creote') ,
        'page-sidebar' => esc_html__('Page Sidebar', 'creote') ,
        'shop-sidebar' => esc_html__('Shop Sidebar', 'creote') ,
        'service-sidebar' => esc_html__('Service Sidebar', 'creote') ,
    );
    // Register sidebars
    foreach ($sidebars as $id => $name)
    {
        register_sidebar(
        array(
            'name' => $name,
            'id' => $id,
            'description' => esc_html__('Add widgets here in order to display on pages', 'creote') ,
            'before_widget' => '<div class="widgets_grid_box"><div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div> </div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    }
}

add_action('widgets_init', 'creote_register_sidebar');
 

/*
==========================================
 Required Files
==========================================
*/

//require_once get_template_directory() . "/includes/admin/dashboard/pluigns/class-tgm-plugin-activation.php";
//require_once get_template_directory() . "/includes/admin/dashboard/pluigns/list-plugins.php";
//require_once get_template_directory() . '/includes/admin/dashboard/class-dashboard.php';

creote_safe_require(get_template_directory() . '/includes/dashboard/Setup.php');


//require_once get_template_directory() . '/demo-import/class-merlin.php';
//require_once get_template_directory() . '/demo-import/merlin-config.php';
//require_once get_template_directory() . '/demo-import/merlin-filters.php';
/*------includes > Options---------------*/
if(class_exists('RW_Meta_Box')){
    creote_safe_require(get_template_directory() . '/includes/options/metabox.php');
}
/*----includes > custom-menu-option--------*/
creote_safe_require(get_template_directory() . '/includes/custom-menu-option.php');
/*------ includes > common---------------*/
creote_safe_require(get_template_directory() . '/includes/common/functions/header-source.php');
creote_safe_require(get_template_directory() . '/includes/common/functions/layout.php');
creote_safe_require(get_template_directory() . '/includes/common/functions/classes.php');
creote_safe_require(get_template_directory() . '/includes/common/functions/meta.php');
creote_safe_require(get_template_directory() . '/includes/common/lib/breadcrumbs.php');
/*------ templateparts > header---------------*/
creote_safe_require(get_template_directory() . '/template-parts/headers/header-content.php');
creote_safe_require(get_template_directory() . '/template-parts/headers/sticky-header.php');
creote_safe_require(get_template_directory() . '/template-parts/headers/mobile-menu.php');
/*------ templateparts > pageheader---------------*/
creote_safe_require(get_template_directory() . '/template-parts/page-header/default-page-header.php');
/*------ Redux---------------*/
if(class_exists('Redux')){
    creote_safe_require(get_template_directory() . '/template-parts/page-header/page-header.php');
    creote_safe_require(get_template_directory() . '/template-parts/page-header/blog-pageheader.php');
    creote_safe_require(get_template_directory() . '/includes/options/theme-option.php');
    creote_safe_require(get_template_directory() . '/includes/options/typography-css.php');
    creote_safe_require(get_template_directory() . '/includes/options/config.php');
}
/*------includes > functions---------------*/
creote_safe_require(get_template_directory() . '/includes/lib/functions/comments.php');
//require_once get_template_directory() . '/includes/lib/functions/authour-and-tags.php';
creote_safe_require(get_template_directory() . '/includes/lib/functions/nav.php');
/*------includes > libs---------------*/
creote_safe_require(get_template_directory() . '/template-parts/related-posts.php');
creote_safe_require(get_template_directory() . '/includes/custom/color-switcher.php');
creote_safe_require(get_template_directory() . '/includes/custom/side-menu-btn.php');
creote_safe_require(get_template_directory() . '/includes/custom/side-menu.php'); 
 
// woocommerce
if(class_exists('woocommerce')){
    creote_safe_require(get_template_directory() . '/includes/lib/woocom/action.php');
    creote_safe_require(get_template_directory() . '/includes/lib/woocom/min-cart.php');
    creote_safe_require(get_template_directory() . '/includes/quick-view-template.php');
 
}
function ifnotactivated() {
    return true;
}  
// wpbakery
/*add_action( 'vc_before_init', 'creote_vc_remove_css' );
function creote_vc_remove_css() {
    vc_remove_param('vc_row', 'css');
}*/ 

$isActivated = true;

function sanitize_checkbox($input) {
    return ($input == true) ? true : false;
}

function sanitize_textarea($input) {
    return sanitize_text_field($input);
}

function sanitize_custom_image($input) {
    // Sanitize the image URL using esc_url or any custom logic you need
    return esc_url($input);
}

function custom_theme_customize_register($wp_customize) {
    // Add a section
    $wp_customize->add_section('custom_theme_section', array(
        'title' => 'Staging Site',
        'priority' => 30,
    ));

    // Add the checkbox control
    $wp_customize->add_setting('enable_custom_feature', array(
        'default' => false,
        'sanitize_callback' => 'sanitize_checkbox',
    ));

    $wp_customize->add_control('enable_custom_feature', array(
        'label' => 'Staging Site Enable / Disable',
        'section' => 'custom_theme_section',
        'type' => 'checkbox',
    ));

    // Add image control with sanitize_callback
    $wp_customize->add_setting('custom_image_setting', array(
        'sanitize_callback' => 'sanitize_custom_image',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'custom_image_setting',
        array(
            'label' => 'Maintenance Background Image',
            'section' => 'custom_theme_section',
            'settings' => 'custom_image_setting',
        )
    ));

    // Add text controls with sanitization
    $wp_customize->add_setting('custom_text_setting_two', array(
        'sanitize_callback' => 'sanitize_textarea',
    ));
    $wp_customize->add_control('custom_text_setting_two', array(
        'label' => 'Title',
        'section' => 'custom_theme_section',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('custom_text_setting', array(
        'sanitize_callback' => 'sanitize_textarea',
    ));
    $wp_customize->add_control('custom_text_setting', array(
        'label' => 'Content',
        'section' => 'custom_theme_section',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'custom_theme_customize_register');
