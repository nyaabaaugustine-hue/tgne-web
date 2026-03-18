<?php 
/*
 *=================================
 * Layouts
 * @package Creote WordPress Theme
 *==================================
*/
/*
=========================
sticky  header
========================
*/
if(!function_exists('creote_header_sticky')):
    /**
     * Check ifcurrent page has page header
     * @return bool
    **/
    function creote_header_sticky(){
    global $creote_theme_mod;
    $header_sticky = '';
    if(!empty($creote_theme_mod['sticky_header_enable'])){
        $header_sticky = $creote_theme_mod['sticky_header_enable'];
    }
    if((is_page()  || is_singular(array('project' , 'service' , 'post' , 'product'))) && get_post_meta(get_the_ID() , 'custom_sticky_enable', true)){
        return false;
    }
     
    return   $header_sticky;
}
endif;
/*
=========================
Display page header
========================
*/
if(!function_exists('creote_has_page_header')):
    /**
     * Check ifcurrent page has page header
     * @return bool
    **/
    function creote_has_page_header(){
    global $creote_theme_mod;
    $pgheaderone = '';
    if(!empty($creote_theme_mod['page_header_enable'])){
        $pgheaderone = $creote_theme_mod['page_header_enable'];
    }
    if((is_page()  || is_singular(array('project' , 'service' , 'post' , 'product'))) && get_post_meta(get_the_ID() , 'page_header_enable_disable', true)){
        return false;
    }
    elseif(is_singular('mega-menu')){
        return false;
    }
    elseif(is_singular('header')){
        return false;
    }
    elseif(is_singular('footer')){
        return false;
    }
    elseif(is_page_template('template-homepage.php')){
        return false;
    }
    elseif(is_page_template('template-blog.php')){
        return false;
    }
    elseif(is_page_template('template-full-empty.php')){
        return false;
    }
    elseif(is_attachment()){
        return false;
    }
    return   $pgheaderone;
}
endif;

if(!function_exists('creote_get_page_header_image')):
    /**
     *Get page header image URL
     * @return string
    **/
    function creote_get_page_header_image(){    
    global $creote_theme_mod;
    if(!creote_has_page_header()){
        return '';
    }
    if(is_page() || is_singular(array('post','project' ,'product','service'))){
        $image = get_post_meta(get_the_ID() , 'page_header_bgimage', true);
        $image = $image ? wp_get_attachment_image_src($image, 'full') : wp_get_attachment_image_url(get_the_ID() , 'full');
        $image = $image ? $image[0] : $creote_theme_mod['default_page_header_image']['url'];
    }
    else{
        $image = $creote_theme_mod['default_page_header_image']['url'];
    }
    return $image;
}
endif;

/*
============================
creote_get_layout and column
===========================
*/
if(!function_exists('creote_get_layout')):
   function creote_get_layout(){
       global $creote_theme_mod;
       $creote_layout = '';
       if(!empty($creote_theme_mod['layout_default'])){
        $creote_layout = $creote_theme_mod['layout_default'];
       }
       $creote_layout_page  = '';
       if(!empty($creote_theme_mod['layout_page'])){
        $creote_layout_page = $creote_theme_mod['layout_page'];
       }
       $creote_layout_service = '';
       if(!empty($creote_theme_mod['layout_service'])){
       $creote_layout_service = $creote_theme_mod['layout_service'];
       }
       $creote_layout_shop = '';
        if(!empty($creote_theme_mod['layout_shop'])){
            $creote_layout_shop = $creote_theme_mod['layout_shop'];
        }
        if(is_singular() && get_post_meta(get_the_ID() , 'custom_layout', true)){
           $creote_layout = get_post_meta(get_the_ID() , 'layout', true);
        }
        elseif(is_page()){
           $creote_layout =  $creote_layout_page;
        }
        elseif(is_404()){
           $creote_layout = 'no-sidebar';
        }
        elseif(is_search()){
            $creote_layout = 'no-sidebar';
         }
        elseif(is_singular('job_listing')){
            $creote_layout = 'no-sidebar';
         }
        elseif(is_singular('service')){
           $creote_layout =  $creote_layout_service;
        }
        elseif(is_post_type_archive('product') || is_tax('product_cat')  || is_singular('product')){
           $creote_layout =  $creote_layout_shop;
        }
       return $creote_layout;
}
endif;

if(!function_exists('creote_get_content_columns')):
    /**
    * Get  content columns
    * @param string $layout
    * @return array
    **/
   function creote_get_content_columns($creote_layout = null){
       $creote_layout = $creote_layout ? $creote_layout : creote_get_layout();
       if('no-sidebar' == $creote_layout){
           echo esc_html('no_column' , 'creote');
       }
       else{
           echo esc_html('col-lg-8 col-md-12 col-sm-12 col-xs-12', 'creote' );
       }  
   }
endif;
/*
============================
Creote column for Page
===========================
*/
if(!function_exists('creote_column_for_page')):
    function creote_column_for_page(){
        if(is_active_sidebar('page-sidebar')){
            creote_get_content_columns();
        }
        elseif(!is_active_sidebar('page-sidebar') ){
            echo esc_html('col-lg-12 no_sidebar', 'creote');
        }
    }
endif;
/*
============================
Creote column for Service
===========================
*/
if(!function_exists('creote_column_for_service')):
    function creote_column_for_service(){
        if(is_active_sidebar('service-sidebar')){
            creote_get_content_columns();
        }
        elseif(!is_active_sidebar('service-sidebar') ){
            echo esc_html('col-lg-12 no_sidebar', 'creote');
        }
    }
endif;
/*
============================
Creote column for Blog
===========================
*/
if(!function_exists('creote_column_for_blog')):
    function creote_column_for_blog(){
        if(is_active_sidebar('sidebar-blog')){
            creote_get_content_columns();
        }
        elseif(!is_active_sidebar('sidebar-blog')){
            echo esc_html('no_column', 'creote');
        }
    }
endif;  
/*
============================
Creote column for shop
===========================
*/
if(!function_exists('creote_column_for_shop')):
    function creote_column_for_shop(){
        if(is_active_sidebar('shop-sidebar')){
            creote_get_content_columns();
        }
        elseif(!is_active_sidebar('shop-sidebar')){
            echo esc_html('col-lg-12 no_sidebar', 'creote');
        }
    }
endif;
