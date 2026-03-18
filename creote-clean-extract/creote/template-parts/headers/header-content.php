<?php
/**
*  Headers Source
*
* @package Creote
*/
/*
=============================================================
header search content
=============================================================
*/
function header_search_content(){ ?>
<div id="search-popup" class="search-popup">
   <div class="close-search"><i class="flaticon-close"></i></div>
   <div class="popup-inner">
      <div class="overlay-layer"></div>
      <div class="search-form">
         <form role="search" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
            <input type="search" class="search form-control" placeholder="<?php echo esc_attr__( 'Search...', 'creote' ); ?>" value="<?php echo get_search_query() ?>" name="s" title="Search" />
            <button type="submit" class="sch_btn"> <i class="tio tio-search"></i></button>
         </form>
         <fieldset>
         </fieldset>
      </div>
   </div>
</div>
<?php } 
function creote_header_default_logo() {
       $blog_title = get_bloginfo('name');
       $logo =  get_template_directory_uri() . '/assets/images/logo-default.png';
?>   
<div class="logo_box">
   <a href="<?php  echo esc_url(home_url()); ?>" class="logo">
      <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($blog_title); ?>" class="logo_default">
       
      <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
   </a>
</div>
<?php } 
add_action('default_logo' , 'creote_header_default_logo');  

function creote_header_sticky_logo() {
   global $creote_theme_mod;
   $blog_titles = get_bloginfo('name');
   $logo_sticky = '';
   if(!empty($creote_theme_mod['logo_sticky']['url'])):
      $logo_sticky =  $creote_theme_mod['logo_sticky']['url'];
   else:
   $logo_sticky =  get_template_directory_uri() . '/assets/images/logo-default.png';
   endif;
  
   
?>   
<div class="logo_box">
<a href="<?php if(!empty($creote_theme_mod['logo_sticky_link'])): echo esc_html($creote_theme_mod['logo_sticky_link']); else: echo esc_url(home_url()); endif; ?>" class="logo">
  <img src="<?php echo esc_url($logo_sticky); ?>" alt="<?php echo esc_attr($blog_titles); ?>" class="logo_default_sticky">
</a>
</div>
<?php } 
add_action('sticky_default_logo' , 'creote_header_sticky_logo');  
/*
=============================================================
creote modal type one
=============================================================
*/    
function creote_modal_type_one() {
       global $creote_theme_mod;
       $logo_modal =  get_template_directory_uri() . '/assets/images/logo-default.png';
       $modal_form_short_code = '';
       if(!empty($creote_theme_mod['modal_form_short_code'])):
           $modal_form_short_code =  $creote_theme_mod['modal_form_short_code'];
       endif;
   ?>   
<div class="modal_popup one">
   <div class="modal-popup-inner">
      <div class="close-modal"><i class="fas fa-times"></i></div>
      <div class="modal_box">
         <div class="row">
            <div class="col-lg-5 col-md-12 form_inner">
               <div class="form_content">
                  <?php  echo  do_shortcode(wp_kses($modal_form_short_code , wp_kses_allowed_html('post')));  ?>
               </div>
            </div>
            <div class="col-lg-7 col-md-12 about_company_inner">
               <div class="abt_content">
                  <div class="logo">
                     <?php if(!empty($creote_theme_mod['company_logo_modal']['url'])): ?>
                     <img src="<?php echo esc_url($creote_theme_mod['company_logo_modal']['url']); ?>" alt="img" class="company_logo_modal">
                     <?php else:?>
                     <img src="<?php echo esc_url($logo_modal); ?>" alt="img" class="company_logo_modal">
                     <?php  endif;?>
                  </div>
                  <div class="text">
                     <p> <?php echo wp_kses($creote_theme_mod['about_company_modal'] , wp_kses_allowed_html('post'));   ?></p>
                     <?php if(!empty($creote_theme_mod['modal_read_more'])): ?>
                     <a href="<?php if(!empty($creote_theme_mod['modal_read_more_link'])): echo esc_url($creote_theme_mod['modal_read_more_link']); endif;?>"><?php echo esc_attr($creote_theme_mod['modal_read_more']); ?></a>
                     <?php endif; ?>  
                  </div>
                  <?php if(!empty($creote_theme_mod['post_enable_modal']) == true): ?>
                  <div class="post_contet_modal">
                     <h2>  <?php echo wp_kses($creote_theme_mod['post_title_modal'] , wp_kses_allowed_html('post'));   ?></h2>
                     <div class="post_enable">
                        <?php
                           $post_style_modal  =  '';
                           if(!empty($creote_theme_mod['post_style_modal'])):
                                $post_style_modal  =  $creote_theme_mod['post_style_modal'];
                           else:
                                   $post_style_modal =  'post';
                                
                           endif;
                           
                                $query_args = array( 
                                   'post_type'      => $post_style_modal,
                                   'posts_per_page'  => '5',
                                   'orderby'        => 'date',
                                );
                                $modal_post = new WP_Query( $query_args ); 
                           
                                if($modal_post->have_posts()):
                                   while($modal_post->have_posts()): $modal_post->the_post(); ?>
                        <?php if(has_post_thumbnail()): ?>
                        <div class="modal_post_grid">
                           <a href="<?php echo esc_url(get_permalink()); ?>">
                           <?php the_post_thumbnail('creote-grid-470-280', array('class' => 'main_img')); ?>   
                           </a>
                        </div>
                        <?php endif; ?>
                        <?php endwhile;
                           // Restore original Post Data
                           wp_reset_postdata();
                           endif;?>
                     </div>
                  </div>
                  <?php endif;  ?>
                  <?php if(!empty($creote_theme_mod['copy_right_modal'])): ?>
                  <div class="copright">
                     <?php echo wp_kses($creote_theme_mod['copy_right_modal'] , wp_kses_allowed_html('post'));   ?>
                  </div>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php 
} 
add_action('modal_box_one' , 'creote_modal_type_one');