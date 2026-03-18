<?php
   /**
    *  Default Header 
    *
    * @package Creote
   */
   if(is_page_template( 'template-empty.php' ) || is_page_template( 'template-full-empty.php' )){
   return false;
   }
   global $creote_theme_mod;
   $header_id = '';
   if(!empty($creote_theme_mod['header_style'])):
   $header_id = $creote_theme_mod['header_style'];
   endif;
   if(get_post_meta(get_the_ID() , 'custom_header', true)):
       $header_id = get_post_meta(get_the_ID() , 'header_settings_meta', true);
   endif;

  // Enbale Custom header
   $header_custom = '';
   if(!empty($creote_theme_mod['header_custom'])):
   $header_custom = $creote_theme_mod['header_custom'];
   endif;

   ?>
<?php function  creote_default_header(){ ?>
<header class="header df_before header_default">
   <div class="auto-container">
      <div class="row">
         <div class="col-lg-2 col-md-9 col-sm-9 col-xs-9 logo_column">
            <div class="header_logo_box">
               <?php do_action('default_logo'); ?>
            </div>
         </div>
         <div class="col-lg-10 col-md-3 col-sm-3 col-xs-3 menu_column">
            <div class="navbar_togglers hamburger_menu">
               <span class="line"></span>
               <span class="line"></span>
               <span class="line"></span>
            </div>
            <div class="header_content_collapse">
               <div class="header_menu_box">
                  <div class="navigation_menu">
                     <?php wp_nav_menu(array(
                        'theme_location' => 'primary',
                            'container' => false,
                            'menu_class' => 'navbar_nav',
                             'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
                            'walker' => new WP_Bootstrap_Navwalker()
                        ));?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</header>
<?php  } ?>
<?php if($header_custom == false): 
   creote_default_header();
else:?>
<div class="header_area <?php if(get_post_meta(get_the_ID() , 'header_position_enable', true)):  echo esc_attr(get_post_meta(get_the_ID() , 'header_position', true));  endif; ?>"
   id="header_contents">
   <?php  echo do_shortcode('[creote-header id="' . $header_id . '"]'); ?>
   <?php do_action('nest_sticky_header_after_header'); ?>
</div>
<?php endif; ?>