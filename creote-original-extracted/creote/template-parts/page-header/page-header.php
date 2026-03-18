<?php
/**
* Page Header.
* @package creote Wordpress Theme
**/
   
function creote_page_header(){
     $class = '';
   
if(!creote_has_page_header())
{
    return '';
}
if(is_singular('post'))
{
  return false;
}
if(is_404())
{
  return false;
}
if(is_page_template( 'template-empty.php' ) || is_page_template( 'template-full-empty.php' )){
  return false;
}  
if(!is_front_page() && is_home()){
    $class = 'blog-title';
}
elseif(creote_get_page_header_image() == ''){
    $class .= ' no-image';
}
 
$image_alt = get_template_directory_uri() . '/assets/images/page-header-default.jpg';
$page_header_title = get_post_meta(get_the_ID() , 'page_header_title', true);
?>
<section class="page_header_default style_one <?php echo esc_attr($class); ?> <?php if(!empty($page_header_title)): ?> enabled_custom_title <?php endif; ?>">
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
</section>
<?php    }
add_action('creote_after_header_no_blog', 'creote_page_header');