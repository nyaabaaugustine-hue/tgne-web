<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

 defined( 'ABSPATH' ) || exit;

 global $product;
 
 // Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
 if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
     return;
 }
?>
<div <?php wc_product_class( 'project-wrapper grid-item', $product ); ?>>
    <div class="product_box type_one">
        <div class="inner_box">
            <?php woocommerce_show_product_sale_flash(); ?>
            <div class="image_box">
                <?php woocommerce_template_loop_product_thumbnail()?>

            </div>
            <div class="labels">
                <?php creote_wc_template_loop_stock(); ?>
            </div>
            <div class="overlay">
                <ul>
                    <li class="upper_box">
                    <a href="<?php echo esc_attr($product->get_id()); ?>"
                           class="creote_quick_view_btn">
                           <i class="icon-eye"></i>
                        </a>
                    </li>
                    <?php if(class_exists('YITH_WCWL')): ?>
                    <li class="whish_list_box">
                        <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                    </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>

        <div class="content_box">

            <?php creote_get_current_product_category(); ?>

            <h2><a href="<?php echo esc_url(get_permalink(get_the_id())); ?>"><?php the_title(); ?></a></h2>

            <div class="product_attributes">
                <?php echo esc_html(creote_attribute_links()); ?>
            </div>

            <div class="rating_price">

                <?php woocommerce_template_loop_price(); ?>
                <?php creote_get_star_rating(); ?>
            </div>

            <div class="cart_btn">
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>

        </div>
    </div>
</div>