<?php
 // Mode
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
        do_action('wp_body_open');
    }
endif;
$enable_custom_feature = get_theme_mod('enable_custom_feature', false);
$custom_image = get_theme_mod('custom_image_setting');
$custom_text = get_theme_mod('custom_text_setting');
$custom_text_setting_two = get_theme_mod('custom_text_setting_two');

?>
<div id="page" class="page_wapper maintenance hfeed site"> 

<div class="maintenance-content">
    <?php 
    if ($enable_custom_feature) {
        // Display content when staging site is enabled
        if ($custom_image) {
            echo '<img src="' . esc_url($custom_image) . '" alt="Custom Image">';
        }
    }
        ?>
        <div class="box_content">
        <?php
         if ($enable_custom_feature) {
        if ($custom_text_setting_two) {
            echo '<h2>' . esc_html($custom_text_setting_two) . '</h2>';
        }else{
                   echo '<h2>' . esc_html__('Site Under Maintenance.' , 'creote') . '</h2>';
        }
        if ($custom_text) {
            echo '<p>' . esc_html($custom_text) . '</p>';
        }else{
            echo '<p>' . esc_html__('This website is currently undergoing maintenance.' , 'creote') . '</p>';
        }
    }  
 ?>
 </div>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
