<?php
/**
* Page Header.
* @package Creote Wordpress Theme
**/
function creote_page_header_blog(){
   if(!creote_has_page_header()){
    return '';
   }
     $class = '';
       if(creote_get_page_header_image() == ''){
          $class .= ' no-image';
        }
   $title_text = get_post_meta(get_the_ID() , 'page_header_title', true); 
   $image_alt = get_template_directory_uri() . '/assets/images/page-header-default.jpg';


   $page_header_title = get_post_meta(get_the_ID() , 'page_header_title', true);

   ?>
<?php
   the_post(); // queue first post
   $author_id = get_the_author_meta('ID');
   $curauth = get_user_by('ID', $author_id);
   $user_nicename    = $curauth->user_nicename;
   rewind_posts(); // rewind the loop
   ?>
<section class="page_header_default style_one blog_single_pageheader <?php echo esc_attr($class); ?> <?php if(!empty($page_header_title)): ?> enabled_custom_title <?php endif; ?>">
   <div class="parallax_cover">
      <?php if($image = creote_get_page_header_image()): ?>
      <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_html('bg_image' , 'creote'); ?>" class="cover-parallax">
      <?php else: ?>
      <img src="<?php echo esc_url($image_alt); ?>" alt="<?php echo esc_html('bg_image' , 'creote'); ?>" class="cover-parallax">
      <?php endif; ?>
   </div>
   <div class="page_header_content">
      <div class="auto-container">
         <div class="row">
            <div class="col-md-12">
               <div class="banner_title_inner">
                  <div class="date">
                     <span class="date_in_number"><?php echo esc_attr(get_the_date(get_option('date_format'))); ?></span>
                  </div>
                  <?php do_action('get_creote_choose_tag'); ?>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="breadcrumbs creote">
                  <?php  if(function_exists('creote_breadcrumb')) echo creote_breadcrumb(); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="meta_blog_single">
      <div class="auto-container">
         <div class="row">
            <div class="col-md-12">
               <div class="left_side">
                  <?php creote_category_two(); ?>
                  <?php creote_comments(); ?>
               </div>
               <div class="right_side">
                  <div class="content_box_auht d-flex">
                     <div class="authour_content">
                        <h6><?php echo esc_html__('Posted By' , 'creote'); ?></h6>
                        <h4><?php the_author(); ?></h4>
                     </div>
                     <div class="authour_image">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ) , 50 ); ?>  
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php   
}
add_action('creote_after_header_blog', 'creote_page_header_blog');