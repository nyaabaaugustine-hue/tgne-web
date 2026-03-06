<?php
   /**
    * *
    * Page Header.
    * @package Creote Wordpress Theme
    * @version 1.0.0
    * *
   * */
   function creote_page_header_noredux()
   {
     if( class_exists( 'Redux' ) ) {
       return false;
     }
     if(is_404())
     {
       return false;
     }
     $class = '';
     if(creote_get_page_header_image() == '')
     {
         $class .= ' no-image';
      }
     $image_alt = get_template_directory_uri() . '/assets/images/page-header-default.jpg';
   
   ?>
<?php if(!is_singular('post')) { ?>
<section class="page_header_default style_one">
   <div class="parallax_cover">
      <?php if($image = creote_get_page_header_image()): ?>
      <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_html__('bg_image' , 'creote'); ?>" class="cover-parallax">
      <?php else: ?>
      <img src="<?php echo esc_url($image_alt); ?>" alt="<?php echo esc_html__('bg_image' , 'creote'); ?>" class="cover-parallax">
      <?php endif; ?>
   </div>
   <div class="page_header_content">
   <div class="auto-container">
   <div class="row">
      <div class="col-md-12">
         <div class="banner_title_inner">
            <div class="title_page">
               <?php  the_archive_title();   ?>
      </div>
         </div>
      </div>
      <?php if(!is_front_page() && !is_home()):?>    
      <div class="col-lg-12">
         <div class="breadcrumbs creote">
            <?php  if(function_exists('creote_breadcrumb')) echo creote_breadcrumb(); ?>
         </div>
      </div>
      <?php endif; ?>
   </div>
   </div>
   </div>
</section>
<?php }  elseif(is_singular('post'))  { ?>
<!-- Start Banner Section -->
<section class="page_header_default style_one blog_single_pageheader <?php echo esc_attr($class); ?>">
   <div class="parallax_cover">
      <?php if($image = creote_get_page_header_image()): ?>
      <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_html__('bg_image' , 'creote'); ?>" class="cover-parallax">
      <?php else: ?>
      <img src="<?php echo esc_url($image_alt); ?>" alt="<?php echo esc_html__('bg_image' , 'creote'); ?>" class="cover-parallax">
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
                  <div class="title_page">
                     <?php  the_archive_title();  ?>
      </div>
               </div>
            </div>
            <?php if(!is_front_page() && !is_home()):?>    
            <div class="col-lg-12">
               <div class="breadcrumbs creote">
                  <?php  if(function_exists('creote_breadcrumb')) echo creote_breadcrumb(); ?>
               </div>
            </div>
            <?php endif; ?>
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
               <?php if(!empty(the_author())): ?>
               <div class="right_side">
                  <div class="content_box_auht d-flex">
                     <div class="authour_content">
                        <h6><?php echo esc_html__('Posted By' , 'creote'); ?></h6>
                        <h4> <?php the_author(); ?></h4>
                     </div>
                     <div class="authour_image">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ) , 50 ); ?>  
                     </div>
                  </div>
               </div>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- End Banner -->
<?php } ?>
<!-- End banner_about -->
<?php   
}
add_action('creote_after_header_no_redux', 'creote_page_header_noredux');