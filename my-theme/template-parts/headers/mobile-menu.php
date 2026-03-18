<?php
/**
 *  Mobile Header Source
 *  @package Creote
**/
add_action('get_creote_mobile_menu' , 'creote_mobile_menu');
function creote_mobile_menu(){
    global $creote_theme_mod;
$add_class = '';
if(!empty($creote_theme_mod['onepage_header_enable']) == true):  
    $add_class = 'onepage_header_enable';
 endif; 
    ?>
<div class="crt_mobile_menu <?php  echo esc_attr($add_class); ?>">
    <div class="menu-backdrop"></div>
        <nav class="menu-box">
            <div class="close-btn"><i class="icon-close"></i></div>
            
            <?php if(!empty($creote_theme_mod['search_enable']) == true):   creote_simple_search();  endif;  ?>
            <div class="menu-outer">

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
        </nav>
    </div>
<?php }