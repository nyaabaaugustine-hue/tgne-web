<?php
/**
*  Sticky Default Header 
*
* @package Creote
*/
 
function nest_sticky_header(){ 
    global $creote_theme_mod;
if(!creote_header_sticky())
{
    return false;
}

   // choosing sticky header type
   $select_stickt_header_type = '' ;
   if(!empty($creote_theme_mod['select_stickt_header_type'])):
      $select_stickt_header_type = $creote_theme_mod['select_stickt_header_type'];
   endif;
  // choosing sticky header Style
   $sticky_header_style = '';
   if(!empty($creote_theme_mod['sticky_header_style'])):
         $sticky_header_style = $creote_theme_mod['sticky_header_style'];
   endif;
   if(get_post_meta(get_the_ID() , 'custom_sticky_header', true)):
      $sticky_header_style = get_post_meta(get_the_ID() , 'header_sticky_settings_meta', true);
  endif;

 if( $select_stickt_header_type == 'default_sticky_header'): ?>
<header class="sticky_header_main default_sickty_heaad">
   <div class="auto-container">
      <div class="d-flex align-items-center">
         <div class="logo_column">
            <div class="header_logo_box">
               <?php do_action('sticky_default_logo'); ?>
            </div>
         </div>
      
            <div class="navbar_togglers hamburger_menu">
               <span class="line"></span>
               <span class="line"></span>
               <span class="line"></span>
            </div>
            <div class="header_content_collapse  <?php if(!empty($creote_theme_mod['sticky_search_enables']) == false && !empty($creote_theme_mod['sticky_smodal_enables']) == false): ?> no_right_content <?php endif; ?>">
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
               <?php if(!empty($creote_theme_mod['sticky_search_enables']) == true || !empty($creote_theme_mod['sticky_smodal_enables']) == true): ?>
               <div class="header_right_content">
                   <ul>
                    <?php if(!empty($creote_theme_mod['sticky_search_enables']) == true): ?>
                        <li>
                            <button type="button" class="search-toggler"><i class="icon-search"></i></button>
                        </li>
                    <?php endif;?>
                    <?php if(!empty($creote_theme_mod['sticky_smodal_enables']) == true): ?>
                        <li>
                            <button type="button" class="contact-toggler"><i class="icon-bar"></i></button>
                        </li>
                    <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
    
      </div>
   </div>
</header>

<?php elseif($select_stickt_header_type == 'custom_sticky_header'): ?>

     
   <header class="sticky_header_main">
   <?php  echo do_shortcode('[creote-header id="' . $sticky_header_style . '"]'); ?>
   </header>
   <?php endif; ?>

<?php
}
add_action('nest_sticky_header_after_header' , 'nest_sticky_header');
?>