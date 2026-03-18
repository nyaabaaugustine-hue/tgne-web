<?php
/*
 *=================================
 * The 404 template file
 * @package Creote WordPress Theme
 *==================================
*/

get_header();
?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
<div id="primary" class="content-area col-lg-12">
  <main id="main" class="site-main" role="main">
    <section class="error-404 not-found">
      <div class="row d-flex align-items-center">
      <div class="col-lg-6">
      <div class="error_404">
      <div class="image_box">
      <?php 
        global  $creote_theme_mod; 
        $fournotimage = '';
        if(!empty($creote_theme_mod['fournotbg_image']['url'])){
            $fournotimage =  $creote_theme_mod['fournotbg_image']['url'];
        }
        if (empty($fournotimage)) {
          $fournotimage = get_template_directory_uri() . '/assets/images/404.png';
        }
      ?>
      <img src="<?php echo esc_url($fournotimage); ?>" class="img-fluid" alt="404" />
      </div>
      </div>
    </div>
      <div class="col-lg-6">
      <div class="fourntcontent">
      <div class="content">
      <h1 class="margin-t-3 font-s-60"><?php esc_html_e( 'Oops...', 'creote' ) ?></h1>
      <h2><?php esc_html_e( 'We are not being able to find the page you are looking for.', 'creote') ?></h2>
	  <hp><?php esc_html_e( 'The page you are looking for was moved, removed, renamed
or never existed.', 'creote') ?></p>
<div class="search">
<?php creote_simple_search(); ?>
	</div>
      <div class="theme_btn_all">					
              <a href="<?php echo esc_url(home_url()); ?>" class="theme-btn one"><?php esc_html_e('Back to home', 'creote') ?></a>
      </div>	
    </div>
  </div>		
</div>			
			
</div>		
</section>	
</main>
</div>
<?php } ?>
<?php get_footer();?>