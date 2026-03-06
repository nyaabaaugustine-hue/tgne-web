<?php

/**
 * Custom functions for breadcrumb.
 *
 * @package Creote
 */


/**
 * Helper function to render breadcrumbs for single custom post type pages.
 *
 * @param string $post_type The slug of the post type (e.g., 'service', 'project').
 * @param array  $creote_theme_mod The global theme options array.
 * @param int    $showCurrent Flag to show the current page title.
 * @param string $before HTML to place before the current crumb.
 * @param string $after HTML to place after the current crumb.
 */
function creote_breadcrumb_cpt_singular_handler($post_type, $creote_theme_mod, $showCurrent, $before, $after) {
    $breadcrumb_name_key = $post_type . '_breadcrumb_name';
    $breadcrumb_link_key = $post_type . '_breadcrumb_link';

    $crumb_name = !empty($creote_theme_mod[$breadcrumb_name_key]) ? $creote_theme_mod[$breadcrumb_name_key] : '';
    $crumb_link = !empty($creote_theme_mod[$breadcrumb_link_key]) ? $creote_theme_mod[$breadcrumb_link_key] : '';

    echo '<li><a href="' . esc_url($crumb_link) . '">' . esc_html($crumb_name) . '</a></li> ';

    if ($showCurrent == 1) {
        echo html_entity_decode(esc_html($before . get_the_title() . $after));
    }
}

/**
 * Helper function to render breadcrumb taxonomy hierarchy.
 *
 * @param object $queried_object The queried term object.
 * @param string $before HTML to place before the current crumb.
 * @param string $after HTML to place after the current crumb.
 */
function creote_breadcrumb_render_taxonomy_ancestors($queried_object, $before, $after) {
    $term_object = get_term($queried_object);
    if (!$term_object || is_wp_error($term_object)) {
        return;
    }
    $taxonomy = $term_object->taxonomy;
    $term_name = $term_object->name;
    $term_parent = $term_object->parent;
    
    $parent_term_links = [];
    while ($term_parent) {
        $term = get_term($term_parent, $taxonomy);
        if ($term && !is_wp_error($term)) {
            $term_link = get_term_link($term);
            if ( ! is_wp_error( $term_link ) ) {
                $parent_term_links[] = sprintf(
                    '<li><a href="%s">%s</a></li>',
                    esc_url($term_link),
                    esc_html($term->name)
                );
            }
        }
        $term_parent = $term ? $term->parent : 0;
    }
    
    if (!empty($parent_term_links)) {
        echo implode('', array_reverse($parent_term_links));
    }

    echo $before . esc_html($term_name) . $after;
}

/**
 * Helper function to render breadcrumbs for CPT archives and taxonomy pages.
 *
 * @param string $post_type The slug of the post type (e.g., 'service', 'project').
 * @param array  $creote_theme_mod The global theme options array.
 * @param object $queried_object The queried object from WP_Query.
 * @param string $before HTML to place before the current crumb.
 * @param string $after HTML to place after the current crumb.
 */
function creote_breadcrumb_cpt_archive_handler($post_type, $creote_theme_mod, $queried_object, $before, $after) {
    $breadcrumb_name_key = $post_type . '_breadcrumb_name';
    $breadcrumb_link_key = $post_type . '_breadcrumb_link';
    $crumb_name = !empty($creote_theme_mod[$breadcrumb_name_key]) ? $creote_theme_mod[$breadcrumb_name_key] : '';
    $crumb_link = !empty($creote_theme_mod[$breadcrumb_link_key]) ? $creote_theme_mod[$breadcrumb_link_key] : '';
    echo '<li><a href="' . esc_url($crumb_link) . '">' . esc_html($crumb_name) . '</a></li> ';
    if (is_tax()) {
        creote_breadcrumb_render_taxonomy_ancestors($queried_object, $before, $after);
    }
}

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
    creote_breadcrumb_cpt_singular_handler('service', $creote_theme_mod, $showCurrent, $before, $after);
  }
  elseif(is_post_type_archive('service') || is_tax( 'service_category' )  || is_tax( 'service_tag' )) {
    creote_breadcrumb_cpt_archive_handler('service', $creote_theme_mod, $queried_object, $before, $after);
  }
  elseif(is_singular('product')) {
    creote_breadcrumb_cpt_singular_handler('product', $creote_theme_mod, $showCurrent, $before, $after);
  }
  elseif(is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax( 'product_tag' )) {
    creote_breadcrumb_cpt_archive_handler('product', $creote_theme_mod, $queried_object, $before, $after);
  }
  elseif(is_singular('project')) {
    creote_breadcrumb_cpt_singular_handler('project', $creote_theme_mod, $showCurrent, $before, $after);
  }
  elseif(is_post_type_archive('project') || is_tax( 'project_category')  || is_tax('project_tag')) {
    creote_breadcrumb_cpt_archive_handler('project', $creote_theme_mod, $queried_object, $before, $after);
  }
  elseif(is_singular('job_listing')) {
    creote_breadcrumb_cpt_singular_handler('job', $creote_theme_mod, $showCurrent, $before, $after);
  }
  elseif(is_post_type_archive('job_listing')) {
    creote_breadcrumb_cpt_archive_handler('job', $creote_theme_mod, $queried_object, $before, $after);
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