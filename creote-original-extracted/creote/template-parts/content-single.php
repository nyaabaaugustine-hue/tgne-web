<?php
/**
* @package Creote wordpress theme
*/
global $creote_theme_mod;
$extra_class = 'blog_single_details_outer  content-Sblog';
$post_sub_title = get_post_meta(get_the_ID() , 'post_sub_title', true);
?>
<section id="post-<?php esc_attr(the_ID()); ?>" <?php esc_attr(post_class($extra_class)); ?>>
   <div class="single_content_upper">
      <?php if(get_post_meta(get_the_ID() , 'frature_img_enable', true)):?>
      <?php if ( has_post_thumbnail() ): ?>
      <div class="blog_feature_image featured-image">
         <?php echo get_the_post_thumbnail(); ?>
      </div>
      <?php endif; ?>
      <?php endif;  ?>
      <div class="post_single_content">
         <?php the_content(); ?>
         <div class="clearfix"></div>
         <?php wp_link_pages(); ?>
      </div>
   </div>
   <div class="single_content_lower">
   <?php if(!empty($creote_theme_mod['share_disable']) == true || !empty($creote_theme_mod['tag_disable']) == true): 
       creote_tags_and_share(); 
   endif; ?>
      <?php if(!empty($creote_theme_mod['post_nav_enable']) == true): 
          do_action('creote_entry_nav_footer'); 
      endif; ?>
      <?php // creote_authour_details(); ?>
      <?php
         // If comments are open or we have at least one comment, load up the comment template
         if ( comments_open() || get_comments_number() ) :
         	comments_template();
         endif;
         ?>
</div>
<?php if((!empty($creote_theme_mod['enable_related_post']) == true) && (get_post_meta(get_the_ID() , 'relatedpost_single_enable', true) == false)){
  creote_related_posts();
}
?>
</section>