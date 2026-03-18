<?php
/*
 *=================================
 * Side Bar
 * @package Creote WordPress Theme
 *==================================
*/
/* Show the sidebar based on selected layout */

?>
<?php
global $creote_theme_mod;
$sticky_enable = '';
if(!empty($creote_theme_mod['sidebar_sticky_enables'])):
$sticky_enable = $creote_theme_mod['sidebar_sticky_enables'];
endif;
$sidebar = 'sidebar-blog' ;
$side_class_inner = 'blog_siderbar side_bar';
if( is_page()) {
	$sidebar = 'page-sidebar';
	$side_class_inner = 'page_siderbar side_bar';
} 
elseif (is_post_type_archive('service')  || is_singular('service')) {
	$sidebar = 'service-sidebar';
	$side_class_inner = 'service_siderbar side_bar';
}
elseif (is_post_type_archive('product')  || is_singular('product') || is_tax('product_cat')) {
	$sidebar = 'shop-sidebar';
	$side_class_inner = 'shop_siderbar side_bar';
} 
$fixSide_scroll = '';
if($sticky_enable == true){
	$fixSide_scroll  = 'fixSide_scroll';   
}
if(creote_get_layout() == 'no-sidebar') {
	return false;
}
?>
<?php if(is_active_sidebar($sidebar)): ?>
<aside id="secondary" class="widget-area   all_side_bar  col-lg-4 col-md-12 col-sm-12">

				
<div class="<?php echo esc_attr($side_class_inner); ?> <?php echo esc_attr($fixSide_scroll); ?>">
<?php dynamic_sidebar( $sidebar ) ?>
</div>

</aside>
<?php endif; ?>