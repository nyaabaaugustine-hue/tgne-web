<?php

/**
 * Custom functions for breadcrumb.
 *
 * @package Creote
 */



//Breadcrumbs
function creote_breadcrumb() {
 global $creote_theme_mod;
  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = ''; // delimiter between crumbs
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<li class="active">'; // tag before the current crumb
  $after = '</li>'; // tag after the current crumb
  $wp_the_query   = $GLOBALS['wp_the_query'];
  $queried_object = $wp_the_query->get_queried_object();
  $allowed_tags = wp_kses_allowed_html('post');
  global $post;
  $homeLink = esc_url( home_url());
 
  if (is_home() || is_front_page()) {
 
    if ($showOnHome == 1) echo '<ul class="bread-crumb"><li><a href="' . $homeLink . '">' . esc_html__('Home' , 'creote') . '</a></li></ul>';
 
  } 
   

  if (!is_front_page()) {
 
    echo '<ul class="breadcrumb m-auto"><li><a href="' . $homeLink . '">' . esc_html__('Home' , 'creote')  . '</a> </li>';
 
    if ( is_category() ) {
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        $thisCat = $cat_obj->term_id;
        $thisCat = get_category($thisCat);
        $parentCat = get_category($thisCat->parent);
      
        if ($thisCat->parent != 0) echo html_entity_decode( esc_html($before . get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '). $after));
        echo html_entity_decode( esc_html( $before . ' ' . single_cat_title('', false) . '' . $after) );
   
      } 

    elseif ( is_search() ) {
        echo html_entity_decode( esc_html($before . esc_html__('Search results for "' , 'creote') . get_search_query() . '"' . $after));
 
    } elseif ( is_day() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
      echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
      echo html_entity_decode( esc_html( $before . get_the_time('d') . $after));
 
    } elseif ( is_month() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
      echo html_entity_decode( esc_html( $before . get_the_time('F') . $after));
 
    } elseif ( is_year() ) {
        echo html_entity_decode( esc_html( $before . get_the_time('Y') . $after));
 
    }
    
    elseif(is_singular('post')) {
       
      $cat = get_the_category(); $cat = $cat[0];
      $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      if($showCurrent == 0) $cats = preg_replace("/^(.+)\s$delimiter\s$/", "$1", $cats);
      echo '<li>'.$cats.'</li> ';
      if($showCurrent == 1) echo html_entity_decode( esc_html( $before . get_the_title() . $after));
    
  }

  elseif(is_singular('service')) {
    $service_crumb_name = '';
        $service_crumb_name_link = '';
    if(!empty($creote_theme_mod['service_breadcrumb_name'])):
    $service_crumb_name = $creote_theme_mod['service_breadcrumb_name'];
    endif;
    if(!empty($creote_theme_mod['service_breadcrumb_link'])):
    $service_crumb_name_link = $creote_theme_mod['service_breadcrumb_link'];
  endif;
    echo '<li><a href="'.$service_crumb_name_link.'">'.$service_crumb_name.'</a></li> ';

    if($showCurrent == 1) echo html_entity_decode( esc_html( $before . get_the_title() . $after));

    
  
}


elseif(is_post_type_archive('service') || is_tax( 'service_category' )  || is_tax( 'service_tag' )) {
  $service_crumb_name_tax = '';
  $service_crumb_name_link_tax = '';
  if(!empty($creote_theme_mod['service_breadcrumb_name'])):
  $service_crumb_name_tax = $creote_theme_mod['service_breadcrumb_name'];
  endif;
  if(!empty($creote_theme_mod['service_breadcrumb_link'])):
  $service_crumb_name_link_tax = $creote_theme_mod['service_breadcrumb_link'];
  endif;
  echo '<li><a href="'.$service_crumb_name_link_tax.'">'.$service_crumb_name_tax.'</a></li> ';
  if (is_category()|| is_tag()|| is_tax()) {
    // Set the variables for this section
    $term_object        = get_term($queried_object);
    $taxonomy           = $term_object->taxonomy;
    $term_id            = $term_object->term_id;
    $term_name          = $term_object->name;
    $term_parent        = $term_object->parent;
    $taxonomy_object    = get_taxonomy($taxonomy);
    $current_term_link  = $before . $term_name . $after;
    $parent_term_string = '';
if(0!== $term_parent){
// Get all the current term ancestors
$parent_term_links = [];
while($term_parent){
 $term = get_term( $term_parent, $taxonomy );
 $parent_term_links[] =
 
 sprintf(
  '<li>' .
  '<a href="%s">%s</a>' .
  '</li>',
  esc_url( get_term_link( $term ) ), 
  $term->name 
); 
 $term_parent = $term->parent;
}
$parent_term_links  = array_reverse( $parent_term_links );
$parent_term_string = implode( $parent_term_links );
}
if($parent_term_string){
    echo wp_kses($parent_term_string  . $current_term_link , $allowed_tags);
}else{
    echo wp_kses($current_term_link , $allowed_tags);
}
}
   
}
elseif(is_singular('product')) {
  $product_crumb_name = '';
  $product_crumb_link = '';
  if(!empty($creote_theme_mod['product_breadcrumb_name'])):
  $product_crumb_name = $creote_theme_mod['product_breadcrumb_name'];
endif;
  if(!empty($creote_theme_mod['product_breadcrumb_link'])):
  $product_crumb_link = $creote_theme_mod['product_breadcrumb_link'];
endif;

  echo '<li><a href="'.$product_crumb_link.'">'.$product_crumb_name.'</a></li> ';

  if($showCurrent == 1) echo html_entity_decode( esc_html( $before . get_the_title() . $after));

}
elseif(is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax( 'product_tag' )) {
  $product_crumb_name_tax = '';
  $product_crumb_name_link_tax = '';
  if(!empty($creote_theme_mod['product_breadcrumb_name'])):
  $product_crumb_name_tax = $creote_theme_mod['product_breadcrumb_name'];
  endif;
  if(!empty($creote_theme_mod['product_breadcrumb_link'])):
  $product_crumb_name_link_tax = $creote_theme_mod['product_breadcrumb_link'];
  endif;
  echo '<li><a href="'.$product_crumb_name_link_tax.'">'.$product_crumb_name_tax.'</a></li> ';
  if (is_category()|| is_tag()|| is_tax()) {
    // Set the variables for this section
    $term_object        = get_term($queried_object);
    $taxonomy           = $term_object->taxonomy;
    $term_id            = $term_object->term_id;
    $term_name          = $term_object->name;
    $term_parent        = $term_object->parent;
    $taxonomy_object    = get_taxonomy($taxonomy);
    $current_term_link  = $before . $term_name . $after;
    $parent_term_string = '';
if(0!== $term_parent){
// Get all the current term ancestors
$parent_term_links = [];
while($term_parent){
 $term = get_term( $term_parent, $taxonomy );
 $parent_term_links[] =
 
 sprintf(
  '<li>' .
  '<a href="%s">%s</a>' .
  '</li>',
  esc_url( get_term_link( $term ) ), 
  $term->name 
); 
 $term_parent = $term->parent;
}
$parent_term_links  = array_reverse( $parent_term_links );
$parent_term_string = implode( $parent_term_links );
}
if($parent_term_string){
    echo wp_kses($parent_term_string  . $current_term_link , $allowed_tags);
}else{
    echo wp_kses($current_term_link , $allowed_tags);
}
}
}

elseif(is_singular('project')) {
  $project_crumb_name = '';
  $project_crumb_name_link = '';
  if(!empty($creote_theme_mod['project_breadcrumb_name'])):
  $project_crumb_name = $creote_theme_mod['project_breadcrumb_name'];
endif;
  if(!empty($creote_theme_mod['project_breadcrumb_link'])):
  $project_crumb_name_link = $creote_theme_mod['project_breadcrumb_link'];
endif;

  echo '<li><a href="'.$project_crumb_name_link.'">'.$project_crumb_name.'</a></li> ';
 
  if($showCurrent == 1) echo html_entity_decode( esc_html( $before . get_the_title() . $after));

}
 
elseif(is_post_type_archive('project') || is_tax( 'project_category')  || is_tax('project_tag')) {
  $project_crumb_name_tax = '';
  $project_crumb_name_link = '';
  if(!empty($creote_theme_mod['project_breadcrumb_name'])):
    $project_crumb_name_tax = $creote_theme_mod['project_breadcrumb_name'];
  endif;
  if(!empty($creote_theme_mod['project_breadcrumb_link'])):
    $project_crumb_name_link = $creote_theme_mod['project_breadcrumb_link'];
  endif;  

  echo '<li><a href="'.$project_crumb_name_link.'">'.$project_crumb_name_tax.'</a></li> ';
  if (is_category()|| is_tag()|| is_tax()) {
    // Set the variables for this section
    $term_object        = get_term($queried_object);
    $taxonomy           = $term_object->taxonomy;
    $term_id            = $term_object->term_id;
    $term_name          = $term_object->name;
    $term_parent        = $term_object->parent;
    $taxonomy_object    = get_taxonomy($taxonomy);
    $current_term_link  = $before . $term_name . $after;
    $parent_term_string = '';
if(0!== $term_parent){
// Get all the current term ancestors
$parent_term_links = [];
while($term_parent){
 $term = get_term( $term_parent, $taxonomy );
 $parent_term_links[] =
 
 sprintf(
  '<li>' .
  '<a href="%s">%s</a>' .
  '</li>',
  esc_url( get_term_link( $term ) ), 
  $term->name 
); 
 $term_parent = $term->parent;
}
$parent_term_links  = array_reverse( $parent_term_links );
$parent_term_string = implode( $parent_term_links );
}
if($parent_term_string){
    echo wp_kses($parent_term_string  . $current_term_link , $allowed_tags);
}else{
    echo wp_kses($current_term_link , $allowed_tags);
}
}
}

elseif(is_singular('job_listing')) {
  $job_breadcrumb_name_single = '';
  $job_crumb_name_link_single = '';
  if(!empty($creote_theme_mod['job_breadcrumb_name'])):
  $job_breadcrumb_name_single = $creote_theme_mod['job_breadcrumb_name'];
endif;
  if(!empty($creote_theme_mod['job_breadcrumb_link'])):
  $job_crumb_name_link_single = $creote_theme_mod['job_breadcrumb_link'];
endif;

  echo '<li><a href="'.$job_crumb_name_link_single.'">'.$job_breadcrumb_name_single.'</a></li> ';
  if($showCurrent == 1) echo html_entity_decode( esc_html( $before . get_the_title() . $after));

}

elseif(is_post_type_archive('job_listing')) {
  $job_breadcrumb_name = '';
  $job_breadcrumb_link = '';
  if(!empty($creote_theme_mod['job_breadcrumb_name'])):
    $job_breadcrumb_name = $creote_theme_mod['job_breadcrumb_name'];
  endif;
  if(!empty($creote_theme_mod['job_breadcrumb_link'])):
    $job_breadcrumb_link = $creote_theme_mod['job_breadcrumb_link'];
  endif;  

  echo '<li><a href="'.$job_breadcrumb_link.'">'.$job_breadcrumb_name.'</a></li> ';

}
  
elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat;
     
      echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li> ' . $delimiter . ' ';
      if ($showCurrent == 1) echo html_entity_decode( esc_html( $before . get_the_title() . $after));
 
    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo html_entity_decode( esc_html( $before . get_the_title() . $after));
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb)  echo html_entity_decode( esc_html( $crumb . ' ' . $delimiter . ' '));
      if ($showCurrent == 1) echo html_entity_decode( esc_html( $before . get_the_title() . $after));
 
    } elseif ( is_tag() ) {
        echo html_entity_decode( esc_html( $before . '"' . single_tag_title('', false) . '"' . $after));
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo html_entity_decode( esc_html( $before . '"' . $userdata->display_name . '"' . $after));
 
    } elseif ( is_404() ) {
        echo html_entity_decode( esc_html__($before . 'Error 404' , 'creote' . $after));
    }


    
    if (is_home()){

      global $post;

      $page_for_posts_id = get_option('page_for_posts');
      echo '<li>';
      if ( $page_for_posts_id ) { 

          $post = get_page($page_for_posts_id);

          setup_postdata($post);
          the_title();
          rewind_posts();

      }
      echo '</li>';
  }
  
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ){
      echo '<li>'.esc_html__('Page', 'creote') . ''.get_query_var('paged').'</li> ';
    }
    }
    
    echo '</ul>';
 
  }
} 