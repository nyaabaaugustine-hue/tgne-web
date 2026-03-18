<?php
/*
**==============================   
** Creote Qucik View
**==============================
*/
function creote_quick_view_get(){
    global $woocommerce;
    global $product;
?>
<div class="woocommerce quick_view owl_new_one">
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-12 col-sm-12">
                <?php  do_action( 'woocommerce_creote_product_image_box' );  ?>
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="quickproduct_content default_single_product">
                    <div class="summary ">
                        <?php do_action( 'woocommerce_single_product_summary' ); ?>
                    </div>
                </div>
            </div>
        </div>
         
    </div>
</div>
<?php
}