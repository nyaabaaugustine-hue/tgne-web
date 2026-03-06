<?php
/*
 *=================================
 * Theme Classes 
 * @package Creote WordPress Theme
 *==================================
*/
function creote_body_classes($classes){
    global $post;
    global $creote_theme_mod;
    $creotertlenableclsss = '';
    // Add a class of layout
    $classes[] = creote_get_layout();
    $classes[] = 'scrollbarcolor';
    // Adds a class of group-blog to blogs with more than 1 published author.
    if( !class_exists( 'Redux' ) ) {
        $classes[] = 'right-sidebar no_redux';
    }
    if(class_exists('woocommerce')){
        $classes[] = 'woocommerce_plugin_on';
    }
    if (is_multi_author())
    {
        $classes[] = 'group-blog';
    }
    if (is_singular('page'))
    {
        $classes[] = 'page-' . $post->post_name;
    }
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular())
    {
        $classes[] = 'hfeed';
    }

    if(!empty($creote_theme_mod['rtl_enable_all'])){
      $creotertlenableclsss = $creote_theme_mod['rtl_enable_all'];
      }
      if ((get_post_meta(get_the_ID() , 'rtl_enable_disable', true)) || ($creotertlenableclsss == true)){
        $classes[] = 'rtl_enable';
    }
    // header style
    if(!empty($creote_theme_mod['header_style'])){
        $classes[] =  esc_html('header_custom_style_for_all' , 'creote');
    }
    if(get_post_meta(get_the_ID() , 'custom_header', true)){
        $classes[] =  esc_html('header_custom_style_for_page' , 'creote');
    }
 
    $classes[] =  creote_footer_sticky_for_body_class();

    return $classes;
}
add_filter('body_class', 'creote_body_classes');


