
<?php
/*
 *=================================
 * The Header for our theme.
 * Displays all of the <head> section and everything up till <div id="content">
 * @package Creote WordPress Theme
 *==================================
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
if(!function_exists('wp_body_open')):
    function wp_body_open(){
        do_action( 'wp_body_open' );
    }
endif;
global $creote_theme_mod;
?>
<div id="page" class="page_wapper hfeed site">
<?php  if(!isMobile()): do_action('get_creote_side_menu_button');  endif; ?>
<?php if(!isMobile()): if(!empty($creote_theme_mod['color_scheme_option']) == true): creote_color_switcher(); endif; endif;?>
<?php  // quick view ?>
	<div class="quick_view_loading"></div>
	<?php  // quick view end ?>
<?php if(!isMobile()):  if(!empty($creote_theme_mod['side_menu_enable']) == true):  creote_menu_display_arear(); endif; endif;?>
	<div id="wrapper_full"  class="content_all_warpper">
	
    <?php //preloader?>
	 <?php if(!empty($creote_theme_mod['preloader_show']) == true): creote_preloaders(); endif;?>

	 <?php if(!function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location('header')): ?>
		<?php //header?>
			<?php get_template_part('template-parts/headers/default', 'header');  ?>
		<?php //header end?>
		<?php //mobile header?>
	 		<?php get_template_part('template-parts/headers/mobile/mobile', 'layout'); ?>
		<?php //mobile header end?> 
	<?php else: ?>
	<?php //elementor header?>
		<?php do_action( 'creote_elementor_header' ); ?>
	<?php //elementor header end?>
	<?php endif; ?>
    <?php if(!function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location('header')): ?>
		 <?php //page-header?>
			<?php  do_action('creote_after_header_no_blog'); ?>
			<?php if(is_singular('post')){ do_action('creote_after_header_blog'); } ?>
			<?php do_action('creote_after_header_no_redux'); ?>
	<?php endif; ?>
		<?php //page-header?>
            <div id="content" class="site-content <?php echo get_post_meta(get_the_ID() , 'blog_single_page_header' , true); ?>">
		        <?php
					$container = 'auto-container auto_container';
	                if( is_page_template( 'template-homepage.php' ) || is_page_template( 'template-empty.php' ) || is_page_template( 'template-fullwidth.php' ) || is_page_template( 'template-full-empty.php' ) ){
						$container = 'no-container';
					}
		        ?>
		<div class="<?php echo esc_attr($container); ?>">
		<?php
		$layout_row = function_exists('creote_get_layout') ? creote_get_layout() : 'no-sidebar';
		$row = 'row';
		if( is_page_template( 'template-homepage.php' ) || is_page_template( 'template-empty.php' ) || is_page_template( 'template-fullwidth.php' ) || is_page_template( 'template-full-empty.php' ) || $layout_row == 'no-sidebar'){
			$row = 'no-row';
		}
		else{
			$row = 'row default_row';
		}
		?>
		 <div class="<?php echo esc_attr( $row ) ?>">

	 
