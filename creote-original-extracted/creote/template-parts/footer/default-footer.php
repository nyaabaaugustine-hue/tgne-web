<?php
/**
 *  Default Footer 
 *
 * @package Creote
 */
if(is_page_template( 'template-empty.php' ) || is_page_template( 'template-full-empty.php' )){
  return false;
  }
global $creote_theme_mod;
 
$footer_style = '';
if(!empty($creote_theme_mod['footer_style'])):
$footer_style = $creote_theme_mod['footer_style'];
endif;

$footer_custom = '';
if(!empty($creote_theme_mod['footer_custom'])):
$footer_custom = $creote_theme_mod['footer_custom'];
endif;
  
$footer_id = $footer_style;
if(get_post_meta(get_the_ID() , 'custom_footer', true))
{
    $footer_id = get_post_meta(get_the_ID() , 'footer_settings_meta', true);
}
?>
<?php function  creote_default_footer(){
  global $creote_theme_mod;
?>
<footer class="footer footer_default text-center">
  <div class="auto-container">
    <div class="row">
      <div class="col-lg-12">
        <div class="copyright">
          <?php echo esc_html__('© 2023 Steelthemes. All Right Reseved' , 'creote'); ?>
        </div>
      </div>
    </div>
  </div>
</footer>
<?php } ?>
<?php if($footer_custom == false):  ?>
      <?php  creote_default_footer(); ?>
<?php else: ?>
<div class="footer_area <?php creote_footer_sticky_enable_footer(); ?>" id="footer_contents">
  <?php    echo do_shortcode('[creote-footer id="' . $footer_id . '"]'); ?>
</div>
<?php endif; ?>

