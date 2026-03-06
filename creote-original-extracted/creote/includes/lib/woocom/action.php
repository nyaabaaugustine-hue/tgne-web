<?php
/*
 *=================================
 * woocommerce-rebuild
 * @package Creote WordPress Theme
 *==================================
*/
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10,0);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20,0);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10,0);
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_before_customer_details', 'woocommerce_checkout_payment', 10 );
add_action( 'woocommerce_creote_product_image_box', 'creote_product_image_box', 11 );
// twice the ajax cart
if ('no' === get_option('woocommerce_cart_redirect_after_add') && 'yes' === get_option('woocommerce_enable_ajax_add_to_cart') ) { 
    remove_action('wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );
}
/*
**==============================   
** Creote Qucik View
**==============================
*/
add_action( 'wp_ajax_nopriv_creote_get_quick_view', 'creote_get_quick_view_output' );
add_action( 'wp_ajax_creote_get_quick_view', 'creote_get_quick_view_output' );
function creote_get_quick_view_output(){
	$id = intval( $_POST['id'] );
    $query_args = array(
		'p' => $id,
		'post_type' => 'product',
	);
    $post_query = new WP_Query($query_args);
	if ($post_query->have_posts()) : 
     while($post_query->have_posts()) : $post_query->the_post(); 
     creote_quick_view_get();
     endwhile; 
    wp_reset_postdata();
    endif;
}

/*
**==============================   
**product image
**==============================
*/
function creote_product_image_box(){
    global $product;
    $poduct_image = get_post_thumbnail_id();
    $image_source = wp_get_attachment_image_src( $poduct_image, 'full' );
    $image_source =   ! empty( $image_source[0] ) ?  $image_source[0] : '';
    $product_image_repeats = $product->get_gallery_image_ids();
    if((function_exists('has_post_thumbnail')) && (has_post_thumbnail())):
    ?>
<div class="detail-gallery">
    <?php  if(!empty($product_image_repeats)): ?>
    <div class="galler">
        <span class="zoom-icon"><i class="fi-rs-search"></i></span>
        <!-- MAIN SLIDES -->
        <div class="product-image-slider owl_type_two owl-carousel">

            <?php 
            foreach($product_image_repeats as $product_image_repeat):
                $image_source_url = wp_get_attachment_url( $product_image_repeat );	
                ?>
            <figure class="border-radius-10">
            <img data-thumb='<img src="<?php echo esc_url($image_source_url);  ?>" />' src="<?php echo esc_url($image_source_url);  ?>" alt="<?php the_title(); ?>">
         
            </figure>
            <?php endforeach;?>
           
        </div>
    </div>
    <?php else: ?>

<div class="product_thumb"><img src="<?php echo esc_url($image_source); ?>"></div>
<?php endif; ?>
</div>
<?php else: ?>
<div class="detail-gallery">
    <img src="<?php echo esc_url($image_source);  ?>" alt="product image" />
</div>
<?php
endif;

} 
/*
============================
creote Custom Add to cart 
============================
*/
function creote_add_to_cart_button_woocommerce() {

    
    global $product;
    echo apply_filters(
        'woocommerce_loop_add_to_cart_link',
        sprintf(
            '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button ajax_add_to_cart cart_icon %s product_type_%s"> 
            <span class="icon-shopping-cart one_icon"></span>
            </a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( $product->get_id() ),
            esc_attr( $product->get_sku() ),
            $product->is_purchasable() ? 'add_to_cart_button' : '',
            esc_attr( $product->get_type() ),
            esc_html( $product->add_to_cart_text() )
        ),
        $product
    );
}

/*
=========================
creote change tabs order
========================
*/
add_filter( 'woocommerce_product_tabs', 'creote_change_tabs_order' );
function creote_change_tabs_order( $tabs ) {
	$tabs['reviews']['priority'] = 5;
	return $tabs;
}
/*
=========================
Change the breadcrumb
========================
*/
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
function wcc_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = '';
	return $defaults;
}

/*
=====================================================================
Minimum CSS to remove +/- default buttons on input field type number
=====================================================================
*/
add_action( 'wp_head' , 'custom_quantity_fields_css' );
function custom_quantity_fields_css(){
    ?>
    <style>
    .quantity input::-webkit-outer-spin-button,
    .quantity input::-webkit-inner-spin-button {
        display: none;
        margin: 0;
    }
    .quantity input.qty {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }
    </style>
    <?php
}

/*
=============================
custom quantity fields script
=============================
*/
add_action( 'wp_footer' , 'custom_quantity_fields_script' );
function custom_quantity_fields_script(){
    ?>
    <script type='text/javascript'>
    jQuery( function( $ ) {
        if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        $( document.body ).on( 'click', '.plus, .minus', function() {
            var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
        });
    });
    </script>
    <?php
}
/*
=============================
get star rating
=============================
*/
 add_action('woocommerce_after_shop_loop_item', 'creote_get_star_rating' );
 function creote_get_star_rating()
 {
     global $woocommerce, $product;
     $average = $product->get_average_rating();
 
     echo '<span class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'creote' ).'</span></span>';
 }

 


/*
===========================================
Display product attribute archive links 
===========================================
*/
add_action( 'woocommerce_shop_loop_item_title', 'creote_attribute_links');
// if you'd like to show it on archive page, replace "woocommerce_product_meta_end" with "woocommerce_shop_loop_item_title"
function creote_attribute_links() {
	global $post;
    $allowed_tag = wp_kses_allowed_html('post');
    $product_attributes = get_post_meta(get_the_ID() , 'pro_attribute', true);
	$attribute_names =  'pa_'.$product_attributes.''; // Add attribute names here and remember to add the pa_ prefix to the attribute name
	$taxonomy = get_taxonomy( $attribute_names );
	if($taxonomy && !is_wp_error( $taxonomy )){
			$terms = wp_get_post_terms( $post->ID, $attribute_names );
			$terms_array = array();
            if(! empty($terms)){
		        foreach ( $terms as $term ) {
			       $full_line = '<li>'. $term->name . ' <small>,</small></li>';
			       array_push( $terms_array, $full_line );
            }
        ?>    
        <ul class="attributes_list_items">
            <?php $attributename =  get_post_meta(get_the_ID() , 'pro_attribute_name', true);
            if(!empty($attributename)): ?>
                <li><?php echo esc_attr($attributename); ?> <?php echo esc_html__(':', 'creote'); ?></li>
            <?php endif; ?>
               <?php foreach($terms_array as $term):
                    echo wp_kses($term , $allowed_tag );
                endforeach; ?>
            </ul>
            <?php 
	    }
    }
}


/*
===========================================
Projects Page Default
===========================================
*/
add_action('img_fancy_box', 'creote_image_fancy_box', 25);
function creote_image_fancy_box()
{
    $featured_img_url = get_the_post_thumbnail_url(get_the_ID() , 'full');
    echo ' <a data-fancybox="gallery"  href="' . esc_url($featured_img_url) . '">';
    echo '     <i class="icon-plus zoom_icon"></i>';
    echo '</a>';
}

/*
===========================================
creote wc template loop stock
===========================================
*/
add_action( 'woocommerce_after_shop_loop_item_title', 'creote_wc_template_loop_stock', 10 );
function creote_wc_template_loop_stock() {
    global $product;
    if($product->managing_stock() && (int)$product->get_stock_quantity() < 1)
    echo '<p class="stock out-of-stock">'.__('Out of Stock' , 'creote').'</p>';
}


/*
===========================================
creote get current product category
===========================================
*/
function creote_get_current_product_category(){
    global $post;
    $product_cat_name = '';
    $product_cat_id = '';
        $terms = get_the_terms( $post->ID, 'product_cat' );
        if(!empty($terms)):
        foreach ($terms  as $term  ):                       
        $product_cat_name = $term->name;  
        $product_cat_id =  get_term_link( $term->term_id);
        break;
        endforeach;
    endif;
    ?>
    <div class="pro_cat">
        <a href="<?php echo esc_url($product_cat_id); ?>"> <?php echo esc_attr($product_cat_name); ?></a>
    </div>
<?php
}
 

/*
===========================================
Show cart contents / total Ajax
===========================================
*/
add_filter( 'woocommerce_add_to_cart_fragments', 'creote_mini_cart_count');
function creote_mini_cart_count($fragments){
    ob_start();
    $items_counts = WC()->cart->get_cart_contents_count();
    ?>
    <div class="mini-cart-count">

        <?php if(!empty($items_counts)): echo esc_attr($items_counts) ? esc_attr($items_counts) : '&nbsp;'; else: echo esc_html__('0' , 'creote'); endif; ?>
    </div>
    <?php
    $fragments['.mini-cart-count'] = ob_get_clean();
    return $fragments;
}
?>