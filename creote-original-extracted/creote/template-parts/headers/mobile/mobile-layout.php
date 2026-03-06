<?php
/**
* Default Mobile Header 
*
* @package Creote
*/
if(is_page_template( 'template-empty.php' ) || is_page_template( 'template-full-empty.php' )){
    return false;
}
function creote_mobile_header() {
    
    global $creote_theme_mod;
    $blog_titles = get_bloginfo('name');
    $logo_sticky = '';
    if(!empty($creote_theme_mod['mobile_logo']['url'])):
       $logo_sticky =  $creote_theme_mod['mobile_logo']['url'];
    else:
    $logo_sticky =  get_template_directory_uri() . '/assets/images/logo-default.png';
    endif;
?>
<div class="logo_box">
    <a href="<?php if(!empty($creote_theme_mod['mobile_logo_link'])): echo esc_html($creote_theme_mod['mobile_logo_link']); else: echo esc_url(home_url()); endif; ?>"
        class="logo">
        <img src="<?php echo esc_url($logo_sticky); ?>" alt="<?php echo esc_attr($blog_titles); ?>"
            class="logo_default_sticky">
    </a>
</div>
<?php } 
add_action('sticky_mobile_logo' , 'creote_mobile_header'); 
 global $creote_theme_mod;
 $header_mobile_style = !empty($creote_theme_mod['header_mobile_style']) ? $creote_theme_mod['header_mobile_style'] : '';
?>

<header class="mobile_header  <?php if(!empty($header_mobile_style == 'mobile_header_style_two')): ?> mobile_header_style_two <?php endif; ?>">
    <?php if(!empty($creote_theme_mod['mobile_email_enable']) == true || !empty($creote_theme_mod['mobile_phone_enable']) == true): ?>
    <div class="top_bar_moblie">
        <div class="container">
            <?php if(!empty($creote_theme_mod['mobile_email_enable']) == true): ?>
            <div class="mail_id">
                <a href="mailto:<?php echo esc_attr($creote_theme_mod['mobile_mail_number']); ?>">
                    <i class="icon-email"></i>
                    <?php echo esc_attr($creote_theme_mod['mobile_mail_number']); ?>
                </a>
            </div>
            <?php endif; ?>
            <?php if(!empty($creote_theme_mod['mobile_phone_enable']) == true): ?>
            <div class="phone_no">
                <a href="tel:<?php echo esc_attr($creote_theme_mod['mobile_phone_number']); ?>">
                    <i class="icon-phone-call"></i>
                    <?php echo esc_attr($creote_theme_mod['mobile_phone_number']); ?>
                </a>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php endif; ?>
    <?php if(!empty($header_mobile_style == 'mobile_header_style_one')): ?>
    <div class="mobile_logo">
        <div class="container">
            <?php do_action('sticky_mobile_logo'); ?>
        </div>
    </div>
    <div class="bottom_content clearfix">
        <div class="container">
            <div
                class="d-flex align-items-center <?php if(!empty($creote_theme_mod['mobile_btn_enable_disable']) == false): ?>no_button_on_mb<?php endif; ?> <?php if(!empty($creote_theme_mod['mobile_option_enable']) == false): ?>no_option_on_mb<?php endif; ?>">
                <?php if(!empty($creote_theme_mod['mobile_btn_enable_disable']) == true): ?>
                <div>
                    <a href=" <?php echo esc_attr($creote_theme_mod['mobile_button_link']); ?>" class="theme-btn one">
                        <?php echo esc_attr($creote_theme_mod['mobile_button_text']); ?>
                    </a>
                </div>
                <?php endif; ?>
                <div>
                    <ul>
                        <?php if(!empty($creote_theme_mod['mobile_option_enable']) == true): ?>
                        <li class="conta_tog">
                            <button type="button" class="contact-toggler"><i class="icon-bar"></i></button>
                        </li>
                        <?php endif; ?>
                        <?php if(!empty($creote_theme_mod['mobile_mini_cart_enable']) == true): 
                        
                        if(class_exists('woocommerce')):?>
                        <li class="cart_btn_md">
                            <?php $items_counts = WC()->cart->get_cart_contents_count(); ?>
                            <div class="mini_cart_togglers">
                                <div class="mini-cart-count">
                                    <?php if(!empty($items_counts)): echo esc_attr($items_counts) ? esc_attr($items_counts) : '&nbsp;'; else: echo esc_html__('0' , 'creote'); endif; ?>
                                </div>
                                <i class="icon-shopping-cart"></i>
                            </div>

                        </li>
                        <?php endif; endif; ?>
                        <li class="nav_menu_mb">
                            <div class="navbar_togglers hamburger_menu">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <?php elseif(!empty($header_mobile_style == 'mobile_header_style_two')): ?>

    <div class="bottom_content clearfix">
        <div class="container">

            <div class="d-flex align-items-center">
                <div class="mobile_logo">
                        <?php do_action('sticky_mobile_logo'); ?>
                </div>
                
                <div>
                    <ul>
                    <?php if(!empty($creote_theme_mod['mobile_btn_enable_disable']) == true): ?>
                <li>
                    <a href=" <?php echo esc_attr($creote_theme_mod['mobile_button_link']); ?>" class="theme-btn one">
                        <?php echo esc_attr($creote_theme_mod['mobile_button_text']); ?>
                    </a>
                </li>
                <?php endif; ?>
                        <li class="nav_menu_mb">
                            <div class="navbar_togglers hamburger_menu">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php endif; ?>

</header>