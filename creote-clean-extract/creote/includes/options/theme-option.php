<?php
/*
 *=================================
 * Theme Options
 * Contains Redux Option Output
 * @package Creote WordPress Theme
 *==================================
*/
/*--------------------------Enqueues front-end CSS for theme customization-----------------*/
add_action('wp_enqueue_scripts', 'creote_customize_css' );
function creote_customize_css(){
global $creote_theme_mod;
$customize_css = '';
$theme_color_one_css = '';
$theme_color_two_css = '';
$theme_color_three_css = '';
$heading_color_css = '';
$description_color_css  = '';
$description_light_css = '';
$border_color_css  = '';
$menu_color_css = '';
$menu_active_color_css = '';
$preloader_css  = '';
if(!empty($creote_theme_mod['theme_setttings_enable']) == true):
/*--=========Theme Color Settings============--*/
    $theme_color_one = '';
    if(!empty($creote_theme_mod['theme_color_one'])):
    $theme_color_one = $creote_theme_mod['theme_color_one'];
    endif;
    $theme_color_one_css = $theme_color_one;
    if(!empty($theme_color_one_css)){

        $customize_css .= ':root   {--primary-color-one:' . $theme_color_one_css . '!important}';
    } 


    $theme_color_two = '';
    if(!empty($creote_theme_mod['theme_color_two'])):
    $theme_color_two = $creote_theme_mod['theme_color_two'];
    endif;
    $theme_color_two_css = $theme_color_two;
    if(!empty($theme_color_two_css)){

        $customize_css .= ':root   {--primary-color-two:' . $theme_color_two_css . '!important; --footer-default-bgcolor:' . $theme_color_two_css . '!important}';
    } 



    $theme_color_three = '';
    if(!empty($creote_theme_mod['theme_color_three'])):
    $theme_color_three = $creote_theme_mod['theme_color_three'];
    endif;
    $theme_color_three_css = $theme_color_three;
    if(!empty($theme_color_three_css)){

        $customize_css .= ':root   {--primary-color-three:' . $theme_color_three_css . '!important}';
    } 



    $heading_color = '';
    if(!empty($creote_theme_mod['heading_color'])):
    $heading_color = $creote_theme_mod['heading_color'];
    endif;
    $heading_color_css = $heading_color;
    if(!empty($heading_color_css)){

        $customize_css .= ':root   {--heading-dark:' . $heading_color_css . '!important}';
    } 

    $description_color = '';
    if(!empty($creote_theme_mod['description_color'])):
    $description_color = $creote_theme_mod['description_color'];
    endif;
    $description_color_css = $description_color;
    if(!empty($description_color_css)){

        $customize_css .= ':root   {--text-color-dark:' . $description_color_css . '!important}';
    } 


    $description_light = '';
    if(!empty($creote_theme_mod['description_light'])):
    $description_light = $creote_theme_mod['description_light'];
    endif;
    $description_light_css = $description_light;
    if(!empty($description_light_css)){

        $customize_css .= ':root   {--text-color-light:' . $description_light_css . '!important}';
    } 


    $border_color = '';
    if(!empty($creote_theme_mod['border_color'])):
    $border_color = $creote_theme_mod['border_color'];
    endif;
    $border_color_css = $border_color;
    if(!empty($border_color_css)){

        $customize_css .= ':root   {--border-color-dark:' . $border_color_css . '!important}';
    } 


    $menu_color = '';
    if(!empty($creote_theme_mod['menu_color'])):
    $menu_color = $creote_theme_mod['menu_color'];
    endif;
    $menu_color_css = $menu_color;
    if(!empty($menu_color_css)){

        $customize_css .= ':root   {--menu-color:' . $menu_color_css . '!important}';
    } 


    $menu_active_color = '';
    if(!empty($creote_theme_mod['menu_active_color'])):
    $menu_active_color = $creote_theme_mod['menu_active_color'];
    endif;
    $menu_active_color_css = $menu_active_color;
    if(!empty($menu_active_color_css)){

        $customize_css .= ':root   {--menu-active-color:' . $menu_active_color_css . '!important}';
    } 


    

endif;


/*--=========page header color============--*/
$page_header_bg = '';
if(!empty($creote_theme_mod['page_header_bg'])){
    $page_header_bg = $creote_theme_mod['page_header_bg'];
}
$page_header_bg_custom  = $page_header_bg;
if(get_post_meta(get_the_ID() , 'page_header_bgcolor', true)){
    $page_header_bg_custom = get_post_meta(get_the_ID() , 'page_header_bgcolor', true);
}
$page_header_bg_css = $page_header_bg_custom ? 'background-color:' . $page_header_bg_custom . '!important; ' : '';
if(!empty($page_header_bg_css)){
    $customize_css .= ' .page_header_default::before {' . $page_header_bg_css . '}';
}
    
/*--=========preloader============--*/

/*--=========Theme Color Settings============--*/
/*--=========preloader============--*/
$preloader = '';
if(!empty($creote_theme_mod['pre_loader_background'])){
    $preloader = $creote_theme_mod['pre_loader_background'];
}
$preloader_custom  = $preloader;
if(get_post_meta(get_the_ID() , 'preloader_custom_enable', true)){
    $preloader_custom = get_post_meta(get_the_ID() , 'preloader_bgcolor', true);
}

$preloader_css = $preloader_custom ? 'background-color:' . $preloader_custom . '!important; ' : '';
if(!empty($preloader_css)){
    $customize_css .= ' .loader-wrap .layer {' . $preloader_css . '!important}';
}
    
/*--=========preloader============--*/

/*--=========mobile_logo_width ============--*/
$mobile_logo_width = '';
$mobile_logo_width_css = '';
if(!empty($creote_theme_mod['mobile_logo_width']['width'])){
    $mobile_logo_width = $creote_theme_mod['mobile_logo_width']['width'];
}

$mobile_logo_width_css = $mobile_logo_width ? 'width:' . $mobile_logo_width . '!important; ' : '';
if(!empty($mobile_logo_width_css)){
    $customize_css .= ' .mobile_logo .logo_box img {' . $mobile_logo_width_css . ' }';
}


$sticky_logo_width = '';
$sticky_logo_widthcss = '';
if(!empty($creote_theme_mod['sticky_logo_width']['width'])){
    $sticky_logo_width = $creote_theme_mod['sticky_logo_width']['width'];
}

$sticky_logo_widthcss = $sticky_logo_width ? 'width:' . $sticky_logo_width . '!important; ' : '';
if(!empty($sticky_logo_widthcss)){
    $customize_css .= ' .sticky_header_main .header_logo_box img {' . $sticky_logo_widthcss . '}';
}


$sticky_logo_move_top = '';
$sticky_logo_move_topcss = '';
if(!empty($creote_theme_mod['sticky_logo_move_top'])){
    $sticky_logo_move_top = $creote_theme_mod['sticky_logo_move_top'];
}

$sticky_logo_move_topcss = $sticky_logo_move_top ? 'margin-top:' . $sticky_logo_move_top . '!important; ' : '';
if(!empty($sticky_logo_move_topcss)){
    $customize_css .= ' .sticky_header_main .header_logo_box img {' . $sticky_logo_move_topcss . '}';
}

$sticky_logo_move_left = '';
$sticky_logo_move_leftcss = '';
if(!empty($creote_theme_mod['sticky_logo_move_left'])){
    $sticky_logo_move_left = $creote_theme_mod['sticky_logo_move_left'];
}

$sticky_logo_move_leftcss = $sticky_logo_move_left ? 'margin-left:' . $sticky_logo_move_left . '!important; ' : '';
if(!empty($sticky_logo_move_leftcss)){
    $customize_css .= ' .sticky_header_main .header_logo_box img {' . $sticky_logo_move_leftcss . '}';
}
    
    
    
/*--=========preloader============--*/




/*--=========page header padding============--*/
if(get_post_meta(get_the_ID() , 'page_header_padding_enable', true)){
 
        $customize_css .= '@media(min-width:1200px) { .page_header_default.style_one   ,
            .page_header_default.style_one.blog_single_pageheader  .page_header_content   {padding:' . get_post_meta(get_the_ID() , 'padding_for_page_header', true) . '!important; min-height:unset!important;}}';
        $customize_css .= '@media(max-width:1200px) { .page_header_default.style_one   ,
            .page_header_default.style_one.blog_single_pageheader  .page_header_content  {padding:' . get_post_meta(get_the_ID() , 'padding_for_page_header_mb', true) . '!important; min-height:unset!important;}}';
    
     
} 
if(!empty($creote_theme_mod['page_header_css_enable']) == true):
$page_header_padding_css = '';
$page_header_mb_padding_css = '';
$page_header_padding_css = '';
$page_header_mb_padding_css = '';
if(!empty($creote_theme_mod['page_header_padding'])):
$page_header_padding_top = $creote_theme_mod['page_header_padding']['padding-top'];
$page_header_padding_right = $creote_theme_mod['page_header_padding']['padding-right'];
$page_header_padding_bottom = $creote_theme_mod['page_header_padding']['padding-bottom'];
$page_header_padding_left = $creote_theme_mod['page_header_padding']['padding-left'];
$page_header_padding_css .= $page_header_padding_top ? 'padding-top:' . $page_header_padding_top . '!important; ' : '';
$page_header_padding_css .= $page_header_padding_right ? 'padding-right:' . $page_header_padding_right . '!important; ' : '';
$page_header_padding_css .= $page_header_padding_bottom ? 'padding-bottom:' . $page_header_padding_bottom . '!important; ' : '';
$page_header_padding_css .= $page_header_padding_left ? 'padding-left:' . $page_header_padding_left . '!important; ' : '';
$page_header_padding_mb_css = $page_header_padding_css;
if(!empty($page_header_padding_mb_css)){
    $customize_css .= '@media(min-width:1200px) { .page_header_default.style_one  ,
        .page_header_default.style_one.blog_single_pageheader  .page_header_content   {' . $page_header_padding_mb_css . ' min-height:unset!important;}}';
}

endif;
if(!empty($creote_theme_mod['page_header_padding_mb'])):
$page_header_mb_padding_top = $creote_theme_mod['page_header_padding_mb']['padding-top'];
$page_header_mb_padding_right = $creote_theme_mod['page_header_padding_mb']['padding-right'];
$page_header_mb_padding_bottom = $creote_theme_mod['page_header_padding_mb']['padding-bottom'];
$page_header_mb_padding_left = $creote_theme_mod['page_header_padding_mb']['padding-left'];
$page_header_mb_padding_css .= $page_header_mb_padding_top ? 'padding-top:' . $page_header_mb_padding_top . '!important; ' : '';
$page_header_mb_padding_css .= $page_header_mb_padding_right ? 'padding-right:' . $page_header_mb_padding_right . '!important; ' : '';
$page_header_mb_padding_css .= $page_header_mb_padding_bottom ? 'padding-bottom:' . $page_header_mb_padding_bottom . '!important; ' : '';
$page_header_mb_padding_css .= $page_header_mb_padding_left ? 'padding-left:' . $page_header_mb_padding_left . '!important; ' : '';
$page_header_padding_mb_css_two = $page_header_mb_padding_css;
if(!empty($page_header_padding_mb_css_two)){
    $customize_css .= '@media(max-width:1200px) { .page_header_default.style_one  ,
        .page_header_default.style_one.blog_single_pageheader  .page_header_content   {' . $page_header_padding_mb_css_two . ' min-height:unset!important;}}';
}
endif; 
endif;



  

/*--=========page header padding============--*/


/*--=========body padding============--*/
if(get_post_meta(get_the_ID() , 'body_padding_enable', true)){ 
    $customize_css .= '@media(min-width:1200px) { body   {padding:' . get_post_meta(get_the_ID() , 'padding_for_body', true) . '!important}}';
     $customize_css .= '@media(max-width:1200px) { body   {padding:' . get_post_meta(get_the_ID() , 'padding_for_body_mb', true) . '!important}}';
} 
if(!empty($creote_theme_mod['body_css_enable']) == true):
$body_padding_totals_pd_css = '';
$body_padding_total_mb_css = '';
$body_padding_totals_css = '';
$body_padding_total_mb_css = '';
if(!empty($creote_theme_mod['body_padding_totals'])):
    $body_padding_totals = $creote_theme_mod['body_padding_totals'];

$body_padding_top = $creote_theme_mod['body_padding_totals']['padding-top'];
$body_padding_right = $creote_theme_mod['body_padding_totals']['padding-right'];
$body_padding_bottom = $creote_theme_mod['body_padding_totals']['padding-bottom'];
$body_padding_left = $creote_theme_mod['body_padding_totals']['padding-left'];
$body_padding_totals_css .= $body_padding_top ? 'padding-top:' . $body_padding_top . '!important; ' : '';
$body_padding_totals_css .= $body_padding_right ? 'padding-right:' . $body_padding_right . '!important; ' : '';
$body_padding_totals_css .= $body_padding_bottom ? 'padding-bottom:' . $body_padding_bottom . '!important; ' : '';
$body_padding_totals_css .= $body_padding_left ? 'padding-left:' . $body_padding_left . '!important; ' : '';

endif;
if(!empty($creote_theme_mod['body_padding_total_mbss'])):
$body_padding_total_mbss = $creote_theme_mod['body_padding_total_mbss'];
$body_mb_padding_top = $creote_theme_mod['body_padding_total_mbss']['padding-top'];
$body_mb_padding_right = $creote_theme_mod['body_padding_total_mbss']['padding-right'];
$body_mb_padding_bottom = $creote_theme_mod['body_padding_total_mbss']['padding-bottom'];
$body_mb_padding_left = $creote_theme_mod['body_padding_total_mbss']['padding-left'];
$body_padding_total_mb_css .= $body_mb_padding_top ? 'padding-top:' . $body_mb_padding_top . '!important; ' : '';
$body_padding_total_mb_css .= $body_mb_padding_right ? 'padding-right:' . $body_mb_padding_right . '!important; ' : '';
$body_padding_total_mb_css .= $body_mb_padding_bottom ? 'padding-bottom:' . $body_mb_padding_bottom . '!important; ' : '';
$body_padding_total_mb_css .= $body_mb_padding_left ? 'padding-left:' . $body_mb_padding_left . '!important; ' : '';
endif;
$body_padding_totals_pd_css = $body_padding_totals_css;
$body_padding_total_mbs_css = $body_padding_total_mb_css;
if(!empty($body_padding_totals_pd_css)){
    $customize_css .= '@media(min-width:1200px) { body   {' . $body_padding_totals_pd_css . '}}';
}
if(!empty($body_padding_total_mbs_css)){
    $customize_css .= '@media(max-width:1200px) { body   {' . $body_padding_total_mbs_css . '}}';
}
endif;

 
/*--=========body padding============--*/


wp_add_inline_style('creote-theme', $customize_css);
}



