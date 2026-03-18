<?php
/*
**
creote side menu Button
**
*/
add_action('get_creote_side_menu_button' , 'creote_side_menu_button');
function  creote_side_menu_button(){
    global $creote_theme_mod;
    $allowed_tags = wp_kses_allowed_html('post');
?>

<ul class="sidemenu_content_bx">
    
<?php if(!empty($creote_theme_mod['side_menu_enable']) == true):  ?>
  <li>  <a href="#" id="side_menu_toggle_btn">
        <?php if(!empty($creote_theme_mod['side_menu_icon_image']['url'])): ?>
            <img src="<?php echo esc_attr($creote_theme_mod['side_menu_icon_image']['url']);  ?>" alt="img" class="img-fluid" />
        <?php  endif; ?>
        <?php if(!empty($creote_theme_mod['side_menu_button_texts'])):   ?>
        <?php echo wp_kses($creote_theme_mod['side_menu_button_texts'] , $allowed_tags); ?>
        <?php endif; ?>
    </a> </li>
    <?php endif; ?>


    <?php if(!empty($creote_theme_mod['color_scheme_option']) == true):  ?>
  <li>  <a href="#" class="switcher-toggler">
        <?php if(!empty($creote_theme_mod['color_sc_icon_image']['url'])): ?>
            <img src="<?php echo esc_attr($creote_theme_mod['color_sc_icon_image']['url']);  ?>" alt="img" class="img-fluid" />
        <?php  endif; ?>
        <?php if(!empty($creote_theme_mod['color_button_texts'])):   ?>
        <?php echo wp_kses($creote_theme_mod['color_button_texts'] , $allowed_tags); ?>
        <?php endif; ?>
    </a> </li>
    <?php endif; ?>


    <?php if(!empty($creote_theme_mod['mini_cart_enable']) == true):  ?>
  <li>  <?php //cart?>
	<?php  if(class_exists('woocommerce')):
		if(!empty($creote_theme_mod['mini_cart_enable']) == true):
		   	$items_counts = WC()->cart->get_cart_contents_count();
		?> 
		<div class="mini_cart_togglers fixed_cart not_for_mobile_cart">
         	<div class="mini-cart-count">  
             	<?php if(!empty($items_counts)): echo esc_attr($items_counts) ? esc_attr($items_counts) : '&nbsp;'; else: echo esc_html('0'); endif; ?>
        	</div>
            <?php if(!empty($creote_theme_mod['mini_cart_icon_img']['url'])): ?>
            <img src="<?php echo esc_attr($creote_theme_mod['mini_cart_icon_img']['url']);  ?>" alt="img" class="img-fluid" />
        <?php  endif; ?>
    	</div> 
	<?php endif; endif;
 ?>

<?php if(!empty($creote_theme_mod['mini_cart_text'])):   ?>
        <?php echo wp_kses($creote_theme_mod['mini_cart_text'] , $allowed_tags); ?>
        <?php endif; ?>
	<?php //cart?> </li>
    <?php endif; ?>

     

    <?php if(!empty($creote_theme_mod['content_one_enable']) == true):  ?>
   <li> <a href="<?php if(!empty($creote_theme_mod['content_one_text_link'])): echo esc_attr($creote_theme_mod['content_one_text_link']); endif; ?>">
        <?php if(!empty($creote_theme_mod['content_one_icon_image']['url'])): ?>
            <img src="<?php echo esc_attr($creote_theme_mod['content_one_icon_image']['url']);  ?>" alt="img" class="img-fluid" />
        <?php  endif; ?>
        <?php if(!empty($creote_theme_mod['content_one_text'])):   ?>
        <?php echo wp_kses($creote_theme_mod['content_one_text'] , $allowed_tags); ?>
        <?php endif; ?>
    </a></li>
    <?php endif; ?>
    <?php if(!empty($creote_theme_mod['content_two_enable']) == true):  ?>
        <li> <a href="<?php if(!empty($creote_theme_mod['content_two_link'])): echo esc_attr($creote_theme_mod['content_two_link']); endif; ?>">
        <?php if(!empty($creote_theme_mod['content_two_icon_image']['url'])): ?>
            <img src="<?php echo esc_attr($creote_theme_mod['content_two_icon_image']['url']);  ?>" alt="img" class="img-fluid" />
        <?php  endif; ?>
        <?php if(!empty($creote_theme_mod['content_two_text'])):   ?>
        <?php echo wp_kses($creote_theme_mod['content_two_text'] , $allowed_tags); ?>
        <?php endif; ?>
    </a></li>
    <?php endif; ?>
</ul>

<?php 

}

