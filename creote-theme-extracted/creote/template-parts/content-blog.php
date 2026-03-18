<?php
/**
* Blog Content
* @package Creote wordpress theme
**/
global $creote_theme_mod;

$blog_style = '';
if(!empty($creote_theme_mod['blog_layout_styles'])){
$blog_style = $creote_theme_mod['blog_layout_styles'];
}

$image_size = 'creote-full-width';
$blog_column = '';
$css_classes = 'col-xs-12';
if(!empty($creote_theme_mod['blog_layout_column'])){
$blog_column = $creote_theme_mod['blog_layout_column'];
}

if(!is_singular()) {
if($blog_column == 'one_column') {
 $image_size = 'creote-grid-1170-520';
 $css_classes = 'col-lg-12 grid_box';
}
elseif( $blog_column == 'two_column'){
 $image_size = 'creote-grid-570-420';
 $css_classes = 'col-lg-6 col-md-6 col-sm-6 col-xs-12 grid_box';
} 
elseif( $blog_column == 'three_column'){
 $image_size = 'creote-grid-470-280';
 $css_classes = 'col-lg-4 col-md-6 col-sm-6 col-xs-12 grid_box';
}
elseif($blog_column == 'four_column'){
 $image_size = 'creote-grid-270-180';
 $css_classes = 'col-lg-3 col-md-6 col-sm-6 col-xs-12 grid_box';
} 
} 
else{
	$image_size = 'creote-full-width';
}
$css_classes_tw = esc_html('col-xs-12 grid_box' , 'creote');

/* grab the animation effects */ 
$animation = '';
if(!empty($creote_theme_mod['aos_animation_stop']) == true){
 $animation = 'data-aos=fade-up data-aos-delay=0';
}
/* grab the url for the full size featured image */
$featured_img_url = get_the_post_thumbnail_url($post->ID, 'full'); 
$myexcerpt = wp_trim_words(get_the_excerpt());  
$mycontent = wp_trim_words(get_the_content()); 
?>
<?php if($blog_style == 'style_one'): ?>
<div <?php post_class($css_classes); ?>>
   <div class="news_box  style_one blog_classic  <?php if(has_post_thumbnail()): ?>has_images<?php else: ?>no_images<?php endif; ?>" id="post-<?php esc_attr(the_ID()); ?>" <?php echo esc_attr($animation); ?>>
      <?php if(has_post_thumbnail()): ?>
      <div class="image img_hover-1">
         <?php the_post_thumbnail($image_size); ?>
         <a class="arrow" href="<?php echo esc_url(get_permalink()); ?>"><i class="fab fa-angle-right"></i></a>
      </div>
      <?php endif;?>    
      <div class="content_box">
         <div class="date">
            <span class="date_in_number"><?php echo esc_attr(get_the_date('d')); ?></span>
            <span class="date_in_month"><?php echo esc_attr(get_the_date('M')); ?></span>
         </div>
         <?php creote_category(); ?>
         <?php the_title( '<h2 class="title"><a href="' .  esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>' ); ?>
      </div>
   </div>
</div>
<?php elseif($blog_style == 'style_two'):?>
<div <?php post_class($css_classes_tw); ?>>
   <div class="news_box default_style list_view clearfix   <?php if(has_post_thumbnail()): ?>has_images<?php else: ?>no_images<?php endif; ?>" id="post-<?php esc_attr(the_ID()); ?>" <?php echo esc_attr($animation); ?>>
      <?php if(has_post_thumbnail()): ?>
      <div class="image img_hover-1">
         <?php the_post_thumbnail(); ?>
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
            <p><?php echo esc_html($myexcerpt); ?></p>
            <?php }elseif(!empty($mycontent)){ ?>
            <p><?php  echo esc_html($mycontent); ?></p>
            <?php } ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="link__go"><?php echo esc_html__('Read more' , 'creote');?></a>
         </div>
         <div class="auhtour_box">
            <?php echo get_avatar( get_the_author_meta( 'ID' ) , 60 ); ?>
            <div class="contnet_a">
               <p><?php echo esc_html__('POSTED BY' , 'creote'); ?></p>
               <h4>
                  <?php the_author(); ?>
               </h4>
            </div>
         </div>
      </div>
   </div>
</div>
<?php else:?>
<div <?php post_class($css_classes_tw); ?>>
   <div class="news_box default_style list_view normal_view   clearfix <?php if(has_post_thumbnail()): ?>has_images<?php else: ?>no_images<?php endif; ?>" id="post-<?php esc_attr(the_ID()); ?>" <?php echo esc_attr($animation); ?>>
      <?php if(has_post_thumbnail()): ?>
      <div class="image img_hover-1">
         <?php the_post_thumbnail(); ?>
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
            <p><?php echo esc_html($myexcerpt); ?></p>
            <?php }elseif(!empty($mycontent)){ ?>
            <p><?php  echo esc_html($mycontent); ?></p>
            <?php } ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="link__go"><?php echo esc_html__('Read more' , 'creote');?></a>
         </div>
         <div class="auhtour_box">
            <?php echo get_avatar( get_the_author_meta( 'ID' ) , 60 ); ?>
            <div class="contnet_a">
               <p><?php echo esc_html__('POSTED BY' , 'creote'); ?></p>
               <h4>
                  <?php the_author(); ?>
               </h4>
            </div>
         </div>
      </div>
   </div>
</div>
<?php endif; ?>