<?php
/*
 *=================================
 * Mini Cart
 * @package Creote WordPress Theme
 *==================================
*/
function  creote_mini_cart(){ 
?>
 <div class="side_bar_cart" id="mini_cart">
    <div class="cart_overlay"></div>
        <div class="cart_right_conten">
            <div  class="close">
                <div class="close_btn_mini"><i class="icon-close"></i></div>
            </div>
            <div class="cart_content_box">
            <?php   global $woocommerce;
                ob_start();
                woocommerce_mini_cart();
                $mini_cart = ob_get_clean(); 
                $mini_content = sprintf( '	<div class="widget_shopping_cart_content">%s</div>', wp_kses($mini_cart , wp_kses_allowed_html('post')));
                printf(
                    '<div class="contnet_cart_box">%s</div>', 
                    wp_kses($mini_content , wp_kses_allowed_html('post'))
                );
            ?>
        </div>
    </div>
</div>
 <?php 
}
?>