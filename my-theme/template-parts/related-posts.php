<?php
/**
* The Related Posts .
* @package creote Wordpress Theme
**/  
function creote_related_posts() {
     global $creote_theme_mod;
     $categories = get_the_category();
     $category_ids = array();
     foreach ( $categories as $category ) {
         $category_ids[] = $category->term_id;
     }
  
       $relate_post = '';
       if(!empty($creote_theme_mod['related_post_count'])){
         $relate_post = $creote_theme_mod['related_post_count'];
       }
       else{
         $relate_post = '3';
       }
      
        $query_args = array(
         'post_type' => 'post',
         'post_status' => 'publish',
         'category__in' => $category_ids,
         'posts_per_page' => $relate_post, // Change this number to display a different number of related posts
         'post__not_in' => array( get_the_ID() )
         );
         $related_post_query = new WP_Query( $query_args ); 
   ?>
<section class="related_post blog_slider">
   <div class="swip__stories">
      <div class="title_sections_inner">
         <h2><?php if(!empty($creote_theme_mod['related_post_title'])){ echo esc_html($creote_theme_mod['related_post_title']);} else{echo esc_html__('Related Posts' , 'creote'); } ?></h2>
      </div>
      <!-- Swiper -->
      <div class="swiper-container  <?php  if(!empty($creote_theme_mod['related_carousel_items'])): echo esc_attr($creote_theme_mod['related_carousel_items']); else: echo esc_html('related_posts_swiper_two' , 'creote'); endif;?> ">
         <div class="swiper-wrapper">
            <?php if($related_post_query->have_posts()):
               while($related_post_query->have_posts()): $related_post_query->the_post(); 
               
               $myexcerpt = wp_trim_words(get_the_excerpt(), 15);  
               $mycontent = wp_trim_words(get_the_content(), 15); 

               ?>
            <div class="swiper-slide">
               <div class="news_box default_style list_view normal_view clearfix <?php if(has_post_thumbnail()): ?>has_images<?php else: ?>no_images<?php endif; ?>" id="post-<?php esc_attr(the_ID()); ?>">
                  <?php if(has_post_thumbnail()): 
                      $featured_image_url = get_the_post_thumbnail_url(get_the_ID(),'full');
                     ?>
                  <div class="image img_hover-1">
                  <img src="<?php echo esc_url($featured_image_url);?>" class="img-fluid" alt="<?php the_title(); ?>">
                     <?php creote_category(); ?>
                  </div>
                  <?php endif;?>    
                  <div class="content_box">
                     <div class="date">
                        <span class="date_in_number"><?php echo esc_attr(get_the_date(get_option('date_format'))); ?></span>
                     </div>
                     <div class="source">
                        <?php the_title( '<h2 class="title"><a href="' .  esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>' ); ?>
                        <?php if(!empty($myexcerpt)){?>
                  <p class="short_desc"><?php echo  esc_html($myexcerpt); ?></p>
                  <?php }elseif(!empty($mycontent)){ ?>
                  <p class="short_desc"><?php echo  esc_html($mycontent); ?></p>
                  <?php } ?>
                     </div>
                  </div>
               </div>
            </div>
            <?php endwhile;
               // Restore original Post Data
               wp_reset_postdata();
               endif;
               ?>
         </div>
      </div>
      <div class="arrow_related">
         <div class="related-button-prev">
            <i class="fas fa-angle-left"></i>
         </div>
         <div class="related-button-next">
            <i class="fas fa-angle-right"></i> 
         </div>
      </div>
   </div>
</section>
<!-- End. section__stories -->
<?php
}